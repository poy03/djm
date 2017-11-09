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
$itemID=@$_GET['id'];
if(isset($itemID)){
	$itemquery = mysql_query("SELECT * FROM tbl_ts_cart WHERE itemID='$itemID' AND accountID='$accountID'");
	if(mysql_num_rows($itemquery)!=0){
		while($row=mysql_fetch_assoc($itemquery)){
			$quantity = $row["quantity"];
		}
		$quantity++;
		mysql_query("UPDATE tbl_ts_cart SET quantity='$quantity' WHERE itemID='$itemID' AND accountID='$accountID'");
	}else{
		$query = "SELECT * FROM tbl_ts_cart WHERE accountID='$accountID'";
		$cart_query = mysql_query($query);
		if(mysql_num_rows($cart_query)!=0){
			while($cart_row=mysql_fetch_assoc($cart_query)){
				$customer_name = mysql_real_escape_string(htmlspecialchars(trim($cart_row["customer"])));
				$customerID = $cart_row["customerID"];
				$salesmanID = $cart_row["salesmanID"];
				$terms = $cart_row["terms"];
				$type_price = $cart_row["type_price"];
				$ts = $cart_row["ts"];
				$discount = $cart_row["discount"];
			}
			mysql_query("INSERT INTO tbl_ts_cart VALUES('','$itemID','1','','','$customerID','$customer_name','$accountID','','$type_price','$salesmanID','$terms','$discount')");
		}else{
			mysql_query("INSERT INTO tbl_ts_cart VALUES('','$itemID','1','','','','','$accountID','','srp','','','')");
		}
	}
	header("location:sales-ts");
}else{
	header("location:index");
}
?>
