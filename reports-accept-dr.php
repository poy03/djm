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
	foreach ($_POST["select"] as $ts_orderID) {
		mysql_query("UPDATE tbl_ts_orders SET approved_for_dr='1', need_approve='0', sales_manager='".mysql_real_escape_string(htmlspecialchars(trim($employee_name)))."' WHERE ts_orderID='$ts_orderID'");
	}
}
?>