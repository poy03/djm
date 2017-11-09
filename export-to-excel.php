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

if(isset($_POST["export"])){
$post_category = mysql_real_escape_string(htmlspecialchars_decode(trim($_POST["category"])));
$post_supplier = mysql_real_escape_string(htmlspecialchars_decode(trim($_POST["supplier"])));
$post_sub_costprice = mysql_real_escape_string(htmlspecialchars(trim($_POST["sub_costprice"])));
$post_costprice = mysql_real_escape_string(htmlspecialchars(trim($_POST["costprice"])));
$post_srp = mysql_real_escape_string(htmlspecialchars(trim($_POST["srp"])));
$post_std_price_to_trade_terms = mysql_real_escape_string(htmlspecialchars(trim($_POST["std_price_to_trade_terms"])));
$post_std_price_to_trade_cod = mysql_real_escape_string(htmlspecialchars(trim($_POST["std_price_to_trade_cod"])));
$post_price_to_distributors = mysql_real_escape_string(htmlspecialchars(trim($_POST["price_to_distributors"])));
$query = "SELECT * FROM tbl_items WHERE deleted='0'";
if(isset($post_category)&&$post_category!=""&&$post_category!="all"){
	$query.=" AND category = '".$post_category."'";
}

if(isset($post_supplier)&&$post_supplier!=""&&$post_supplier!="all"){
	$query.=" AND supplierID = '".$post_supplier."'";
}


$query.=" ORDER BY category ASC";
echo $query;
$item_query = mysql_query($query);
// exit;

$filename = "list-of-items\list-of-items-".date("F-d-Y-").date("h-i-s-A").".csv";
$fp = fopen($filename, 'w');
$fields = array("CATEGORY","ITEM NAME","ITEM CODE","UOM","QUANTITY","SUB COST PRICE","TOTAL COST PRICE","WPP","STD PRICE TO TRADE","STD PRICE TO COD","PRICE TO DISTRIBUTORS");
fputcsv($fp, $fields);
if(mysql_num_rows($item_query)!=0){
	while($item_row=mysql_fetch_assoc($item_query)){
		$category = $item_row["category"];
		$itemname = $item_row["itemname"];
		$item_code = $item_row["item_code"];
		$unit_of_measure = $item_row["unit_of_measure"];
		$quantity = $item_row["quantity"];
		(isset($post_sub_costprice)?$sub_costprice = $item_row["sub_costprice"]:$sub_costprice = '');
		(isset($post_costprice)?$costprice = $item_row["costprice"]:$costprice = '');
		(isset($post_srp)?$srp = $item_row["srp"]:$srp = '');
		(isset($post_std_price_to_trade_terms)?$std_price_to_trade_terms = $item_row["std_price_to_trade_terms"]:$std_price_to_trade_terms = '');
		(isset($post_std_price_to_trade_cod)?$std_price_to_trade_cod = $item_row["std_price_to_trade_cod"]:$std_price_to_trade_cod = '');
		(isset($post_price_to_distributors)?$price_to_distributors = $item_row["price_to_distributors"]:$price_to_distributors = '');
		$fields = array($category,$itemname,$item_code,$unit_of_measure,$quantity,number_format($sub_costprice,2),number_format($costprice,2),number_format($srp,2),number_format($std_price_to_trade_terms,2),number_format($std_price_to_trade_cod,2),number_format($price_to_distributors,2));
		fputcsv($fp, $fields);
	}

}
fclose($fp);
header("location:".$filename);
// unlink($filename);
}
?>