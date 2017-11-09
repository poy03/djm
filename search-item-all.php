<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
//get matched data from skills table
$data = array();
$query = mysql_query("SELECT DISTINCT quantity, itemname,item_code, itemID FROM tbl_items WHERE (itemname LIKE '%$q%' OR item_code LIKE '%$q%') AND deleted = 0 ORDER BY itemname");
while ($row = mysql_fetch_assoc($query)) {
    $itemname = $row['itemname'];
    $itemID = $row['itemID'];
    $item_code = $row['item_code'];
    if($item_code!=''){
    	$item_code = " [$item_code]";
    }
    $data[] = array("label"=>$itemname.$item_code,"data"=>$itemID);
}
//return json data
echo json_encode($data);
//echo "<br>";
//echo "<br>";
//var_dump($data);
?>