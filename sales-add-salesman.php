<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$salesmanID=@$_GET['id'];
$salesman=@$_GET['salesman'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';


?>
<?php
if(isset($salesmanID)){
	$salesman_query = mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'");
	while($row=mysql_fetch_assoc($salesman_query)){
		$salesman_name=$row["salesman_name"];
	}
	mysql_query("UPDATE tbl_cart SET salesmanID='$salesmanID' WHERE accountID='$accountID'");
	header("location:sales");
}elseif(isset($salesman)){
	mysql_query("UPDATE tbl_cart SET salesmanID='0' WHERE accountID='$accountID'");
	header("location:sales");
}else{
	header("location:sales");
}

?>