<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
//get matched data from skills table
$data = array();
$query = mysql_query("SELECT * FROM tbl_salesman WHERE salesman_name LIKE '%$q%' AND deleted='0'");
while ($row = mysql_fetch_assoc($query)) {
    $salesman_name = $row['salesman_name'];
    $salesmanID = $row['salesmanID'];
    $data[] = array("label"=>$salesman_name,"data"=>$salesmanID);
}
//return json data
echo json_encode($data);
//echo "<br>";
//echo "<br>";
//var_dump($data);
?>