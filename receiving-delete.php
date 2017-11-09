<?php
ob_start();
session_start();



include 'db.php';

?>

<?php
if($_POST)
{
$delete=@$_POST['delete'];
$comments=@$_POST['comments'];
if(isset($delete)){
	mysql_query("UPDATE tbl_orders_receiving SET deleted='1', date_deleted='".strtotime($date)."', deleted_by='$accountID', deleted_comments='$comments' WHERE orderID='$delete'");
	mysql_query("UPDATE tbl_receiving SET deleted='1' WHERE orderID='$delete'");
	$receiving_query = mysql_query("SELECT * FROM tbl_receiving WHERE orderID='$delete'");
	while($receiving_row=mysql_fetch_assoc($receiving_query)){
		$itemID = $receiving_row["itemID"];
		$quantity = $receiving_row["quantity"];

		$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
		$new_quantity = $item_data["quantity"]- $quantity;

		mysql_query("UPDATE tbl_items SET quantity='$new_quantity' WHERE itemID = '$itemID'");
	}
}
}
?>
