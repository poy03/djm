<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$t=@$_GET['t'];
$f=@$_GET['f'];
$s=@$_GET['s'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Sales Reports</title>
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
			$("#date_from").datepicker();
			$("#date_to").datepicker();
			$("#by").change(function(){
				var date_from = $("#date_from").val();
				var date_to = $("#date_to").val();
				var by = $(this).val();
				window.location= "reports?by="+by+"&f="+date_from+"&t="+date_to;
			});
			
			$("#salesman").change(function(){
				var id = $(this).val();
				var f = $("#f").val();
				var t = $("#t").val();
				window.location = '?f='+f+'&t='+t+'&s='+id;
			});

	
		
$("#Reports").addClass("active");
  
  });
  </script>
    <style>
		#item_results
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
  	<div class='col-md-12'>
	
	
	<?php
	if($logged==1||$logged==2){
	if($reports=='1'){
		echo "<center><h3>Sales in ".date("F d, Y",strtotime($f))." - ".date("F d, Y",strtotime($t))."</h3></center>";
		echo "<input type='hidden' id='f' value='$f'>";
		echo "<input type='hidden' id='t' value='$t'>";
	?>
	<div class='table-responsive'>
		<table class='table table-hover'>
		<thead>
			<tr>
				<th style="text-align: center;">SKU CODE</th>
				<th style="text-align: center;">Product Name</th>
				<th style="text-align: center;">Supplier</th>
				<th style="text-align: center;">Category</th>
				<th style="text-align: center;">QTY</th>
				<th style="text-align: center;">UOM</th>
				<th style="text-align: center;">Cost</th>
				<th style="text-align: center;">Total Cost</th>
				<th style="text-align: center;">Total Sales</th>
				<th style="text-align: center;">Gross Margin</th>
				<th style="text-align: center;">Gross Profit Rate</th>
				<!--
				<th style='text-align:right'>Payment</th>
				<th style='text-align:right'>Balance</th>
				<th style='text-align:right'>Loss</th>
				<th style='text-align:right'>Gain</th>
				-->
			</tr>
		</thead>
		<tbody>
		<?php
			$salesman_unique_query = mysql_query("SELECT DISTINCT salesmanID FROM tbl_purchases WHERE date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'");

			echo "<select id='salesman'><option value=''>Select Account Specialist</option>";
			while($salesman_unique_row=mysql_fetch_assoc($salesman_unique_query)){
				$salesmanID = $salesman_unique_row["salesmanID"];
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo "<option value='$salesmanID' ";
				if($s==$salesmanID){
					echo "selected='selected'";
				}
				echo ">".$salesman_data["salesman_name"]."</option>";
			}
			echo "</select>";
			$query = "SELECT DISTINCT itemID FROM tbl_purchases WHERE date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'";
			if(isset($s)&&$s!=""){
				$query.=" AND salesmanID='$s'";
				$salesman_string = " AND salesmanID='$s'";
			}else{
				$salesman_string = "";
			}

			echo $query;
			$order_query = mysql_query($query);
			if(mysql_num_rows($order_query)!=0){
				while ($order_row=mysql_fetch_assoc($order_query)) {
					# code...
					$itemID = $order_row["itemID"];
					$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
					$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='".$item_data["supplierID"]."' AND deleted='0'"));
					$quantity = mysql_fetch_assoc(mysql_query("SELECT SUM(quantity) as total_quantity FROM tbl_purchases WHERE date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND itemID='$itemID' AND deleted='0'$salesman_string"));
					$costprice = mysql_fetch_assoc(mysql_query("SELECT SUM(costprice) as total_costprice FROM tbl_purchases WHERE date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND itemID='$itemID' AND deleted='0'$salesman_string"));
					$price = mysql_fetch_assoc(mysql_query("SELECT SUM(price) as total_price FROM tbl_purchases WHERE date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND itemID='$itemID' AND deleted='0'$salesman_string"));
					$total_costprice = $costprice["total_costprice"]*$quantity["total_quantity"];
					$total_sales = $price["total_price"]*$quantity["total_quantity"];
					$gross_margin = $total_sales-$total_costprice;
					($total_sales!=0?$gross_profit_rate = $gross_margin/$total_sales:$gross_profit_rate=0);
					echo "
					<tr>
						<td>".$item_data["item_code"]."</td>
						<td><a href='item?s=$itemID'>".$item_data["itemname"]."</a></td>
						<td><a href='suppliers?id=".$item_data["supplierID"]."'>".$supplier_data["supplier_name"]."</a></td>
						<td>".$item_data["category"]."</td>
						<td>".(number_format($quantity["total_quantity"]))."</td>
						<td>".$item_data["unit_of_measure"]."</td>
						<td style='text-align:right;'>".(number_format($costprice["total_costprice"],2))."</td>
						<td style='text-align:right;'>".number_format($total_costprice,2)."</td>
						<td style='text-align:right;'>".number_format($total_sales,2)."</td>
						<td style='text-align:right;'>".number_format($gross_margin,2)."</td>
						<td style='text-align:right;'>".number_format(($gross_profit_rate*100),2)."%</td>
					</tr>
					";
				}
			}

		?>
		</tbody>
		<tfoot>
		</tfoot>
		</table>
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