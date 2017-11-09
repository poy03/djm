<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];

$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];

include 'db.php';
$format = date("Ym")."000";
if(isset($_POST["save"])){
	$customerID = $_POST["customerID"];
	$terms = $_POST["terms"];
	$customer = mysql_real_escape_string(htmlspecialchars(trim($_POST["customer"])));
	$salesmanID = $_POST["salesmanID"];
	$discount = $_POST["discount"];
	$date_due = strtotime($date.'+'.$terms.' days');
	$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
	$customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'");
	if(mysql_num_rows($customer_query)!=0){
		$customer_data = mysql_fetch_assoc($customer_query);
		$credit_line = $customer_data["credit_limit"];
	}else{
		$credit_line = 0;
	}

	$last_transaction_query = mysql_query("SELECT * FROM tbl_orders WHERE customerID='$customerID' and deleted='0' ORDER BY orderID DESC LIMIT 1");
	if(mysql_num_rows($last_transaction_query)!=0){
		$last_transaction_data = mysql_fetch_assoc($last_transaction_query);
		if($last_transaction_data["balance"]!=0){

			$outstanding_bal = $last_transaction_data["balance"];
			$balance_data = mysql_fetch_assoc(mysql_query("SELECT SUM(balance) as total_balance FROM tbl_orders WHERE customerID='$customerID' and deleted='0' ORDER BY orderID DESC"));
			$outstanding_bal = $balance_data["total_balance"];
			$old_dr = $last_transaction_data["orderID"];
		}else{
			$outstanding_bal = 0;
			$old_dr = 0;
		}

	}else{
		$old_dr = 0;
		$outstanding_bal = 0;
	}



	$current_data = mysql_fetch_assoc(mysql_query("SELECT SUM(balance) as total_balance FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND customerID='$customerID' AND date_due >= '".strtotime($date)."'"));;
	$overdue_date_data_1 = mysql_fetch_assoc(mysql_query("SELECT SUM(balance) as total_balance FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND customerID='$customerID' AND date_due < '".strtotime($date)."' AND overdue_date_1 > '".strtotime($date)."'"));
	$overdue_date_data_2 = mysql_fetch_assoc(mysql_query("SELECT SUM(balance) as total_balance FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND customerID='$customerID' AND overdue_date_1 < '".strtotime($date)."' AND overdue_date_2 > '".strtotime($date)."'"));
	$overdue_date_data_3 = mysql_fetch_assoc(mysql_query("SELECT SUM(balance) as total_balance FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND customerID='$customerID' AND overdue_date_2 < '".strtotime($date)."'"));

	$status_with_returned_check	= mysql_num_rows(mysql_query("SELECT tbl_orders.fully_paid, tbl_orders.deleted, tbl_orders.customerID, tbl_payments.pdc_returned FROM tbl_orders INNER JOIN tbl_payments ON tbl_orders.orderID=tbl_payments.orderID WHERE tbl_orders.fully_paid='0' AND tbl_orders.deleted='0' AND tbl_orders.customerID='$customerID' AND tbl_payments.pdc_returned='1'"));

	$amount_current = $current_data["total_balance"];
	$overdue_one = $overdue_date_data_1["total_balance"];
	$overdue_two = $overdue_date_data_2["total_balance"];
	$overdue_three = $overdue_date_data_3["total_balance"];
	$outstanding_bal = $current_data["total_balance"] + $overdue_date_data_1["total_balance"] + $overdue_date_data_2["total_balance"] + $overdue_date_data_3["total_balance"];

	($current_data["total_balance"]==0?$status_current=0:$status_current=1);
	(($overdue_date_data_1["total_balance"] + $overdue_date_data_2["total_balance"] + $overdue_date_data_3["total_balance"])==0?$status_with_overdue = 0:$status_with_overdue = 1);

	$salesman_name = mysql_real_escape_string(htmlspecialchars(trim($salesman_data["salesman_name"])));
	$cart_query = mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID'");
	if(mysql_num_rows($cart_query)==0){
		header("location:sales-ts");
		exit;
	}
	$order_query = mysql_query("SELECT * FROM tbl_ts_orders WHERE ts_orderID >= '$format' ORDER BY ts_orderID DESC LIMIT 0,1");
	//if ts_orderID is less than the format then reset the ts_orderID to 0.
	if(mysql_num_rows($order_query)==0){
		$orderID = $_POST["ts"];
	}else{
		$order_data = mysql_fetch_assoc($order_query);
		$orderID = $order_data["ts_orderID"]+1;
	}



	
	$available_bal = $credit_line - $outstanding_bal;
	$available_bal = round($available_bal,2);


	// var_dump("SELECT SUM(quantity*price) as total_sales FROM tbl_ts_items WHERE ts_orderID='$orderID'");
	mysql_query("INSERT INTO tbl_ts_orders (ts_orderID,date_due,customerID,accountID,date,time,customer,salesmanID,terms,discount,account_specialist,credit_line,outstanding_bal,available_bal,status_with_overdue,overdue_one,overdue_two,overdue_three,status_current,amount_current) VALUES ('$orderID','$date_due','$customerID','$accountID','".strtotime($date)."','$time','$customer','$salesmanID','$terms','$discount','$salesman_name','$credit_line','$outstanding_bal','$available_bal','$status_with_overdue','$overdue_one','$overdue_two','$overdue_three','$status_current','$amount_current')");
	// exit;
	// mysql_query("INSERT INTO tbl_ts_orders VALUES ('$orderID','$date_due','$customerID','$accountID','".strtotime($date)."','$time','','','$customer','$salesmanID','','','','$terms','$discount','','','','','','','','','','','','','','$salesman_name','','','')");
	$latest_order = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_ts_orders ORDER BY ts_orderID DESC LIMIT 0,1"));
	$orderID = $latest_order["ts_orderID"];
	while ($cart_row=mysql_fetch_assoc($cart_query)) {
		# code...
		$itemID = $cart_row["itemID"];
		$quantity = $cart_row["quantity"];
		$price = $cart_row["price"];
		$type_price = $cart_row["type_price"];
		$discount = $cart_row["discount"];
		$costprice = $cart_row["costprice"];
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
		($price==0?$price = $item_data["$type_price"]:false);
		($costprice==0?$costprice = $item_data["costprice"]:false);
		$total_cost = $costprice * $quantity;
		mysql_query("INSERT INTO tbl_ts_items VALUES ('','$orderID','$itemID','$quantity','$price','$total_cost','','".strtotime($date)."','$time')");
	}


	$total_sales = mysql_fetch_assoc(mysql_query("SELECT SUM(quantity*price) as total_sales FROM tbl_ts_items WHERE ts_orderID='$orderID'"));
	$total_sales = $total_sales["total_sales"];
	$additional_case = $total_sales;
	$overhang = $available_bal - $additional_case;

	if($overhang<0){
		$need_approve = 1;
		$approved_for_dr = 0;

		mysql_query("UPDATE tbl_ts_orders SET status_current='0',status_with_overdue='0',status_with_excess='1',amount_current='0',overdue_one='0',overdue_two='0',overdue_three='0',amount_excess='$outstanding_bal' WHERE ts_orderID='$orderID'");
	}else{
		$need_approve = 0;
		$approved_for_dr = 1;
	}

	if($status_with_returned_check!=0){
		mysql_query("UPDATE tbl_ts_orders SET status_current='0',status_with_overdue='0',amount_current='0',overdue_one='0',overdue_two='0',overdue_three='0',status_with_returned_check='1',amount_history='$outstanding_bal' WHERE ts_orderID='$orderID'");
	}

	
	$need_approve = 1;
	$approved_for_dr = 0;

	mysql_query("UPDATE tbl_ts_orders SET need_approve='$need_approve', approved_for_dr='$approved_for_dr', additional_case='$additional_case', overhang='$overhang' WHERE ts_orderID='$orderID'");

	mysql_query("DELETE FROM tbl_ts_cart WHERE accountID='$accountID'"); // clear the items in the cart.
	echo json_encode(array("orderID"=>$orderID));
	// header("location:sales-ts-complete?id=".$orderID);
}
?>