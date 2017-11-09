<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
//get matched data from skills table
$data = array();
$query = mysql_query("SELECT * FROM tbl_customer WHERE companyname LIKE '%$q%' AND deleted='0'");
while ($row = mysql_fetch_assoc($query)) {
    $companyname = $row['companyname'];
    $customerID = $row['customerID'];
    $data[] = array("label"=>$companyname,"data"=>$customerID);
}
//return json data
echo json_encode($data);
//echo "<br>";
//echo "<br>";
//var_dump($data);
?>