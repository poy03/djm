<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

	
?>
<?php
if(isset($_POST["add"])){
	$category = $_POST["category"];
	$description = $_POST["description"];
	$expenses = $_POST["expenses"];
	mysql_query("INSERT INTO tbl_cart_expenses VALUES('','$description','$expenses','$accountID','$category','')");
	header("location:expenses");
}
if(isset($_POST["save"])){
	$cart_query = mysql_query("SELECT * FROM tbl_cart_expenses");
	$total_expenses = 0;
	$comments = $_POST["comments"];
	while($cart_row=mysql_fetch_assoc($cart_query)){
		$description = $cart_row["description"];
		$expenses = $cart_row["expenses"];
		$dbaccountID = $cart_row["accountID"];
		$total_expenses+=$expenses;
		echo("INSERT INTO tbl_expenses VALUES('','$description','$expenses','$accountID','$category','','')");
	}
exit;
	
	mysql_query("INSERT INTO tbl_orders_expenses VALUES('','$date','$time','$total_expenses','$comments','$accountID','')");
	$latest_query = mysql_query("SELECT * FROM tbl_orders_expenses ORDER BY orderID DESC LIMIT 0,1");
	while($latest_row=mysql_fetch_assoc($latest_query)){
		$latest_orderID = $latest_row["orderID"];
	}
	//echo "$latest_orderID";
	mysql_query("UPDATE tbl_expenses SET orderID='$latest_orderID' WHERE orderID='0' AND accountID='$accountID'");
	mysql_query("DELETE FROM tbl_cart_expenses WHERE accountID='$accountID'");

	header("location:expenses");
}

if(isset($_POST["delete"])){
	
	mysql_query("DELETE FROM tbl_cart_expenses WHERE accountID='$accountID'");
	header("location:expenses");
}
?>