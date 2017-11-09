<?php

ob_start();
session_start();
$accountID=@$_SESSION['accountID'];

include 'db.php';


if(isset($_POST["save"])){// Start of Accounting Period
	// beginning inventory
	$item_query = mysql_query("SELECT DISTINCT category FROM tbl_items WHERE deleted='0' ORDER BY category");
	$category_items = array();
	$category_value = array();
	if(mysql_num_rows($item_query)!=0){
		while($item_row=mysql_fetch_assoc($item_query)){
			$category_items[] = mysql_real_escape_string(htmlspecialchars(trim($item_row["category"])));
			$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(costprice*quantity) as total_amount FROM tbl_items WHERE category='".mysql_real_escape_string(htmlspecialchars(trim($item_row["category"])))."' AND deleted='0'"));
			$category_value[] = sprintf("%0.2f",$total_amount["total_amount"]);
		}
	}
	$items_to_database = implode("---", $category_items);
	$value_to_database = implode("---", $category_value);
	mysql_query("INSERT INTO tbl_income_statement (beginning_inventory_items, beginning_inventory_value, beginning_date, beginning_time, beginning_by) VALUES ('$items_to_database','$value_to_database','".strtotime($date)."','".strtotime($time)."','$accountID')");
	//find the latest statementID in the database
	$statementID = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_income_statement ORDER BY statementID DESC LIMIT 0,1"));
	$statementID = $statementID["statementID"];
	//global settings for accounting
	mysql_query("UPDATE app_config SET statementID='$statementID', accounting_period='1' WHERE id='1'");
	header("location:reports?tab=15");
}

