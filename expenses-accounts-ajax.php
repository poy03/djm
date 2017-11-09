<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];



include 'db.php';

if($_POST){
	$tab=$_POST['tab'];
	// echo $tab;
	if($tab==1){
		$expense_account = mysql_real_escape_string(htmlspecialchars(trim($_POST["expense_account"])));
		$type = $_POST["type"];
		$expense_account_query = mysql_query("SELECT * FROM tbl_expenses_account WHERE expense_account='$expense_account' AND type='selling' AND deleted='0'");
		echo '<option value="">Select Description</option>';
		if(mysql_num_rows($expense_account_query)!=0){
			while($expense_account_row=mysql_fetch_assoc($expense_account_query)){
				echo '<option value="'.$expense_account_row["description"].'">'.$expense_account_row["description"].'</option>';
			}
		}
	}elseif ($tab==2){
		$expense_account = mysql_real_escape_string(htmlspecialchars(trim($_POST["expense_account"])));
		$type = $_POST["type"];
		$expense_account_query = mysql_query("SELECT * FROM tbl_expenses_account WHERE expense_account='$expense_account' AND type='admin' AND deleted='0'");
		echo '<option value="">Select Description</option>';
		if(mysql_num_rows($expense_account_query)!=0){
			while($expense_account_row=mysql_fetch_assoc($expense_account_query)){
				echo '<option value="'.$expense_account_row["description"].'">'.$expense_account_row["description"].'</option>';
			}
		}
	}elseif ($tab==3) {

		$expense_account = mysql_real_escape_string(htmlspecialchars(trim($_POST["expense_account"])));
		$expense_account_query = mysql_query("SELECT * FROM tbl_expenses_account WHERE expense_account='$expense_account' AND type='capital' AND deleted='0'");
		echo '<option value="">Select Description</option>';
		if(mysql_num_rows($expense_account_query)!=0){
			while($expense_account_row=mysql_fetch_assoc($expense_account_query)){
				echo '<option value="'.$expense_account_row["description"].'">'.$expense_account_row["description"].'</option>';
			}
		}
		
	}
}


?>