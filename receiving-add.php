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
$mode=@$_GET['mode'];
$supplierID=@$_GET['sup'];
if(isset($itemID)){
	$itemquery = mysql_query("SELECT * FROM tbl_cart_receiving WHERE itemID='$itemID' AND accountID='$accountID'");
	if(mysql_num_rows($itemquery)!=0){
		while($row=mysql_fetch_assoc($itemquery)){

			$quantity = $row["quantity"];
			$costprice = $row["costprice"];
		}
		$quantity++;
		$total = $quantity * $costprice;
		mysql_query("UPDATE tbl_cart_receiving SET quantity='$quantity', subtotal = '$total' WHERE itemID='$itemID' AND accountID='$accountID'");
	}else{
		$query = mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'");
		while($itemrow=mysql_fetch_assoc($query)){
			$costprice = $itemrow["costprice"];
		}
		$cart_query = mysql_query("SELECT * FROM tbl_cart_receiving");
		if(mysql_num_rows($cart_query)!=0){
			while($cart_row=mysql_fetch_assoc($cart_query)){
				$supplierID = $cart_row["supplierID"];
				$mode = $cart_row["mode"];
				$comments = $cart_row["comments"];
				$date_selected = $cart_row["date"];
				$terms = $cart_row["terms"];
				$freight = $cart_row["freight"];
				$type = $cart_row["type"];
				$invoice_number = $cart_row["invoice_number"];
			}
			mysql_query("INSERT INTO tbl_cart_receiving VALUES('','$itemID','1','$accountID','$supplierID','$mode','$costprice','$costprice','$comments','$date_selected','$terms','$invoice_number','$freight','$type')");
		}else{
			mysql_query("INSERT INTO tbl_cart_receiving VALUES('','$itemID','1','$accountID','','','$costprice','$costprice','','','','','','purchase')");			
		}

	}
	header("location:receiving");
}elseif(isset($mode)){
	mysql_query("UPDATE tbl_cart_receiving SET mode='$mode' WHERE accountID='$accountID'");
	header("location:receiving");
}else{
	header("location:index");
}
?>
