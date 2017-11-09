<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$orderID=@$_GET['id'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
$by=@$_GET['by'];
$order=@$_GET['order'];
error_reporting(0);

include 'db.php';
echo "<input type='hidden' id='ts_orderID' value='$orderID'>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Sales Receipt</title>
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
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>
  <style>
  .order_details th, .order_details td{
  	border-color:black;border-style:solid;border-width:1pt;
  }
  *{
	  padding:0px;
  }
  .table-row-pox{
	v-align:center;
	height:38px;
	overflow:hidden;
    text-overflow: ellipsis;
	}
  .item:hover{
	  cursor:pointer;
  }
  input {
    text-align:right;
}input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0;

}

input[type=number] {
    -moz-appearance:textfield;
}
.dr{
	border-width: 2pt;
	border-color: black;
	border-style: solid;
	padding: 2pt;
}
  </style>
  <script>
  $(document).ready(function(){
  	$("#print").click(function(){
  		window.print();
  	});  	
  	$("#Sales").addClass("active");
	  $("#confirm").click(function(){
		  var orderID = $("#ts_orderID").val();
		  var comments = $("#comments").val();
		  if(comments!=''){
			 window.location = "sales-ts-delete?id="+orderID+"&comments="+comments;
		  }	
	  });
	  
	  $("#delivery_date").datepicker({
		  dateFormat: "MM dd, yy"
	});
	  $(".payment").change(function(e){
		  var orderID = $("#orderID").val()
		  var datastr = 'id='+orderID+'&value='+e.target.value+'&type_payment='+e.target.id;
		  $.ajax({
			  type: 'POST',
			  url: 'sales-payments',
			  data: datastr,
			  cache: false,
			  success: function(html){
				  $(".final").html(html);
			  }
		  });
		  return false;
	  });
	  $("#total_amount").html($("#total").html());
	  $(".comments").change(function(e){
		  
		  var orderID = $("#orderID").val()
		  var datastr = 'id='+orderID+'&comments='+e.target.value+'&type_payment='+e.target.id+'&type=1';
		  $.ajax({
			  type: 'POST',
			  url: 'sales-payments-comments',
			  data: datastr,
			  cache: false,
			  success: function(html){
				  $(".final").html(html);
			  }
		  });
		return false;
	  });

	   $(".update_db").on("change focusout",function(e){
		  var orderID = $("#ts_orderID").val();
	   	  var datastr = 'id='+orderID+'&type='+e.target.id+'&value='+e.target.value;
	   	  // alert(datastr);
	   	  $.ajax({
	   		  type: 'POST',
	   		  url: 'sales-ts-complete-fillup',
	   		  data: datastr,
	   		  cache: false,
	   		  success: function(html){
	   			  // alert(html);
	   		  }
	   	  });
	   });
	   $(".update_db_amount").on("change",function(e){
	   	// alert("asdasd");
		  var orderID = $("#ts_orderID").val();
	   	  var datastr = 'id='+orderID+'&type='+e.target.id+'&value='+e.target.value+'&amount=1';
	   	  // alert(datastr);
	   	  $.ajax({
	   		  type: 'POST',
	   		  url: 'sales-ts-complete-fillup',
	   		  data: datastr,
	   		  cache: false,
	   		  dataType: "json",
	   		  success: function(data){
	   		  	// alert(html);
		   		  $("#credit_line").val(data.credit_line);
	   			  $("#outstanding_bal").val(data.outstanding_bal);
	   			  $("#available_bal").val(data.available_bal);
	   			  $("#additional_case").val(data.additional_case);
	   			  $("#overhang").val(data.overhang);
	   			  // $("body").html(data.query);
	   		  }
	   	  });
	   });
   });
	  


  </script>	
    <style>
    .tbl_header{
    	border-top: 1px solid black;
    	border-bottom: 1px solid black;
    	background-color:gray !important;
    	color:black;
    }
	.page{
		display:none;
	}
		th, td{
	}

textarea{
	resize: vertical;
}

