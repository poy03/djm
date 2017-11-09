<?php
date_default_timezone_set('Asia/Manila');
ini_set('max_execution_time', 30000);
ini_set('max_input_vars', 3000);
define("DB_HOST", "");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DBNAME", "posdb");
define("APP_VERSION", "2.3");
if(isset($_COOKIE["LOGGED"])){
	$accountID = explode("c", $_COOKIE["LOGGED"]);
	$accountID = array_pop($accountID);
}elseif(isset($_SESSION['accountID'])){
	$accountID = $_SESSION['accountID'];
}
$type='';
$connect = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
mysql_select_db(DBNAME);

$updates = 0;
error_reporting(0);
//initialization of navbar's class 
$navbar_second_row = $navbar_first_row = "";
$accounting_period=0;
$limit_to_many_module_to_display_row_one_in_navbar = 8;
$nav_modules_array = array();
$app_db = mysql_query("SELECT * FROM app_config");
if(mysql_num_rows($app_db)==0){
	mysql_query("INSERT INTO app_config (type_payment,maximum_items_displayed) VALUES ('CASH, CHECK, CREDITS',50)");
}
			$configquery=mysql_query("SELECT * FROM app_config");
			if(mysql_num_rows($configquery)!=0){
				while($configrow=mysql_fetch_assoc($configquery)){
					$app_name=$configrow["app_name"];
					$type_payment=$configrow["type_payment"];
					$address=$configrow["address"];
					$accounting_period=$configrow["accounting_period"];
					$statementID=$configrow["statementID"];
					$contact_number=$configrow["contact_number"];
					$app_company_name=$configrow["app_company_name"];
					$maximum_items_displayed=$configrow["maximum_items_displayed"];
					$logo=$configrow["logo"];
				}
			}else{
				$app_name = $type_payment = $address = $contact_number = $app_company_name = $maximum_items_displayed = $logo = $display = "";
			}
			$items = $customers = $sales = $receiving = $users = $reports = $suppliers = $credits = $expenses = $salesman = '0';
			$date_now =date("m/d/Y");
			$datenow=date("m/d/Y");
			$timenow=date("h:i:s A");
		    $date=date("m/d/Y");
			$time=date("h:i:s A");
			$badge_credit = mysql_num_rows(mysql_query("SELECT * FROM tbl_orders WHERE payment='0' AND deleted='0' AND date_due<= '".strtotime($date)."'"));			
			$badge_items = mysql_num_rows(mysql_query("SELECT * FROM tbl_items WHERE quantity<=reorder AND deleted='0'"));
			$badge_receiving = 1;
			$badge_sales = mysql_num_rows(mysql_query("SELECT * FROM tbl_ts_orders WHERE processed='0' AND deleted='0'"));
			$badge_reports = mysql_num_rows(mysql_query("SELECT * FROM tbl_sales_edit WHERE approved='0' AND deleted='0'"));
			$badge_accounts_payable = mysql_num_rows(mysql_query("SELECT * FROM tbl_orders_receiving WHERE deleted='0' AND (payment='0' AND date_due <= '".strtotime($date)."') OR (freight_needs_payment='1' AND freight_payment='0'  AND date_due <= '".strtotime($date)."') ORDER BY date_received DESC"));



			$badge_credit_1 = mysql_num_rows(mysql_query("SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND date_due = '".strtotime($date)."'"));
			$badge_credit_2 = mysql_num_rows(mysql_query("SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND date_due< '".strtotime($date)."' AND overdue_date_1 > '".strtotime($date)."'"));
			$badge_credit_3 = mysql_num_rows(mysql_query("SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND overdue_date_1< '".strtotime($date)."' AND overdue_date_2 > '".strtotime($date)."'"));
			$badge_credit_4 = mysql_num_rows(mysql_query("SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND overdue_date_2< '".strtotime($date)."'"));

			$badge_credit = $badge_credit_1 + $badge_credit_2 + $badge_credit_3 + $badge_credit_4;


			$badge_expenses = mysql_num_rows(mysql_query("SELECT * FROM tbl_expenses WHERE fully_paid = '0' AND deleted='0' AND date_due > '".strtotime(date("m/d/Y"))."'"));
			$badge_expenses_due = mysql_num_rows(mysql_query("SELECT * FROM tbl_expenses WHERE fully_paid = '0' AND deleted='0' AND date_due <= '".strtotime(date("m/d/Y"))."'"));

			$badge_accounts_payable_page = $badge_accounts_payable;
			$badge_accounts_payable = $badge_accounts_payable + $badge_expenses + $badge_expenses_due;




			$badge_reports_to_dr = mysql_num_rows(mysql_query("SELECT * FROM tbl_ts_orders WHERE need_approve='1' AND deleted='0'"));
			$badge_reports_edit = $badge_reports;

			$badge_reports = $badge_reports+$badge_reports_to_dr;
			$GLOBALS['badge_credit'] = $badge_credit;
			$GLOBALS['badge_items'] = $badge_items;
			$GLOBALS['badge_receiving'] = $badge_receiving;
			$GLOBALS['badge_sales'] = $badge_sales;
			$GLOBALS['badge_reports'] = $badge_reports;
			$GLOBALS['badge_accounts_payable'] = $badge_accounts_payable;

			($GLOBALS['badge_credit']==0?$GLOBALS['badge_credit']="":false);
			($GLOBALS['badge_items']==0?$GLOBALS['badge_items']="":false);
			($GLOBALS['badge_receiving']==0?$GLOBALS['badge_receiving']="":false);
			($GLOBALS['badge_sales']==0?$GLOBALS['badge_sales']="":false);
			($GLOBALS['badge_reports']==0?$GLOBALS['badge_reports']="":false);
			($GLOBALS['badge_accounts_payable']==0?$GLOBALS['badge_accounts_payable']="":false);
