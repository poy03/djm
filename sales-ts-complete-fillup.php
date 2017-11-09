<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$orderID=@$_GET['id'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
$by=@$_GET['by'];
$order=@$_GET['order'];
error_reporting(0);

include 'db.php';


if($_POST){
	$ts_orderID = $_POST["id"];
	$type = $_POST["type"];
	$value = $_POST["value"];
	if(isset($_POST["amount"])||$_POST["amount"]=='1'){
		mysql_query("UPDATE tbl_ts_orders SET $type = '$value' WHERE ts_orderID='$ts_orderID'");
		// echo number_format($value,2);
		$ts_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_ts_orders WHERE ts_orderID='$ts_orderID'"));
		// $data = array();
		$credit_line = $ts_data["credit_line"];
		$outstanding_bal = $ts_data["outstanding_bal"];
		$available_bal = $credit_line-$outstanding_bal;
		$additional_case = $ts_data["additional_case"];
		$overhang = $available_bal-$additional_case;

		
		mysql_query("UPDATE tbl_ts_orders SET credit_line='$credit_line',outstanding_bal='$outstanding_bal',available_bal='$available_bal',additional_case='$additional_case', overhang='$overhang' WHERE ts_orderID='$ts_orderID'");

		$data = array(
			"credit_line" => $credit_line,
			"outstanding_bal" => $outstanding_bal,
			"available_bal" => $available_bal,
			"additional_case" => $additional_case,
			"overhang" => $overhang,
			"query" => "UPDATE tbl_ts_orders SET credit_line='$credit_line',outstanding_bal='$outstanding_bal',available_bal='$available_bal',additional_case='$additional_case', overhang='$overhang' FROM tbl_ts_orders WHERE ts_orderID='$ts_orderID'"
			);
		echo json_encode($data);
	}else{
		$value = mysql_real_escape_string($_POST["value"]);
		mysql_query("UPDATE tbl_ts_orders SET $type = '$value' WHERE ts_orderID='$ts_orderID'");
	}

}
?>