@media print{
	body {
	  -webkit-print-color-adjust: exact;
	}
	input {
    border: none;
    background: transparent;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
	textarea,textarea::-webkit-outer-spin-button  {
		border: none;
		background-color: transparent;
		resize: none;
		outline: none;
	}
	
	.page{
		display:inline !important;
	}
.col-md-12{
	padding-left:1.5em !important;
	padding-right:1.5em !important;
	padding-top:1em !important;
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

    body, table {
		
		font-family: Arial, Helvetica, sans-serif;
    }
	*{
		 margin:0;
		 padding:0;
	}
	.editable{
		display:none !important;
	}
	.final{
		display:initial !important;
	}
}
th, td{
	font-size: 8pt;
	padding: 1pt;
}

	.editable{
		display:initial;
	}
	.final{
		display:none;
	}
table {
    border-collapse: collapse;
}
border-color: transparent;
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
		if($sales=='1'||$reports=='1'){
			$order_query = mysql_query("SELECT * FROM tbl_ts_orders WHERE ts_orderID='$orderID'");
			if(mysql_num_rows($order_query)==0){
				header("location:success");
			}
			$order_data = mysql_fetch_assoc($order_query);
			$customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='".$order_data["customerID"]."'");
			if(mysql_num_rows($customer_query)!=0){
				$customer_data = mysql_fetch_assoc($customer_query);
			}else{
				$customer_data["companyname"]=$order_data["customer"];
			}
			$purchase_query = mysql_query("SELECT * FROM tbl_ts_items WHERE ts_orderID='$orderID'");
			echo "
				<center style='font-size:12pt;font-weight:bold;text-align:center'><u>$app_company_name</u></center>
				<center style='font-size:6pt;text-align:center'>$address</center>
				<center style='font-size:6pt;text-align:center'>TEL. <i class='fa fa-phone' aria-hidden='true'></i> $contact_number</center>
				<div class='dr'>
				<table style='width:100%' style=''>
					<tr>
						<th colspan='20'>TRANSACTION SHEET<img src='$logo' style='height:50px;position:absolute;right:0;padding-right:25px'></th>
					</tr>
					<tr>
						<th style=''>No ".$orderID[0].$orderID[1].$orderID[2].$orderID[3]."-".$orderID[4].$orderID[5]."-".$orderID[6].$orderID[7].$orderID[8]."</th>
						<th colspan='20' style='text-align:center;'></th>
					</tr>
					<tr>
						<th>Date:</th>
						<th style='width:30%;border-bottom-width:1pt;border-bottom-style:solid'>".date("F d, Y",$order_data["date"])."</th>
						<th style='width:50%;'></th>
					</tr>
					<tr>
						<th>Customer Name</th>
						<th style='border-bottom-width:1pt;border-bottom-style:solid' colspan='2'>".$customer_data["companyname"]."</th>
					</tr>
					<tr>
						<th>Delivery Address</th>
						<th style='border-bottom-width:1pt;border-bottom-style:solid' colspan='2'>".$customer_data["address"]."</th>
					</tr>
					<tr>
						<th colspan='20'></th>
					</tr>
					<tr>
						<th colspan='20' class='tbl_header'>TRANSACTION DETAILS</th>
					</tr>
					<tr>
						<th>Transaction Proposed:</th>
						<th style='text-align:right'>__ Excess in CL</th>
						<th style='text-align:center'>__ Case-to-case</th>
					</tr>
				</table>


				<table style='width:98%;margin-left:auto;margin-right:auto;' class='order_details'>
					<thead>
					<tr>
						<th style='border-width:0px'>Amount</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'>Php <span id='total_amount'></span></th>
					</tr>
					<tr>
						<th style='border-width:0px'>Credit Terms</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'>";
						if($order_data["terms"]==0){
							echo "Cash on Delivery";
						}else{
							echo $order_data["terms"]." Days";
						}
						echo "</th>
					</tr>
					<tr>
						<th style='border-width:0px'>Delivery Date</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'><input type='text' style='width:100%;text-align:left;' id='delivery_date' class='update_db' value='".$order_data["delivery_date"]."' readonly></th>
					</tr>
					<tr>
						<th style='border-width:0px'>&nbsp;<br>Order Details</th>
					</tr>
					<tr>
						<th style='text-align:center'>SKU CODE</th>
						<th style='text-align:center'>SKU Description</th>
						<th style='text-align:center'>Unit</th>
						<th style='text-align:center'>Qty</th>
						<th style='text-align:center'>Unit Price</th>
						<th style='text-align:center'>Cost Price</th>
						<th style='text-align:center'>Total Cost</th>
						<th style='text-align:center'>Total Sales</th>
					</tr>
					</thead>
					<tbody>";
					$total= 0;
					$total_cost = 0;
					$total_sales = 0;
					$number_of_items = mysql_num_rows($purchase_query);
					while($purchase_row=mysql_fetch_assoc($purchase_query)){
						$itemID = $purchase_row["itemID"];
						$quantity = $purchase_row["quantity"];
						$price = $purchase_row["price"];
						$costprice = $purchase_row["costprice"];
						$costprice = $costprice / $quantity;
						$line_total = $quantity*$price;
						$total += $line_total;
						$total_cost += $costprice*$quantity;
						$total_sales += $price*$quantity;
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						echo "
						<tr>
							<td>".$item_data["item_code"]."</td>
							<td>".$item_data["itemname"]."</td>
							<td style='text-align:center'>".$item_data["unit_of_measure"]."</td>
							<td style='text-align:center'>".$quantity."</td>
							<td style='text-align:right'>".number_format($price,2)."</td>
							<td style='text-align:right'>".number_format($costprice,2)."</td>
							<td style='text-align:right'>".number_format($costprice*$quantity,2)."</td>
							<td style='text-align:right'>".number_format($price*$quantity,2)."</td>
						</tr>
						";
					}

					while($number_of_items<10){
						echo "
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						";
						$number_of_items++;
					}
					$unknown_field = ($total_sales-$total_cost-$order_data["discount"])/($total_sales);
					echo "
					</tbody>
					<tfoot>
						<tr>
							<th style='text-align:right' colspan='6'></th>
							<th style='text-align:right'><span>".number_format($total_cost,2)."</span></th>
							<th style='text-align:right'><span id='total'>".number_format($total_sales,2)."</span></th>
						</tr>
						<tr>
							<th style='text-align:right' colspan='7'>Discount/ Incentives:</th>
							<th style='text-align:right'><span>".number_format($order_data["discount"],2)."</span></th>
						</tr>
						<tr>
							<th style='text-align:right' colspan='7'></th>
							<th style='text-align:right'><span>".number_format($unknown_field,2)."</span></th>
						</tr>
						<tr>
							<th colspan='20' style='border-width:0px;text-align:center'>&nbsp;</th>
						</tr>
					</tfoot>
				</table>

				<table style='width:100%' style=''>";
				echo "

				<tr>
					<td>";

					//previous DR
					$prev_dr = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='".$order_data["old_dr"]."' AND date_payment='0'"));
					// echo $prev_dr["date_due"];
					// echo "<br>";
					// echo strtotime(date("m/d/Y"));
					// echo "<br>";

					// $date1=date_create(date("m/d/Y",$prev_dr["date_due"]));
					// $date2=date_create(date("m/d/Y"));
					// $diff=date_diff($date1,$date2);
					// echo $diff->format("%a days");
					// echo "<br>";
					// echo "<br>";
					($order_data["status_current"]==1?$satisfactory_stat="x":$satisfactory_stat="&nbsp;");
					($order_data["status_with_overdue"]==1?$with_overdue_stat="x":$with_overdue_stat="&nbsp;");
					($order_data["status_with_excess"]==1?$with_excess_stat="x":$with_excess_stat="&nbsp;");
					($order_data["status_with_returned_check"]==1?$with_history_stat="x":$with_history_stat="&nbsp;");
					$with_delayed_stat = "&nbsp;";
					$outstanding_bal = 0;
					/*
					if($order_data["old_dr"]==0){

					}elseif(strtotime(date("m/d/Y"))<=$prev_dr["date_due"]){
					$prev_dr["total"] = $order_data["outstanding_bal"];

						$prev_dr_returned_pdc = mysql_num_rows(mysql_query("SELECT * FROM tbl_payments WHERE type_payment='pdc' AND pdc_returned='1' AND orderID='".$order_data["old_dr"]."'"));


						if($prev_dr_returned_pdc!=0){
							$with_history_stat = "x";
							$with_history_amount = number_format($prev_dr["total"],2);
							$outstanding_bal = $prev_dr["total"];
							$with_history_dr = $prev_dr["orderID"];
							$with_history_del = $prev_dr["date_delivered"];
							$with_history_due = date("m/d/Y",$prev_dr["date_due"]);
							if($prev_dr["pdc_date"]!=0){
								$pdc_date = date("m/d/Y",$prev_dr["pdc_date"]);
							}
							$with_history_check = $prev_dr["pdc_bank"]." ".$prev_dr["pdc_check_number"]." ".$pdc_date;
						}elseif(0>$order_data["overhang"]){
							// echo "excess";
							$with_excess_stat = "x";
							$with_excess_amount = number_format($prev_dr["total"],2);
							$outstanding_bal = $prev_dr["total"];
							$with_excess_dr = $prev_dr["orderID"];
							$with_excess_del = $prev_dr["date_delivered"];
							$with_excess_due = date("m/d/Y",$prev_dr["date_due"]);
							if($prev_dr["pdc_date"]!=0){
								$pdc_date = date("m/d/Y",$prev_dr["pdc_date"]);
							}
							$with_excess_check = $prev_dr["pdc_bank"]." ".$prev_dr["pdc_check_number"]." ".$pdc_date;
						}else{
							$satisfactory_stat = "x";
							$satisfactory_amount = number_format($prev_dr["total"],2);
							$outstanding_bal = $prev_dr["total"];
							$satisfactory_dr = $prev_dr["orderID"];
							$satisfactory_del = $prev_dr["date_delivered"];
							$satisfactory_due = date("m/d/Y",$prev_dr["date_due"]);
							if($prev_dr["pdc_date"]!=0){
								$pdc_date = date("m/d/Y",$prev_dr["pdc_date"]);
							}
							$satisfactory_check = $prev_dr["pdc_bank"]." ".$prev_dr["pdc_check_number"]." ".$pdc_date;
						}
					}elseif (strtotime(date("m/d/Y"))>=$prev_dr["date_due"]&&strtotime(date("m/d/Y"))<=$prev_dr["overdue_date_1"]) {
						$with_overdue_stat = "x";
						$with_overdue_1_amount = number_format($prev_dr["total"],2);
						$outstanding_bal = $prev_dr["total"];
						$with_overdue_1_dr = $prev_dr["orderID"];
						$with_overdue_1_del = $prev_dr["date_delivered"];
						$with_overdue_1_due = date("m/d/Y",$prev_dr["date_due"]);
						if($prev_dr["pdc_date"]!=0){
							$pdc_date = date("m/d/Y",$prev_dr["pdc_date"]);
						}
							$with_overdue_1_check = $prev_dr["pdc_bank"]." ".$prev_dr["pdc_check_number"]." ".$pdc_date;
					}elseif (strtotime(date("m/d/Y"))>$prev_dr["overdue_date_1"]&&strtotime(date("m/d/Y"))<=$prev_dr["overdue_date_2"]) {
						$with_overdue_stat = "x";
						$with_overdue_2_amount = number_format($prev_dr["total"],2);
						$outstanding_bal = $prev_dr["total"];
						$with_overdue_2_dr = $prev_dr["orderID"];
						$with_overdue_2_del = $prev_dr["date_delivered"];
						$with_overdue_2_due = date("m/d/Y",$prev_dr["date_due"]);
						if($prev_dr["pdc_date"]!=0){
							$pdc_date = date("m/d/Y",$prev_dr["pdc_date"]);
						}
							$with_overdue_2_check = $prev_dr["pdc_bank"]." ".$prev_dr["pdc_check_number"]." ".$pdc_date;
					}else{
						$with_overdue_stat = "x";
						$with_overdue_3_amount = number_format($prev_dr["total"],2);
						$outstanding_bal = $prev_dr["total"];
						$with_overdue_3_dr = $prev_dr["orderID"];
						$with_overdue_3_del = $prev_dr["date_delivered"];
						$with_overdue_3_due = date("m/d/Y",$prev_dr["date_due"]);
						if($prev_dr["pdc_date"]!=0){
							$pdc_date = date("m/d/Y",$prev_dr["pdc_date"]);
						}
							$with_overdue_3_check = $prev_dr["pdc_bank"]." ".$prev_dr["pdc_check_number"]." ".$pdc_date;
					}
					*/
					echo "</td>
				</tr>

				";


				echo "
					<tr>
						<th colspan='20' class='tbl_header'>CREDIT LINE UTILIZATION</th>
					</tr>
					<tr>
						<td>
							<table style='width:98%;margin-left:auto;margin-right:auto;' class='order_details'>
								<tr>
									<td style='width:50%'>Credit Line</td>
									<td style='width:50%'><input type='text' style='width:100%;text-align:right' id='credit_line' class='update_db_amount' value='".number_format($order_data["credit_line"],2)."' readonly></td>
								</tr>
								<tr>
									<td>Outstanding Balance (As of Date)</td>
									<td><input type='text' style='width:100%;text-align:right' id='outstanding_bal' class='update_db_amount' value='".number_format($order_data["outstanding_bal"],2)."' readonly></td>
								</tr>
								<tr>
									<td>Available Balance/(Excess)</td>
									<td><input type='text' style='width:100%;text-align:right' id='available_bal' class='update_db_amount' value='".number_format($order_data["available_bal"],2)."' readonly></td>
								</tr>
								<tr>
									<td>This Transaction/Additional Case-to-case credit</td>
									<td><input type='text' style='width:100%;text-align:right' id='additional_case' class='update_db_amount' value='".number_format($order_data["additional_case"],2)."' readonly></td>
								</tr>
								<tr>
									<td>Overhang/(Excess) After This Transaction</td>
									<td><input type='text' style='width:100%;text-align:right' id='overhang' class='update_db_amount' value='".number_format($order_data["overhang"],2)."' readonly></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th colspan='20' class='tbl_header'>CREDIT STANDING STATUS</th>
					</tr>
					<tr>";



					($order_data["amount_current"]==0?$satisfactory_amount = "":$satisfactory_amount = number_format($order_data["amount_current"],2));
					($order_data["overdue_one"]==0?$with_overdue_1_amount = "":$with_overdue_1_amount = number_format($order_data["overdue_one"],2));
					($order_data["overdue_two"]==0?$with_overdue_2_amount = "":$with_overdue_2_amount = number_format($order_data["overdue_two"],2));
					($order_data["overdue_three"]==0?$with_overdue_3_amount = "":$with_overdue_3_amount = number_format($order_data["overdue_three"],2));
					($order_data["amount_excess"]==0?$with_excess_amount = "":$with_excess_amount = number_format($order_data["amount_excess"],2));
					($order_data["amount_history"]==0?$with_history_amount = "":$with_history_amount = number_format($order_data["amount_history"],2));


					echo "
						<td>
							<table style='width:98%;margin-left:auto;margin-right:auto;'>
								<tr>
									<td style='width:40%'></td>
									<td style='width:30%;text-align:center'>Amount</td>
									<!--<td style='width:10%;text-align:center'>DR #</td>
									<td style='width:10%;text-align:center'>DEL Date</td>
									<td style='width:10%;text-align:center'>DUE Date</td>
									<td style='width:30%;text-align:center'>CHECK DETAILS</td>-->
								</tr>
								<tr>
									<td><span style='border-bottom: 1px solid black;padding-right:3px;padding-left:3px'>".$satisfactory_stat."</span> Current/Satisfactory repayment</td>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$satisfactory_amount."</th>
									<!--<th style='border-bottom: 1px black solid;text-align:center;'>".$satisfactory_dr."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$satisfactory_del."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$satisfactory_due."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$satisfactory_check."</th>-->
								</tr>
								<tr>
									<td><span style='border-bottom: 1px solid black;padding-right:3px;padding-left:3px'>".$with_overdue_stat."</span> With overdue account</td>

								</tr>
								<tr>
									<th><span style='margin-left:40px'>Aging</span></th>
									<th></th>
								</tr>
									<td><span style='margin-left:15px'>1-30 days overdue</span></td>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_1_amount."</th>
									<!--<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_1_dr."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_1_del."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_1_due."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_1_check."</th>-->
								<tr>
								</tr>
									<td><span style='margin-left:15px'>31-60 days overdue</span></td>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_2_amount."</th>
									<!--<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_2_dr."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_2_del."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_2_due."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_2_check."</th>-->
								<tr>
								</tr>
									<td><span style='margin-left:15px'>over 61 days overdue</span></td>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_3_amount."</th>
									<!--<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_3_dr."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_3_del."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_3_due."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_overdue_3_check."</th>-->
								<tr>
								<tr>
									<td><span style='border-bottom: 1px solid black;padding-right:3px;padding-left:3px'>".$with_excess_stat."</span> Current but IN EXCESS OF APRROVED CL</td>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_excess_amount."</th>
									<!--<th style='border-bottom: 1px black solid;text-align:center;'>".$with_excess_dr."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_excess_del."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_excess_due."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_excess_check."</th>-->
								</tr>
								<tr>
									<td><span style='border-bottom: 1px solid black;padding-right:3px;padding-left:3px'>".$with_history_stat."</span> Current but with history of returned checks</td>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_history_amount."</th>
									<!--<th style='border-bottom: 1px black solid;text-align:center;'>".$with_history_dr."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_history_del."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_history_due."</th>
									<th style='border-bottom: 1px black solid;text-align:center;'>".$with_history_check."</th>-->
								</tr>

							</table>
						</td>
					</tr>
					<tr>
						<th colspan='20'>&nbsp;</th>
					</tr>
					<tr>
						<th colspan='20' class='tbl_header'>JUSTIFICATION</th>
					</tr>
				</table>";


				echo '
				<table style="width:100%" border="1">
					<tr>
						<th style="width:50%">
							<textarea style="width:100%;height:100%" rows="5" id="justification_one" class="update_db">'.$order_data["justification_one"].'</textarea>
						</th>
						<th style="width:50%">
							<textarea style="width:100%;height:100%" rows="5" id="justification_two" class="update_db">'.$order_data["justification_two"].'</textarea>
						</th>
					</tr>
				</table>

				<table style="width:100%" class="dr">
					<tr>
						<th colspan="20" class="tbl_header">ACTION TAKEN</th>
					</tr>
				</table>
				</div>

				<div class="dr" style="position:relative;top:-2pt">

				<table  style="width:98%;margin-left:auto;margin-right:auto;">
				<thead>
					<tr>
						<th style="width:40%">Prepared By:</th>
						<th style="width:20%"></th>
						<th style="width:40%">Verified/Received By:</th>
					</tr>
					<tr>
						<th style="border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" style="width:100%;text-align:center" id="account_specialist" class="update_db" value="'.$order_data["account_specialist"].'"></th>
						<th>&nbsp;</th>
						<th style="border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" style="width:100%;text-align:center" id="credit_and_collection" class="update_db" value="'.$order_data["credit_and_collection"].'"></th>
					</tr>
					<tr>
						<td style="text-align:center"><small>Account Specialist</small></td>
						<th>&nbsp;</th>
						<td style="text-align:center"><small>Credit & Collection</small></td>
					</tr>

					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th>Approved By:</th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th style="border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" style="width:100%;text-align:center" id="sales_manager" class="update_db" value="'.$order_data["sales_manager"].'"</th>
						<th>&nbsp;</th>
						<th style="border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" style="width:100%;text-align:center" id="president" class="update_db" value="'.$order_data["president"].'"</th>
					</tr>
					<tr>
						<td style="text-align:center"><small>Sales Manager</small>&nbsp;</td>
						<th>&nbsp;</th>
						<td style="text-align:center"><small>President</small>&nbsp;</td>
					</tr>

				</thead>
				</table>
				</div>';

				if(isset($_POST["submit"])){
					echo "asdajsdjk";
				}
				?>
				<div class='prints'>
					<!-- Trigger the modal with a button -->
					<?php
					if($accounting_period == 1){
						if($order_data["deleted"]!=0){
							$deleted_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$order_data["deleted"]."'"));
							$status = "<h5>This Transaction Sheet is deleted by: ".$deleted_data["employee_name"].", ".date("F d, Y",$order_data["date_deleted"]).".</h5>";
						}
						if($order_data["processed"]!=0){
							$dr_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE ts_orderID='$orderID'"));
							$deleted_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$dr_data["accountID"]."'"));
							$status = "<h5><a href='sales-complete?id=".$dr_data["orderID"]."'>This Transaction Sheet has Delivery Date Number: ".$dr_data["orderID"].", issued by: ".$deleted_data["employee_name"].", ".date("F d, Y",$dr_data["date_ordered"]).".</a></h5>";
						}
						if($order_data["deleted"]==0&&$order_data["processed"]==0){
							echo "<button type='button' class='btn btn-danger btn-lg' data-toggle='modal' data-target='#myModal'><span class='glyphicon glyphicon-trash'></span> Delete</button>";
						}
						echo "<button type='button' class='btn btn-info btn-lg' id='print'><span class='glyphicon glyphicon-print'></span> Print</button><br>";
						echo $status;
					}
					?>

				</div>

		<!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         <form action='#' method='get'>
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Delete this Transaction Sheet?
            </h4>
         </div>
         
         <div class = "modal-body">
         	<textarea class='form-control' placeholder='Reason for Deleting?' id='comments'></textarea>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
            
            <button type = "button" class = "btn btn-danger" id='confirm' type='submit'>
               Confirm
            </button>
         </div>
         </form>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->
	


			<?php
		}else{
				echo "<strong><center>You do not have the authority to access this module.</center></strong>";
		}
	}

	 ?>
	</div>
	
  </div>
</div>
</body>
</html>

<?php mysql_close($connect);
?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>