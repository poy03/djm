<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];



include 'db.php';


if($_POST){
	$type = $_POST["type"];
	$value = mysql_real_escape_string(htmlspecialchars(trim($_POST["value"])));
	$orderID = $_POST["id"];
	mysql_query("UPDATE tbl_orders SET $type = '$value' WHERE orderID='$orderID'");
}

?>