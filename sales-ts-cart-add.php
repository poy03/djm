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
$subtotal=@$_POST['subtotal'];
$discount=@$_POST['discount'];
$ts=@$_POST['ts'];
$deleteid=@$_POST['deleteid'];
$price=@$_POST['price'];
$terms=@$_POST['terms'];
$type_payment_post=@$_POST['type_payment'];
$reset_cost=@$_POST['reset_cost'];
$costprice=@$_POST['costprice'];
$delall=@$_POST['delall'];
if(isset($q)){
	mysql_query("UPDATE tbl_ts_cart SET type_payment = '$q' WHERE accountID='$accountID'");
}elseif(isset($reset)){
	mysql_query("UPDATE tbl_ts_cart SET price = '0' WHERE accountID='$accountID'");
}elseif(isset($reset_cost)){
	mysql_query("UPDATE tbl_ts_cart SET costprice = '0' WHERE accountID='$accountID'");
}elseif(isset($deleteid)){
	mysql_query("DELETE FROM tbl_ts_cart WHERE cartID='$deleteid'");
}elseif(isset($ts)){
	mysql_query("UPDATE tbl_ts_cart SET ts = '$ts' WHERE accountID='$accountID'");
}elseif(isset($delall)){
	mysql_query("DELETE FROM tbl_ts_cart WHERE accountID='$accountID'");
}elseif(isset($type_payment_post)){
		mysql_query("UPDATE tbl_ts_cart SET type_payment = '$type_payment_post' WHERE accountID='$accountID'");
}elseif(isset($terms)){
		mysql_query("UPDATE tbl_ts_cart SET terms = '$terms' WHERE accountID='$accountID'");
}else{
	$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$id'"));
	if(isset($value)){
		($value>=$item_data["quantity"]?$value=$item_data["quantity"]:false);
		mysql_query("UPDATE tbl_ts_cart SET quantity = '$value' WHERE itemID='$id' AND accountID='$accountID'");
		$cart_query = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID' AND itemID='$id'"));
		$type_price = $cart_query["type_price"];
		if($cart_query["price"]==0){
			$cart_query["price"]=$item_data["$type_price"];
		}
		echo "".number_format($cart_query["price"]*$cart_query["quantity"],2);
	}elseif(isset($costprice)){
		mysql_query("UPDATE tbl_ts_cart SET costprice = '$costprice' WHERE itemID='$id' AND accountID='$accountID'");
	}else{
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$id'"));
		mysql_query("UPDATE tbl_ts_cart SET price = '$price' WHERE itemID='$id' AND accountID='$accountID'");
		$cart_query = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID' AND itemID='$id'"));
		$type_price = $cart_query["type_price"];
		if($cart_query["price"]==0){
			$cart_query["price"]=$item_data["$type_price"];
		}
		echo "".number_format($cart_query["price"]*$cart_query["quantity"],2);
	}
}

}
?>
