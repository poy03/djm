<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$orderID=@$_GET['id'];
$comments=@$_GET['comments'];

include 'db.php';

mysql_query("UPDATE tbl_orders SET deleted='1',delete_comment='$comments',deleted_by='$accountID', date_deleted='".strtotime($date)."' WHERE orderID='$orderID'");
mysql_query("UPDATE tbl_purchases SET deleted='1' WHERE orderID='$orderID'");
mysql_query("UPDATE tbl_payments SET deleted='1' WHERE orderID='$orderID'");
$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
$ts_orderID = $order_data["ts_orderID"];
if($ts_orderID!=0){
	mysql_query("UPDATE tbl_ts_orders SET processed = '0' WHERE ts_orderID='$ts_orderID'");
}
$purchase_query = mysql_query("SELECT * FROM tbl_purchases WHERE orderID='$orderID'");
while($purchase_row=mysql_fetch_assoc($purchase_query)){
	$itemID = $purchase_row["itemID"];
	$quantity = $purchase_row["quantity"];
	$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
	$new_quantity = $quantity + $item_data["quantity"];
	mysql_query("UPDATE tbl_items SET quantity='$new_quantity' WHERE itemID='$itemID'");
}
header("location:success");
?>
