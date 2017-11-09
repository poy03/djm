<?php
ob_start();
session_start();

include 'db.php';
//get search term
$q = $_GET['term'];
//get matched data from skills table
$query = mysql_query("SELECT DISTINCT description FROM tbl_expenses WHERE category='admin' AND description LIKE '%$q%' AND deleted = 0 ORDER BY description");
while ($row = mysql_fetch_assoc($query)) {
    $data[] = $row['description'];
}
//return json data
echo json_encode($data);
?>