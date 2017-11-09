<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$tab=@$_GET['tab'];

if(!isset($tab)){
	$tab=1;
}


include 'db.php';
if(isset($_POST["save"])){
	$expense_account_array = $_POST["expense_account"];
	$description = $_POST["description"];
	$amount = $_POST["amount"];
	$comments = $_POST["comments"];
	$date = $_POST["date"];
	$payee = $_POST["payee"];
	$term = $_POST["term"];
	$i = 0;
	foreach ($expense_account_array as $expense_account) {
		if($expense_account!==""&&$description[$i]!==""){
			($term[$i]==0?$fully_paid=1:$fully_paid=0);
			($term[$i]==0?$date_due = strtotime($date[$i]):$date_due = strtotime($date[$i]." +".$term[$i]." days"));
			($fully_paid==1?$date_payment=strtotime($date[$i]):$date_payment=0);
			
			$terms[$i] = $term[$i];
			$expense_account = mysql_real_escape_string(htmlspecialchars(trim($expense_account)));
			$description[$i] = mysql_real_escape_string(htmlspecialchars(trim($description[$i])));
			$payee[$i] = mysql_real_escape_string(htmlspecialchars(trim($payee[$i])));
			$comments[$i] = mysql_real_escape_string(htmlspecialchars(trim($comments[$i])));
			$amount[$i] = mysql_real_escape_string(htmlspecialchars(trim($amount[$i])));
			$date[$i] = strtotime($date[$i]);
				mysql_query("INSERT INTO tbl_expenses (category,expense_account,description,amount,accountID,date,terms,payee,fully_paid,date_due,date_payment,comments) VALUES ('selling','$expense_account','$description[$i]','$amount[$i]','$accountID','$date[$i]','$terms[$i]','$payee[$i]','$fully_paid','$date_due','$date_payment','$comments[$i]')");
			}
		$i++;
	}
}
?>
