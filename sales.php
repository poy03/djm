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
  <title><?php echo $app_name; ?> - Sales</title>
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
	  $("#add_customer").click(function(){
		  window.location= "customer-add";
	  });
	  
	  $("#myTable").tablesorter();
	  $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} );
	  
	  $("#reset").click(function(){
		  var dataString = 'reset=1';
		  $.ajax({
			type: 'POST',
			url: 'sales-cart-add',
			data: dataString,
			cache: false,
			success: function(html){
				window.location = 'sales';
			}
		  });
	  });	  
	  $("#reset_cost").click(function(){
		  var dataString = 'reset_cost=1';
		  $.ajax({
			type: 'POST',
			url: 'sales-cart-add',
			data: dataString,
			cache: false,
			success: function(html){
				window.location = 'sales';
			}
		  });
	  });
	  
	  $(".quantity").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&value='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					$("#total_of_"+e.target.id).html(html);
					// window.location = 'sales';
					var dataString = 'total=sales'; 
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
	  });
	  
	  $(".price").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&price='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					$("#total_of_"+e.target.id).html(html);
					var dataString = 'total=sales'; 
		            $.ajax({                    
		                type: "post",
		                url: "total.php",
		                data: dataString,
		                cache: false,
		                success: function(data){
							$("#total").html(data);
						}
					});		
					// window.location = 'sales';
				}
			});
	  });
		  
	  $(".costprice").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&costprice='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// window.location = 'sales';
				}
			});
	  });
	  
	  $("#type").change(function(){
		  var n = $(this).val();
		  window.location="sales-type?type="+n;
	  });
	  $(".delete").click(function(){
		  if(conf = confirm("Are you sure you want to delete selected item?")){
		  var id = $(this).attr("href");
		  window.location=id;
		  }		  
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
		  window.location='sales-add-customer?id='+ui.item.data;
	  }
    });
		
	$( "#salesman" ).autocomplete({
      source: 'search-salesman',
	  select: function(event, ui){
		  window.location='sales-add-salesman?id='+ui.item.data;
	  }
    });
		
		
	$( "#itemsearch" ).autocomplete({
      source: 'search-item-auto',
	  select: function(event, ui){
		  window.location='sales-add?id='+ui.item.data;
	  }
    });		


 	$( "#itemsearch_cat" ).autocomplete({
      source: 'search-item-category-auto',
	  select: function(event, ui){
		  window.location='sales-add?id='+ui.item.data;
	  }
    });
    

	$( "#search_ts" ).autocomplete({
      source: 'search_ts.php',
	  select: function(event, ui){
		  window.location='sales-add-by-ts?id='+ui.item.data;
	  }
    });		
    
	$("#terms").keyup(function(){
		var terms = $(this).val();
		var dataString = 'terms='+terms;
		  $.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// window.location='sales';
				}
		  });
	});
	
	

	

	$("#delall").click(function(){
		var dataString = 'delall=1';
		  $.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					window.location='sales';
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
					// window.location = 'sales'
				}
			});
		});
		
		$("#del_customer").click(function(){
			window.location='sales-add-customer?id=0';
		});
		$("#delete_salesman").click(function(){
			window.location='sales-add-salesman?id=0';
		});		

		$("#discount").keyup(function(e){
			var subtotal = $("#subtotal").val();
			var dataString = 'discount='+ e.target.value+'&subtotal='+subtotal;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// window.location = 'sales';
					// alert(html);
					$("#total").html(html);
				}
			});
		});

		$("#own_use").change(function(e){
			var own_use = ($('#own_use').is(':checked')?"true":"false");
			var dataString = 'own_use='+ own_use;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// window.location = 'sales';
					// alert(html);
					$("#total").html(html);
				}
			});
		});


		$("#sales-form").submit(function(e){
			e.preventDefault();
			$("#sales-submit").attr("disabled","disabled");
			$.ajax({
				type: "POST",
				data: $("#sales-form :input").serialize()+"&save=1",
				url: $("#sales-form").attr("action"),
				dataType: "json",
				cache: false,
				success: function(data){
					window.location = "sales-complete?id="+data.orderID;
				}
			});
		});

	// function containsWord(haystack, needle) {
    // return (" " + haystack + " ").indexOf(" " + needle + " ") !== -1;
	// }
	  // alert(containsWord("red green blue", "red"));
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
	<ol class="breadcrumb">
		<li class="active">Make Delivery Receipt</li>
		<li><a href="sales-ts">Make Transaction Sheet</a></li>
		<li><a href="sales-ts-list">List of Pending Transaction Sheets <span class='badge'><?php ($badge_sales==0?$badge_sales="":false); echo $badge_sales; ?></span></a></li>
		<li><a href="sales-dr-list">List of Delivery Receipt</a></li>
	</ol>
	<?php
	if($logged==1||$logged==2){
		if($sales=='1'){
	?>
	
	<div class='col-md-2 pull-right'>
	
		
	<form action='sales-form' method='post' id="sales-form">
	
	<?php

	// if empty cart
	$inthecartquery = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");

	if(mysql_num_rows($inthecartquery)==0){
			echo "<label>TS Number:</label>";
		echo "<input tabindex='-1' type='text' class='form-control search' id='search_ts' placeholder='TS Number' autocomplete='off' name='ts_orderID'>";
	}
	if(mysql_num_rows($inthecartquery)!=0){
	?>
	<?php
	$order_query = mysql_query("SELECT * FROM tbl_orders WHERE deleted='0' ORDER BY orderID DESC LIMIT 0,1");
	if(mysql_num_rows($order_query)!=0){
		while ($order_row=mysql_fetch_assoc($order_query)) {
			$dr_number = $order_row["orderID"]+1;
		}
	}else{
		$dr_number = '';
	}
	$cart_data = mysql_fetch_assoc($inthecartquery);
	if($cart_data["ts_orderID"]!=0){
			echo "<label>TS Number:</label>";
			echo "<input tabindex='-1' type='text' class='form-control search' id='search_ts' placeholder='TS Number' autocomplete='off' value='".$cart_data["ts_orderID"]."' name='ts_orderID' readonly> <br>";
	}
	echo "
	
	<label>Delivery Receipt</label>
	<input type='number' class='form-control' name='dr_number' value='$dr_number' required>
	";

	?>
	<br>
	<label>Customer:</label>
	<?php
	$customername = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID' ORDER BY customer DESC");
	if(mysql_num_rows($customername)!=0){
		while($cusrow=mysql_fetch_assoc($customername)){
			$Customer = $cusrow["Customer"];
			$comments = $cusrow["comments"];
			$terms = $cusrow["terms"];
			$salesmanID = $cusrow["salesmanID"];
			$customerID = $cusrow["customerID"];
			$own_use = $cusrow["own_use"];
			if($terms==0){
				$terms=0;
			}
		}
		if($customerID!=0){
		echo '<input tabindex="-1" type="text" class="form-control search" id="searchid" name="Customer" placeholder="Type for Customer Name" value="'.htmlspecialchars_decode($Customer).'" autocomplete="off" readonly>';
		}else{
		echo '<input tabindex="-1" type="text" class="form-control search" id="searchid" name="Customer" placeholder="Type for Customer Name" value="'.htmlspecialchars_decode($Customer).'" autocomplete="off" required="required">';
		}
	}else{
		echo "<input tabindex='-1' type='text' class='form-control search' id='searchid' name='Customer' placeholder='Type for Customer Name' autocomplete='off' required='required'>";
	}
	?>
	<a class='btn btn-info btn-block' href='customer-add' target='_blank' tabindex='-1'><span class='glyphicon glyphicon-user'></span> Add Customer</a>
	<?php
	if($customerID!=0&&$cart_data["ts_orderID"]==0){
	echo "<a class='btn btn-danger btn-block' id='del_customer' tabindex='-1'><span class='glyphicon glyphicon-trash'></span> Remove Customer</a>";
	}
	?>
	<br>
	<label>Salesman:</label>
	<?php
	if($salesmanID==0){
		echo "<input type='text' name='' id='salesman' class='form-control' placeholder='Type for Salesman Name'>";
		echo "<a class='btn btn-info btn-block' href='salesman-add' target='_blank' tabindex='-1'><span class='glyphicon glyphicon-user'></span> Add Salesman</a>";
	}else{	
		$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
		echo '
		<input type="hidden" name="salesmanID" value="'.$salesmanID.'">
		<input type="text" name=" id="salesman" class="form-control" placeholder="Type for Salesman Name" value="'.$salesman_data["salesman_name"].'" readonly>';
		echo '<a class="btn btn-info btn-block" href="salesman-add" target="_blank" tabindex="-1"><span class="glyphicon glyphicon-user"></span> Add Salesman</a>';		
		if($cart_data["ts_orderID"]==0){
			echo "<a class='btn btn-block btn-danger' id='delete_salesman'><span class='glyphicon glyphicon-trash'></span> Remove Salesman</a>";
		}
	}
	?>
	<br>
	<label>Type of Price:</label>
	<select id='type' class='form-control' tabindex='-1'>
		<option value='srp' 
		<?php if(isset($typeprice)&&strtolower($typeprice)=="srp"){
		echo "selected='selected'";	
		}
		?> >Suggested Retail Price</option>
		<option value='std_price_to_trade_terms'
		<?php if(isset($typeprice)&&strtolower($typeprice)=="std_price_to_trade_terms"){
		echo "selected='selected'";	
		}
		?>
		>STD Price to Trade (Terms)</option>
		<option value='std_price_to_trade_cod'
		<?php if(isset($typeprice)&&strtolower($typeprice)=="std_price_to_trade_cod"){
		echo "selected='selected'";	
		}
		?>
		>STD Price to Trade (COD)</option>
		<option value='price_to_distributors'
		<?php if(isset($typeprice)&&strtolower($typeprice)=="price_to_distributors"){
		echo "selected='selected'";	
		}
		?>
		>Price to Distributors</option>

	</select>
	<!--
	<label>Controls:</label>
	<a class='btn btn-info btn-block' id='reset'><span class='glyphicon glyphicon-refresh'></span> Reset All Prices</a>
	<a class='btn btn-info btn-block' id='reset_cost'><span class='glyphicon glyphicon-refresh'></span> Reset All Cost Price</a>
	<br>
	<label>Type of Payment:</label>
	<select id='type_payment' multiple='multiple' name='type_payment[]' class='form-control' required='required' tabindex='-1'>
	<?php
	$type_payment_array = explode(",",$type_payment);
	$type_payment_db_array = explode(",",$type_payment_db);

	foreach($type_payment_array as $type_payment_each){
		echo "<option value='$type_payment_each'";
		if(isset($type_payment_db)){
		  if(in_array($type_payment_each,$type_payment_db_array)){
			echo "selected='selected'";
		  }
		}
		echo ">$type_payment_each</option>";
	}

	?>
	</select>
	<br>
	-->
	<br>
	<label>Terms:</label>
	<input type='number' min='0' name='terms' class='form-control' id='terms' tabindex='-1' placeholder='Number of Days' value='<?php echo $terms; ?>'>
	<!--<small><i>* For Credits Only.</i></small>-->
	<br>
	<span><b>Comments:</b></span>
	<textarea name='comments' class='form-control' tabindex='-1'><?php echo $comments; ?></textarea>
	<br>
	<div class="checkbox">
	  <label><input type="checkbox" id="own_use" name="own_use" value="true" <?php echo ($own_use=="1"?"checked":"") ?>>Own Use</label>
	</div>
	<span><b>Sales Register:</b></span>
	<!--<button class='btn btn-primary btn-block' name='save'><span class='glyphicon glyphicon-floppy-disk'></span> Save</button>-->
	<button class='btn btn-primary btn-block' name='save'  tabindex='-1' id="sales-submit"><span class='glyphicon glyphicon-floppy-disk'></span> Save & Continue</button>

	<a class='btn btn-danger btn-block' name='delete' id='delall' tabindex='-1'><span class='glyphicon glyphicon-trash'></span> Cancel Sale</a>
	<br>
	<?php }
	echo "
	<br>
	<label>Utilities:</label>
		<a class='btn btn-primary btn-block' href='sales'><span class='glyphicon glyphicon-refresh'></span> Refresh Page</a>
			<a class='btn btn-info btn-block' id='reset'><span class='glyphicon glyphicon-refresh'></span> Reset All Prices</a>
	<a class='btn btn-info btn-block' id='reset_cost'><span class='glyphicon glyphicon-refresh'></span> Reset All Cost Price</a>
	<a tabindex='-1' class='btn btn-info btn-block' name='delete' href='sales-re'><span class='glyphicon glyphicon-shopping-cart'></span> Sales Search</a>";


	if($orderID!=Null){
		echo "<a tabindex='-1' href='sales-complete' class='btn btn-block btn-info'>View Last Transaction</a>";
	}
	?>
	

	
	
	</div>
	<div class='table-responsive col-md-10'>
	
	<div class='col-md-6'>
	<label><b>Add Item:</b></label>
	<div class = "form-group">
	   <input type = "text" class = "form-control itemsearch" name='itemname' id='itemsearch' autocomplete='off' placeholder='Type for Item Name Or Item Code'>
	</div>			
	</div>		
	<div class='col-md-6'>
	<label><b>Add Item:</b></label>
	<div class = "form-group">
	   <input type = "text" class = "form-control" name='itemname' id='itemsearch_cat' autocomplete='off' placeholder='Type for Category'>
	</div>		
	</div>


	<table class='table table-hover tablesorter tablesorter-default'>
	<thead>
		<tr>
			<th>Item Name</th>
			<th>Remaining</th>
			<th>Cost Price</th>
			<th>Quantity</th>
			<th>Price</th>
			<th style='text-align:right'>Line Total</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$total = 0;
		$cartquery = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");
		if(mysql_num_rows($cartquery)!=0){
			while($itemrow=mysql_fetch_assoc($cartquery)){
				$itemID = $itemrow["itemID"];
				$quantity = $itemrow["quantity"];
				$cartprice = $itemrow["price"];
				$discount = $itemrow["discount"];
				$customerID = $itemrow["customerID"];
				$costprice = $itemrow["costprice"];
				$pricequery = mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'");
				while($pricerow=mysql_fetch_assoc($pricequery)){
					$itemname = $pricerow["itemname"];
					$item_code = $pricerow["item_code"];
					if($item_code!=""){
						$item_code = "[$item_code]";
					}
					$remaining = $pricerow["quantity"];
					$category = $pricerow["category"];
					if($costprice==0){
						$costprice = $pricerow["costprice"];
					}
					if($cartprice=="0"){
						if(isset($typeprice)&&strtolower($typeprice)=='dp'){
							$price = $pricerow['dp'];
							
						}elseif(isset($typeprice)&&strtolower($typeprice)=='std_price_to_trade_terms'){
							$price = $pricerow['std_price_to_trade_terms'];
							
						}elseif(isset($typeprice)&&strtolower($typeprice)=='std_price_to_trade_cod'){
							$price = $pricerow['std_price_to_trade_cod'];
							
						}elseif(isset($typeprice)&&strtolower($typeprice)=='price_to_distributors'){
							$price = $pricerow['price_to_distributors'];
						}else{
							$price = $pricerow['srp'];
						}
					}else{
						$price=$cartprice;
					}
				}
				$subtotal = $quantity*$price;
				$total = $total + $subtotal;
				echo "
				<tr>
					<input type='hidden' name='itemID[]' value='$itemID'>
					<td><a href='item?s=$itemID' tabindex='-1'>$itemname</a><br><i style='font-size:75%;'>$category $item_code</i></td>
					<td>$remaining</td>
					<td><input type='number' min='0' max='' step='0.01' value='$costprice' name='costprice[]' required='required' class='costprice' id='$itemID'></td>
					<td><input type='number' min='1' max='$remaining' value='$quantity' name='quantity[]' required='required' class='quantity' id='$itemID'></td>
					<td><input type='number' min='0' max='' step='0.01' value='$price' name='price[]' required='required' class='price' id='$itemID'></td>
					<td style='text-align:right'><span id='total_of_$itemID'><b>₱".number_format($subtotal,2)."</b></span></td>
					<td>
					<span class='delete btn btn-danger' href='sales-form?id=$itemID'>X</span>
					</td>
					
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
	if(mysql_num_rows($cartquery)!=0){
		echo "
	<tr>
		<input type='hidden' name='customerID' value='$customerID'>
		<input type='hidden' name='total' value='$total'>
		<td colspan='5' align='right'><b>Total:</b></td>
		<td style='text-align:right'><b><span id='total'>₱".number_format($total,2)."</b></span><input type='hidden' id='subtotal' value='$total'></td>
		<td></td>
	</tr>
	";
	if($cart_data["ts_orderID"]!=0){
		$status = "readonly";
	}else{
		$status = "";
	}
	echo "
	<tr>
	<th colspan='5' style='text-align: right;'>Discount:</th>
	<th style='text-align:right'>".number_format($discount,2)."</th>
	</tr>
	";
	
	}
	?>
	</tfoot>
	</table>
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
