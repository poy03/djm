<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$orderID=@$_SESSION['orderID'];

$page=@$_GET['page'];

$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

$cart_query = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");
if(mysql_num_rows($cart_query)==0){
	$typeprice=@$_GET['type'];
}else{
	while($cart_row=mysql_fetch_assoc($cart_query)){
		$typeprice=$cart_row["type_price"];
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Sales | Transaction Sheet</title>
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
  <script src="js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="css/bootstrap-multiselect.css">
  <style>
  .item:hover{
	  cursor:pointer;
  }

  </style>
  <link rel="stylesheet" href="css/theme.default.min.css">
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
	<link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  
  <script>
  $(document).ready(function(){
	$("#Sales").addClass("active");
	$( "#salesman" ).autocomplete({
	  source: 'search-salesman',
	  select: function(event, ui){
		  window.location='sales-ts-add-salesman?id='+ui.item.data;
	  }
	});	  	  
		$("#delete_salesman").click(function(){
			if(confirm("Are you sure you want to delete?")){
				window.location='sales-ts-add-salesman?id=0';
			}
		});	
	  $("#ts").change(function(){
		var dataString = $(this).val();
		$.ajax({
			type: 'POST',
			data: 'ts='+dataString,
			cache: false,
			url: 'sales-ts-cart-add',
			success: function(){

			}
		});
	  });
	  $("#add_customer").click(function(){
		  window.location= "customer-add";
	  });
	  
	  $("#myTable").tablesorter();
	  $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} );
	  
	  $("#reset").click(function(){
		  var dataString = 'reset=1';
		  $.ajax({
			type: 'POST',
			url: 'sales-ts-cart-add',
			data: dataString,
			cache: false,
			success: function(html){
				location.reload();
				// window.location = 'sales-ts';
			}
		  });
	  });	  
	  $("#reset_cost").click(function(){
		  var dataString = 'reset_cost=1';
		  $.ajax({
			type: 'POST',
			url: 'sales-ts-cart-add',
			data: dataString,
			cache: false,
			success: function(html){
				location.reload();
				// window.location = 'sales-ts';
			}
		  });
	  });
	  
	  $("#discount").on("blur", function(e){
		var subtotal = $("#subtotal").val();
		var dataString = 'discount='+e.target.value+'&total=sales_ts_total';
		$.ajax({
			type: 'POST',
			url: 'total.php',
			data: dataString,
			cache: false,
			success: function(html){
				// window.location = 'sales';
				// alert(html);
				$("#total").html(html);
			}
		});
	  });

	  $(".quantity").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&value='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// window.location = 'sales';
					$("#total_of_"+e.target.id).html(html);
					// window.location = 'sales';
					var dataString = 'total=sales_ts'; 
					$.ajax({                    
						type: "post",
						url: "total",
						data: dataString,
						cache: false,
						success: function(data){
							$("#sub_total").html(data);
							var dataString = 'total=sales_ts_total'; 
							$.ajax({                    
								type: "post",
								url: "total.php",
								data: dataString,
								cache: false,
								success: function(data){
									$("#total").html(data);
								}
							});
						}
					});
				}
			});
	  });
	  
	  $(".price").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&price='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					$("#total_of_"+e.target.id).html(html);
					// window.location = 'sales';
					var dataString = 'total=sales_ts'; 
					$.ajax({                    
						type: "post",
						url: "total.php",
						data: dataString,
						cache: false,
						success: function(data){
							$("#sub_total").html(data);
							var dataString = 'total=sales_ts_total'; 
							$.ajax({                    
								type: "post",
								url: "total.php",
								data: dataString,
								cache: false,
								success: function(data){
									$("#total").html(data);
								}
							});
						}
					});
				}
			});
	  });	

	  $(".costprice").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&costprice='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){

				}
			});
	  });

	  $(".delete").click(function(e){
		if(confirm("Are you sure you want to delete selected item?")){
			var dataString = 'deleteid='+ e.target.id;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
			});
		}
	  });
	  
	  $("#type").change(function(){
		  var n = $(this).val();
		  window.location="sales-ts-type?type="+n;
	  });
	  $("#type_payment_cart").change(function(){
		var type_payment = $(this).val();
		var dataString = 'search='+ type_payment;
		  $.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
		  });
	  });
	  

	$( "#searchid" ).autocomplete({
	  source: 'search-customer-auto',
	  select: function(event, ui){
		  window.location='sales-ts-add-customer?id='+ui.item.data;
	  }
	});
		
		
	$( "#itemsearch" ).autocomplete({
	  source: 'search-item-auto',
	  select: function(event, ui){
		  window.location='sales-ts-add?id='+ui.item.data;
	  }
	});

	$( "#itemsearch_cat" ).autocomplete({
	  source: 'search-item-category-auto',
	  select: function(event, ui){
		 window.location='sales-ts-add?id='+ui.item.data;
	  }
	});
	

	$("#terms").change(function(){
		var terms = $(this).val();
		var dataString = 'terms='+terms;
		  $.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
				}
		  });
	});
	
	

	

	$("#delall").click(function(){
		var dataString = 'delall=1';
		  $.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
		  });
	});
		
		$('#type_payment').multiselect();
		$('#type_payment').change(function(){
			var type_payment = $(this).val();
			var dataString = "type_payment="+type_payment;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(){
				}
			});
		});
		
		$("#del_customer").click(function(){
			if(confirm("Are you sure you want to delete?")){
				window.location='sales-ts-add-customer?id=0'
			}
		});


		$("#sales-ts-form").submit(function(e){
			e.preventDefault();
			$("#sales-ts-submit").attr("disabled","disabled");
			// alert($("#sales-ts-form :input").serialize());
			$.ajax({
				url: $("#sales-ts-form").attr("action"),
				data: $("#sales-ts-form :input").serialize()+"&save=1",
				cache: false,
				type: "POST",
				dataType: "json",
				success: function(data){
					window.location = "sales-ts-complete?id="+data.orderID;
				}
			});
		});

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
	<ol class="breadcrumb" >
		<li><a href="sales">Make Delivery Receipt</a></li>
		<li class="active">Make Transaction Sheet</li>
		<li><a href="sales-ts-list">List of Pending Transaction Sheets <span class='badge'><?php ($badge_sales==0?$badge_sales="":false); echo $badge_sales; ?></span></a></li>
		<li><a href="sales-dr-list">List of Delivery Receipt</a></li>
	</ol>
	<?php
	if($logged==1||$logged==2){
		if($sales=='1'){
	?>
	
		<?php
			$ts_cart_query = mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID'");
		?>
	<form action='sales-ts-form' method='post' id="sales-ts-form">
	<div class='col-md-2 pull-right'>
	<?php
		if(mysql_num_rows($ts_cart_query)!=0){
			while ($ts_cart_row_unique=mysql_fetch_assoc($ts_cart_query)) {
				$type_price = $ts_cart_row_unique["type_price"];
				$terms = $ts_cart_row_unique["terms"];
				$salesmanID = $ts_cart_row_unique["salesmanID"];
				$customer = $ts_cart_row_unique["customer"];
				$customerID = $ts_cart_row_unique["customerID"];
				$ts = $ts_cart_row_unique["ts"];
			}
			$order_ts_query = mysql_query("SELECT * FROM tbl_ts_orders WHERE deleted='0'");
			if(mysql_num_rows($order_ts_query)!=0){
				$order_ts_data = mysql_fetch_assoc($order_ts_query);
				$ts=$order_ts_data["ts_orderID"]+1; //increment the orderID into the database to match the incrementation in the database.
			}
	$format = date("Ym")."000";
	$query = "SELECT * FROM tbl_ts_orders WHERE ts_orderID >= '$format' ORDER BY ts_orderID DESC LIMIT 0,1";
	// echo $query;
	$order_query = mysql_query($query);
	//if ts_orderID is less than the format then reset the ts_orderID to 0.
	if(mysql_num_rows($order_query)==0){
		$ts = $format;
	}else{
		$order_data = mysql_fetch_assoc($order_query);
		$ts = $order_data["ts_orderID"]+1;
	}
	if(mysql_num_rows($ts_cart_query)!=0){
	?>

	<label>TS:</label>
	<input type="text" name="ts" class="form-control" placeholder="Transaction Sheet" id="ts" value="<?php echo $ts; ?>" readonly>
	<br>



<?php 





		echo "<input type='hidden' name='customerID' value='$customerID'><br>";
		echo "<label>Customer:</label>";
		if($customerID!=0){
		echo '<input tabindex="-1" type="text" class="form-control search" id="searchid" name="customer" placeholder="Type for Customer Name" value="'.htmlspecialchars_decode($customer).'" autocomplete="off" readonly>';
		echo "<a class='btn btn-danger btn-block' id='del_customer' tabindex='-1'><span class='glyphicon glyphicon-trash'></span> Remove Customer</a>";		
		}else{
		echo '<input tabindex="-1" type="text" class="form-control search" id="searchid" name="customer" placeholder="Type for Customer Name" value="'.htmlspecialchars_decode($customer).'" autocomplete="off" required="required">';
		}
		echo "<a class='btn btn-info btn-block' href='customer-add' target='_blank' tabindex='-1'><span class='glyphicon glyphicon-user'></span> Add Customer</a>";


	}


?>

<label>Salesman</label>
<?php
if($salesmanID==0){
	echo "<input type='text' name='' id='salesman' class='form-control' placeholder='Type for Salesman Name'>";
}else{	
	$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
	echo '
	<input type="hidden" name="salesmanID" value="'.$salesmanID.'">
	<input type="text" name=" id="salesman" class="form-control" placeholder="Type for Salesman Name" value="'.htmlspecialchars_decode($salesman_data["salesman_name"]).'" readonly>';
	echo "<a class='btn btn-block btn-danger' id='delete_salesman'><span class='glyphicon glyphicon-trash'></span> Remove Salesman</a>";
}
?>



	<br>
	<label>Terms</label>
	<?php
	echo "<input type='number' name='terms' id='terms' value='$terms' class='form-control' placeholder='Terms'>"
	?>

	<br>

	<span><b>Type of Price:</b></span>
	<select id='type' class='form-control' tabindex='-1'>
		<option value='srp' 
		<?php if(isset($type_price)&&strtolower($type_price)=="srp"){
		echo "selected='selected'";	
		}
		?> >Suggested Retail Price</option>
		<option value='std_price_to_trade_terms'
		<?php if(isset($type_price)&&strtolower($type_price)=="std_price_to_trade_terms"){
		echo "selected='selected'";	
		}
		?>
		>STD Price to Trade (Terms)</option>
		<option value='std_price_to_trade_cod'
		<?php if(isset($type_price)&&strtolower($type_price)=="std_price_to_trade_cod"){
		echo "selected='selected'";	
		}
		?>
		>STD Price to Trade (COD)</option>
		<option value='price_to_distributors'
		<?php if(isset($type_price)&&strtolower($type_price)=="price_to_distributors"){
		echo "selected='selected'";	
		}
		?>
		>Price to Distributors</option>

	</select>

	<br>


	<label>Comments:</label>
	<textarea class="form-control" placeholder="Comments" name="comments" id="comments"></textarea>
	<br>
	<label>Controls:</label>
	<button class="btn btn-block btn-primary" name="save" id="sales-ts-submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
	<a class='btn btn-danger btn-block' name='delete' id='delall' tabindex='-1'><span class='glyphicon glyphicon-trash'></span> Cancel Sale</a>	
	<br>
	<label>Resets:</label>
	<a class='btn btn-primary btn-block' href='sales-ts'><span class='glyphicon glyphicon-refresh'></span> Refresh Page</a>
	<a class='btn btn-info btn-block' id='reset'><span class='glyphicon glyphicon-refresh'></span> Reset All Prices</a>
	<a class='btn btn-info btn-block' id='reset_cost'><span class='glyphicon glyphicon-refresh'></span> Reset All Cost Price</a>
	<br>
		<?php 
}
		?>	
	</div>
	<div class="col-md-10">
		<div class="row">
			<div class="col-md-6">
				<label>Add Item:</label>
				<input type="text" id="itemsearch" class="form-control" placeholder="Type for Item Name or Item Code">
			</div>
			<div class="col-md-6">
				<label>Add Item:</label>
				<input type="text" id="itemsearch_cat" class="form-control" placeholder="Type for Category">
			</div>

		</div>
		<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<th>Item Name</th>
				<th>Remaining Qty</th>
				<th>Cost Price</th>
				<th>Qty</th>
				<th>Selling Price</th>
				<th>Line Total</th>
				<th></th>
			</thead>
			<tbody>
				<?php
					$ts_cart_query = mysql_query("SELECT * FROM tbl_ts_cart WHERE accountID='$accountID'");
					$total = 0;
					if((mysql_num_rows($ts_cart_query)!=0)){
						while ($ts_cart_row=mysql_fetch_assoc($ts_cart_query)) {
							$cartID = $ts_cart_row["cartID"];
							$itemID = $ts_cart_row["itemID"];
							$quantity = $ts_cart_row["quantity"];
							$discount = $ts_cart_row["discount"];
							$costprice = $ts_cart_row["costprice"];
							$type_price = $ts_cart_row["type_price"];
							$price = $ts_cart_row["price"];
							$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
							($costprice==0?$costprice = $item_data["costprice"]:false);
							($price==0?$price = $item_data["$type_price"]:false);
							$line_total = $quantity * $price;
							$total += $line_total;
							if($item_data["item_code"]!=""){
								$item_data["item_code"] = "[".$item_data["item_code"]."]";
							}
							echo "
							<tr>
								<td><a href='item?s=$itemID' tabindex='-1'>".$item_data["itemname"]."</a><br><i style='font-size:75%;'>".$item_data["category"]." ".$item_data["item_code"]."</i></td>
								<td>".$item_data["quantity"]."</td>
								<td><input type='number' value='$costprice' min='0' step='0.01' id='$itemID' class='costprice'></td>
								<td><input type='number' value='$quantity' min='1' max='".$item_data["quantity"]."' id='$itemID' class='quantity'></td>
								<td><input type='number' value='$price' min='0' step='0.01' id='$itemID' class='price'></td>
								<td style='text-align:right'><span id='total_of_$itemID'>".number_format($line_total,2)."</span></td>
								<td><span class='delete btn btn-danger' id='$cartID'>X</span></td>
							</tr>
							";
						}
					}else{
									echo "
			<tr>
				<td colspan='20' align='center'><b style='font-size:200%'>No Items to Show.</b></td>
			</tr>
			";
					}
				?>
			</tbody>
			<tfoot>
				
					<?php
					if((mysql_num_rows($ts_cart_query)!=0)){
					echo "
					<tr>
					<th colspan='5' style='text-align: right;'>SUB Total:</th>
					<th style='text-align:right'><span id='sub_total'>".number_format($total,2)."</span><input type='hidden' id='subtotal' value='$total'></th>
					</tr>
					";
					echo "
					<tr>
					<th colspan='5' style='text-align: right;'>Discount/ Incentives:</th>
					<th style='text-align:right'><input  style='text-align:right' type='number' step='0.01' min='0' max='$total' name='discount' class='form-control' id='discount' value='$discount'></th>
					</tr>
					";
					echo "
					<tr>
					<th colspan='5' style='text-align: right;'>Total:</th>
					<th style='text-align:right'><span id='total'>".number_format($total-$discount,2)."</span></th>
					</tr>
					";					
					}else{
						echo "
						<th></th>
						<th></th>
						</tr>
						";
					}

					?>
				
			</tfoot>
		</table>
		</div>
	</div>
	</form>

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


