<?php
ob_start();
session_start();



include 'db.php';

?>

<?php
if($_POST)
{
$amount=@$_POST['amount'];
$id=@$_POST['id'];
$date_payment=@$_POST['date_payment'];
$check_number=mysql_real_escape_string(htmlspecialchars(trim($_POST['check_number'])));
	if($_POST["payment"]=="purchases"){
		if(isset($amount)){
			mysql_query("UPDATE tbl_orders_receiving SET payment='$amount', date_payment='".strtotime($date_payment)."', check_number = '".$check_number."' WHERE orderID='$id'");
		}
	}else{
		if(isset($amount)){
			mysql_query("UPDATE tbl_orders_receiving SET freight_payment='$amount', 	freight_payment_date='".strtotime($date_payment)."', freight_check_number = '".$check_number."' WHERE orderID='$id'");
		}
	}
}
?>
