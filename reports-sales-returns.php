<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$t=@$_GET['t'];
$f=@$_GET['f'];
$s=@$_GET['s'];
$c=@$_GET['c'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Sales Returns</title>
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
			$("#Reports").addClass("active");
			$("#salesman").change(function(){
				var f = $("#f").val();
				var t = $("#t").val();
				var c = $("#c").val();
				var s = $(this).val();
				window.location = "?f="+f+"&t="+t+"&s="+s+"&c="+c;
			});
			$("#customer").change(function(){
				var f = $("#f").val();
				var t = $("#t").val();
				var c = $(this).val();
				var s = $("#s").val();
				window.location = "?f="+f+"&t="+t+"&s="+s+"&c="+c;
			});
			$("#date_from").datepicker();
			$("#date_to").datepicker();
			$("#by").change(function(){
				var date_from = $("#date_from").val();
				var date_to = $("#date_to").val();
				var by = $(this).val();
				window.location= "reports?by="+by+"&f="+date_from+"&t="+date_to;
			});
			
	
		

  
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
		echo "<center><h3>Sales Returns in ".date("F d, Y",strtotime($f))." - ".date("F d, Y",strtotime($t))."</h3></center>
		<input type='hidden' id='f' value='".date("m/d/Y",strtotime($f))."'>
		<input type='hidden' id='t' value='".date("m/d/Y",strtotime($t))."'>
		<input type='hidden' id='s' value='$s'>
		<input type='hidden' id='c' value='$c'>
		";
	?>	
	<div class='table-responsive'>
		<table class='table table-hover'>
		<thead>
			<tr>
				<th style="text-align: center;">REQ #</th>
				<th style="text-align: center;">Date Returned</th>
				<th style="text-align: center;">Date of DR</th>
				<th style="text-align: center;">DR #</th>
				<th style="text-align: center;">TS #</th>
				<th style="text-align: center;">Customer</th>
				<th style="text-align: center;">Account Specialist</th>
				<th style="text-align: center;">SKU Code</th>
				<th style="text-align: center;">Product Name</th>
				<th style="text-align: center;">Supplier</th>
				<th style="text-align: center;">Category</th>
				<th style="text-align: center;">UOM</th>
				<th style="text-align: center;">QTY</th>
				<th style="text-align: center;">Price</th>
				<th style="text-align: center;">Total Amount</th>
				<th style="text-align: center;">Status</th>
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
			$str_date_from = strtotime($f);
			$str_date_to = strtotime($t);
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;
			$query  = "SELECT * FROM tbl_sales_edit_items WHERE approved_by != '0' AND date_approved BETWEEN '$str_date_from' AND '$str_date_to'";
			$export_query = $query;
			$total_returns = mysql_fetch_assoc(mysql_query("SELECT SUM(new_quantity*price) as total_returns FROM tbl_sales_edit_items WHERE approved_by != '0' AND date_approved BETWEEN '$str_date_from' AND '$str_date_to'"));
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
			$sales_return_query = mysql_query($query);
			if(mysql_num_rows($sales_return_query)!=0){
				while($sales_return_row=mysql_fetch_assoc($sales_return_query)){
					$editID = $sales_return_row["editID"];
					$sales_edit_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_sales_edit WHERE editID='$editID'"));
					$itemID = $sales_return_row["itemID"];
					$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
					$quantity = $sales_return_row["quantity"];
					$new_quantity = $sales_return_row["new_quantity"];
					$orderID = $sales_return_row["orderID"];
					$date_approved = $sales_return_row["date_approved"];
					$approved_by = $sales_return_row["approved_by"];
					$price = $sales_return_row["price"];
					$date_approved = $sales_return_row["date_approved"];
					$requested_by = $sales_return_row["accountID"];
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '".$order_data["customerID"]."'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '".$order_data["salesmanID"]."'"));
					$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID = '".$item_data["itemID"]."'"));
					echo "
						<tr>
							<td><a href='reports-edits?id=$editID'>$editID</a></td>
							<td>".date("m/d/Y",$sales_edit_data["date"])."</td>
							<td>".date("m/d/Y",$order_data["date_ordered"])."</td>
							<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
							<td>".$order_data["ts_orderID"]."</td>
							<td>".$customer_data["companyname"]."</td>
							<td>".$salesman_data["salesman_name"]."</td>
							<td>".$item_data["item_code"]."</td>
							<td>".$item_data["itemname"]."</td>
							<td>".$supplier_data["supplier_name"]."</td>
							<td>".$item_data["category"]."</td>
							<td>".$item_data["unit_of_measure"]."</td>
							<td>".$new_quantity."</td>
							<td style='text-align:right'>".number_format($price,2)."</td>
							<td style='text-align:right'>".number_format($price*$new_quantity,2)."</td>
						</tr>
					";
				}
			}

		?>
		</tbody>	
		<tfoot>
		<?php
		if(mysql_num_rows($sales_return_query)!=0){
			echo "
			<tr>
				<th style='text-align:right' colspan='14'>TOTAL Sales Returns</th>
				<th style='text-align:right'>".number_format($total_returns["total_returns"],2)."</th>
			</tr>
			";
		}

		?>
		</tfoot>
		</table>
				<form action='#' method='post'>
				<button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Report</button>
				</form>
					<?php
						if(isset($_POST["download"])){
							$filename = "reports-files\sales-return-reports-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
							// echo $filename;
							$fp = fopen($filename, 'w');
							$fields = array("REQ #","Date Returned","Date of DR","DR #","TS #","Customer","Account Specialist","SKU Code","Product Name","Supplier","Category","UOM","QTY","Price","Total Amount","Status");
							
							fputcsv($fp, $fields);
							$export_query = mysql_query($export_query);
							while ($export_row=mysql_fetch_assoc($export_query)) {
								$editID = $export_row["editID"];
								$sales_edit_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_sales_edit WHERE editID='$editID'"));
								$itemID = $export_row["itemID"];
								$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
								$quantity = $export_row["quantity"];
								$new_quantity = $export_row["new_quantity"];
								$orderID = $export_row["orderID"];
								$date_approved = $export_row["date_approved"];
								$approved_by = $export_row["approved_by"];
								$price = $export_row["price"];
								$date_approved = $export_row["date_approved"];
								$requested_by = $export_row["accountID"];
								$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
								$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '".$order_data["customerID"]."'"));
								$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '".$order_data["salesmanID"]."'"));
								$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID = '".$item_data["itemID"]."'"));
								if($received!=0){
									$status = "Returned";
									$received_date = date("m/d/Y",$order_data["received"]);
								}else{
									$status = "";
									$received_date = "";
								}

								$fields = array($editID,
								date("m/d/Y",$sales_edit_data["date"]),
								date("m/d/Y",$order_data["date_ordered"]),
								$orderID,
								$order_data["ts_orderID"],
								$customer_data["companyname"],
								$salesman_data["salesman_name"],
								$item_data["item_code"],
								$item_data["itemname"],
								$supplier_data["supplier_name"],
								$item_data["category"],
								$item_data["unit_of_measure"],
								$new_quantity,
								number_format($price,2),
								number_format($price*$new_quantity,2));
								


								fputcsv($fp, $fields);
								# code...
							}
							$fields = array('','','','','','','','','','','','','','TOTAL',number_format($total_returns["total_returns"],2),'','','');
							fputcsv($fp, $fields);
							fclose($fp);
							header("location:".$filename);
						}	
					?>
		<?php
		echo "<div class='text-center'><ul class='pagination prints'>
		
		";
		$url="?f=$f&t=$t&";
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