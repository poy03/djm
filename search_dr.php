<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
//get matched data from skills table
$data = array();
$query = mysql_query("SELECT * FROM tbl_orders WHERE orderID LIKE '%$q%' AND deleted='0'");
while ($row = mysql_fetch_assoc($query)) {
    $orderID  = $row['orderID'];
    $data[] = array("label"=>$orderID,"data"=>$orderID);
}
//return json data
echo json_encode($data);
//echo "<br>";
//echo "<br>";
//var_dump($data);
?>