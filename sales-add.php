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
	$itemquery = mysql_query("SELECT * FROM tbl_cart WHERE itemID='$itemID' AND accountID='$accountID'");
	if(mysql_num_rows($itemquery)!=0){
		while($row=mysql_fetch_assoc($itemquery)){
			$quantity = $row["quantity"];
		}
		$quantity++;
		mysql_query("UPDATE tbl_cart SET quantity='$quantity' WHERE itemID='$itemID' AND accountID='$accountID'");
	}else{
		$query = "SELECT * FROM tbl_cart";
		$cart_query = mysql_query($query);
		if(mysql_num_rows($cart_query)!=0){ //if the sales cart is not empty then copy the data to the succeeding data. 
			while($cart_row=mysql_fetch_assoc($cart_query)){
				$customer_name = mysql_real_escape_string(htmlspecialchars(trim($cart_row["Customer"])));
				$customerID = $cart_row["customerID"];
				$type_payment = $cart_row["type_payment"];
				$type_price = $cart_row["type_price"];
				$date_due = $cart_row["date_due"];
				$discount = $cart_row["discount"];
				$salesmanID = $cart_row["salesmanID"];
				$terms = $cart_row["terms"];
				$ts_orderID = $cart_row["ts_orderID"];
			}
			mysql_query("INSERT INTO tbl_cart (itemID,quantity,accountID,Customer,date_due,customerID,type_price,terms,ts_orderID,salesmanID,discount) VALUES('$itemID','1','$accountID','$customer_name','$date_due','$customerID','$type_price','$terms','$ts_orderID','$salesmanID','$discount')");
		}else{
			mysql_query("INSERT INTO tbl_cart (itemID,quantity,accountID,type_price) VALUES('$itemID','1','$accountID','srp')");
		}


		

	}
	header("location:sales");
}else{
	header("location:index");
}
?>
