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
	  
	  $(".quantity").change(function(e){
			var dataString = 'id='+ e.target.id + '&value='+e.target.value;
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
	  
	  $(".price").change(function(e){
			var dataString = 'id='+ e.target.id + '&price='+e.target.value;
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
	  },
	  change: function(){
		var customer = $(this).val();
		var dataString = 'customer='+customer;
		  $.ajax({
				type: 'POST',
				url: 'sales-add-customer-02',
				data: dataString,
				cache: false,
				success: function(html){
					// window.location='sales';
					// alert("asdasd");
				}
		  });
	  }
    });
		
		
	$( "#itemsearch" ).autocomplete({
      source: 'search-item-auto',
	  select: function(event, ui){
		  window.location='sales-add?id='+ui.item.data;
	  }
    });
	$("#terms").change(function(){
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
	#result,#itemresult, #item_results
	{
		width:100%;
		max-height:200px;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:auto;
		border:1px #CCC solid;
		background-color: white;
	}
	#item_results{
		position:absolute;
		width:250px;
		z-index:3;
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
			 data-toggle = "collapse" data-target = "#example-navbar-collapse">
			 <span class = "sr-only">Toggle navigation</span>
			 <span class = "icon-bar"></span>
			 <span class = "icon-bar"></span>
			 <span class = "icon-bar"></span>
		  </button>
		  <a class = "navbar-brand" href = "index"><?php echo $app_name; ?></a>
	   </div>
	   
	   <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
		  <ul class = "nav navbar-nav  navbar-left">
		  <?php
		  $header = new Template;
		  foreach ($list_modules as $module) {
			if($module==1){
				$badge_arg = $badge_items;
			}elseif($module==3){
				$badge_arg = $badge_sales;
			}elseif($module==7){
				$badge_arg = $badge_reports;
			}elseif($module==9){
				$badge_arg = $badge_credit;
			}elseif($module==12){
				$badge_arg = $badge_accounts_payable;
			}else{
				$badge_arg = 0;
			}
			echo $header->header($module,$badge_arg,$display);
		  }
		  ?>

		 <?php if($logged!=0){ ?>
		 <div class="form-group navbar-form navbar-right">
			<input type="text" class="form-control" placeholder="Search" name='search' id='search' autocomplete='off'><div id='item_results'></div>
		 </div>
		 <?php } ?>
						
		  </ul>

		  
		  
		  <?php 
		  if($logged==0){
			
		  ?>
		  	<ul class='nav navbar-nav navbar-right'>
				<li><a href='login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
			</ul>
		  <?php }else{ ?>
		  	<ul class='nav navbar-nav navbar-right'>
				
				
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
	   </nav>	
<div class="container-fluid">
<ol class="breadcrumb">
	<li class="active">Sales</li>
	<li><a href="sales-items">Select Items to add to Sales</a></li>
</ol>
  <div class='row'>
  	<div class='col-md-12'>
	<?php
	if($logged==1||$logged==2){
		if($sales=='1'){
	?>
	
	<div class='col-md-2'>
	<form action='sales-form' method='post'>
	
	<?php

	
	
	// if empty cart
	$inthecartquery = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");
	if(mysql_num_rows($inthecartquery)!=0){
	?>
	<span><b>Type of Price:</b></span>
	<select id='type' class='form-control' tabindex='-1'>
		<option value='srp' 
		<?php if(isset($typeprice)&&strtolower($typeprice)=="srp"){
		echo "selected='selected'";	
		}
		?> >Suggested Retail Price</option>
		<option value='dp'
		<?php if(isset($typeprice)&&strtolower($typeprice)=="dp"){
		echo "selected='selected'";	
		}
		?>
		>Dealer Price</option>
	</select>
	<a class='btn btn-info btn-block' id='reset'><span class='glyphicon glyphicon-refresh'></span> Reset All Prices</a>
	<br>
	
	<span><b>Customer:</b></span>
	<?php
	$customername = mysql_query("SELECT DISTINCT customer,type_payment,comments,customerID,terms FROM tbl_cart WHERE accountID='$accountID' ORDER BY customer DESC");
	if(mysql_num_rows($customername)!=0){
		while($cusrow=mysql_fetch_assoc($customername)){
			$customer = $cusrow["customer"];
			$comments = $cusrow["comments"];
			$terms = $cusrow["terms"];
			$customerID = $cusrow["customerID"];
			$type_payment_db = $cusrow["type_payment"];
			if($terms==0){
				$terms=30;
			}
		}
		if($customerID!=0){
		echo "<input tabindex='-1' type='text' class='form-control search' id='searchid' name='customer' placeholder='Type for Customer Name' value='$customer' autocomplete='off' readonly>";
		}else{
		echo "<input tabindex='-1' type='text' class='form-control search' id='searchid' name='customer' placeholder='Type for Customer Name' value='$customer' autocomplete='off' required='required'>";
		}
	}else{
		echo "<input tabindex='-1' type='text' class='form-control search' id='searchid' name='customer' placeholder='Type for Customer Name' autocomplete='off' required='required'>";
	}
	?>
	<a class='btn btn-info btn-block' href='customer-add' target='_blank' tabindex='-1'><span class='glyphicon glyphicon-user'></span> Add Customer</a>
	<?php
	if($customerID!=0){
	echo "<a class='btn btn-danger btn-block' id='del_customer' tabindex='-1'><span class='glyphicon glyphicon-trash'></span> Remove Customer</a>";
	}
	?>
	<br>
	<span><b>Type of Payment:</b></span>
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
	<br>
	<label>Terms:</label>
	<input type='number' min='1' name='terms' class='form-control' id='terms' tabindex='-1' placeholder='Number of Days' value='<?php echo $terms; ?>'>
	<small><i>* For Credits Only.</i></small>
	<br>
	<br>
	<span><b>Comments:</b></span>
	<textarea name='comments' class='form-control' tabindex='-1'><?php echo $comments; ?></textarea>
	
	<br>
	<span><b>Sales Register:</b></span>
	<!--<button class='btn btn-primary btn-block' name='save'><span class='glyphicon glyphicon-floppy-disk'></span> Save</button>-->
	<button class='btn btn-primary btn-block' name='savecontinue'  tabindex='-1'><span class='glyphicon glyphicon-floppy-disk'></span> Save & Continue</button>
	<a class='btn btn-danger btn-block' name='delete' id='delall' tabindex='-1'><span class='glyphicon glyphicon-trash'></span> Cancel Sale</a>
	<br>
	<?php }
	echo "
	
	<label>Utilities:</label><a tabindex='-1' class='btn btn-info btn-block' name='delete' href='sales-re'><span class='glyphicon glyphicon-shopping-cart'></span> Sales Search</a>";


	if($orderID!=Null){
		echo "<a tabindex='-1' href='sales-complete' class='btn btn-block btn-info'>View Last Transaction</a>";
	}
	?>
	

	
	
	</div>
	<div class='col-md-10'>

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