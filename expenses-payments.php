<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$tab=@$_GET['tab'];
if(!isset($tab)){
	$tab=1;
}
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

if($_POST){
	$date_payment = strtotime($_POST["date_payment"]);
	$expensesID = $_POST["expensesID"];
	$comment_payment = mysql_real_escape_string(htmlentities(trim($_POST["comment_payment"])));

	mysql_query("UPDATE tbl_expenses SET fully_paid='1', date_payment='$date_payment', comment_payment='$comment_payment' WHERE expensesID='$expensesID'");
}
?>