$list_modules = array();
if(isset($accountID)){
$accquery = mysql_query("SELECT * FROM tbl_users WHERE accountID='$accountID'");
if(mysql_num_rows($accquery)!=0){
	while($accrow=mysql_fetch_assoc($accquery)){
		$type=$accrow["type"];
		$employee_name=$accrow["employee_name"];
		$themes=$accrow["themes"];
		$display=$accrow["display"];
		$payroll=1;
		$accounts_payable=$accrow["accounts_payable"];

		$items=$accrow["items"];
		$items_add=$accrow["items_add"];
		$items_modify=$accrow["items_modify"];
		$salesman=$accrow["salesman"];
		$salesman_add=$accrow["salesman_add"];
		$salesman_modify=$accrow["salesman_modify"];
		$customers=$accrow["customers"];
		$customers_add=$accrow["customers_add"];
		$customers_modify=$accrow["customers_modify"];
		$salesman=$accrow["salesman"];
		$salesman_add=$accrow["salesman_add"];
		$salesman_modify=$accrow["salesman_modify"];
		$users=$accrow["users"];
		$users_add=$accrow["users_add"];
		$users_modify=$accrow["users_modify"];
		$suppliers = $accrow["suppliers"];
		$suppliers_add = $accrow["suppliers_add"];
		$suppliers_modify = $accrow["suppliers_modify"];

		$sales=$accrow["sales"];
		$expenses=$accrow["expenses"];
		$receiving=$accrow["receiving"];
		$reports=$accrow["reports"];
		$credits = $accrow["credits"];

		if($accounting_period==0){
			//if accounting period is disabled, these modules with are not available.
			// $items_add =
			// $items_modify =
			$sales =
			$expenses =
			$receiving =
			$credits = 0;
		}

		$total_modules = $items + $customers + $sales + $receiving + $users+ $reports + $suppliers + $credits + $expenses + $salesman + $accounts_payable + $payroll +2; // 2 is for maintenance and settings

		($items==1?$items_module = 1:$items_module = 0);
		($customers==1?$customers_module = 2:$customers_module = 0);
		($sales==1?$sales_module = 3:$sales_module = 0);
		($salesman==1?$salesman_module = 4:$salesman_module = 0);
		($receiving==1?$receiving_module = 5:$receiving_module = 0);
		($users==1?$users_module = 6:$users_module = 0);
		($reports==1?$reports_module = 7:$reports_module = 0);
		($suppliers==1?$suppliers_module = 8:$suppliers_module = 0);
		($credits==1?$credits_module = 9:$credits_module = 0);
		($expenses==1?$expenses_module = 10:$expenses_module = 0);
		($payroll==1?$payroll_module = 11:$payroll_module = 0);
		($accounts_payable==1?$accounts_payable_module = 12:$accounts_payable_module = 0);
		$list_modules = array($items_module,$customers_module,$sales_module,$salesman_module,$receiving_module,$users_module,$reports_module,$suppliers_module,$credits_module,$expenses_module,$payroll_module,$accounts_payable_module,13,14);

		$list_modules = array_unique($list_modules);
		sort($list_modules);
		if($total_modules<12){
			array_shift($list_modules);
		}
		//if total modules-2 is less than number of modules to display in navbar then set the style to navbar second row to display:none else add hide-navbar class in the first navbar, hide-navbar is used in style.css
		(($total_modules-2)<$limit_to_many_module_to_display_row_one_in_navbar?$navbar_second_row="style='display:none !important'":$navbar_first_row="hide-navbar");
		// print_r($list_modules);

	}
	if($type=='admin'){
		$logged=2;
	}else{
		$logged=1;
	}
}else{
	$logged=0;
}
}else{
	$logged=0;
	$type='';
}

