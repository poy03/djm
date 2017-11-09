<?php
ob_start();
session_start();
include 'db.php';

if(isset($_POST["sort"])){
	$page=$_POST['page'];
	$query = "SELECT * FROM tbl_expenses WHERE deleted='0'";
	if(isset($_POST["expense_account"])&&$_POST["expense_account"]!=""){
		$expense_account = urldecode($_POST["expense_account"]);
		$expense_account = htmlentities($expense_account);
		$query.=" AND expense_account='$expense_account'";
	}
	if(isset($_POST["description"])&&$_POST["description"]!=""){
		$description = urldecode($_POST["description"]);
		$description = htmlentities($description);
		$query.=" AND description='$description'";
	}
	if(isset($_POST["category"])&&$_POST["category"]!=""){
		$category = urldecode($_POST["category"]);
		$category = htmlentities($category);
		$query.=" AND category='$category'";
	}
	if(isset($_POST["fully_paid"])&&$_POST["fully_paid"]!=""){
		$fully_paid = $_POST["fully_paid"];
		$query.=" AND fully_paid='$fully_paid'";
	}

	if(isset($_POST["payee"])&&$_POST["payee"]!=""){
		$payee = $_POST["payee"];
		$query.=" AND payee='$payee'";
	}
	if(isset($_POST['show_all'])){

	}else{
		if(isset($_POST["date_from"])&&$_POST["date_from"]!=""&&isset($_POST["date_to"])&&$_POST["date_to"]!=""){
			$date_from = strtotime($_POST["date_from"]);
			$date_to = strtotime($_POST["date_to"]);
			$sort_by = $_POST["sort_by"];
			$query.=" AND $sort_by BETWEEN '$date_from' AND '$date_to'";
		}
	}
	$sort_by = $_POST["sort_by"];
	$query.=" ORDER BY $sort_by ASC";

	// echo $query;
	// echo "
	// <tr>
	// 	<td>$query</td>
	// </tr>
	// ";
	$expenses_query = mysql_query($query);
	if(mysql_num_rows($expenses_query)!=0){
		$total_amount = 0;
		while($expenses_row=mysql_fetch_assoc($expenses_query)){
			$total_amount += $expenses_row['amount'];
			if($expenses_row["fully_paid"]==0){
				$expenses_status = "Unpaid";
			}else{
				$expenses_status = "Paid";
			}

			$date_due = "";
			if($expenses_row["date_due"]!=0){
				$date_due = date("m/d/Y",$expenses_row["date_due"]);
			}

			$date_payment = "";
			if($expenses_row["date_payment"]!=0){
				$date_payment = date("m/d/Y",$expenses_row["date_payment"]);
			}

			echo '
			<tr>
				<td>'.$expenses_row["expense_account"].'</td>
				<td>'.$expenses_row["description"].'</td>
				<td style="text-align:right">'.number_format($expenses_row["amount"],2).'</td>
				<td>'.$expenses_row["payee"].'</td>
				<td>'.date("m/d/Y",$expenses_row["date"]).'</td>
				<td>'.$expenses_row["terms"].'</td>
				<td>'.$date_due.'</td>
				<td>'.ucfirst($expenses_row["category"])." Expenses".'</td>
				<td>'.$date_payment.'</td>
				<td>'.$expenses_row["comments"].'</td>
				<td>'.$expenses_status.'</td>
				<td><a href="#" class="delete" id="'.$expenses_row["expensesID"].'">&times;</a></td>
			</tr>
			';
		}
		echo '
		<tr>
			<th colspan="2"></th>
			<th style="text-align:right">'.number_format($total_amount,2).'</th>
		</tr>
		';
	}
}


?>