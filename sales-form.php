<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];


error_reporting(0);
include 'db.php';
$id = @$_GET["id"];
if(isset($id)){
	mysql_query("DELETE FROM tbl_cart WHERE itemID='$id' AND accountID='$accountID'");
	header("location:sales");
	exit;
}

?>
<?php

if(isset($_POST["save"])){
	$Customer = mysql_real_escape_string(htmlspecialchars(trim($_POST["Customer"])));
	$customerID = $_POST["customerID"];
	$salesmanID = $_POST["salesmanID"];
	$ts_orderID = $_POST["ts_orderID"];

	$terms = $_POST["terms"];
	// echo "SalesMan : $salesmanID";
	// echo "<br>";
	// echo "SalesMan : $customerID";
	// exit;
	$date_due = strtotime($date.'+ '.$terms.'days');
	$comments = mysql_real_escape_string($_POST["comments"]);
	$exploded = explode(",",$type_payment);
	if($ts_orderID!=""){
		$ts_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_ts_orders WHERE ts_orderID='$ts_orderID'"));
		$date_due = $ts_data["date_due"];
		$terms = $ts_data["terms"];
	}	
		// echo "<br>";
	$order_query = mysql_query("SELECT * FROM tbl_orders WHERE deleted='0'");
	(mysql_num_rows($order_query)==0?$orderID=$_POST["dr_number"]:$orderID='');
	
	$overdue_date_1 = strtotime(date("m/d/Y", $date_due) . " +30 days");
	$overdue_date_2 = strtotime(date("m/d/Y", $date_due) . " +60 days");
	mysql_query("INSERT INTO tbl_orders (orderID,date_ordered,time_ordered,accountID,type_payment,customer,comments,date_due,customerID,terms,ts_orderID,salesmanID,overdue_date_1,overdue_date_2,date_delivered) VALUES ('$orderID','".strtotime($date)."','".strtotime($time)."','$accountID','credit','$Customer','$comments','$date_due','$customerID','$terms','$ts_orderID','$salesmanID','$overdue_date_1','$overdue_date_2','".strtotime(date("m/d/Y"))."')");


	// mysql_query("INSERT INTO tbl_orders VALUES ('$orderID','".strtotime($date)."','".strtotime($time)."','$accountID','','credit','$Customer','','','','','','$comments','','$date_due','$customerID','','','','$terms','$ts_orderID','$salesmanID','','','','','','','','','','')");
	$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders ORDER BY orderID DESC LIMIT 0,1"));//find the latest orderID in the database.
	$orderID = $order_data["orderID"];
	$total = 0;
	$total_cost = 0;
	$cart_query = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");
	while ($cart_row=mysql_fetch_assoc($cart_query)) {
		$itemID = $cart_row["itemID"];		
		$quantity = $cart_row["quantity"];				
		$costprice = $cart_row["costprice"];		
		$price = $cart_row["price"];		
		$customerID = $cart_row["customerID"];		
		$own_use = $cart_row["own_use"];		
		$type_price = $cart_row["type_price"];		
		$Customer = $cart_row["Customer"];
		$total_cost +=($costprice*$quantity);
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID = '$itemID'"));
		($price==0?$price=$item_data["$type_price"]:false);
		($costprice==0?$costprice=$item_data["costprice"]:false);
		mysql_query("UPDATE tbl_items SET quantity='".($item_data["quantity"]-$quantity)."' WHERE itemID='$itemID'");//subtract the remaining quanitity to the quantity of items in the DR.
		$loss = $costprice-$price;
		$profit = $price-$costprice;
		($loss<=0?$loss=0:false);
		($profit<=0?$profit=0:false);
		$subtotal = $quantity * $price;	
		$total += $subtotal;
		mysql_query("INSERT INTO tbl_purchases VALUES ('','$itemID','$quantity','$price','$subtotal','$accountID','$profit','$loss','$orderID','','$costprice','$customerID','".strtotime($date)."','','$salesmanID')");
	}
	mysql_query("UPDATE tbl_orders SET total = '$total', customerID='$customerID', balance = '$total', costprice='$total_cost' WHERE orderID='$orderID'");
	mysql_query("UPDATE tbl_ts_orders SET processed = '1' WHERE ts_orderID='$ts_orderID'");
	mysql_query("DELETE FROM tbl_cart WHERE accountID='$accountID'");
	if($ts_orderID!=0){//if DR has TS then update the orderID of TS to have a reference.
		mysql_query("UPDATE tbl_ts_orders SET orderID='$orderID', date_ordered='".strtotime($date)."' WHERE ts_orderID = '$ts_orderID'");
	}
	if($own_use==1){
		mysql_query("UPDATE tbl_orders SET balance = '0', fully_paid='1' WHERE orderID='$orderID'");
	}
	echo json_encode(array("orderID"=>$orderID));
	// header("location:sales-complete?id=".$orderID);
}
?>