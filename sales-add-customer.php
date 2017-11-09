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
if(isset($customerID)){
	$customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'");
	while($row=mysql_fetch_assoc($customer_query)){
		$customername=mysql_real_escape_string(htmlspecialchars(trim($row["companyname"])));
		$term=$row["term"];
	}
	mysql_query("UPDATE tbl_cart SET customerID='$customerID', Customer='$customername', terms='$term' WHERE accountID='$accountID'");
	header("location:sales");
}elseif(isset($customer)){
	mysql_query("UPDATE tbl_cart SET customerID='0', Customer='$customer', terms='0' WHERE accountID='$accountID'");
	header("location:sales");
}else{
	header("location:sales");
}

?>