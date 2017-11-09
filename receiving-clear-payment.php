<?php
ob_start();
session_start();



include 'db.php';

?>

<?php
if($_POST)
{
  $id=@$_POST['id'];
  $type=@$_POST['type'];
  if($type=="payment"){
    mysql_query("UPDATE tbl_orders_receiving SET payment='0', date_payment='0', check_number = '' WHERE orderID='$id'");
  }else{
    mysql_query("UPDATE tbl_orders_receiving SET freight_payment_date='0', freight_payment='0', freight_check_number = '' WHERE orderID='$id'");
  }
}
?>
