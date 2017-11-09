<?php
ob_start();
session_start();

include 'db.php';
?>

<?php
if($_POST)
{
$q=@$_POST['search'];
$id=@$_POST['id'];
$value=@$_POST['value'];
$price=@$_POST['price'];
$discount=@$_POST['discount'];
$own_use=@$_POST['own_use'];
$subtotal=@$_POST['subtotal'];
$costprice=@$_POST['costprice'];
$terms=@$_POST['terms'];
$type_payment_post=@$_POST['type_payment'];
$reset=@$_POST['reset'];
$reset_cost=@$_POST['reset_cost'];
$delall=@$_POST['delall'];
if(isset($q)){
	mysql_query("UPDATE tbl_cart SET type_payment = '$q' WHERE accountID='$accountID'");
}elseif(isset($reset)){
	mysql_query("UPDATE tbl_cart SET price = '0' WHERE accountID='$accountID'");
}elseif(isset($reset_cost)){
	mysql_query("UPDATE tbl_cart SET costprice = '0' WHERE accountID='$accountID'");
}elseif(isset($delall)){
	mysql_query("DELETE FROM tbl_cart WHERE accountID='$accountID'");
}elseif(isset($type_payment_post)){
		mysql_query("UPDATE tbl_cart SET type_payment = '$type_payment_post' WHERE accountID='$accountID'");
}elseif(isset($discount)){
		mysql_query("UPDATE tbl_cart SET discount = '$discount' WHERE accountID='$accountID'");
		echo number_format($subtotal-$discount,2);
}elseif(isset($terms)){
		mysql_query("UPDATE tbl_cart SET terms = '$terms' WHERE accountID='$accountID'");
}elseif(isset($own_use)){
		$own_use = ($own_use=='false'?0:1);
		mysql_query("UPDATE tbl_cart SET own_use = '$own_use' WHERE accountID='$accountID'");
}else{
	if(isset($value)){
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$id'"));
		if($value>=$item_data["quantity"]){ //if quantity is greater than the remaining stocks then set the quantity to its available stocks
			$value = $item_data["quantity"];
		}
		mysql_query("UPDATE tbl_cart SET quantity = '$value' WHERE accountID='$accountID' AND itemID='$id'");
		$cart_query = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID' AND itemID='$id'"));
		$type_price = $cart_query["type_price"];
		if($cart_query["price"]==0){
			$cart_query["price"]=$item_data["$type_price"];//price is 0 then return to the defined or original values.
		}
		echo "<b>₱".number_format($cart_query["price"]*$cart_query["quantity"],2)."</b>";
	}elseif(isset($costprice)){
		mysql_query("UPDATE tbl_cart SET costprice = '$costprice' WHERE accountID='$accountID' AND itemID='$id'");
	}else{
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$id'"));
		mysql_query("UPDATE tbl_cart SET price = '$price' WHERE accountID='$accountID' AND itemID='$id'");
		$cart_query = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID' AND itemID='$id'"));
		$type_price = $cart_query["type_price"];
		if($cart_query["price"]==0){
			$cart_query["price"]=$item_data["$type_price"];//price is 0 then return to the defined or original values.
		}
		echo "<b>₱".number_format($cart_query["price"]*$cart_query["quantity"],2)."</b>";
	}
}

}
?>