if($updates==1){
	if(preg_match("/\bpatch\b/i", $_SERVER["REQUEST_URI"])){
		echo "patching....";
	}else{
		if(!preg_match("/\bwait\b/i", $_SERVER["REQUEST_URI"])){
			header("location:wait");
		}
	}
}

//auto backup if it has already a backup each day
$filename_of_db = DBNAME."_(".date("m-d-Y").").sql";
if(!file_exists("auto_backup/".$filename_of_db)){
	$auto_backup = new Auto_backup;
	$auto_backup->export_tables(DB_HOST,DB_USER,DB_PASSWORD,DBNAME);
}
class Template
{
	public function announcement($accounting_period,$logged){
		if($accounting_period!=1&&$logged!=0){
			return "
			<div class = 'alert alert-danger alert-dismissable announcement'>
			   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
				  &times;
			   </button>
			   <strong>Accounting Period has not been started. Please contact administrator to enable sales.</strong>
			</div>
			";
		}
	}
	
	public function header($module,$badge,$display){
		$display_string = " ";
		$no_display_string = "";
		($badge==0?$badge="":false);
		switch ($module) {
			case '1':
				# code...
				$string_to_display = "Items";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='item'><span class = 'glyphicon glyphicon-briefcase'></span> $display_string <span class = 'badge'>".$GLOBALS['badge_items']."</span></a></li>";
				$onclick = 'location="item"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='item' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-briefcase'></span> $display_string 
							<span class = 'badge'>".$GLOBALS['badge_items']."</span>
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='item-add'>Add Items</a></li>
				        </ul>
				      </li>
				";
				
				break;
			case '2':
				# code...

					$string_to_display = "Customers";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='customer'><span class = 'glyphicon glyphicon-user'></span> $display_string </a></li>";
				$onclick = 'location="customer"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='customer' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-user'></span> $display_string 
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='customer-add'>Add Customer</a></li>
				        </ul>
				      </li>
				";
				break;
			case '3':
				# code...
				$string_to_display = "Sales";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='sales'><span class = 'glyphicon glyphicon-shopping-cart'></span> $display_string <kbd>F2</kbd> <span class = 'badge'>$badge</span> </a></li>";
				$onclick = 'location="sales"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='sales' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-shopping-cart'></span> $display_string 
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='sales'>Make Delivery Receipt</a></li>
				          <li><a href='sales-ts'>Make Transaction Sheet</a></li>
				          <li><a href='sales-ts-list'>List of Transaction Sheet</a></li>
				          <li><a href='sales-dr-list'>List of Delivery Receipt</a></li>
				        </ul>
				      </li>
				";
				break;
			case '4':
				# code...
				$string_to_display = "Salesman";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='salesman'><span class = 'glyphicon glyphicon-user'></span> $display_string </a></li>";
				$onclick = 'location="salesman"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='salesman' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-user'></span> $display_string 
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='salesman-add'>Add Salesman</a></li>
				        </ul>
				      </li>
				";
				break;									
			case '5':
				# code...
				$string_to_display = "Purchases";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				return "<li $no_display_string id='$string_to_display'><a href='receiving'><span class = 'glyphicon glyphicon-download-alt'></span> $display_string </a></li>";
				break;
			case '6':
				# code...
				$string_to_display = "Users";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='users'><span class = 'glyphicon glyphicon-user'></span> $display_string </a></li>";
				$onclick = 'location="users"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='user' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-user'></span> $display_string 
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='users-add'>Add User</a></li>
				        </ul>
				      </li>
				";
				break;
			case '7':
				# code...			
				$string_to_display = "Reports";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='reports'><span class = 'glyphicon glyphicon-stats'></span> $display_string <span class = 'badge'>".$GLOBALS["badge_reports"]."</span></a></li>";
				$onclick = 'location="reports"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='user' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-stats'></span> $display_string 
							<span class = 'badge'>".$GLOBALS["badge_reports"]."</span>
						</a>
				        <ul class='dropdown-menu'>
				          <li class='dropdown-header'>Expenses</li>
				          <li><a href='expenses'>Add Selling Expenses</a></li>
				          <li><a href='expenses?tab=2'>Add Admin Expenses</a></li>
				          <li><a href='expenses?tab=3'>Add Capital Expenses</a></li>
				          <li><a href='expenses-list'>View Expenses</a></li>
				          <li class='dropdown-header'>Reports</li>
				          <li><a href='reports?tab=1'>Sales Reports</a></li>
				          <li><a href='reports?tab=11'>Sales Per Items Reports</a></li>
				          <li><a href='reports?tab=14'>Deleted TS Reports</a></li>
				          <li><a href='reports?tab=2'>Deleted Sales Reports</a></li>
				          <li><a href='reports?tab=13'>Request to Edit Sales</a></li>
				          <li><a href='reports?tab=16'>Sales Returns Reports</a></li>
				          <li><a href='reports?tab=10'>Accepted Sales Edits</a></li>
				          <li><a href='reports?tab=8'>Deleted Request to Edit Sales</a></li>
				          <li><a href='reports?tab=3'>Purchases Reports</a></li>
				          <li><a href='reports?tab=17'>Approval for Delivery Receipt</a></li>
				          <li><a href='reports?tab=4'>Expenses Reports</a></li>
				          <li><a href='reports?tab=5'>Deleted Expenses</a></li>
				          <li><a href='reports?tab=6'>Payments Reports</a></li>
				          <li><a href='reports?tab=15'>All Reports</a></li>
				        </ul>
				      </li>
				";
				break;
			case '8':
				# code...
				$string_to_display = "Suppliers";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='suppliers'><span class='glyphicon glyphicon-phone'></span> $display_string </a></li>";
				$onclick = 'location="suppliers"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='user' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-phone'></span> $display_string 
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='suppliers-add'>Add Supplier</a></li>
				        </ul>
				      </li>
				";
				break;
			case '9':
				# code...
				$string_to_display = "Accounts Receivable";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='Credits'><a href='credits'><span class = 'glyphicon glyphicon-copyright-mark'></span> $display_string <span class='badge'>".$GLOBALS["badge_credit"]."</span></a></li>";
				$onclick = 'location="credits"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='user' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-copyright-mark'></span> $display_string 
							<span class='badge'>".$GLOBALS["badge_credit"]."</span>
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='credits'>Accounts Receivable</a></li>
				          <li><a href='credits?tab=9'>Due</a></li>
				          <li><a href='credits?tab=4'>Past Due (1-30 Days)</a></li>
				          <li><a href='credits?tab=7'>Past Due (31-60 Days)</a></li>
				          <li><a href='credits?tab=8'>Past Due (over 61 Days)</a></li>
				          <li><a href='credits?tab=5'>Paid with Cash</a></li>
				          <li><a href='credits?tab=6'>Paid with PDC</a></li>
				        </ul>
				      </li>
				";
				break;				
			case '10':
				# code...
				$string_to_display = "Expenses";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='$string_to_display'><a href='expenses'><span class='glyphicon glyphicon-list-alt'></span> $display_string </a></li>";
				$onclick = 'location="expenses"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='user' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-list-alt'></span> $display_string 
						</a>
				        <ul class='dropdown-menu'>
				          <li><a href='expenses'>Add Selling Expenses</a></li>
				          <li><a href='expenses?tab=2'>Add Admin Expenses</a></li>
				          <li><a href='expenses?tab=3'>Add Capital Expenses</a></li>
				          <li><a href='expenses-list'>View Expenses</a></li>
				        </ul>
				      </li>
				";
				break;
			case '11':
				# code...
				$string_to_display = "Payroll";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				return "";
				break;							
			case '12':
				# code...
				$string_to_display = "Accounts Payable";
				($display==1?$display_string=$string_to_display:$display_string=$string_to_display[0]);
				($display==1?false:$no_display_string="data-balloon='".$string_to_display."' data-balloon-pos='down'");
				// return "<li $no_display_string id='accounts_payable'><a href='accounts-payable'><span class='glyphicon glyphicon-pushpin'></span> $display_string <span class='badge'>".$GLOBALS["badge_accounts_payable"]."</span></a></li>";
				$onclick = 'location="accounts-payable"';
				return "
				<li class='dropdown' $no_display_string id='$string_to_display'>
						<a href='user' class='dropdown-toggle' data-toggle='dropdown' onclick='".$onclick."'>
							<span class = 'glyphicon glyphicon-pushpin'></span> $display_string 
							<span class='badge'>".$GLOBALS["badge_accounts_payable"]."</span>
						</a>
				        <ul class='dropdown-menu'>
				          <li class='dropdown-header'>Accounts Payables</li>
				          <li><a href='accounts-payable'>View Purchases</a></li>
				          <li><a href='accounts-payable?tab=2'>Due and Past Due</a></li>
				          <li><a href='accounts-payable?tab=3'>Paid Accounts</a></li>
				          <li class='dropdown-header'>Expenses Payables</li>
				          <li><a href='accounts-payable?tab=4'>View Expenses Payables</a></li>
				          <li><a href='accounts-payable?tab=5'>Due and Past Due Expenses Payables</a></li>
				        </ul>
				      </li>
				";
				break;					
			default:
				# code...
				return "";
				break;
		}
	}	
}

