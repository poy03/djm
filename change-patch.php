<?php
ob_start();
session_start();

$page=@$_GET['page'];
$cat=@$_GET['cat'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';
if(APP_VERSION=="1.2"){
	//edit costprice as its sub_costprice
	$items_query = mysql_query("SELECT * FROM tbl_items WHERE deleted='0'");
	while($items_row=mysql_fetch_assoc($items_query)){
		$sub_costprice = $items_row["sub_costprice"];
		$costprice = $items_row["costprice"];
		$itemID = $items_row["itemID"];
		mysql_query("UPDATE tbl_items SET costprice='$sub_costprice' WHERE itemID='$itemID'");
	}
}elseif(APP_VERSION=="1.3"){
	mysql_query("ALTER TABLE tbl_orders_receiving ADD check_number VARCHAR(150) NOT NULL AFTER payment");
}elseif(APP_VERSION=="1.4"){
	mysql_query("ALTER TABLE tbl_ts_orders ADD delivery_date TEXT NOT NULL AFTER date_ordered, ADD credit_line TEXT NOT NULL AFTER delivery_date, ADD outstanding_bal TEXT NOT NULL AFTER credit_line, ADD available_bal TEXT NOT NULL AFTER outstanding_bal, ADD additional_case TEXT NOT NULL AFTER available_bal, ADD overhang TEXT NOT NULL AFTER additional_case, ADD overdue_one TEXT NOT NULL AFTER overhang, ADD overdue_two TEXT NOT NULL AFTER overdue_one, ADD overdue_three TEXT NOT NULL AFTER overdue_two, ADD justification_one TEXT NOT NULL AFTER overdue_three, ADD justification_two TEXT NOT NULL AFTER justification_one");
	mysql_query("ALTER TABLE tbl_ts_orders ADD account_specialist TEXT NOT NULL AFTER justification_two, ADD credit_and_collection TEXT NOT NULL AFTER account_specialist, ADD sales_manager TEXT NOT NULL AFTER credit_and_collection, ADD president TEXT NOT NULL AFTER sales_manager");
}elseif (APP_VERSION=="1.5") {
	mysql_query("ALTER TABLE tbl_customer CHANGE x3 credit_limit DOUBLE NOT NULL");
	mysql_query("ALTER TABLE tbl_orders ADD overdue_date_1 INT NOT NULL AFTER date_due, ADD overdue_date_2 INT NOT NULL AFTER overdue_date_1, ADD overdue_date_3 INT NOT NULL AFTER overdue_date_2");
	mysql_query("ALTER TABLE tbl_orders ADD pdc_bank TEXT NOT NULL AFTER date_delivered");
	mysql_query("ALTER TABLE tbl_orders  ADD pdc_status TEXT NOT NULL  AFTER pdc_amount");
	mysql_query("ALTER TABLE tbl_orders ADD pdc_returned INT NOT NULL AFTER pdc_status");
	mysql_query("ALTER TABLE tbl_ts_orders ADD old_dr INT NOT NULL AFTER delivery_date");
	mysql_query("ALTER TABLE tbl_orders ADD prepared_by TEXT NOT NULL AFTER payment_change, ADD released_by TEXT NOT NULL AFTER prepared_by, ADD approved_by TEXT NOT NULL AFTER released_by, ADD received_by TEXT NOT NULL AFTER approved_by, ADD delivered_by TEXT NOT NULL AFTER received_by");
}elseif (APP_VERSION=="1.6") {
	mysql_query("ALTER TABLE tbl_customer ADD term INT NOT NULL AFTER credit_limit");
	mysql_query("ALTER TABLE tbl_orders ADD fully_paid INT NOT NULL AFTER payment_change");
	mysql_query("CREATE TABLE posdb.tbl_payments ( paymentID INT NOT NULL AUTO_INCREMENT ,  type_payment TEXT NOT NULL ,  amount DOUBLE NOT NULL ,  pdc_check_number TEXT NOT NULL ,  pdc_date INT NOT NULL ,  pdc_bank TEXT NOT NULL ,  ar_number TEXT NOT NULL ,  date_payment INT NOT NULL ,  orderID INT NOT NULL ,  status INT NOT NULL ,  accountID INT NOT NULL ,    PRIMARY KEY  (paymentID)) ENGINE = InnoDB");
	mysql_query("ALTER TABLE tbl_payments ADD balance DOUBLE NOT NULL AFTER paymentID");
	mysql_query("ALTER TABLE tbl_payments ADD excess DOUBLE NOT NULL AFTER amount");
	mysql_query("ALTER TABLE tbl_payments ADD deleted INT NOT NULL AFTER accountID");
	mysql_query("ALTER TABLE tbl_payments CHANGE status status TEXT NOT NULL");
	mysql_query("ALTER TABLE tbl_payments ADD pdc_returned INT NOT NULL AFTER ar_number");
	mysql_query("ALTER TABLE tbl_payments ADD not_valid INT NOT NULL AFTER status");
	mysql_query("ALTER TABLE tbl_ts_orders ADD need_approve INT NOT NULL AFTER overhang");
	mysql_query("ALTER TABLE tbl_ts_orders ADD approved_for_dr INT NOT NULL AFTER overhang");
	# code...




	$ts_query = mysql_query("SELECT * FROM tbl_ts_orders");
	if(mysql_num_rows($ts_query)!=0){
		while($ts_row=mysql_fetch_assoc($ts_query)){
			$overhang = $ts_row["overhang"];
			$ts_orderID = $ts_row["ts_orderID"];
			if($overhang<0){
				$need_approve = 1;
				$approved_for_dr = 0;
			}else{
				$need_approve = 0;
				$approved_for_dr = 1;
			}
			mysql_query("UPDATE tbl_ts_orders SET need_approve='$need_approve', approved_for_dr='$approved_for_dr' WHERE ts_orderID='$ts_orderID'");
		}
	}

}elseif (APP_VERSION=="1.7") {
	mysql_query("ALTER TABLE tbl_orders_receiving ADD freight_payment DOUBLE NOT NULL AFTER payment, ADD freight_payment_date INT NOT NULL AFTER freight_payment");
	mysql_query("ALTER TABLE tbl_orders_receiving ADD freight_check_number TEXT NOT NULL AFTER freight_payment_date");
	mysql_query("ALTER TABLE tbl_orders_receiving ADD freight_needs_payment INT NOT NULL AFTER freight");
}elseif (APP_VERSION=="1.8") {
	mysql_query("ALTER TABLE tbl_income_statement ADD capital_expenses_items TEXT NOT NULL AFTER admin_expenses_value, ADD capital_expenses_value TEXT NOT NULL AFTER capital_expenses_items");
	$orders_query = mysql_query("SELECT * FROM tbl_orders");
	while($row=mysql_fetch_assoc($orders_query)){
		$orderID=$row["orderID"];
		$customerID=$row["customerID"];
		mysql_query("UPDATE tbl_purchases SET customerID='$customerID' WHERE orderID='$orderID'");
	}
}elseif (APP_VERSION=="1.9") {
	mysql_query("ALTER TABLE tbl_ts_orders ADD status_current INT NOT NULL AFTER need_approve, ADD status_with_overdue INT NOT NULL AFTER status_current, ADD status_with_excess INT NOT NULL AFTER status_with_overdue, ADD status_with_returned_check INT NOT NULL AFTER status_with_excess");
	mysql_query("ALTER TABLE tbl_ts_orders ADD amount_current DOUBLE NOT NULL AFTER status_with_returned_check");
	mysql_query("ALTER TABLE tbl_ts_orders ADD amount_excess DOUBLE NOT NULL AFTER overdue_three, ADD amount_history DOUBLE NOT NULL AFTER amount_excess");
}elseif (APP_VERSION=="2.0") {
	$sales_edit_query = mysql_query("SELECT * FROM tbl_sales_edit WHERE approved='1'");
	if(mysql_num_rows($sales_edit_query)!=0){
		while($sales_edit_row = mysql_fetch_assoc($sales_edit_query)){
			$editID = $sales_edit_row["editID"];
			$orderID = $sales_edit_row["orderID"];
			$total = mysql_fetch_assoc(mysql_query("SELECT SUM(price*quantity) as total FROM tbl_sales_edit_items WHERE editID='$editID'"));
			$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
			// echo "<br>";
			// echo $orderID." ".$total["total"]."<br>";
			$balance = (($order_data["balance"]-$total["total"])<=0?0:$order_data["balance"]-$total["total"]);
			$has_payment = (mysql_num_rows(mysql_query("SELECT * FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0'"))==0?0:1);
			$fully_paid = ($balance==0&&$has_payment==1?1:0);
			mysql_query ("UPDATE tbl_orders SET approved='0', balance='$balance',fully_paid='$fully_paid'  WHERE orderID='$orderID'");
		}
	}
}elseif (APP_VERSION=="2.1") {
	mysql_query("UPDATE `tbl_orders` SET `balance` = '76268.64' WHERE `tbl_orders`.`orderID` = 2703");
	mysql_query("UPDATE `tbl_orders` SET `balance` = '0' WHERE `tbl_orders`.`orderID` = 2457");
	mysql_query("UPDATE `tbl_orders` SET `balance` = '0' WHERE `tbl_orders`.`orderID` = 2707");
	mysql_query("UPDATE `tbl_orders` SET `balance` = '0' WHERE `tbl_orders`.`orderID` = 2817");
	mysql_query("UPDATE `tbl_purchases` SET `quantity` = '0', `subtotal` = '0' WHERE `tbl_purchases`.`purchaseID` = 1647");
	mysql_query("UPDATE `tbl_purchases` SET `quantity` = '0', `subtotal` = '0' WHERE `tbl_purchases`.`purchaseID` = 334");
	// mysql_query("UPDATE `tbl_payments` SET `excess` = '0' WHERE `tbl_payments`.`paymentID` = 27");
	// mysql_query("UPDATE `tbl_payments` SET `excess` = '0' WHERE `tbl_payments`.`paymentID` = 27");
}elseif (APP_VERSION=="2.2") {
	mysql_query("ALTER TABLE `tbl_cart` ADD `own_use` INT NOT NULL AFTER `discount`");
	mysql_query("ALTER TABLE `tbl_receiving` ADD `type` VARCHAR(50) NOT NULL AFTER `date_received`");
	mysql_query("ALTER TABLE `tbl_cart_receiving` ADD `type` VARCHAR(50) NOT NULL AFTER `freight`");
	mysql_query("ALTER TABLE `tbl_orders_receiving` ADD `type` VARCHAR(50) NOT NULL AFTER `deleted_comments`");
	mysql_query("UPDATE tbl_orders_receiving SET type='purchase'");
	mysql_query("UPDATE tbl_receiving SET type='purchase'");
	# code...
}elseif(APP_VERSION=="2.3"){

}



?>

