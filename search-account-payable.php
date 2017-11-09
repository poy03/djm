<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
//get matched data from skills table
$data = array();
$query = mysql_query("SELECT * FROM tbl_orders_receiving WHERE invoice_number LIKE '%$q%'");
while ($row = mysql_fetch_assoc($query)) {
    $invoice_number = $row['invoice_number'];
    $orderID = $row['orderID'];
    $data[] = array("label"=>$invoice_number,"data"=>$orderID);
}
//return json data
echo json_encode($data);
//echo "<br>";
//echo "<br>";
//var_dump($data);
?>