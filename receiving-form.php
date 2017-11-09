<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];

include 'db.php';

if(isset($_POST["save"])){
	$date_selected = mysql_real_escape_string(strtotime($_POST["date"]));
	$comments = mysql_real_escape_string(htmlspecialchars(trim($_POST["comments"])));
	$supplierID = mysql_real_escape_string(htmlspecialchars(trim($_POST["supplierID"])));
	$comments = mysql_real_escape_string(htmlspecialchars(trim($_POST["comments"])));
	$invoice_number = mysql_real_escape_string(htmlspecialchars(trim($_POST["invoice_number"])));
	$terms = mysql_real_escape_string(htmlspecialchars(trim($_POST["terms"])));
	$type = mysql_real_escape_string(htmlspecialchars(trim($_POST["type"])));
	$freight = mysql_real_escape_string(htmlspecialchars(trim($_POST["freight"])));
	$date_due = strtotime(date("m/d/Y",$date_selected).'+'.$terms.' days');
	($freight!=0?$freight_needs_payment=1:$freight_needs_payment=0);
	mysql_query("INSERT INTO tbl_orders_receiving (time_received,date_received,accountID,comments,supplierID,invoice_number,terms,freight,date_due,freight_needs_payment,type) VALUES('".strtotime("h:i:s A")."','$date_selected','$accountID','$comments','$supplierID','$invoice_number','$terms','$freight','$date_due','$freight_needs_payment','$type')");





	$orderID = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders_receiving ORDER BY orderID DESC LIMIT 0,1"));
	$orderID = $orderID["orderID"];
	$total_cost = 0;
	$cart_query = mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID'");
	while($cart_row=mysql_fetch_assoc($cart_query)){
		$itemID = $cart_row["itemID"];
		$quantity = $cart_row["quantity"];
		$type = $cart_row["type"];
		$costprice = $cart_row["costprice"];
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
		($costprice==0?$costprice=$item_data["costprice"]:false);
		$subtotal = $costprice*$quantity;
		$total_cost += $subtotal;
		mysql_query("INSERT INTO tbl_receiving (itemID,quantity,costprice,subtotal,accountID,orderID,date_received,type) VALUES ('$itemID','$quantity','$costprice','$subtotal','$accountID','$orderID','$date_selected','$type')");
		$new_quantity = $item_data["quantity"]+$quantity;
		mysql_query("UPDATE tbl_items SET quantity = '$new_quantity', costprice='$costprice' WHERE itemID='$itemID'");
	}
	mysql_query("UPDATE tbl_orders_receiving SET total_cost='$total_cost' WHERE orderID='$orderID'");
	mysql_query("DELETE FROM tbl_cart_receiving WHERE accountID='$accountID'");
	echo json_encode(array("orderID"=>$orderID));
	// header("location:receiving-complete?id=".$orderID);
}

?>
