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
$delete_item=@$_POST['delete_item'];
$costprice=@$_POST['costprice'];
$price=@$_POST['price'];
$reset=@$_POST['reset'];
$type=@$_POST['type'];
$delall=@$_POST['delall'];
$supplierID=@$_POST['supplier'];
$terms=@$_POST['terms'];
$freight=@$_POST['freight'];
$invoice_number=@$_POST['invoice_number'];
$date_selected=@$_POST['date'];
if(isset($q)){
	mysql_query("UPDATE tbl_cart SET type_payment = '$q' WHERE accountID='$accountID'");
}elseif(isset($reset)){
	mysql_query("UPDATE tbl_cart_receiving SET costprice = '0' WHERE accountID='$accountID'");
}elseif(isset($delall)){
	mysql_query("DELETE FROM tbl_cart_receiving WHERE accountID='$accountID'");
}elseif(isset($delete_item)){
	mysql_query("DELETE FROM tbl_cart_receiving WHERE accountID='$accountID' AND itemID='$id'");
}elseif(isset($terms)){
	mysql_query("UPDATE tbl_cart_receiving SET terms = '$terms' WHERE accountID='$accountID'");
}elseif(isset($freight)){
	mysql_query("UPDATE tbl_cart_receiving SET freight = '$freight' WHERE accountID='$accountID'");
}elseif(isset($invoice_number)){
	mysql_query("UPDATE tbl_cart_receiving SET invoice_number = '".mysql_real_escape_string(htmlspecialchars(trim($invoice_number)))."' WHERE accountID='$accountID'");
}elseif(isset($date_selected)){
	mysql_query("UPDATE tbl_cart_receiving SET date = '".strtotime($date_selected)."' WHERE accountID='$accountID'");
}elseif(isset($supplierID)){
	mysql_query("UPDATE tbl_cart_receiving SET supplierID = '$supplierID' WHERE accountID='$accountID'");
}elseif(isset($type)){
	mysql_query("UPDATE tbl_cart_receiving SET type = '$type' WHERE accountID='$accountID'");
}else{
	if(isset($value)){
		mysql_query("UPDATE tbl_cart_receiving SET quantity = '$value' WHERE accountID='$accountID' AND itemID='$id'");
		$cart_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID' AND itemID='$id'"));
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$id'"));
		($cart_data["costprice"]==0?$cart_data["costprice"]=$item_data["costprice"]:false); //cost price is 0 then return to the defined or original values.
		echo number_format($cart_data["quantity"]*$cart_data["costprice"],2);
		mysql_query("UPDATE tbl_cart_receiving SET subtotal = '".($cart_data["quantity"]*$cart_data["costprice"])."' WHERE accountID='$accountID' AND itemID='$id'");
	}
	if(isset($costprice)){
		mysql_query("UPDATE tbl_cart_receiving SET costprice = '$costprice' WHERE accountID='$accountID' AND itemID='$id'");
		$cart_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID' AND itemID='$id'"));
		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$id'"));
		($cart_data["costprice"]==0?$cart_data["costprice"]=$item_data["costprice"]:false); //cost price is 0 then return to the defined or original values.
		echo number_format($cart_data["quantity"]*$cart_data["costprice"],2);
		mysql_query("UPDATE tbl_cart_receiving SET subtotal = '".($cart_data["quantity"]*$cart_data["costprice"])."' WHERE accountID='$accountID' AND itemID='$id'");
	}
}
}
?>
