<?php
ob_start();
session_start();


error_reporting(0);
include 'db.php';
?>

<?php
if($_POST)
{
$id=mysql_real_escape_string(htmlspecialchars(trim($_POST['id'])));
$pdc_date=mysql_real_escape_string(htmlspecialchars(trim($_POST['pdc_date'])));
$cash=mysql_real_escape_string(htmlspecialchars(trim($_POST['cash'])));
$total=mysql_real_escape_string(htmlspecialchars(trim($_POST['total'])));
$pdc_check_number=mysql_real_escape_string(htmlspecialchars(trim($_POST['pdc_check_number'])));
$pdc_bank=mysql_real_escape_string(htmlspecialchars(trim($_POST['pdc_bank'])));
$pdc_amount=mysql_real_escape_string(htmlspecialchars(trim($_POST['pdc_amount'])));
$date_payment=mysql_real_escape_string(htmlspecialchars(trim($_POST['date_payment'])));
$ar_number=mysql_real_escape_string(htmlspecialchars(trim($_POST['ar_number'])));
	if(isset($_POST['pdc_amount'])){
		$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$id'"));
		echo "<br>";
		echo $order_data["balance"];
		echo "<br>";
		$remain_balance = $order_data["balance"] - $pdc_amount;
		if($remain_balance<=0){
			$remain_balance=0;
			$fully_paid=1;
			$excess = $pdc_amount - $order_data["balance"];
		}else{
			$fully_paid=0;
			$excess = 0;
		}

		mysql_query("UPDATE tbl_orders SET pdc_date='".strtotime($pdc_date)."', pdc_check_number = '$pdc_check_number', pdc_amount='$pdc_amount', pdc_bank='$pdc_bank' WHERE orderID='$id'");
		mysql_query("INSERT INTO tbl_payments (balance,type_payment,amount,pdc_check_number,pdc_date,pdc_bank,ar_number,date_payment,orderID,accountID,excess) VALUES
			('".$order_data["balance"]."','pdc', '$pdc_amount', '$pdc_check_number', '".strtotime($pdc_date)."', '$pdc_bank', '$ar_number', '".strtotime($date_payment)."', '$id', '$accountID','$excess')");
	}
	if(isset($_POST['cash'])){
		// echo("UPDATE tbl_orders SET payment='".$cash."',date_payment='".strtotime($date)."' WHERE orderID='$id'");

		echo "<br>";
		echo "<br>";

		
		$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$id'"));
		echo "<br>";
		echo $order_data["balance"];
		echo "<br>";
		$remain_balance = $order_data["balance"] - $cash;
		$remain_balance = round($remain_balance,2);
		if($remain_balance<=0){
			$remain_balance=0;
			$fully_paid=1;
			$excess = $cash - $order_data["balance"];
			$excess = round($excess,2);
		}else{
			$fully_paid=0;
			$excess = 0;
		}
		mysql_query("UPDATE tbl_orders SET balance='$remain_balance', fully_paid='$fully_paid' WHERE orderID='$id'");

		mysql_query("INSERT INTO tbl_payments (balance,type_payment,amount,ar_number,date_payment,orderID,accountID,excess) VALUES
			('".$order_data["balance"]."','cash','$cash','$ar_number','".strtotime($date_payment)."','$id','$accountID','$excess')");
	}
	if(isset($_POST['amount'])){
		$change = $_POST['amount']-$total;
		$change = round($change,2);
		($change<=0?$change=0:false);
		echo "₱".number_format($change,2);
	}
}
?>
