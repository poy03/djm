<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];


$page=@$_GET['page'];


$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
$by=@$_GET['by'];
$order=@$_GET['order'];


/*
2731
2717
2626
2622
2706
2665
2619
2457
2419
2406
2355
2557
2383
2252
2319
2322
2311

*/
include 'db.php';


$editID=@$_GET['id'];
$edit_query = mysql_query("SELECT * FROM tbl_sales_edit WHERE editID='$editID'");
if(mysql_num_rows($edit_query)==0){
	header("location:success");
}

$edit_data = mysql_fetch_assoc($edit_query);
if($edit_data["approved"]==1||$edit_data["deleted"]==1){
	header("location:success");
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


	  $("#save").click(function(e) {
	  	$.ajax({
	  		type: "POST",
	  		url: $("#edit-form").attr("action"),
	  		data: 'save=1',
	  		cache: false,
	  		beforeSend: function() {
	  			$('#save').prop('disabled',true);
	  		},
	  		success: function(data) {
	  			window.location = "sales-complete?id="+ <?php echo $edit_data["orderID"]; ?>;
	  		},
	  		complete: function() {
	  			$('#save').prop('disabled',true);
	  		}
	  	});
	  });
	  $("#delete").click(function(e) {
	  	$.ajax({
	  		type: "POST",
	  		url: $("#edit-form").attr("action"),
	  		data: 'delete=1',
	  		cache: false,
	  		beforeSend: function() {
	  			$('#delete').prop('disabled',true);
	  		},
	  		success: function(data) {
	  			window.location = "sales-complete?id="+ <?php echo $edit_data["orderID"]; ?>;
	  		},
	  		complete: function() {
	  			$('#delete').prop('disabled',true);
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
		if($type=='admin'){
			$orderID = $edit_data["orderID"];
			$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
			$user_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$edit_data["accountID"]."'"));
			$edit_items_query = mysql_query("SELECT * FROM tbl_sales_edit_items WHERE editID='$editID'");

			if(isset($_POST["save"])){
				$success = 0;
				$total_returned = 0;
				while ($edit_items_row = mysql_fetch_assoc($edit_items_query)) {
					$itemID = $edit_items_row["itemID"];
					$returned = $edit_items_row["new_quantity"];
					$edit_purchase_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_purchases WHERE orderID='$orderID' AND itemID='$itemID'"));
					$new_quantity = $edit_purchase_data["quantity"]-$returned;
					$purchaseID = $edit_purchase_data["purchaseID"];
					$price = $edit_purchase_data["price"];
					$total_returned += ($returned*$price);
						// echo "<br>";
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						$new_stocks = $item_data["quantity"]+$returned;
						$new_sub_total = $price*$new_quantity;
						mysql_query("UPDATE tbl_items SET quantity='$new_stocks' WHERE itemID='$itemID'");
						mysql_query("UPDATE tbl_purchases SET quantity='$new_quantity', subtotal='$new_sub_total' WHERE itemID='$itemID' AND purchaseID='$purchaseID'");
						// echo "<br>";

					$success = 1;
				}
				$balance = (($order_data["balance"]-$total_returned)<=0?0:$order_data["balance"]-$total_returned);
				$balance = round($balance,2);
				$has_payment = (mysql_num_rows(mysql_query("SELECT * FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0'"))==0?0:1);
				$fully_paid = ($balance==0&&$has_payment==1?1:0);
				mysql_query("UPDATE tbl_sales_edit SET date_approved = '".strtotime($date)."' , approved='1' , approved_by='$accountID' WHERE editID='$editID'");
				mysql_query("UPDATE tbl_sales_edit_items SET date_approved = '".strtotime($date)."', approved_by='$accountID' WHERE editID='$editID'");
				mysql_query("UPDATE tbl_orders SET approved='0', balance='$balance',fully_paid='$fully_paid'  WHERE orderID='$orderID'"); //if edit is approved then update dr to make it available for edit.
				echo "
				<div class = 'alert alert-success alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>Successfuly Saved. Redirecting in 5 seconds</strong>
				</div>
				";
				// header( "Refresh:3; url=sales-complete?id=".$orderID, true, 303);
				// exit;

			}
			if(isset($_POST["delete"])){
				mysql_query("UPDATE tbl_sales_edit SET deleted='1', deleted_by = '$accountID', date_deleted = '".strtotime($date)."' WHERE editID='$editID'");
				echo "
				<div class = 'alert alert-success alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>Request is deleted.</strong>
				</div>
				";
				//header( "Refresh:3; url=success".$orderID, true, 303);
				mysql_query("UPDATE tbl_orders SET approved='0' WHERE orderID='$orderID'");//if edit is disapproved then update dr to make it available for edit.
				// exit;
			}

			echo "
			<form action='sales-edit-confirm?id=$editID' method='post' id='edit-form'>
			<div class='col-md-2'>";
			if($accounting_period==1){
				echo "
				<button class='btn btn-primary btn-block' id='save' type='button'><span class='glyphicon glyphicon-floppy-disk'></span> Approve</button>
				<button class='btn btn-danger btn-block' id='delete' type='button'><span class='glyphicon glyphicon-trash'></span> Delete Request</button>
				";
			}
			echo "</div>
			<div class='col-md-10'>
				<div class='table-responsive'>
				DR # : <a href='sales-complete?id=$orderID'>$orderID</a><br>
				Comments: ".$edit_data["comments"]." <br>
				Edit By: ".$user_data["employee_name"]."<br>
				Customer: ".$order_data["customer"]." <br>
				<table class='table-hover table'>
					<thead>
						<tr>
							<th>Itemname</th>
							<th>Quantity</th>
							<th>Qty of Returned</th>
						</tr>
					</thead>
					<tbody>";
					$edit_items_query = mysql_query("SELECT * FROM tbl_sales_edit_items WHERE editID='$editID'");
					while ($edit_items_row=mysql_fetch_assoc($edit_items_query)) {
						$itemID = $edit_items_row["itemID"];
						$new_quantity = $edit_items_row["new_quantity"];//new quantity is the quanitity of returned items :)
						$purchase_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_purchases WHERE itemID = '$itemID' AND orderID='$orderID'"));
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						echo "
							<tr>
								<td><a href='item?s=$itemID'>".$item_data["itemname"]."</a></td>
								<td>".$purchase_data["quantity"]."</td>
								<td>".$new_quantity."</td>
							</tr>
						";
					}
					echo "
					</tbody>
				</table>
				</div>
			</div>
			</form>
			";
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

