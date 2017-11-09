<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$customerID=@$_GET['id'];
$customer=@$_GET['customer'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';


?>
<?php
if($_POST)
{
	$customer = $_POST["customer"];
	mysql_query("UPDATE tbl_cart SET customer='$customer', customerID='0' WHERE accountID='$accountID'");
}

?>