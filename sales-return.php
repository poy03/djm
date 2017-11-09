<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];



include 'db.php';


	
if($_POST)
{
$id=$_POST['id'];
$return=@$_POST['return'];
$date_delivered=@$_POST['date_delivered'];

if(isset($return)){
	mysql_query("UPDATE tbl_orders SET received='".strtotime($date)."' WHERE orderID='$id'");
}else{
	$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$id'"));
	$terms = $order_data["terms"];
	$date_due = strtotime($date_delivered.'+ '.$terms.'days');
	$overdue_date_1 = strtotime(date("m/d/Y", $date_due) . " +30 days");
	$overdue_date_2 = strtotime(date("m/d/Y", $date_due) . " +60 days");
	mysql_query("UPDATE tbl_orders SET date_delivered='".strtotime($date_delivered)."',date_due = '$date_due', overdue_date_1 = '$overdue_date_1', overdue_date_2 = '$overdue_date_2' WHERE orderID='$id'");
}

}
?>