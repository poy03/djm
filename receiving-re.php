<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$id=@$_GET['id'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Receiving</title>
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
<script src="js/pox.js"></script>  <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script><script type="text/javascript" src="js/shortcut.js"></script>

  <style>
  .item:hover{
	  cursor:pointer;
  }
  
  </style>
  <script>
		$(document).ready(function(){
			$("#Purchases").addClass("active");
				  $(".delete").click(function(){
		  if(conf = confirm("Are you sure you want to delete selected item?")){
		  var id = $(this).attr("href");
		  window.location=id;
		  }		  
	  });
			
			

		
		
				//item ajax search
		$("#Purchases").keyup(function() 
		{ 
		var keyword = $(this).val();
		var dataString = 'search='+ keyword;
		if(keyword!='')
		{
			$.ajax({
			type: "POST",
			url: "search-item-all",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#results").html(html).show();
			}
			});
		}else{
			$("#results").hide();
		}
		return false;    
		});
		
		$("#results").click(function(){
			$(".show").click(function(){
				var n = $(this).attr("href");
				var id = $(this).attr("my");
				$("#Purchases").val(n);
				$("#results").hide();
				window.location='receiving-add?id='+id;
			});
			$(".cusclose").click(function(){
				$("#results").hide();
			});
		});
		
  
  //item ajax search
		$("#suppliers").keyup(function() 
		{ 
		var keyword = $(this).val();
		var dataString = 'search='+ keyword;
		if(keyword!='')
		{
			$.ajax({
			type: "POST",
			url: "search-supplier",
			data: dataString,
			cache: false,
			success: function(html)
			{
			$("#supp_results").html(html).show();
			}
			});
		}else{
			$("#supp_results").hide();
		}
		return false;    
		});
		
		$("#supp_results").click(function(){
			$(".show").click(function(){
				var n = $(this).attr("href");
				var id = $(this).attr("my");
				$("#suppliers").val(n);
				$("#supp_results").hide();
				window.location='suppliers-save?s='+id;
			});
			$(".cusclose").click(function(){
				$("#supp_results").hide();
			});
		});
  
  
  
  });
  </script>
    <style>
		#item_results,#results,#supp_results
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
	#results,#supp_results{
		width:100%;
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
	if($receiving=='1'){
		$date_received = $time_received = $dbemployee_name = "";
		$receiving_orders_query = mysql_query("SELECT * FROM tbl_orders_receiving WHERE orderID='$id'");
		if(mysql_num_rows($receiving_orders_query)!=0){
			while($receiving_orders_row=mysql_fetch_assoc($receiving_orders_query)){
				$time_received = $receiving_orders_row["time_received"];
				$date_received = $receiving_orders_row["date_received"];
				$comments = $receiving_orders_row["comments"];
				$supplierID = $receiving_orders_row["supplierID"];
				$dbaccountID = $receiving_orders_row["accountID"];
				$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
				$account_query = mysql_query("SELECT * FROM tbl_users WHERE accountID='$dbaccountID'");
				while($account_row=mysql_fetch_assoc($account_query)){
					$dbemployee_name = $account_row["employee_name"];
				}
			}
			
		}
	?>
	<?php 
	echo "Receive ID.: <b>R".sprintf("%06d",$id)."</b><br>
	Date Received:  <b>$date_received</b><br>
	Time Received: <b>$time_received</b><br>
	Received By: <b>$dbemployee_name</b><br>
	Supplier: <b>".$supplier_data['supplier_name']."</b><br>
	<div class='table-responsive'>
	<table class='table table-hover'>
	<thead>
		<tr>
			<th>Item Name</th>
			<th>Qty</th>
			<th style='text-align:right'>Cost Price</th>
			<th style='text-align:right'>Total</th>
		</tr>
	</thead>
	<tbody>";
	$receiving_query = mysql_query("SELECT * FROM tbl_receiving WHERE orderID='$id'");
	if(mysql_num_rows($receiving_query)!=0){
		while($receiving_row=mysql_fetch_assoc($receiving_query)){
			$itemID = $receiving_row["itemID"];
			$quantity = $receiving_row["quantity"];
			$costprice = $receiving_row["costprice"];
			$total_cost = $receiving_row["total_cost"];
			$item_query = mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'");
			while($item_row=mysql_fetch_assoc($item_query)){
				$itemname=$item_row["itemname"];
			}
			
			echo "
			<tr>
				<td>$itemname</td>
				<td>$quantity</td>
				<td align='right'>₱".number_format($costprice,2)."</td>
				<td align='right'>₱".number_format($total_cost,2)."</td>
			</tr>
			";
		}
	}
	$total_cost_query = mysql_query("SELECT SUM(total_cost) as total_expenses FROM tbl_orders_receiving WHERE orderID='$id'");
	if(mysql_num_rows($receiving_query)!=0){
		while($total_cost_row=mysql_fetch_assoc($total_cost_query)){
			$total_expenses = $total_cost_row["total_expenses"];
		}
	
	echo "</tbody>
	<tfoot>
		<tr>
			<th colspan='3' style='text-align:right'>TOTAL:</th>
			<th style='text-align:right'>₱".number_format($total_expenses,2)."</th>
		</tr>
	</tfoot>
	";
	}
	echo "
	</table>
	<b>Comments:</b>
	$comments
	</div>
	";
	?>
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