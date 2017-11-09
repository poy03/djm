<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$d=@$_GET['d'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Collection Remittances</title>
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
  <script type="text/javascript" src="js/shortcut.js"></script>  <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="css/balloon.css">
  

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

		echo "<center><h3>Collection Remittances on<br>".date("F d, Y - ",strtotime($_GET["f"])).date("F d, Y",strtotime($_GET["t"]))."</h3></center><br>";
		echo '
		<div class="table-reponsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th style="text-align:center">Deposited PDC</th>
						<th style="text-align:center">Undeposited PDC</th>
						<th style="text-align:center">Paid With Cash</th>
						<th style="text-align:center">Total Collection Remittances</th>
						<th style="text-align:center">Total Amount</th>
						<th style="text-align:center">Total Balances</th>
					</tr>
				</thead>
				</tbody>';
				$date_from = strtotime($_GET["f"]);
				$date_to = strtotime($_GET["t"]);
				$total_deposited_data = mysql_fetch_assoc(mysql_query("SELECT SUM(tbl_payments.amount) as amount FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' AND tbl_payments.type_payment='pdc' AND tbl_payments.status!=''"));
				$excess_deposited_data = mysql_fetch_assoc(mysql_query("SELECT SUM(excess) as amount FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' AND tbl_payments.type_payment='pdc' AND tbl_payments.status!=''"));
				$total_undeposited_data = mysql_fetch_assoc(mysql_query("SELECT SUM(tbl_payments.amount) as amount FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' AND tbl_payments.type_payment='pdc' AND tbl_payments.status=''"));
				$excess_undeposited_data = mysql_fetch_assoc(mysql_query("SELECT SUM(excess) as amount FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' AND tbl_payments.type_payment='pdc' AND tbl_payments.status=''"));
				$total_cash_data = mysql_fetch_assoc(mysql_query("SELECT SUM(tbl_payments.amount) as amount FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' AND tbl_payments.type_payment='cash'"));
				$excess_cash_data = mysql_fetch_assoc(mysql_query("SELECT SUM(excess) as amount FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' AND tbl_payments.type_payment='cash'"));


				$balance_query = mysql_query("SELECT DISTINCT tbl_orders.orderID,tbl_orders.balance FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' ORDER BY tbl_orders.date_due");

				$total_balance = 0;
				$total_sales = 0;
				if(mysql_num_rows($balance_query)!=0){
					while ($balance_row = mysql_fetch_assoc($balance_query)) {
						$total_balance += $balance_row['balance'];
						$sales_data = mysql_fetch_assoc(mysql_query("SELECT SUM(quantity*price) as total FROM tbl_purchases WHERE orderID='".$balance_row['orderID']."'"));
						$total_sales += $sales_data['total'];
					}
				}
				echo '
				<tr>
					<th>TOTAL</th>
					<td style="text-align:center;">'.number_format($total_deposited_data["amount"],2).'</td>
					<td style="text-align:center;">'.number_format($total_undeposited_data["amount"],2).'</td>
					<td style="text-align:center;">'.number_format($total_cash_data["amount"],2).'</td>
					<td style="text-align:center;">'.number_format($total_undeposited_data['amount']+$total_deposited_data['amount']+$total_cash_data["amount"],2).'</td>
					<td style="text-align:center;">'.number_format($total_sales,2).'</td>
					<td style="text-align:center;">'.number_format($total_balance,2).'</td>
				</tr>
				';
				// echo '
				// <tr>
				// 	<td>Excess</td>
				// 	<td style="text-align:right;">'.number_format($excess_deposited_data["amount"],2).'</td>
				// 	<td style="text-align:right;">'.number_format($excess_undeposited_data["amount"],2).'</td>
				// 	<td style="text-align:right;">'.number_format($excess_cash_data["amount"],2).'</td>
				// 	<td style="text-align:right;">'.number_format($excess_undeposited_data['amount']+$excess_deposited_data['amount']+$excess_cash_data["amount"],2).'</td>
				// </tr>
				// ';

				// echo '
				// <tr>
				// 	<td>Excess</td>
				// 	<td style="text-align:right;"></td>
				// 	<td style="text-align:right;"></td>
				// 	<td style="text-align:right;">'.number_format($excess_cash_data["amount"],2).'</td>
				// 	<td style="text-align:right;">'.number_format($excess_cash_data["amount"],2).'</td>
				// </tr>
				// ';
				echo '
				</tbody>
			</table>
		</div>
		<div class="table-reponsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Due Date</th>
						<th>Customer</th>
						<th>DR No.</th>
						<th>Amount</th>
						<th>AR No.</th>
						<th>Cash</th>
						<th>Check Date</th>
						<th>Bank</th>
						<th>Check Number</th>
						<th>Deposited</th>
						<th>Undeposited</th>
						<th>Total</th>
						<th>Balance</th>
					</tr>
				</thead>
				<tbody>
					';
								$payments = mysql_query("SELECT tbl_payments.*,tbl_orders.date_due FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_orders.date_due BETWEEN '$date_from' AND '$date_to' AND tbl_payments.not_valid='0' ORDER BY tbl_orders.date_due");
								while ($payment_row = mysql_fetch_assoc($payments)) {

									$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='".$payment_row['orderID']."'"));
									$order_total = mysql_fetch_assoc(mysql_query("SELECT SUM(quantity*price) as total FROM tbl_orders WHERE orderID='".$payment_row['orderID']."'"));
									$cash_data = mysql_fetch_assoc(mysql_query("SELECT amount FROM tbl_payments WHERE type_payment='cash' AND paymentID='".$payment_row['paymentID']."'"));
									$deposited_data = mysql_fetch_assoc(mysql_query("SELECT amount FROM tbl_payments WHERE type_payment='pdc' AND not_valid='0' AND status!='' AND paymentID='".$payment_row['paymentID']."'"));
									$undeposited_data = mysql_fetch_assoc(mysql_query("SELECT amount FROM tbl_payments WHERE type_payment='pdc' AND not_valid='0' AND status='' AND paymentID='".$payment_row['paymentID']."'"));
									echo '
									<tr>
										<td>'.date('m/d/Y',$payment_row['date_due']).'</td>
										<td>'.$order_data['customer'].'</td>
										<td><a href="sales-complete.php?id='.$payment_row['orderID'].'">'.$payment_row['orderID'].'</a></td>
										<td style="text-align:right">'.number_format($order_data['total'],2).'</td>
										<td>'.$payment_row['ar_number'].'</td>
										<td style="text-align:right">'.number_format($cash_data['amount'],2).'</td>
										<td>'.($payment_row['pdc_date']!=0?date('m/d/Y',$payment_row['pdc_date']):"").'</td>
										<td>'.$payment_row['pdc_bank'].'</td>
										<td>'.$payment_row['pdc_check_number'].'</td>
										<td style="text-align:right">'.number_format($deposited_data['amount'],2).'</td>
										<td style="text-align:right">'.number_format($undeposited_data['amount'],2).'</td>
										<td style="text-align:right">'.number_format($cash_data['amount']+$deposited_data['amount']+$undeposited_data['amount'],2).'</td>
										<td style="text-align:right">'.number_format($order_data['balance'],2).'</td>
									</tr>
									';
								}
								echo'
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3">TOTAL:</th>
						<th></th>
						<th></th>
						<th style="text-align:right;">'.number_format($total_cash_data["amount"],2).'</th>
						<th colspan="3"></th>
						<th style="text-align:right;">'.number_format($total_deposited_data["amount"],2).'</th>
						<th style="text-align:right;">'.number_format($total_undeposited_data["amount"],2).'</th>
						<th style="text-align:right;">'.number_format($total_undeposited_data['amount']+$total_deposited_data['amount']+$total_cash_data["amount"],2).'</th>
					</tr>
				</tfoot>
			</table>
		</div>
		';

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