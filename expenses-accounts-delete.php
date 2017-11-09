<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];

include 'db.php';


if($_POST){

	$id = $_POST["id"];
	mysql_query("DELETE FROM tbl_expenses_account WHERE id='$id'");
}

?>