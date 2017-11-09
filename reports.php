<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$tab=@$_GET['tab'];
if(!isset($tab)){
	$tab=1;
}
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Reports</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  if(isset($themes)&&$themes!=''){
	  echo "<link rel='stylesheet' href='css/$themes'>";
  }else{
	  echo "<link rel='stylesheet' href='css/bootstrap.min.css'>";
  }
  
  ?>
  
  <link rel="stylesheet" href="style.css">
  <script src="jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/balloon.css">
<link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>
  
  
    <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
    
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="css/balloon.css">

  <script>
		$(document).ready(function(){
		$("#date_expense,#date_from,#date_to,#date_cost,#date_sales,#date_from_1,#date_to_1,#date_customer_f,#date_customer_f_1,#date_customer_t_1,#date_customer_t,#date_deleted_sales,#date_now").datepicker();
		$("#date_now").change(function(){
			var date_now = $(this).val();
			window.location = "reports?tab=6&d="+date_now;
		});
			$(".return").click(function(e){
				// alert(e.target.id);
				var dataStr = "id="+e.target.id+"&return=1";
				$.ajax({
					type: 'POST',
					url: 'sales-return',
					data: dataStr,
					cache: false,
					success: function(){
						location.reload();
					}
				});
			});
			

		
		
    $( "#customer,#customer_01" ).autocomplete({
      source: 'search-new-customer'
    });


    $("#approve_to_dr_form").submit(function(e){
    	e.preventDefault();
    	$.ajax({
    		type: "POST",
    		url: $("#approve_to_dr_form").attr("action"),
    		data: $("#approve_to_dr_form :input").serialize(),
    		cache: false,
    		success: function(data){
    			alert("Transaction Sheets are has been approved.");
    			location.reload();
    		}

    	});
    });

		$("#Reports").addClass("active");
		
  
  });

  </script>
    <style>
	  .item:hover{
	  cursor:pointer;
  }

	
	
		#item_results,#cus_results
	{
		position:absolute;
		width:250px;
		z-index:5;
		max-height:200px;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:auto;
		border:1px #CCC solid;
		background-color: white;
	}
	.show,.cusclose
	{
		padding:10px; 
		border-bottom:1px #999 dashed;
		font-size:15px; 
	}
	.cusclose:hover,.show:hover
	{
		background:#4c66a4;
		color:#FFF;
		cursor:pointer;
	}
	
	
	
	.page{
		display:none;
	}
	
@media print{
	.page{
		display:inline !important;
	}
  .prints{
	  display:none;
	  }
	  .content{
		  border-color:white;
	  }
	  
    a[href]:after {
    content: none !important;
  }
}
  </style>
</head>
<body>
<?php
	$announcement = new Template;
	echo $announcement->announcement($accounting_period,$logged);

?>
	   <nav class = "navbar navbar-default" role = "navigation" id='heading'>
	   <div class = "navbar-header">
		  <button type = "button" class = "navbar-toggle" 
			 data-toggle = "collapse" data-target = ".example-navbar-collapse">
			 <span class = "sr-only">Toggle navigation</span>
			 <span class = "icon-bar"></span>
			 <span class = "icon-bar"></span>
			 <span class = "icon-bar"></span>
		  </button>
		  <a class = "navbar-brand" href = "index"><?php echo $app_name; ?></a>
	   </div>
	   <div class = "collapse navbar-collapse example-navbar-collapse" id = "">
		 <ul class = 'nav navbar-nav  navbar-left'>
		  <?php
		  $header = new Template;

		  for ($i=0; $i <$limit_to_many_module_to_display_row_one_in_navbar ; $i++) { 
		  	if($logged!=0&&$i<$total_modules-2){
		  		echo $header->header($list_modules[$i],0,$display);
		  	}
		  }
		  ?>
		</ul>		  
		  <?php 
		  if($logged==0){
			
		  ?>
		  	<ul class='nav navbar-nav navbar-right'>
				<li><a href='login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
			</ul>
		  <?php }else{ ?>
		  	
		  	<?php echo "<ul class ='nav navbar-nav  navbar-right $navbar_first_row'>"; ?>
		  	 <div class="form-group navbar-form navbar-left div-of-search">
		  		<input type="text" class="form-control main-search" placeholder="Search" style="width: 75px">
		  	 </div>
				<li>
					<a href='#' role='button'
					  data-container = 'body' data-toggle = 'popover' data-placement = 'bottom' 
					  data-content = "
						<a href='settings' class = 'list-group-item'><span class='glyphicon glyphicon-cog'></span> Settings</a>
						<a href = 'maintenance' class = 'list-group-item'><span class='glyphicon glyphicon-hdd'></span> Maintenance</a><a href = 'logout' class = 'list-group-item'><span class='glyphicon glyphicon-log-out'></span> Logout</a><a href = 'shutdown-server' class = 'list-group-item shutdown-server'><span class='glyphicon glyphicon-off'></span> Shutdown</a>
					  ">
					Hi <?php echo $employee_name; ?></a></a>
				</li>
			</ul>

		  <?php }?>
		  </div>
		  <?php echo "<div class = 'collapse navbar-collapse example-navbar-collapse' $navbar_second_row>"; ?>
		  <a class = "navbar-brand app-name" href = "index"><?php echo $app_name; ?></a>
		   <ul class = 'nav navbar-nav  navbar-left'>
		    <?php
		    $header = new Template;

		    for ($i=$limit_to_many_module_to_display_row_one_in_navbar; $i <count($list_modules) ; $i++) { 
		    	echo $header->header($list_modules[$i],0,$display);
		    }
		    ?>
		  </ul>
		  <?php if($logged!=0){ ?>
		   <ul class ='nav navbar-nav  navbar-right'>
		   <div class="form-group navbar-form navbar-left div-of-search">
		  	<input type="text" class="form-control main-search" placeholder="Search" style="width: 75px">
		   </div>
		   <li>
		   	<a href='#' role='button'
		   	  data-container = 'body' data-toggle = 'popover' data-placement = 'bottom' 
		   	  data-content = "
		   		<a href='settings' class = 'list-group-item'><span class='glyphicon glyphicon-cog'></span> Settings</a>
		   		<a href = 'maintenance' class = 'list-group-item'><span class='glyphicon glyphicon-hdd'></span> Maintenance</a><a href = 'logout' class = 'list-group-item'><span class='glyphicon glyphicon-log-out'></span> Logout</a><a href = 'shutdown-server' class = 'list-group-item shutdown-server'><span class='glyphicon glyphicon-off'></span> Shutdown</a>
		   	  ">
		   	Hi <?php echo $employee_name; ?></a></a>
		   </li>
		  </ul>
		  </div>
		  <?php } ?>
	   </nav>	
