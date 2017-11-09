<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
$by=@$_GET['by'];
$order=@$_GET['order'];



include 'db.php';
$orderID=@$_POST['orderID'];
$data['success'] = array();
$data['failed'] = array();
if(isset($_POST['receiveID'])){
  for ($i=0; $i < count($_POST['receiveID']); $i++) { 
    $receiveID = $_POST['receiveID'][$i];
    $itemID = $_POST['itemID'][$i];
    $return_quantity = $_POST['return_quantity'][$i];
    if($return_quantity>0){
      $item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
      if($item_data['quantity']<=$return_quantity){
        $data['failed'][] = $item_data;
        continue;
      }else{
        $new_quantity = $item_data['quantity'] - $return_quantity;
        mysql_query("UPDATE tbl_items SET quantity='$new_quantity' WHERE itemID='$itemID'");
        $receive_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_receiving WHERE receiveID='$receiveID'"));
        $new_quantity = $receive_data['quantity'] - $return_quantity;
        $subtotal = $receive_data['costprice'] * $new_quantity;
        mysql_query("UPDATE tbl_receiving SET quantity='$new_quantity', subtotal='$subtotal' WHERE receiveID='$receiveID'");
        $data['success'][] = $item_data;
      }
    }
  }

  $total_cost_data = mysql_fetch_assoc(mysql_query("SELECT SUM(quantity*costprice) as total_cost FROM tbl_receiving WHERE orderID='$orderID'"));
  mysql_query("UPDATE tbl_orders_receiving SET total_cost='".$total_cost_data['total_cost']."' WHERE orderID='$orderID'");
}
echo json_encode($data);

?>
