<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$id=@$_GET['id'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - All Reports</title>
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
  

  <style>
  .item:hover{
	  cursor:pointer;
  }
  
  </style>
  <script>
  $(document).ready(function(){
	$("#Reports").addClass("active");

  });
  </script>
    <style>

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
  	<div class='col-md-12'>
	
	
	<?php
	if($logged==1||$logged==2){
	if($reports=='1'){
		$statement_query = mysql_query("SELECT * FROM tbl_income_statement WHERE statementID = '$id'");
		if(mysql_num_rows($statement_query)==0){
			goto exit_program;
		}
		$statement_data = mysql_fetch_assoc($statement_query);
		echo "<h2 style='text-align:center'>Income Statement in ".date("F d, Y",$statement_data["beginning_date"])." to ".date("F d, Y",$statement_data["closing_date"])."</h2>";
		echo "<h3 style='text-align:center'>Inventory</h3>";
		echo "<div class='row'>";
		echo "<div class='col-md-4'>";
		echo "<div class='table-reponsive'>
		<table class='table table-hover'>
		<thead>
			<tr>
				<th>Category</th>
				<th>Beginning Inventory</th>
			</tr>
		</thead>
		<tbody>";
		$i = 0;
		$total_beginning_inventory = 0;
		$list_of_beginning_inventory_items = explode("---",$statement_data["beginning_inventory_items"]);
		$list_of_beginning_inventory_value = explode("---",$statement_data["beginning_inventory_value"]);
		foreach($list_of_beginning_inventory_items as $beginning_inventory_items){
			$total_beginning_inventory+=$list_of_beginning_inventory_value[$i];
			echo "
			<tr>
				<td>$beginning_inventory_items</td>
				<td style='text-align:right'>".number_format($list_of_beginning_inventory_value[$i],2)."</td>
			</tr>
			";
		$i++;
		}
		echo "
		</tbody>
		<tfoot>
			<tr class='info'>
				<th style='text-align:right'>Total Beginning Inventory</th>
				<th style='text-align:right'>".number_format($total_beginning_inventory,2)."</th>
			</tr>
		</tfoot>
		</table>
		</div>
		</div>
		";
		echo "<div class='col-md-4'>";
		echo "<div class='table-reponsive'>
		<table class='table table-hover'>
		<thead>
			<tr>
				<th>Category</th>
				<th>Purchases</th>
			</tr>
		</thead>
		<tbody>";
		$i = 0;
		$total_receiving = 0;
		$list_of_receiving_items = explode("---",$statement_data["receiving_items"]);
		$list_of_receiving_value = explode("---",$statement_data["receiving_value"]);
		foreach($list_of_receiving_items as $receiving_items){
			$total_receiving+=$list_of_receiving_value[$i];
			if($list_of_receiving_value[$i]==""){
				break;
			}
			echo "
			<tr>
				<td>$receiving_items</td>
				<td style='text-align:right'>".number_format($list_of_receiving_value[$i],2)."</td>
			</tr>
			";
		$i++;
		}
			$total_receiving+=$statement_data["freight"];
		echo "
		<tr>
			<th>Freight Charges:</th>
			<td style='text-align:right'>".number_format($statement_data["freight"],2)."</td>
		</tr>
		";
		echo "
		</tbody>
		<tfoot>
			<tr class='info'>
				<th style='text-align:right'>Total Purchases</th>
				<th style='text-align:right'>".number_format($total_receiving,2)."</th>
			</tr>
		</tfoot>
		</table>
		</div>
		</div>
		";
		echo "<div class='col-md-4'>";
		echo "<div class='table-reponsive'>
		<table class='table table-hover'>
		<thead>
			<tr>
				<th>Category</th>
				<th>Closing Inventory</th>
			</tr>
		</thead>
		<tbody>";
		$i = 0;
		$total_closing_inventory = 0;
		$list_of_closing_inventory_items = explode("---",$statement_data["closing_inventory_items"]);
		$list_of_closing_inventory_value = explode("---",$statement_data["closing_inventory_value"]);
		foreach($list_of_closing_inventory_items as $closing_inventory_items){
			$total_closing_inventory+=$list_of_closing_inventory_value[$i];
			if($list_of_closing_inventory_value[$i]==""){
				break;
			}
			echo "
			<tr>
				<td>$closing_inventory_items</td>
				<td style='text-align:right'>".number_format($list_of_closing_inventory_value[$i],2)."</td>
			</tr>
			";
		$i++;
		}
		echo "
		</tbody>
		<tfoot>
			<tr class='info'>
				<th style='text-align:right'>Total Closing Inventory</th>
				<th style='text-align:right'>".number_format($total_closing_inventory,2)."</th>
			</tr>
		</tfoot>
		</table>
		</div>
		</div>
		";
		echo "</div>";
		echo "<h3 style='text-align:center'>Expenses</h3>";
		echo "<div class='row'>";
			echo "
			<div class='col-md-4'>
				<div class='table-reponsive'>
					<table class='table-hover table'>
						<thead>
							<tr>
								<th>Selling Expenses</th>
								<th>Expenses</th>
							</tr>
						</thead>
						</tbody>";
						$list_of_selling_expenses_items = explode("---",$statement_data["selling_expenses_items"]);
						$list_of_selling_expenses_value = explode("---",$statement_data["selling_expenses_value"]);
						$total_selling_expenses = 0;
						$i = 0;
						foreach($list_of_selling_expenses_items as $selling_expenses){
							if($list_of_selling_expenses_value[$i]==""){
								$list_of_selling_expenses_value[$i]=0;
							}else{
								echo "
								<tr>
									<td>$selling_expenses</td>
									<td style='text-align:right'>".number_format($list_of_selling_expenses_value[$i],2)."</td>
								</tr>
								";
							}
							
							$total_selling_expenses+=$list_of_selling_expenses_value[$i];
							$i++;
						}
						echo "</tbody>
					</tfoot>
						<tr class='info'>
							<th style='text-align:right'>Total Selling Expenses</th>
							<th style='text-align:right'>".number_format($total_selling_expenses,2)."</th>
						</tr>
					<tfoot>
					</table>
				</div>
			</div>";

			echo "
			<div class='col-md-4'>
				<div class='table-reponsive'>
					<table class='table-hover table'>
						<thead>
							<tr>
								<th>Admin Expenses</th>
								<th>Expenses</th>
							</tr>
						</thead>
						</tbody>";
						$list_of_admin_expenses_items = explode("---",$statement_data["admin_expenses_items"]);
						$list_of_admin_expenses_value = explode("---",$statement_data["admin_expenses_value"]);
						$total_admin_expenses = 0;
						$i = 0;
						foreach($list_of_admin_expenses_items as $admin_expenses){
							if($list_of_admin_expenses_value[$i]==""){
								$list_of_admin_expenses_value[$i]=0;
							}else{
								echo "
								<tr>
									<td>$admin_expenses</td>
									<td style='text-align:right'>".number_format($list_of_admin_expenses_value[$i],2)."</td>
								</tr>
								";
							}
							$total_admin_expenses+=$list_of_admin_expenses_value[$i];
							$i++;
						}
						echo "</tbody>
					</tfoot>
						<tr class='info'>
							<th style='text-align:right'>Total Admin Expenses</th>
							<th style='text-align:right'>".number_format($total_admin_expenses,2)."</th>
						</tr>
					<tfoot>
					</table>
				</div>
			</div>";

			echo "
			<div class='col-md-4'>
				<div class='table-reponsive'>
					<table class='table-hover table'>
						<thead>
							<tr>
								<th>Capital Expenditure</th>
								<th>Expenses</th>
							</tr>
						</thead>
						</tbody>";
						$list_of_capital_expenses_items = explode("---",$statement_data["capital_expenses_items"]);
						$list_of_capital_expenses_value = explode("---",$statement_data["capital_expenses_value"]);
						$total_capital_expenses = 0;
						$i = 0;
						foreach($list_of_capital_expenses_items as $capital_expenses){
							if($list_of_capital_expenses_value[$i]==""){
								$list_of_capital_expenses_value[$i]=0;
							}else{
								echo "
								<tr>
									<td>$capital_expenses</td>
									<td style='text-align:right'>".number_format($list_of_capital_expenses_value[$i],2)."</td>
								</tr>
								";
							}
							
							$total_capital_expenses+=$list_of_capital_expenses_value[$i];
							$i++;
						}
						echo "</tbody>
					</tfoot>
						<tr class='info'>
							<th style='text-align:right'>Total capital Expenditure</th>
							<th style='text-align:right'>".number_format($total_capital_expenses,2)."</th>
						</tr>
					<tfoot>
					</table>
				</div>
			</div>";


		echo "</div>";
		echo "<h3 style='text-align:center'>Income</h3>";
		echo "<div class='row'>";
		//formulas
		$good_availables = $total_beginning_inventory+$total_receiving;
		$cost_of_sales = $good_availables-$total_closing_inventory;
		$total_sales = $statement_data["sales"]-$statement_data["sales_returns_discount"];
		$gross_income = $total_sales-$cost_of_sales;
		$net_operating_income = $gross_income-$total_selling_expenses-$total_admin_expenses-$total_capital_expenses;
		echo "
		<div class='col-md-12'>
			<div class='table-reponsive'>
				<table class='table table-hover'>
					<tbody>
						<tr>
							<th>Sales</th>
							<td style='text-align:right'>".number_format($statement_data["sales"],2)."</td>
							<td></td>
						</tr>
						<tr>
							<th>Sales Returns, Discount and Allowances</th>
							<td style='text-align:right'><b>LESS:</b> ".number_format($statement_data["sales_returns_discount"],2)."</td>
							<td style='text-align:right'></td>
						</tr>
						<tr class='info'>
							<th>Total Sales</th>
							<td style='text-align:right'></td>
							<td style='text-align:right'>".number_format($total_sales,2)."</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th>Beginning Inventory</th>
							<td style='text-align:right'></td>
							<td style='text-align:right'>".number_format($total_beginning_inventory,2)."</td>
						</tr>
						<tr>
							<th>Purchases</th>
							<td style='text-align:right'>".number_format($total_receiving-$statement_data["freight"],2)."</td>
							<td></td>
						</tr>
						<tr>
							<th>Freight Charges</th>
							<td style='text-align:right'><b>ADD:</b> ".number_format($statement_data["freight"],2)."</td>
							<td></td>
						</tr>
						<tr class='info'>
							<th>Total Purchases</th>
							<td style='text-align:right'>".number_format($total_receiving,2)."</td>
							<td style='text-align:right'><b>ADD:</b> ".number_format($total_receiving,2)."</td>
						</tr>
						<tr>
							<th>Goods Available</th>
							<td></td>
							<td style='text-align:right'>".number_format($good_availables,2)."</td>
						</tr>
						<tr>
							<th>Closing Inventory</th>
							<td style='text-align:right'></td>
							<td style='text-align:right'>".number_format($total_closing_inventory,2)."</td>
						</tr>

						<tr class='info'>
							<th>Cost of Sales</th>
							<td></td>
							<td style='text-align:right'>".number_format($cost_of_sales,2)."</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th>Total Sales</th>
							<td style='text-align:right'></td>
							<td style='text-align:right'>".number_format($total_sales,2)."</td>
						</tr>
						<tr>
							<th>Cost of Sales</th>
							<td></td>
							<td style='text-align:right'>".number_format($cost_of_sales,2)."</td>
						</tr>
						<tr class='info'>
							<th>GROSS INCOME</th>
							<td></td>
							<td style='text-align:right'>".number_format($gross_income,2)."</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<th>Selling Expenses</th>
							<td></td>
							<td style='text-align:right'>".number_format($total_selling_expenses,2)."</td>
						</tr>
						<tr>
							<th>Admin Expenses</th>
							<td></td>
							<td style='text-align:right'>".number_format($total_admin_expenses,2)."</td>
						</tr>
						<tr>
							<th>Capital Expenditure</th>
							<td></td>
							<td style='text-align:right'>".number_format($total_capital_expenses,2)."</td>
						</tr>
						<tr class='info'>
							<th>NET OPERATING INCOME</th>
							<td></td>
							<td style='text-align:right'>".number_format($net_operating_income,2)."</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		";
		echo "</div>";
			echo "<form action='#' method='post'>
			<button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Report</button>
			</form>";

					if(isset($_POST["download"])){
						$filename = "reports-files\income-statement-".date("F-d-Y-",$statement_data["beginning_date"]).date("F-d-Y",$statement_data["closing_date"]).".csv";
						// echo $filename;
						$fp = fopen($filename, 'w');
						
						//titles
						$fields = array("Beginning Inventory","","","Purchases","","","Closing Inventory");
						fputcsv($fp, $fields);
						
						$i=0;
						while(($i<=count($list_of_beginning_inventory_items))||($i<=count($list_of_receiving_items))||($i<=count($list_of_closing_inventory_items))){
							//category names
							$fields = array($list_of_beginning_inventory_items[$i],$list_of_beginning_inventory_value[$i],"",$list_of_receiving_items[$i],$list_of_receiving_value[$i],"",$list_of_closing_inventory_items[$i],$list_of_closing_inventory_value[$i]);
							$i++;
							fputcsv($fp, $fields);
						}
						
						//freight
						$fields = array("","","","Freight Charges:",number_format($statement_data["freight"],2));
						fputcsv($fp, $fields);
						
						//totals
						$fields = array("TOTAL Beginning Inventory",number_format($total_beginning_inventory),"","TOTAL Purchases",number_format($total_receiving,2),"","TOTAL Closing Inventory",number_format($total_closing_inventory,2));
						fputcsv($fp, $fields);

						//empty
						$fields = array();
						fputcsv($fp, $fields);

						//gross sales
						$fields = array("Sales",number_format($statement_data["sales"],2));
						fputcsv($fp, $fields);

						//sales returns and discounts
						$fields = array("Sales Returns, Discount and Allowances",number_format($statement_data["sales_returns_discount"],2));
						fputcsv($fp, $fields);

						//net sales
						$fields = array("Total Sales",number_format($total_sales,2));
						fputcsv($fp, $fields);

						$fields = array("Goods Available",number_format($good_availables,2));
						fputcsv($fp, $fields);						

						$fields = array("Cost of Sales",number_format($cost_of_sales,2));
						fputcsv($fp, $fields);		

						$fields = array("GROSS INCOME",number_format($gross_income,2));
						fputcsv($fp, $fields);

						//empty
						$fields = array();
						fputcsv($fp, $fields);

						$i = 0;
						$fields = array("Selling Expenses","","","Admin Expenses","","","Capital Expenditure");
						fputcsv($fp, $fields);
						while(($i<count($list_of_admin_expenses_items))||$i<count($list_of_selling_expenses_items)){
							$fields = array($list_of_selling_expenses_items[$i],number_format($list_of_selling_expenses_value[$i],2),"",$list_of_admin_expenses_items[$i],number_format($list_of_admin_expenses_value[$i],2),"",$list_of_capital_expenses_items[$i],number_format($list_of_capital_expenses_value[$i],2));
							fputcsv($fp, $fields);
							echo $i."<br>";
							$i++;
						}

						//total of expenses
						$fields = array("TOTAL Selling Expenses",number_format($total_selling_expenses,2),"","TOTAL Admin Expenses",number_format($total_admin_expenses,2),"","TOTAL Capital Expenditure",number_format($total_capital_expenses,2));
						fputcsv($fp, $fields);


						$fields = array("NET OPERATING INCOME",number_format($net_operating_income,2));
						fputcsv($fp, $fields);

						fclose($fp);
						header("location:".$filename);
					}
	}else{
		echo "<strong><center>You do not have the authority to access this module.</center></strong>";
	}
	}else{
		location("location:index");
	} ?>
	</div>
  </div>
</div>
</body>
</html>
<?php
exit_program:
 mysql_close($connect);?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>