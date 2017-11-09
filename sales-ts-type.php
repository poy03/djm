<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$typeprice=@$_GET['type'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

mysql_query("UPDATE tbl_ts_cart SET type_price='$typeprice' WHERE accountID='$accountID'");
header("location:sales-ts");

?>
