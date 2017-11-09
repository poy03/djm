<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$ts_orderID=@$_GET['id'];

include 'db.php';
mysql_query("DELETE FROM tbl_cart WHERE accountID='$accountID'");
$ts_query = mysql_query("SELECT * FROM tbl_ts_orders WHERE ts_orderID='$ts_orderID'");
$cart_query = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");

if(mysql_num_rows($ts_query)!=0){//if ts_order is in the database then
	if(mysql_num_rows($cart_query)==0){ //if cart is empty then
		$ts_order_data = mysql_fetch_assoc($ts_query);
		$customerID = $ts_order_data["customerID"];
		$terms = $ts_order_data["terms"];
		$date_due = $ts_order_data["date_due"];
		$discount = $ts_order_data["discount"];
		$customer = $ts_order_data["customer"];
		$salesmanID = $ts_order_data["salesmanID"];
		$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
		($customer_data["companyname"]!=""?$customer=$customer_data["companyname"]:false);

	$ts_items_query = mysql_query("SELECT * FROM tbl_ts_items WHERE ts_orderID='$ts_orderID'");
	$x=0;
	while ($row=mysql_fetch_assoc($ts_items_query)) {
		# code...
		$itemID = $row["itemID"];
		$quantity = $row["quantity"];
		$costprice = $row["costprice"];
		$costprice = $costprice / $quantity;
		$price = $row["price"];
		$customer = mysql_real_escape_string(htmlspecialchars(trim($customer)));
		mysql_query("INSERT INTO tbl_cart VALUES ('','$itemID','$quantity','$costprice','$price','$accountID','$customer','$date_due','$customerID','','','$terms','$ts_orderID','$salesmanID','$discount','0')");
	}
	}
	header("location:sales");
}
?>