<div class="container-fluid">
  <div class='row'>
  	<div class='col-md-12 prints'>
	
	
	<?php
	if($logged==1||$logged==2){
	if($reports=='1'){
		
		 ?>
		

		<div class='col-md-2'>
		
		<?php
		($badge_reports==0?$badge_reports="":false);
			echo "<label>Navigation:</label><a href = '?tab=1' class = 'list-group-item"; if(isset($tab)&&$tab=='1'){echo " active"; } echo "'>Sales Reports</a>";
			echo "<a href = '?tab=11' class = 'list-group-item"; if(isset($tab)&&$tab=='11'){echo " active"; } echo "'>Sales Per Items</a>";
			// echo "<a href = '?tab=12' class = 'list-group-item"; if(isset($tab)&&$tab=='12'){echo " active"; } echo "'>Unreturned DR's</a>";
			echo "<a href = '?tab=18' class = 'list-group-item"; if(isset($tab)&&$tab=='18'){echo " active"; } echo "'>Accounts Receivable</a>";
			echo "<a href = '?tab=20' class = 'list-group-item"; if(isset($tab)&&$tab=='20'){echo " active"; } echo "'>Accounts Payables</a>";
			echo "<a href = '?tab=14' class = 'list-group-item"; if(isset($tab)&&$tab=='14'){echo " active"; } echo "'>Deleted TS</a>";
			echo "<a href = '?tab=2' class = 'list-group-item"; if(isset($tab)&&$tab=='2'){echo " active"; } echo "'>Deleted Sales</a>";
			echo "<a href = '?tab=13' class = 'list-group-item"; if(isset($tab)&&$tab=='13'){echo " active"; } echo "'>Request to Edit Sales <span class='badge'>$badge_reports_edit</span></a>";
			echo "<a href = '?tab=16' class = 'list-group-item"; if(isset($tab)&&$tab=='16'){echo " active"; } echo "'>Sales Returns</a>";
			echo "<a href = '?tab=19' class = 'list-group-item"; if(isset($tab)&&$tab=='19'){echo " active"; } echo "'>Bad Orders</a>";
			echo "<a href = '?tab=21' class = 'list-group-item"; if(isset($tab)&&$tab=='21'){echo " active"; } echo "'>Good Orders</a>";
			echo "<a href = '?tab=10' class = 'list-group-item"; if(isset($tab)&&$tab=='10'){echo " active"; } echo "'>Accepted Sales Edits</a>";
			echo "<a href = '?tab=8' class = 'list-group-item"; if(isset($tab)&&$tab=='8'){echo " active"; } echo "'>Deleted Request to Edit Sales</a>";
			echo "<a href = '?tab=3' class = 'list-group-item"; if(isset($tab)&&$tab=='3'){echo " active"; } echo "'>Purchases Reports</a>";
			echo "<a href = '?tab=17' class = 'list-group-item"; if(isset($tab)&&$tab=='17'){echo " active"; } echo "'>Approval for Delivery Receipt <span class='badge'>$badge_reports_to_dr</span></a>";
			echo "<a href = '?tab=4' class = 'list-group-item"; if(isset($tab)&&$tab=='4'){echo " active"; } echo "'>Expenses</a>";
			// echo "<a href = '?tab=21' class = 'list-group-item"; if(isset($tab)&&$tab=='21'){echo " active"; } echo "'>Expenses Ledger</a>";
			echo "<a href = '?tab=5' class = 'list-group-item"; if(isset($tab)&&$tab=='5'){echo " active"; } echo "'>Deleted Expenses</a>";
			echo "<a href = '?tab=6' class = 'list-group-item"; if(isset($tab)&&$tab=='6'){echo " active"; } echo "'>Collection Remittances</a>";
			// echo "<a href = '?tab=7' class = 'list-group-item"; if(isset($tab)&&$tab=='7'){echo " active"; } echo "'>Credits</a>";
			// echo "<a href = '?tab=9' class = 'list-group-item"; if(isset($tab)&&$tab=='9'){echo " active"; } echo "'>All Reports</a>";
			echo "<a href = '?tab=15' class = 'list-group-item"; if(isset($tab)&&$tab=='15'){echo " active"; } echo "'>All Reports</a>";

		?>
		
		</div>
		<?php
		if($tab=='1'){// Sales Report
			echo "
			<div class='col-md-6'>
			<form action='reports-sales' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Sales</h3>
			
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block'><span class='glyphicon glyphicon-shopping-cart'></span> View Sales</button>
			</form>
			</div>
				";
		}elseif($tab==2){ // deleted sales
			$deleted_sales_query = mysql_query("SELECT * FROM tbl_orders WHERE deleted='1' ORDER BY date_deleted DESC");
			echo "
				<div class='table-responsive'>
				<h3 style='text-align:center;'>Deleted Sales</h3>
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>Date Deleted</th>
								<th>DR #</th>
								<th>Customer</th>
								<th>Account Specialist</th>
								<th>Amount</th>
								<th>Deleted By</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>";
						$query = "SELECT * FROM tbl_orders WHERE deleted='1' ORDER BY date_deleted DESC";
						$deleted_query = mysql_query($query);
						if(mysql_num_rows($deleted_query)!=0){
							while($deleted_row=mysql_fetch_assoc($deleted_query)){
								$orderID = $deleted_row["orderID"];
								$date_deleted = date("m/d/Y",$deleted_row["date_deleted"]);
								$customerID = $deleted_row["customerID"];
								$deleted_by = $deleted_row["deleted_by"];
								$delete_comment = $deleted_row["delete_comment"];
								$salesmanID = $deleted_row["customerID"];
								$deleted_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$deleted_by'"));
								$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
								$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
								$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total_amount FROM tbl_purchases WHERE orderID='$orderID'"));
								echo "
								<tr>
									<td>$date_deleted</td>
									<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
									<td>".$customer_data["companyname"]."</td>
									<td>".$salesman_data["salesman_name"]."</td>
									<td>".number_format($total_amount["total_amount"],2)."</td>
									<td>".$deleted_by["employee_name"]."</td>
									<td>".$delete_comment."</td>
								</tr>
								";
							}
						}
						echo "
						</tbody>
					</table>
				</div>
			";
		}elseif($tab=='3'){ // receiving reports
			echo "
			<div class='col-md-6'>
			<form action='reports-receiving' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Purchases</h3>
			
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-download-alt'></span> View Purchases</button>
			</form>
			</div>			
			";
		}elseif($tab=='4'){ // expenses reports
			$expense_type = mysql_fetch_assoc(mysql_query("SELECT DISTINCT category,expense_account,description FROM tbl_expenses"));
			// $expense_account = mysql_fetch_assoc(mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses"));
			// $expense_description = mysql_fetch_assoc(mysql_query("SELECT DISTINCT description FROM tbl_expenses"));
			echo "
			<div class='col-md-6'>
			<form action='reports-expenses' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Expenses</h3>		
			
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-usd'></span> View Expenses</button>
			
			</form>	
			</div>
			";
		}elseif($tab=='5'){ // customers purchase
			echo "
			<h3 style='text-align:center;'>Deleted Expenses</h3>
			<div class='col-md-10'>
			<div class='table-responsive'>
			<table class='table table-hover'>
				<thead>
					<tr>
						<th>Date</th>
						<th>Account</th>
						<th>Description</th>
						<th>Amount</th>
						<th>Date Deleted</th>
						<th>Deleted By</th>
					</tr>
				</thead>
				<tbody>";

				$expenses_query = mysql_query("SELECT * FROM tbl_expenses WHERE deleted!='0' ORDER BY expensesID DESC");
				if(mysql_num_rows($expenses_query)!=0){
					while($expenses_row=mysql_fetch_assoc($expenses_query)){
						$expensesID = $expenses_row["expensesID"];
						$db_accountID = $expenses_row["accountID"];
						$description = $expenses_row["description"];
						$deleted = $expenses_row["deleted"];
						$deleted_by = $expenses_row["deleted_by"];
						$date_expenses = $expenses_row["date"];
						$amount = $expenses_row["amount"];
						$account_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID = '$db_accountID'"));
						$deleted_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID = '$deleted_by'"));
						echo "
							<tr>
								<td>".date("m/d/Y",$date_expenses)."</td>
								<td>".$account_data["employee_name"]."</td>
								<td>".$description."</td>
								<td>".number_format($amount,2)."</td>
								<td>".date("m/d/Y",$deleted)."</td>
								<td>".$deleted_data["employee_name"]."</td>
							</tr>
						";
					}
				}
				echo "</tbody>
			</table>
			</div>
			</div>
			";
			
		}elseif($tab=='6'){ // credits
			echo "
			<div class='col-md-6'>
			<form action='reports-payments' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Collection Remittances</h3>
			
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-shopping-cart'></span> View Collection Remittances</button>
			</form>
			</div>
				";
		}elseif($tab=='7'){ // detailed reports
		echo "
		<div class='table-responsive'>
		<table class='table table-hover'>
		<thead>
		<tr>
			<th>Sale ID</th>
			<th>Date</th>
			<th>Time</th>
			<th>Customer</th>
			<th>Date Due</th>
			<th>Amount</th>
			<th>Invoice #</th>
		</tr>
		</thead>
		";
		$credit_search_query = mysql_query("SELECT * FROM tbl_payments WHERE type_payment LIKE '%CREDIT%' AND deleted='0'");
		if(mysql_num_rows($credit_search_query)!=0){
			while($credit_search_row=mysql_fetch_assoc($credit_search_query)){
				$orderID = $credit_search_row["orderID"];
				$invoice = $credit_search_row["comments"];
				$amount = $credit_search_row["payment"];
				$date_due = $credit_search_row["date_due"];
				$order_query=mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID' AND deleted='0'");
				while($order_row=mysql_fetch_assoc($order_query)){
					$date_ordered = $order_row["date_ordered"];
					$time_ordered = $order_row["time_ordered"];
					$customer = $order_row["customer"];
					$customerID = $order_row["customerID"];
				}
					echo "
					<tr>
						<td><a href='sales-re?id=$orderID'>S".sprintf("%06d",$orderID)."</a></td>
						<td>$date_ordered</td>
						<td>$time_ordered</td>
						<td><a href='credits?tab=2&id=$customerID'>$customer</a></td>
						<td>".date("m/d/Y",$date_due)."</td>
						<td>$amount</td>
						<td>$invoice</td>
					</tr>
					";
			}
		}

		echo "
		</table>
		</div>
		";
		}elseif($tab==8){
			echo "
			<div class='col-md-10'>
			<h3 style='text-align:center'>Deleted Request to Edit Sales</h3>
			<div class='table-responsive'>
			<table class='table-hover table'>
			<thead>
				<tr>
					<th>Date Deleted</th>
					<th>Deleted By</th>
					<th>Request #</th>
					<th>DR #</th>
					<th>Customer</th>
					<th>Account Specialist</th>
					<th>Requested From</th>
					<th>Date Requested</th>
					<th>Comments</th>
				</tr>
			</thead>
			<tbody>";
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;
			$query = "SELECT * FROM tbl_sales_edit WHERE deleted!='0' ORDER BY date_deleted DESC";
			$numitemquery = mysql_query($query);
			$numitem = mysql_num_rows($numitemquery);
			$query.=" LIMIT $limit, $maxitem";
			//echo $query;
			$deleted_query = mysql_query($query);
			 		if(($numitem%$maxitem)==0){
						$lastpage=($numitem/$maxitem);
					}else{
						$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
					}
					$maxpage = 3;
			if(mysql_num_rows($deleted_query)!=0){
				while($deleted_row = mysql_fetch_assoc($deleted_query)){
					$date_deleted = $deleted_row["date_deleted"];
					$deleted_by = $deleted_row["deleted_by"];
					$editID = $deleted_row["editID"];
					$comments = $deleted_row["comments"];
					$orderID = $deleted_row["orderID"];
					$request_fromID = $deleted_row["accountID"];
					$date_req = date("m/d/Y",$deleted_row["date"]);
					$deleted_by= mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$deleted_by'"));
					$request_fromID= mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$request_fromID'"));
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='".$order_data["customerID"]."'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='".$order_data["salesmanID"]."'"));
					echo "
					<tr>
						<td>".date("m/d/Y",$date_deleted)."</td>
						<td>".$deleted_by["employee_name"]."</td>
						<td><a href='reports-edits?id=$editID'>".$editID."</a></td>
						<td><a href='sales-complete?id=$orderID'>".$orderID."</a></td>
						<td>".$customer_data["companyname"]."</td>
						<td>".$salesman_data["salesman_name"]."</td>
						<td>".$request_fromID["employee_name"]."</td>
						<td>".$date_req."</td>
						<td>".$comments."</td>
					</tr>
					";
				}
			}
			echo "</tbody>
			</table>";
			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?tab=$tab&";
			$cnt=0;
			if($page>1){
				$back=$page-1;
				echo "<li><a href = '".$url."page=1'>&laquo;&laquo;</a></li>";	
				echo "<li><a href = '".$url."page=$back'>&laquo;</a></li>";	
				for($i=($page-$maxpage);$i<$page;$i++){
					if($i>0){
						echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
					}
					$cnt++;
					if($cnt==$maxpage){
						break;
					}
				}
			}
			
			$cnt=0;
			for($i=$page;$i<=$lastpage;$i++){
				$cnt++;
				if($i==$page){
					echo "<li class='active'><a href = '#'>$i</a></li>";	
				}else{
					echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				}
				if($cnt==$maxpage){
					break;
				}
			}
			
			$cnt=0;
			for($i=($page+$maxpage);$i<=$lastpage;$i++){
				$cnt++;
				echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				if($cnt==$maxpage){
					break;
				}
			}
			if($page!=$lastpage&&$numitem>0){
				$next=$page+1;
				echo "<li><a href = '".$url."page=$next'>&raquo;</a></li>";
				echo "<li><a href = '".$url."page=$lastpage'>&raquo;&raquo;</a></li>";
			}
			echo "</ul><span class='page' >Page $page</span></div>";
			echo "</div>
			</div>
			";
			
		}elseif($tab==9){
		echo "
			<div class='col-md-6'>
			<form action='reports' method='get' class='form-horizontal'>

		<h3 style='text-align:center;'>All Reports</h3>
		
		<label>Report By:</label>
		<select class='form-control' name='by'>
			<option value='d'>Day</option>
			<option value='m'>Month</option>
			<option value='y'>Year</option>
		</select>
		
		<label>From:</label>
		<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>

		<label>To:</label>
		<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
		<br>
		<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-stats'></span> Make Report</button>
		
		</form>
		</div>
			";
		}elseif($tab==10){
		echo "<div class='col-md-10'>";
		echo "
		<h3 style='text-align:center;'>Accepted Edits</h3>
		<table class='table table-responsive'>
			<thead>
				<tr>
					<th>Request #</th>
					<th>DR #</th>
					<th>Customer</th>
					<th>Account Specialist</th>
					<th>Edited By</th>
					<th>Date Edited</th>
					<th>Approved By</th>
					<th>Date Approved</th>
					<th>Comments</th>
				</tr>
			</thead>
			<tbody>";
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$query = "SELECT * FROM tbl_sales_edit WHERE approved='1' AND deleted='0' ORDER BY date_approved DESC";
			$numitemquery = mysql_query($query);
			$numitem = mysql_num_rows($numitemquery);
			$query.=" LIMIT $limit, $maxitem";
			// echo $query;
	 		if(($numitem%$maxitem)==0){
				$lastpage=($numitem/$maxitem);
			}else{
				$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
			}
			$maxpage = 3;
			$edit_query = mysql_query($query);
			if(mysql_num_rows($edit_query)!=0){
				while($edit_row=mysql_fetch_assoc($edit_query)){
					$editID = $edit_row["editID"];
					$orderID = $edit_row["orderID"];
					$approved_by = $edit_row["approved_by"];
					$db_accountID = $edit_row["accountID"];
					$date_req = $edit_row["date"];
					$date_approved = $edit_row["date_approved"];
					$orderID = $edit_row["orderID"];
					$comments = $edit_row["comments"];
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
					$customerID = $order_data["customerID"];
					$salesmanID = $order_data["salesmanID"];
					$approved_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$approved_by'"));
					$edited_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$db_accountID'"));
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
					echo "
					<tr>
						<td><a href='reports-edits?id=$editID'>".$editID."</a></td>
						<td><a href='sales-complete?id=$orderID'>".$orderID."</a></td>
						<td><a href='customer?id=$customerID'>".$customer_data["companyname"]."</a></td>
						<td><a href='salesman?id=$salesmanID'>".$salesman_data["salesman_name"]."</a></td>
						<td>".$edited_by["employee_name"]."</td>
						<td>".date("m/d/Y",$date_req)."</td>
						<td>".$approved_by["employee_name"]."</td>
						<td>".date("m/d/Y",$date_approved)."</td>
						<td>".$comments."</td>
					</tr>
					";
				}
			}
			echo "</tbody>
		</table>
		";
echo "
			<div class='text-center'>
			<ul class='pagination prints'>
			
			";
			$url="?tab=$tab&";
			$cnt=0;
			if($page>1){
				$back=$page-1;
				
				echo "<li><a href = '".$url."page=1'>&laquo;&laquo;</a></li>";	
				
				echo "<li><a href = '".$url."page=$back'>&laquo;</a></li>";	
				for($i=($page-$maxpage);$i<$page;$i++){
					if($i>0){
						
						echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
					}
					$cnt++;
					if($cnt==$maxpage){
						break;
					}
				}
			}
			
			$cnt=0;
			for($i=$page;$i<=$lastpage;$i++){
				$cnt++;
				if($i==$page){
					
					echo "<li class='active'><a href = '#'>$i</a></li>";	
				}else{
					
					echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				}
				if($cnt==$maxpage){
					break;
				}
			}
			
			$cnt=0;
			for($i=($page+$maxpage);$i<=$lastpage;$i++){
				$cnt++;
				
				echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				if($cnt==$maxpage){
					break;
				}
			}
			if($page!=$lastpage&&$numitem>0){
				$next=$page+1;
				
				echo "<li><a href = '".$url."page=$next'>&raquo;</a></li>";
				
				echo "<li><a href = '".$url."page=$lastpage'>&raquo;&raquo;</a></li>";
			}
			
			echo "</ul><span class='page' >Page $page</span>
			</div>
			";
			

		echo "</div>
			";
		}elseif($tab=='11'){// Sales Report
			echo "
			<div class='col-md-6'>
			<form action='reports-items' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Sales per Items</h3>
			
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-shopping-cart'></span> View Sales</button>
			</form>
			</div>
				";
		}elseif($tab=='12'){ // credits


			echo "
			<div class='col-md-10'>
			<h3 style='text-align:center;'>Unreturned Delivery Receipt</h3>
			<div class='table-responsive'>
				<table class='table-responsive table'>
					<thead>
						<tr>
							<th>Date</th>
							<th>DR #</th>
							<th>Customer</th>
							<th>Account Specialist</th>
							<th>Total Amount</th>
							<th style='text-align: center;'>Status</th>
							<th style='text-align: center;'>Date Returned</th>							
						</tr>
					</thead>
					<tbody>";

					if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
					$maxitem = $maximum_items_displayed; // maximum items
					$limit = ($page*$maxitem)-$maxitem;

					$query = "SELECT * FROM tbl_orders WHERE received='0' AND deleted='0'";

					$numitemquery = mysql_query($query);
					$numitem = mysql_num_rows($numitemquery);
					$query.=" LIMIT $limit, $maxitem";
					// echo $query;

			 		if(($numitem%$maxitem)==0){
						$lastpage=($numitem/$maxitem);
					}else{
						$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
					}
					$maxpage = 3;

					$order_query = mysql_query($query);
					if(mysql_num_rows($order_query)!=0){
						while ($order_row=mysql_fetch_assoc($order_query)) {
							$date_ordered=$order_row["date_ordered"];
							$orderID=$order_row["orderID"];
							$salesmanID=$order_row["salesmanID"];
							$customerID=$order_row["customerID"];
							$received=$order_row["received"];
							$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
							$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
							$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
							if($received!=0){
								$status = "Returned";
								$received_date = date("m/d/Y",$order_data["received"]);
							}else{
								$status = "<a href='#' id='$orderID' class='return'>Mark as Returned</a>";
								$received_date = "";
							}
							echo "
								<tr>
									<td>".date("m/d/Y",$date_ordered)."</td>
									<td><a href='sales-complete?id=$orderID'>".$orderID."</a></td>
									<td><a href='customer?id=$customerID'>".$customer_data["companyname"]."</a></td>
									<td><a href='salesman?id=$salesmanID'>".$salesman_data["salesman_name"]."</a></td>
									<td>".number_format($total_amount["total"],2)."</td>
									<td>".$status."</td>
									<td>".$received_date."</td>
								</tr>
							";
							# code...
						}
					}
					echo "</tbody>
				</table>
					<div class='text-center'>";
							echo "<ul class='pagination prints'>
							
							";
							$url="?tab=$tab&";
							$cnt=0;
							if($page>1){
								$back=$page-1;
								echo "<li><a href = '".$url."page=1'>&laquo;&laquo;</a></li>";	
								echo "<li><a href = '".$url."page=$back'>&laquo;</a></li>";	
								for($i=($page-$maxpage);$i<$page;$i++){
									if($i>0){
										echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
									}
									$cnt++;
									if($cnt==$maxpage){
										break;
									}
								}
							}
							
							$cnt=0;
							for($i=$page;$i<=$lastpage;$i++){
								$cnt++;
								if($i==$page){
									echo "<li class='active'><a href = '#'>$i</a></li>";	
								}else{
									echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
								}
								if($cnt==$maxpage){
									break;
								}
							}
							
							$cnt=0;
							for($i=($page+$maxpage);$i<=$lastpage;$i++){
								$cnt++;
								echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
								if($cnt==$maxpage){
									break;
								}
							}
							if($page!=$lastpage&&$numitem>0){
								$next=$page+1;
								echo "<li><a href = '".$url."page=$next'>&raquo;</a></li>";
								echo "<li><a href = '".$url."page=$lastpage'>&raquo;&raquo;</a></li>";
							}
							echo "</ul><span class='page' >Page $page</span></div>";
							
					
			echo "
			</div>
			</div>
			</div>
				";
		}elseif($tab=='13'){// Sales Report
			echo "
			<div class='table-responsive'>
			<h3 style='text-align:center;'>Pending Returns</h3>
				<table class='table table-responsive'>
					<thead>
						<tr>
							<th>Request #</th>
							<th>DR #</th>
							<th>Customer</th>
							<th>Account Specialist</th>
							<th>Requested From</th>
							<th>Date</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody>";
						$sales_edit_query = mysql_query("SELECT * FROM tbl_sales_edit WHERE approved='0' AND deleted='0'");
						if(mysql_num_rows($sales_edit_query)!=0){
							while($sales_edit_row=mysql_fetch_assoc($sales_edit_query)){
								$editID = $sales_edit_row["editID"];
								$orderID = $sales_edit_row["orderID"];
								$date = $sales_edit_row["date"];
								$comments = $sales_edit_row["comments"];
								$request_fromID = $sales_edit_row["accountID"];
								$date_req = $sales_edit_row["date"];
								$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
								$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='".$order_data["customerID"]."'"));
								$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='".$order_data["salesmanID"]."'"));
								$account_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$request_fromID'"));
								echo "
								<tr>
									<td><a href='sales-edit-confirm?id=$editID'>$editID</a></td>
									<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
									<td>".$customer_data["companyname"]."</td>
									<td>".$salesman_data["salesman_name"]."</td>
									<td>".$account_data["employee_name"]."</td>
									<td>".date("m/d/Y",$date_req)."</td>
									<td>".$comments."</td>
								</tr>
								";
							}
						}
					echo "</tbody>
				</table>
			</div>
				";
		}elseif($tab==14){
			echo "
			<div class='col-md-10'>
			<h3 style='text-align:center'>Deleted Transaction Sheets</h3>
			<div class='table-responsive'>
			<table class='table-hover table'>
			<thead>
				<tr>
					<th>TS #</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Account Specialist</th>
					<th>Terms</th>
					<th>Date Due</th>
					<th>Deleted By</th>
					<th>Comments</th>

				</tr>
			</thead>
			<tbody>";
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;
			$query = "SELECT * FROM tbl_ts_orders WHERE deleted!='0' ORDER BY date_deleted DESC";
			$numitemquery = mysql_query($query);
			$numitem = mysql_num_rows($numitemquery);
			$query.=" LIMIT $limit, $maxitem";
			//echo $query;
			$deleted_query = mysql_query($query);
			 		if(($numitem%$maxitem)==0){
						$lastpage=($numitem/$maxitem);
					}else{
						$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
					}
					$maxpage = 3;
			if(mysql_num_rows($deleted_query)!=0){
				while($deleted_row = mysql_fetch_assoc($deleted_query)){
					$date_deleted = $deleted_row["date_deleted"];
					$ts_orderID = $deleted_row["ts_orderID"];
					$customerID = $deleted_row["customerID"];
					$salesmanID = $deleted_row["salesmanID"];
					$date_due = date("m/d/Y",$deleted_row["date_due"]);
					$deleted_by = $deleted_row["deleted_by"];
					$terms = $deleted_row["terms"];
					$comments = $deleted_row["comments"];
					$deleted_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$deleted_by'"));
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
					echo "
					<tr>
						<td><a href='sales-ts-complete?id=$ts_orderID'>".$ts_orderID."</a></td>
						<td>".date("m/d/Y",$date_deleted)."</td>
						<td>".$customer_data["companyname"]."</td>
						<td>".$salesman_data["salesman_name"]."</td>
						<td>".$terms."</td>
						<td>".$date_due."</td>
						<td>".$deleted_by["employee_name"]."</td>
						<td>".$comments."</td>
					</tr>
					";
				}
			}
			echo "</tbody>
			</table>";
			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?tab=$tab&";
			$cnt=0;
			if($page>1){
				$back=$page-1;
				echo "<li><a href = '".$url."page=1'>&laquo;&laquo;</a></li>";	
				echo "<li><a href = '".$url."page=$back'>&laquo;</a></li>";	
				for($i=($page-$maxpage);$i<$page;$i++){
					if($i>0){
						echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
					}
					$cnt++;
					if($cnt==$maxpage){
						break;
					}
				}
			}
			
			$cnt=0;
			for($i=$page;$i<=$lastpage;$i++){
				$cnt++;
				if($i==$page){
					echo "<li class='active'><a href = '#'>$i</a></li>";	
				}else{
					echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				}
				if($cnt==$maxpage){
					break;
				}
			}
			
			$cnt=0;
			for($i=($page+$maxpage);$i<=$lastpage;$i++){
				$cnt++;
				echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				if($cnt==$maxpage){
					break;
				}
			}
			if($page!=$lastpage&&$numitem>0){
				$next=$page+1;
				echo "<li><a href = '".$url."page=$next'>&raquo;</a></li>";
				echo "<li><a href = '".$url."page=$lastpage'>&raquo;&raquo;</a></li>";
			}
			echo "</ul><span class='page' >Page $page</span></div>";
			echo "</div>
			</div>
			";
			
		}elseif($tab==15){
			echo "<div class='col-md-10'>";

			$statement_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_income_statement WHERE statementID='$statementID'"));
			echo "
			<form action='reports-accounting-forms' method='post'><label>Accounting Period:</label>&nbsp;";
			if($accounting_period==0){
				echo "<button name='save' class='btn btn-success'>START</button>";
			}else{
				echo "<button name='end' class='btn btn-danger'>END</button>";
				$started_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$statement_data["beginning_by"]."'"));
				echo "<br>Accounting Period is Started by: ".$started_by["employee_name"]." on ".date("F d, Y",$statement_data["beginning_date"])." ".date("h:i:s A",$statement_data["beginning_time"]).".";
			}

			echo "</form>
			";
			$income_statement = "SELECT * FROM tbl_income_statement	";
			echo "
			<div class='table-responsive'>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Statement #</th>
							<th>Date Time Started</th>
							<th>Started By</th>
							<th>Date Time Ended</th>
							<th>Ended By</th>
						</tr>
					</thead>
				
				<tbody>";
				$income_statement_query = mysql_query($income_statement);
				if(mysql_num_rows($income_statement_query)!=0){
					while($income_row=mysql_fetch_assoc($income_statement_query)){
						$beginning_date = $income_row["beginning_date"];
						$db_statementID = $income_row["statementID"];
						$beginning_time = $income_row["beginning_time"];
						$beginning_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$income_row["beginning_by"]."'"));
						$closing_date = $income_row["closing_date"];
						$closing_time = $income_row["closing_time"];
						$closing_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$income_row["closing_by"]."'"));
						if($closing_by!=0){
							$date_time_end = date("m/d/Y",$closing_date).date(" h:i:s A",$closing_time);
						}else{
							$date_time_end = "";
						}
						echo "
						<tr>
							<td><a href='reports-income-statement?id=$db_statementID'>$db_statementID</a></td>
							<td>".date("m/d/Y",$beginning_date).date(" h:i:s A",$beginning_time)."</td>
							<td>".$beginning_by["employee_name"]."</td>
							<td>".$date_time_end."</td>
							<td>".$closing_by["employee_name"]."</td>
						</tr>
						";
					}
				}
				echo "
				</tbody>
				</table>
			</div>
			";
		}elseif($tab==16){// Sales Returns
			echo "
			<div class='col-md-6'>
			<form action='reports-sales-returns' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Sales Returns</h3>
			
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-shopping-cart'></span> View Sales</button>
			</form>
			</div>
				";
		}elseif ($tab==17) {
			echo "
			<div class='col-md-10'>
			<h3 style='text-align:center'>Approval for Delivery Receipt</h3>
			<div class='table-responsive'>
			<form action='reports-accept-dr' method='post' id='approve_to_dr_form'>
			<button class='btn btn-primary' type='submit'><span class='glyphicon glyphicon-ok'></span> Accept</button>
			<table class='table-hover table'>
			<thead>
				<tr>
					<th></th>
					<th>TS #</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Account Specialist</th>
					<th>Terms</th>
					<th>Date Due</th>
				</tr>
			</thead>
			<tbody>";
			$ts_orders_query = mysql_query("SELECT * FROM tbl_ts_orders WHERE need_approve='1' AND deleted='0'");
			if(mysql_num_rows($ts_orders_query)!=0){
				while($ts_orders_row=mysql_fetch_assoc($ts_orders_query)){
					$customer_data = mysql_fetch_array(mysql_query("SELECT * FROM tbl_customer WHERE customerID='".$ts_orders_row["customerID"]."'"));
					$salesman_data = mysql_fetch_array(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='".$ts_orders_row["salesmanID"]."'"));
					echo '
						<tr>
							<td><input type="checkbox" id="'.$ts_orders_row["ts_orderID"].'" name="select[]" value="'.$ts_orders_row["ts_orderID"].'"></td>
							<td><a href="sales-ts-complete?id='.$ts_orders_row["ts_orderID"].'">'.$ts_orders_row["ts_orderID"].'</a></td>	
							<td>'.date("m/d/Y",$ts_orders_row["date"]).'</td>	
							<td>'.$customer_data["companyname"].'</td>	
							<td>'.$salesman_data["salesman_name"].'</td>	
							<td>'.$ts_orders_row["terms"].'</td>	
							<td>'.date("m/d/Y",$ts_orders_row["date_due"]).'</td>	
							<!--<td><a href="#" class="approve_to_dr" id="'.$ts_orders_row["ts_orderID"].'">Approve for Delivery Receipt</a></td>-->
						</tr>
					';
				}
			}

			echo "</tbody>
			</table>";

			
		}elseif($tab==18){// Sales Report
			echo "
			<div class='col-md-6'>
			<form action='reports-accounts-receivable' method='get' class='form-horizontal'>
			<h3 style='text-align:center;'>View Accounts Receivable Ledger</h3>
			
			<label>Date From:</label>
			<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<label>Date To:</label>
			<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
			<br>
			<button class='btn btn-primary btn-block'><span class='glyphicon glyphicon-shopping-cart'></span> View Accounts Receivable Ledger</button>
			</form>
			</div>
				";
		}elseif ($tab==19) {
			 // receiving reports
						echo "
						<div class='col-md-6'>
						<form action='reports-bad-orders' method='get' class='form-horizontal'>
						<h3 style='text-align:center;'>View Bad Orders</h3>
						
						<label>Date From:</label>
						<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
						<label>Date To:</label>
						<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
						<br>
						<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-download-alt'></span> View Bad Orders</button>
						</form>
						</div>			
						";
					
		}elseif ($tab==20) {
			// Sales Report
						echo "
						<div class='col-md-6'>
						<form action='reports-accounts-payables' method='get' class='form-horizontal'>
						<h3 style='text-align:center;'>View Accounts Payables Ledger</h3>
						
						<label>Date From:</label>
						<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
						<label>Date To:</label>
						<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
						<br>
						<button class='btn btn-primary btn-block'><span class='glyphicon glyphicon-shopping-cart'></span> View Accounts Payables Ledger</button>
						</form>
						</div>
							";
					
		}elseif ($tab==21) {
			
			 // receiving reports
						echo "
						<div class='col-md-6'>
						<form action='reports-good-orders' method='get' class='form-horizontal'>
						<h3 style='text-align:center;'>View Good Orders</h3>
						
						<label>Date From:</label>
						<input type='text' class='form-control' id='date_from' name='f' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
						<label>Date To:</label>
						<input type='text' class='form-control' id='date_to' name='t' placeholder='Pick a Date' value='".date("m/d/Y")."' required='required'>
						<br>
						<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-download-alt'></span> View Good Orders</button>
						</form>
						</div>			
						";
					
			
		}
		?>

		</div>
		<?php 
	}else{
		echo "<strong><center>You do not have the authority to access this module.</center></strong>";
	}
	}else{
	header("location:index");
	} ?>
	</div>
  </div>
</div>
</body>
</html>
<?php mysql_close($connect);?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>