if(isset($_POST["end"])){// End of Accounting Period
	//start closing inventory
	$item_query = mysql_query("SELECT DISTINCT category FROM tbl_items WHERE deleted='0' ORDER BY category");
	//inititalization of arrays
	$category_items = array();
	$category_value = array();
	if(mysql_num_rows($item_query)!=0){
		while($item_row=mysql_fetch_assoc($item_query)){
			$category_items[] = mysql_real_escape_string(htmlspecialchars(trim($item_row["category"])));
			$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(costprice*quantity) as total_amount FROM tbl_items WHERE category='".mysql_real_escape_string(htmlspecialchars(trim($item_row["category"])))."' AND deleted='0'"));
			$category_value[] = sprintf("%0.2f",$total_amount["total_amount"]);//to prevent data to have many trailing zeros
		}
	}

	//I used implode to insert all category of items in one field only.
	$closing_inventory_items = implode("---", $category_items);
	$closing_inventory_value = implode("---", $category_value);

	mysql_query("UPDATE tbl_income_statement SET closing_inventory_items = '$closing_inventory_items', closing_inventory_value='$closing_inventory_value', closing_date='".strtotime($date)."', closing_time='".strtotime($time)."', closing_by='$accountID' WHERE statementID='$statementID'");
	// end of closing inventory

	// data of the latest income statement
	$income_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_income_statement WHERE statementID='$statementID'"));

	//begin purchases
	$category_items_receiving = $category_items; //copy the data in the array of item's category
	$category_value_receiving = array();
	$date_from = $income_data["beginning_date"];
	$date_to = strtotime($date);
	
	$total = 0;
	$i=0;
	foreach ($category_items_receiving as $category_items_each) {
		//initialize item_list or empty the data of the item_list array
		$item_list = array();
		//query to get the list of item per category
		$item_query = mysql_query("SELECT * FROM tbl_items WHERE deleted='0' AND category='$category_items_each'");
		while($item_row = mysql_fetch_assoc($item_query)){
			$item_list[] = $item_row["itemID"]; // add to array list of items per category
		}
		//query to get the subtotal of all purchases of from given dates per category.
		$query = "SELECT SUM(subtotal) as subtotal_cost FROM tbl_receiving WHERE type='purchase' AND deleted='0' AND date_received BETWEEN '$date_from' AND '$date_to'";
		$i=0;
		//loop to get all the list of items per category using AND (itemID OR itemID OR ItemID) in the query
		foreach($item_list as $item_each){
			if($i==0){
				$query.=" AND (itemID='$item_each'";
			}else{
				$query.=" OR itemID='$item_each'";
			}
			$i++;
		}
		$query.=")";
		$total_cost = mysql_fetch_assoc(mysql_query($query));
		//to make sure that the value to output is 0 and not null.
		($total_cost["subtotal_cost"]==""?$category_value_receiving[]=0:$category_value_receiving[]=number_format($total_cost["subtotal_cost"],2,".",""));
		$total+=$total_cost["subtotal_cost"];
	}
	//I used implode to insert all category of items in one field only.
	$receiving_items = implode("---", $category_items_receiving);
	$receiving_value = implode("---", $category_value_receiving);
	mysql_query("UPDATE tbl_income_statement SET receiving_items = '$receiving_items', receiving_value='$receiving_value' WHERE statementID='$statementID'");

	//end purchases

	//start freight charges
	//query to get the amount of freight charges from the given dates
	$freight_charges = mysql_fetch_assoc(mysql_query("SELECT SUM(freight_payment) as total_freight FROM tbl_orders_receiving WHERE type='purchase' deleted='0' AND freight_payment_date BETWEEN '$date_from' AND '$date_to'"));
	mysql_query("UPDATE tbl_income_statement SET freight = '".number_format($freight_charges["total_freight"],2,".","")."' WHERE statementID='$statementID'");
	//end freight charges

	//start selling expenses
	$selling_expenses_items = array();
	$selling_expenses_value = array();
	$selling_expenses_query = mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses WHERE deleted='0' AND category='selling' AND date BETWEEN '$date_from' AND '$date_to' ORDER BY expense_account");
	if(mysql_num_rows($selling_expenses_query)!=0){
		while($selling_expenses_row=mysql_fetch_assoc($selling_expenses_query)){
			$selling_expenses_items[] = mysql_real_escape_string(htmlspecialchars(trim($selling_expenses_row["expense_account"])));
			$selling_expenses = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_expenses FROM tbl_expenses WHERE category='selling' AND date BETWEEN '$date_from' AND '$date_to' AND expense_account='".mysql_real_escape_string(htmlentities(trim($selling_expenses_row["expense_account"])))."' AND deleted='0'"));
			$selling_expenses_value[] = number_format($selling_expenses["total_expenses"],2,".","");
		}
	}
	//end selling expenses
	//start admin expenses
	$admin_expenses_items = array();
	$admin_expenses_value = array();
	$admin_expenses_query = mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses WHERE deleted='0' AND category='admin' AND date BETWEEN '$date_from' AND '$date_to' ORDER BY expense_account");
	if(mysql_num_rows($admin_expenses_query)!=0){
		while($admin_expenses_row=mysql_fetch_assoc($admin_expenses_query)){
			$admin_expenses_items[] = mysql_real_escape_string(htmlspecialchars(trim($admin_expenses_row["expense_account"])));
			$admin_expenses = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_expenses FROM tbl_expenses WHERE category='admin' AND date BETWEEN '$date_from' AND '$date_to' AND expense_account='".mysql_real_escape_string(htmlentities(trim($admin_expenses_row["expense_account"])))."' AND deleted='0'"));
			$admin_expenses_value[] = number_format($admin_expenses["total_expenses"],2,".","");
		}
	}
	//end admin expenses

	//start capital expenses
	$capital_expenses_items = array();
	$capital_expenses_value = array();
	$capital_expenses_query = mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses WHERE deleted='0' AND category='capital' AND date BETWEEN '$date_from' AND '$date_to' ORDER BY expense_account");
	if(mysql_num_rows($capital_expenses_query)!=0){
		while($capital_expenses_row=mysql_fetch_assoc($capital_expenses_query)){
			$capital_expenses_items[] = mysql_real_escape_string(htmlspecialchars(trim($capital_expenses_row["expense_account"])));
			$capital_expenses = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_expenses FROM tbl_expenses WHERE category='capital' AND date BETWEEN '$date_from' AND '$date_to' AND expense_account='".mysql_real_escape_string(htmlentities(trim($capital_expenses_row["expense_account"])))."' AND deleted='0'"));
			$capital_expenses_value[] = number_format($capital_expenses["total_expenses"],2,".","");
		}
	}
	//end capital expenses

	$selling_expenses_items = implode("---", $selling_expenses_items); 
	$selling_expenses_value = implode("---", $selling_expenses_value); 
	$admin_expenses_items = implode("---", $admin_expenses_items); 
	$admin_expenses_value = implode("---", $admin_expenses_value);
	$capital_expenses_items = implode("---", $capital_expenses_items); 
	$capital_expenses_value = implode("---", $capital_expenses_value);
	mysql_query("UPDATE tbl_income_statement SET selling_expenses_items='$selling_expenses_items', selling_expenses_value='$selling_expenses_value' WHERE statementID='$statementID'");
	mysql_query("UPDATE tbl_income_statement SET admin_expenses_items='$admin_expenses_items', admin_expenses_value='$admin_expenses_value' WHERE statementID='$statementID'");
	mysql_query("UPDATE tbl_income_statement SET capital_expenses_items='$capital_expenses_items', capital_expenses_value='$capital_expenses_value' WHERE statementID='$statementID'");

	//start total sales
	//query to sum all the total sales from the given dates.
	$total_sales_db = mysql_fetch_assoc(mysql_query("SELECT SUM(total) as total_sales FROM tbl_orders WHERE date_ordered BETWEEN '$date_from' AND '$date_to' AND deleted='0'"));

	mysql_query("UPDATE tbl_income_statement SET sales='".number_format($total_sales_db["total_sales"],2,".","")."' WHERE statementID='$statementID'");
	//end total sales

	//start discounts
	//query to sum all the discounts from the given dates.
	$total_discount = mysql_fetch_assoc(mysql_query("SELECT SUM(discount) as total_discount FROM tbl_ts_orders WHERE orderID!='0' AND deleted='0' AND date_ordered BETWEEN '$date_from' AND '$date_to'"));
	//end discounts

	//start bad orders
	$bad_orders = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total_bad_orders FROM tbl_receiving WHERE (type='bad order' OR type='good order')  AND deleted='0' AND date_received BETWEEN '$date_from' AND '$date_to'"));
	//end bad orders
	
	//start returns
	$total_returns = mysql_fetch_assoc(mysql_query("SELECT SUM(new_quantity*price) as total_returns FROM tbl_sales_edit_items WHERE deleted='0' AND date_approved BETWEEN '$date_from' AND '$date_to' AND approved_by!='0'"));
	mysql_query("UPDATE tbl_income_statement SET complete='1' ,sales_returns_discount='".number_format(($total_returns["total_returns"]+$total_discount["total_discount"]+$bad_orders['total_bad_orders']),2,".","")."' WHERE statementID='$statementID'");
	//end returns

	mysql_query("UPDATE app_config SET statementID='0', accounting_period='0' WHERE id='1'");
	header("location:reports-income-statement?id=".$statementID);
}
?>