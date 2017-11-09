<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];


include 'db.php';

?>
<?php
if($_POST){
	$id = $_POST["id"];

	$payment_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_payments WHERE paymentID='$id'"));
	$pdc_status = $_POST["pdc_status"];
	if($pdc_status=="returned"){
		if($payment_data['status']==""){
			mysql_query("UPDATE tbl_payments SET status='Returned on ".date("m/d/Y")."', pdc_returned='1', not_valid='1' WHERE paymentID='$id'");
			mysql_query("UPDATE tbl_orders SET pdc_date='', pdc_check_number = '', pdc_amount='', pdc_bank='' WHERE orderID='".$payment_data["orderID"]."'");
		}else{

			mysql_query("UPDATE tbl_payments SET status='Returned on ".date("m/d/Y")."', pdc_returned='1', not_valid='1' WHERE paymentID='$id'");
			mysql_query("UPDATE tbl_orders SET pdc_date='', pdc_check_number = '', pdc_amount='', pdc_bank='' WHERE orderID='$id'");
			$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='".$payment_data["orderID"]."'"));
			$new_balance = $order_data['balance']+$payment_data["amount"];
			$new_balance = round($new_balance,2);
			mysql_query("UPDATE tbl_orders SET balance='$new_balance', fully_paid='0' WHERE orderID='".$payment_data["orderID"]."'");

		}

	}else{
		$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='".$payment_data["orderID"]."'"));
		echo "<br>";
		echo $order_data["balance"];
		echo "<br>";
		$pdc_amount = $payment_data["amount"];
		$remain_balance = $order_data["balance"] - $pdc_amount;
		$remain_balance = round($remain_balance,2);
		if($remain_balance<=0){
			$remain_balance=0;
			$fully_paid=1;
			$excess = $pdc_amount - $order_data["balance"];
			$excess = round($excess,2);
			$pdc_returned = 0;
		}else{
			$fully_paid=0;
			$excess = 0;
		}

		mysql_query("UPDATE tbl_orders SET balance='$remain_balance', fully_paid='$fully_paid' WHERE orderID='".$payment_data["orderID"]."'");
		mysql_query("UPDATE tbl_payments SET excess='$excess', status='Deposited on ".date("m/d/Y")."', date_payment='".strtotime(date("m/d/Y"))."' WHERE paymentID='$id'");

	}
}

?>