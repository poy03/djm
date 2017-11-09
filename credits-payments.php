<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$selected=@$_SESSION['selectcredit'];
$tab=@$_GET['tab'];
$id=@$_GET['id'];
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
  <title><?php echo $app_name; ?> - Credits</title>
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
  <style>
  .item:hover{
	  cursor:pointer;
  }
  .popover{
    width:100%;   
}
  </style>
  <script>
		$(document).ready(function(){
			$("#Credits").addClass("active");

	$( "#customer" ).autocomplete({
      source: 'search-customer-auto',
	  select: function(event, ui){
		  window.location='credits?tab=2&id='+ui.item.data;
	  }
    });
	
	$("#date_now").datepicker();
	$("#date_now").change(function(){
		var date_now = $(this).val();
		window.location = 'credits?d='+date_now;
	});
	
		 $('.selected').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
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
  <div class='row'>
	<form action='credits-form' method='post'>

	<div class='col-md-12 prints'>
	<?php
	if($logged==1||$logged==2){
		if($credits=='1'){
		?>
		<div class='col-md-2'>
		<label>Controls:</label>
		<button class='btn btn-block btn-primary' type='submit' name='save'>Acknowledgement<br>Receipt</button>
		</div>
		<div class='col-md-10'>
		<div class='table-responsive'>
		<table class='table table-hover'>
		<thead>
			<tr>
				<th>Sale #</th>
				<th>Date</th>
				<th>Time</th>
				<th>Customer</th>
				<th>Invoice #</th>
				<th>Date Due</th>
				<th style='text-align:right'>Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$total_amount = 0;
		if(isset($selected)||(!isset($_GET['id']))){
			if($selected==NULL){
				header("location:credits");
			}
		foreach($selected as $orderID){
			$order_query = mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID' AND deleted='0'");
			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$date_ordered = $order_row["date_ordered"];
					$time_ordered = $order_row["time_ordered"];
					$customer = $order_row["customer"];
					$customerID = $order_row["customerID"];
					$comments = $order_row["comments"];
					$credit_query = mysql_query("SELECT * FROM tbl_payments WHERE type_payment LIKE '%credit%' AND orderID='$orderID' AND deleted='0'");
					while($credit_row=mysql_fetch_assoc($credit_query)){
						$date_due = date("m/d/Y",$credit_row["date_due"]);
						$payment = $credit_row["payment"];
						$paymentID = $credit_row["paymentID"];
						$invoice = $credit_row["comments"];
						$total_amount+=$payment;
					}
					$customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'");
					while($customer_row=mysql_fetch_assoc($customer_query)){
						$companyname = $customer_row["companyname"];
					}
					echo "
					<input type='hidden' name='paymentID[]' value='$paymentID'>
					<tr>
							<td>S".sprintf("%06d",$orderID)."</td>
							<td>$date_ordered</td>
							<td>$time_ordered</td>
							<td>$companyname</td>
							<td>$invoice</td>
							<td>$date_due</td>
							<td style='text-align:right'>₱".number_format($payment,2)."</td>
						</tr>";
				}
			}
		}
		
		?>
		</tbody>
			<tr>
				<th colspan='6' style='text-align:right'>Total:</th>
				<th style='text-align:right'>₱<?php echo number_format($total_amount,2); ?></th>
				<?php echo "<input type='hidden' name='amount' value='$total_amount'>";?>
				<?php echo "<input type='hidden' name='customerID' value='$customerID'>";?>
			</tr>
		<tfoot>
		</tfoot>
		</table>
		</div>
		<div class='form-group'>
			<label class='col-md-2'>Payment Type:</label>
			<div class='col-md-5'>
				<select class='form-control' name='type_payment'>
				<?php
					$type_payment_array = explode(",",$type_payment);
					foreach($type_payment_array as $type_payment_each){
						if(!preg_match("/\bcredit\b/i",$type_payment_each)){
						echo "
							<option value='$type_payment_each'>$type_payment_each</option>
						";
						}
					}
				?>
				</select>
			</div>
		</div>
		<br>
		<br>
		<div class='form-group'>
			<label class='col-md-2 control-label'>Amount:</label>
			<div class='col-md-5'>
				<input type='number' min='<?php echo $total_amount;?>' name='payment' class='form-control' required='required' value='<?php echo $total_amount;?>'>
			</div>
		</div>
		<br>
		<br>
		<div class='form-group'>
			<label class='col-md-2 control-label'>Comments:</label>
			<div class='col-md-5'>
				<textarea class='form-control' name='comments' placeholder='Reference Number, Bank Number, Bank Name Check Number, Invoice Number'></textarea>
			</div>
		</div>				

		
		
		</div>
		
		<?php
		
		}elseif(isset($_GET['id'])){
			$id = $_GET['id'];
			echo "<input type='hidden' name='soaID' value='$id'>";
			$soa_query = mysql_query("SELECT * FROM tbl_soa WHERE soaID='$id' AND paid='0'");
				if(mysql_num_rows($soa_query)!=0){
					$selected = array();
					while($soa_row=mysql_fetch_assoc($soa_query)){
						$selected = explode(",",$soa_row['orderID']);
						// var_dump($paymentID_array);

					}
					// var_dump($selected);
			foreach($selected as $orderID){
			$order_query = mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID' AND deleted='0'");
			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$date_ordered = $order_row["date_ordered"];
					$time_ordered = $order_row["time_ordered"];
					$customer = $order_row["customer"];
					$customerID = $order_row["customerID"];
					$comments = $order_row["comments"];
					$credit_query = mysql_query("SELECT * FROM tbl_payments WHERE orderID='$orderID' AND deleted='0'");
					while($credit_row=mysql_fetch_assoc($credit_query)){
						$date_due = date("m/d/Y",$credit_row["date_due"]);
						$payment = $credit_row["payment"];
						$paymentID = $credit_row["paymentID"];
						$invoice = $credit_row["comments"];
						$total_amount+=$payment;
					}
					// echo "$customerID";
					$customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'");
					while($customer_row=mysql_fetch_assoc($customer_query)){
						$companyname = $customer_row["companyname"];
					}
					echo "
					<input type='hidden' name='paymentID[]' value='$paymentID'>


					<tr>
							<td>S".sprintf("%06d",$orderID)."</td>
							<td>$date_ordered</td>
							<td>$time_ordered</td>
							<td>$companyname</td>
							<td>$invoice</td>
							<td>$date_due</td>
							<td style='text-align:right'>₱".number_format($payment,2)."</td>
						</tr>";
				}
			}
		}
		
		?>
		</tbody>
			<tr>
				<th colspan='6' style='text-align:right'>Total:</th>
				<th style='text-align:right'>₱<?php echo number_format($total_amount,2); ?></th>
				<?php echo "<input type='hidden' name='amount' value='$total_amount'>";?>
				<?php echo "<input type='hidden' name='customerID' value='$customerID'>";?>
			</tr>
		<tfoot>
		</tfoot>
		</table>
		</div>
		<div class='form-group'>
			<label class='col-md-2'>Payment Type:</label>
			<div class='col-md-5'>
				<select class='form-control' name='type_payment'>
				<?php
					$type_payment_array = explode(",",$type_payment);
					foreach($type_payment_array as $type_payment_each){
						if(!preg_match("/\bcredit\b/i",$type_payment_each)){
						echo "
							<option value='$type_payment_each'>$type_payment_each</option>
						";
						}
					}
				?>
				</select>
			</div>
		</div>
		<br>
		<br>
		<div class='form-group'>
			<label class='col-md-2 control-label'>Amount:</label>
			<div class='col-md-5'>
				<input type='number' min='<?php echo $total_amount;?>' name='payment' class='form-control' required='required' value='<?php echo $total_amount;?>'>
			</div>
		</div>
		<br>
		<br>
		<div class='form-group'>
			<label class='col-md-2 control-label'>Comments:</label>
			<div class='col-md-5'>
				<textarea class='form-control' name='comments' placeholder='Reference Number, Bank Number, Bank Name Check Number, Invoice Number'></textarea>
			</div>
		</div>				

		
		
		</div>
		
		<?php
				}
		}
		}else{
			echo "<strong><center>You do not have the authority to access this module.</center></strong>";
		}
	} ?>
	</div>
	</form>
  </div>
</div>
</body>
</html>
<?php mysql_close($connect);?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>