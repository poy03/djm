<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
if($tab==1){
	//get matched data from skills table
	$query = mysql_query("SELECT DISTINCT orderID FROM tbl_orders WHERE orderID LIKE '%$q%' AND deleted = 0 ORDER BY orderID");
	while ($row = mysql_fetch_assoc($query)) {
	    $data[] = array("label"=>$row['orderID'],"data"=>$row['orderID']);
	}
	//return json data
	echo json_encode($data);
}else{
	//get matched data from skills table
	$query = mysql_query("SELECT DISTINCT orderID FROM tbl_orders WHERE orderID LIKE '%$q%' AND deleted = 0 AND fully_paid='0' ORDER BY orderID");
	while ($row = mysql_fetch_assoc($query)) {
	    $data[] = array("label"=>$row['orderID'],"data"=>$row['orderID']);
	}
	//return json data
	echo json_encode($data);
}
?>