class Auto_backup
{
	public function export_tables($host,$user,$pass,$name,  $tables=false, $backup_name=false )
	{
	$link = mysqli_connect($host,$user,$pass,$name);
	// Check connection
	if (mysqli_connect_errno())   {   echo "Failed to connect to MySQL: " . mysqli_connect_error();   }

	mysqli_select_db($link,$name);
	mysqli_query($link,"SET NAMES 'utf8'");

	//get all of the tables
	if($tables === false)
	{
	    $tables = array();
	    $result = mysqli_query($link,'SHOW TABLES');
	    while($row = mysqli_fetch_row($result))
	    {
	        $tables[] = $row[0];
	    }
	}
	else
	{
	    $tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	$return='';
	//cycle through
	foreach($tables as $table)
	{
	    $result = mysqli_query($link,'SELECT * FROM '.$table);
	    $num_fields = mysqli_num_fields($result);

	    $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
	    $return.= "\n\n".$row2[1].";\n\n";

	    for ($i = 0; $i < $num_fields; $i++) 
	    {
	        $st_counter= 0;
	        while($row = mysqli_fetch_row($result))
	        {
	            //create new command if when starts and after 100 command cycle
	            if ($st_counter%100 == 0 || $st_counter == 0 )  {
	                $return.= "\nINSERT INTO ".$table." VALUES";
	            }


	            $return.="\n(";
	            for($j=0; $j<$num_fields; $j++) 
	            {
	                $row[$j] = addslashes($row[$j]);
	                $row[$j] = str_replace("\n","\\n",$row[$j]);
	                if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
	                if ($j<($num_fields-1)) { $return.= ','; }
	            }
	            $return.=")";


	            //create new command if when starts and after 100 command cycle (but detect this 1 cycle earlier !)
	            if ( ($st_counter+1)%100 == 0  && $st_counter != 0 )    {   $return.= ";";  }
	            else                                                {   $return.= ",";  }
	            //+++++++
	            $st_counter = $st_counter +1 ;
	        }
	        //as we cant detect WHILE loop end, so, just detect, if last command ends with comma(,) then replace it with semicolon(;)
	        if (substr($return, -1) == ',') {$return = substr($return, 0, -1). ';'; }
	    }
	    $return.="\n\n\n";
	}

	//save file
	$backup_name = $backup_name ? $backup_name : $name."_(".date("m-d-Y").")v".APP_VERSION.".sql";
	// file_put_contents("backups/".$backup_name,$return);
	file_put_contents("auto_backup/".$backup_name,$return);
	// if(file_exists("E:/auto_backup/")){
	// 	file_put_contents("E:/POS_auto_backup/".$backup_name,$return);
	// }else{
	// 	mkdir("E:/POS_auto_backup/");
	// 	file_put_contents("E:/POS_auto_backup/".$backup_name,$return);
	// }
	// file_put_contents("D:/auto_backup/".$backup_name,$return);
	// die('SUCCESS. Download BACKUP file: <a target="_blank" href="'.$backup_name.'">'.$backup_name.'</a> <br/><br/>After download, <a target="_blank" href="?delete_filee='.$backup_name.'">Delete it!</a> ');
	// header("location:backups/".$backup_name);
	}

/*	if (!empty($_GET['delete_filee'])){ chdir(dirname(__file__));       
	if  (unlink($_GET['delete_filee'])) {die('file_deleted');} 
	else                                {die("file doesnt exist");}
	}*/

}
?>