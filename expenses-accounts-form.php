<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];

include 'db.php';


if($_POST){
	$expense_account = mysql_real_escape_string(htmlspecialchars(trim($_POST["expense_account"])));
	$description = mysql_real_escape_string(htmlspecialchars(trim($_POST["description"])));
	$amount = mysql_real_escape_string(htmlspecialchars(trim($_POST["amount"])));
	$type = mysql_real_escape_string(htmlspecialchars(trim($_POST["type"])));


	$query = mysql_query("SELECT * FROM tbl_expenses_account WHERE type='$type' AND expense_account='$expense_account' AND description='$description' AND deleted='0'");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO tbl_expenses_account (type,expense_account,description,amount) VALUES ('$type','$expense_account','$description','$amount')");
		$data["status"] = 1;
	}else{
		$data["status"] = 0;
	}

	echo json_encode($data);
	}

?>