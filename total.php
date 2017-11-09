<?php
ob_start();
session_start();



include 'db.php';

?>

<?php
if($_POST)
{
$total = @$_POST["total"];
if(isset($total)){
	if($total=="receiving"){
		$total_query = mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID'");
		if(mysql_num_rows($total_query)!=0){
			$total=0;
			while($total_row=mysql_fetch_assoc($total_query)){
				$costprice = $total_row["costprice"];
				$quantity = $total_row["quantity"];
				$itemID = $total_row["itemID"];
				$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
				($costprice==0?$costprice=$item_data["costprice"]:false);
				$subtotal = ($quantity*$costprice);
				$total += $subtotal;
			}
			echo number_format($total,2);
		}
	}

	if($total=="sales"){
		$total_query = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");
		if(mysql_num_rows($total_query)!=0){
			$total=0;
			while($total_row=mysql_fetch_assoc($total_query)){
				$costprice = $total_row["costprice"];
				$quantity = $total_row["quantity"];
				$itemID = $total_row["itemID"];
				$type_price = $total_row["type_price"];
				$price = $total_row["price"];
				$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
				($price==0?$price=$item_data["$type_price"]:false);
				$subtotal = ($quantity*$price);
				$total += $subtotal;
			}
			echo "₱".number_format($total,2);
		}
	}
	if($total=="sales_ts"){
		$total_query = mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID'");
		if(mysql_num_rows($total_query)!=0){
			$total=0;
			while($total_row=mysql_fetch_assoc($total_query)){
				$costprice = $total_row["costprice"];
				$quantity = $total_row["quantity"];
				$itemID = $total_row["itemID"];
				$type_price = $total_row["type_price"];
				$price = $total_row["price"];
				$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
				($price==0?$price=$item_data["$type_price"]:false);
				$subtotal = ($quantity*$price);
				$total += $subtotal;
			}
			echo number_format($total,2);
		}
	}

	if($total=="sales_ts_total"){
		$discount = @$_POST["discount"];
		if(isset($discount)){
			mysql_query("UPDATE tbl_ts_cart SET discount='$discount' WHERE accountID='$accountID'");
		}
		$total_query = mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID'");
		if(mysql_num_rows($total_query)!=0){
			$total=0;
			while($total_row=mysql_fetch_assoc($total_query)){
				$costprice = $total_row["costprice"];
				$discount = $total_row["discount"];
				$quantity = $total_row["quantity"];
				$itemID = $total_row["itemID"];
				$type_price = $total_row["type_price"];
				$price = $total_row["price"];
				$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
				($price==0?$price=$item_data["$type_price"]:false);
				$subtotal = ($quantity*$price);
				$total += $subtotal;
			}
			echo number_format($total-$discount,2);
		}
	}
}				
}
?>
