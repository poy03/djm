<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$orderID=@$_GET['id'];

include 'db.php';
$comments=@$_GET['comments'];


$comments=@$_GET['comments'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



mysql_query("UPDATE tbl_ts_orders SET deleted='1', comments='$comments',deleted_by='$accountID', date_deleted='".strtotime($date)."' WHERE ts_orderID='$orderID'");
mysql_query("UPDATE tbl_ts_items SET deleted='1' WHERE ts_orderID='$orderID'");
header("location:success");
?>
