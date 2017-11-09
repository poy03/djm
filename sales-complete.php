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
<style type="text/css">
  .order_details th, .order_details td{
  	border-color:black;border-style:solid;border-width:2pt;
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
  .item:hover{``
	  cursor:pointer;
  }
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0;

}
.dr{
	border-width: 2pt;
	border-color: black;
	border-style: solid;
	padding: 2pt;
}
@media print {
body{
	letter-spacing:7px;
	
}

.davao{
	letter-spacing:10px;

}

.update_footer{
	letter-spacing:7px;
	font-size:13px;
}


.date_delivered{
	letter-spacing:7px;	
	font-size:13px;
}
.total_text{
	font-size:16px !important;
}

	input {
    border: none;
    background: transparent;
}
	
	
	.page{
		display:inline !important;
	}
  .prints{
	  display:none;
	  }
	  .content{
		  border-color:white;
	  }



}

th, td{
	font-size: 14pt;
	padding-left: 2px;
	padding-right: 2px;
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


    <style>
  *{
  	line-height: 1;
  }
	
	.page{
		display:none;
	}
		th, td{
	}


</style>
  <script>
  $(document).ready(function(){
  	$(".date_delivered,.date_payment").datepicker();
  	$("#close_pdc").click(function(){
  		var id= $("#orderID").val();
  		var pdc_amount= $(".pdc_amount").val();
  		var pdc_date= $(".pdc_date").val();
  		var pdc_check_number= $(".pdc_check_number").val();
  		var pdc_bank= $(".pdc_bank").val();
  		// var dataStr = "id="+id+"&pdc_amount="+pdc_amount+"&pdc_date="+pdc_date+"&pdc_check_number="+pdc_check_number+"&pdc_bank="+pdc_bank;
  		var dataStr = $("#pdc-form :input").serialize()+"&id="+id;
  		// alert(dataStr);
  		if(pdc_amount!=""&&pdc_date!=""&&pdc_check_number!=""&&pdc_bank!=""){	
	  		$.ajax({
	  			type: 'POST',
	  			url: 'credits-pdc',
	  			data: dataStr,
	  			cache: false,
          beforeSend: function(data) {
            $('button').prop('disabled',true);
          },
	  			success: function(html){
			  		// $("body").html(html);
			  		location.reload();
	  			}
	  		});
  		}else{
  			$(".required").html("Required");
  		}
  	}); 

  	$(".close_cash").click(function(e){
  		var cash = $("#payment_cash").val();
  		var date_payment = $("#date_payment").val();

  		// var dataStr = "id="+e.target.id+"&cash="+cash+"&date_payment="+date_payment;
  		var dataStr = $("#payment-cash-form :input").serialize()+"&id="+e.target.id;
  		// alert(dataStr);
  		if(cash!=""&&cash!="0"){
	  		$.ajax({
	  			type: 'POST',
	  			url: 'credits-pdc',
	  			data: dataStr,
	  			cache: false,
          beforeSend: function(data) {
            $('button').prop('disabled',true);
          },
	  			success: function(html){
			  		// $("body").html(html);
			  		location.reload();
	  			}
	  		});
	  	}else{
	  		$(".required").html("Required");
	  	}
  	});
  	$(".pdc_date").datepicker();
  	$("#payment_cash").keyup(function(){
  		var amount = $(this).val();
  		var total_amount_of_sales = $("#total_amount_of_sales").val();
  		var dataStr = "amount="+amount+"&total="+total_amount_of_sales;
  		$.ajax({
  			type: 'POST',
  			url: 'credits-pdc',
  			data: dataStr,
  			cache: false,
  			success: function(html){
  				// alert(html);
	  		$("#change").html(html);
  			}
  		});
  	});

  	$(".date_delivered").change(function(e){
		  var datastr = 'id='+e.target.id+'&date_delivered='+$(this).val();
		  $.ajax({
			  type: 'POST',
			  url: 'sales-return',
			  data: datastr,
			  cache: false,
			  success: function(html){

			  }
		  });
  	});

  	$("#print").click(function(){
  		window.print();
  	});  	
  		$( "#search" ).autocomplete({
  	      source: 'search-item-all',
  		  select: function(event, ui){
  			  window.location='item?s='+ui.item.data;
  		  }
  	    });
  	$(".return").click(function(e){
		  var datastr = 'id='+e.target.title+'&return=1';
		  $.ajax({
			  type: 'POST',
			  url: 'sales-return',
			  data: datastr,
			  cache: false,
			  success: function(html){
				  location.reload();
			  }
		  });
  	});
  		$(".edit").click(function(e){
  			window.location = 'sales-edit?id='+e.target.id;
  		});
	  $(".confirm").click(function(e){
      var orderID =e.target.id;
      var comments = $("#comments").val();
      if(comments!=''){
      $(this).prop('disabled',true);
        $('button').prop('disabled',true);
			 window.location = "sales-delete?id="+orderID+"&comments="+comments;
		  }
	  });
	  
	  $("#total_amount").html($("#total").html());	  
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
	  $("#Sales").addClass("active");
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

	  $(".deposit").click(function(e){
      $('button').prop('disabled',true);
	  	$.ajax({
	  		type: "POST",
	  		data: "pdc_status=deposit&id="+e.target.id,
	  		url: "sales-pdc-status",
	  		cache: false,
	  		success: function(data){
	  			location.reload();
	  			// alert(data);
	  		}
	  	});
	  });

	  $(".returned").click(function(e){
      $('button').prop('disabled',true);
      $.ajax({
        type: "POST",
        data: "pdc_status=returned&id="+e.target.id,
        url: "sales-pdc-status",
        cache: false,
        success: function(data){
          location.reload();
          // alert(data);
        }
      });
    });
     

     $(".check-return").click(function(e){
      $('button').prop('disabled',true);
	   	$.ajax({
	   		type: "POST",
	   		data: "pdc_status=returned&id="+e.target.id,
	   		url: "sales-pdc-status",
	   		cache: false,
	   		success: function(data){
	   			location.reload();
	   			// alert(data);
	   		}
	   	});
	   });

	   $(".check-deposit").click(function(e){
      $('button').prop('disabled',true);
	   	$.ajax({
	   		type: "POST",
	   		data: "pdc_status=deposit&id="+e.target.id,
	   		url: "sales-pdc-status",
	   		cache: false,
	   		success: function(data){
	   			location.reload();
	   			// alert(data);
	   		}
	   	});
	   });
	   // check-return
	   // check-deposit



   });
	  
	  $(document).on("change keyup",".update_footer",function(e){
	  	$.ajax({
	  		type: "POST",
	  		url: "sales-complete-fillup",
	  		data: "type="+e.target.title+"&value="+e.target.value+"&id="+e.target.id,
	  		cache: false,
	  		success: function(data){

	  		}
	  	});
	  });
  </script>

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
			$order_query = mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'");
			if(mysql_num_rows($order_query)==0){
				header("location:sales");
			}
			$order_data = mysql_fetch_assoc($order_query);
			$customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='".$order_data["customerID"]."'");
			if(mysql_num_rows($customer_query)!=0){
				$customer_data = mysql_fetch_assoc($customer_query);
			}else{
				$customer_data["companyname"]=$order_data["customer"];
			}

			$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='".$order_data["salesmanID"]."'"));
			$purchase_query = mysql_query("SELECT * FROM tbl_purchases WHERE orderID='$orderID'");
			$full_format = sprintf("%09d",$order_data["ts_orderID"]);
			$format = $full_format[0].$full_format[1].$full_format[2].$full_format[3]."-".$full_format[4].$full_format[5]."-".$full_format[6].$full_format[7].$full_format[8];
			echo "
				<center class='davao' style='font-size:18pt;font-weight:bold;text-align:center'><u>".strtoupper($app_company_name)."</u></center>
				<center style='font-size:14pt;text-align:center'>$address</center>
				<center style='font-size:14pt;text-align:center'>TEL. <i class='fa fa-phone' aria-hidden='true'></i> $contact_number</center>
				<div class='dr'>
				
				
				<table style='width:100%'>
					<tr>
						<th class='update_footer' colspan='20'>DELIVERY RECEIPT<img src='$logo' style='height:50px;position:absolute;right:0;padding-right:25px'></th>
						
					</tr>

					<tr>
						<th style='' class='update_footer'>No $orderID</th>
						<th></th>
						<th class='update_footer'>TS-$format</th>
					</tr>
					<tr>
						<th></th>
						<th class='update_footer' style='text-align:right;'>Account Specialist:</th>
						<th class='update_footer'>".$salesman_data["salesman_name"]."</th>
					</tr>
					<tr>
						<th class='update_footer'>Date:</th>
						<th class='update_footer' style='width:30%;border-bottom-width:2px;border-bottom-style:solid'>".date("F d, Y",$order_data["date_ordered"])."</th>
						<th style='width:50%;' class='update_footer'></th>
					</tr>
					<tr>
						<th class='update_footer'>Customer Name</th>
						<th class='update_footer' style='border-bottom-width:2px;border-bottom-style:solid' colspan='2'>".$customer_data["companyname"]."</th>
					</tr>
					<tr>
						<th class='update_footer'>Delivery Address</th>
						<th class='update_footer' style='border-bottom-width:2px;border-bottom-style:solid' colspan='2'>".$customer_data["address"]."</th>
					</tr>
					<tr>
						<th class='update_footer' colspan='20'>TRANSACTION DETAILS</th>
					</tr>
					<tr>
						<th class='update_footer' colspan='20'>Transaction Proposed:</th>
					</tr>
				</table>
				<table style='width:98%;margin-left:auto;margin-right:auto;' class='order_details'>
					<thead>
					<tr>
						<th class='update_footer' style='border-width:0px'>Amount</th>
						<th class='update_footer total_text' style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'><span id='total_amount'></span></th>
					</tr>
					<tr>
						<th class='update_footer' style='border-width:0px'>Credit Terms</th>
						<th class='update_footer total_text' style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'>";
						if($order_data["terms"]==0){
							echo "Cash On Delivery";
						}else{
							echo $order_data["terms"];
						}
						echo "</th>
					</tr>
					<tr>
						<th class='update_footer' style='border-width:0px'>Delivery Date</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'><input type='text' class='date_delivered  total_text' id='$orderID' value='".date("m/d/Y",$order_data["date_delivered"])."' style='width:100%' readonly></th>
					</tr>
					<tr>
						<th class='update_footer' style='border-width:0px'>&nbsp;<br>Order Details</th>
					</tr>
					<tr>
						<th class='update_footer' style='text-align:center'>SKU CODE</th>
						<th class='update_footer' style='text-align:center'>SKU Description</th>
						<th class='update_footer' style='text-align:center'>Unit</th>
						<th class='update_footer' style='text-align:center'>Qty</th>
						<th class='update_footer' style='text-align:center'>Selling Price</th>
						<th class='update_footer' style='text-align:center'>Total Amount</th>
					</tr>
					</thead>
					<tbody>";
					$total= 0;
					$number_of_items = mysql_num_rows($purchase_query);					
					while($purchase_row=mysql_fetch_assoc($purchase_query)){
						$itemID = $purchase_row["itemID"];
						$quantity = $purchase_row["quantity"];
						$price = $purchase_row["price"];
						$line_total = $quantity*$price;
						$total += $line_total;
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						echo "
						<tr>
							<td class='update_footer'>".$item_data["item_code"]."</td>
							<td class='update_footer'>".$item_data["itemname"]."</td>
							<td class='update_footer' style='text-align:center'>".$item_data["unit_of_measure"]."</td>
							<td class='update_footer' style='text-align:center'>".$quantity."</td>
							<td class='update_footer' style='text-align:right'>".number_format($price,2)."</td>
							<td class='update_footer' style='text-align:right'>".number_format($line_total,2)."</td>
						</tr>
						";
					}
					while($number_of_items<8){
						echo "
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						";
						$number_of_items++;
					}					
					echo '
					</tbody>
					<tfoot>
						<tr>
							<th class="update_footer" style="text-align:right" colspan="5">TOTAL:</th>
							<th class="update_footer total_text" style="text-align:right"><span id="total">'.number_format($total,2).'</span></th>
						</tr>
						<tr>
							<th class="update_footer" colspan="20" style="border-width:0px;text-align:center">RECEIVED THE PRODUCTS / ITEMS IN GOOD CONDITION</th>
						</tr>
					</tfoot>
				</table>
				</div>
				<div class="dr" style="position:relative;top:-2pt">
				<table  style="width:98%;margin-left:auto;margin-right:auto;">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th class="update_footer" style="width:20%">Prepared By:</th>
						<th class="update_footer" style="width:20%"></th>
						<th class="update_footer" style="width:20%">Received By:</th>
					</tr>
					<tr>
						<td style="border-bottom-width:2px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" class="update_footer" id="'.$orderID.'" value="'.$order_data["prepared_by"].'" title="prepared_by" style="width:100%;text-align:center"></td>
						<td>&nbsp;</td>
						<td style="border-bottom-width:2px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" class="update_footer" id="'.$orderID.'" value="'.$order_data["received_by"].'" title="received_by" style="width:100%;text-align:center"></td>
					</tr>

					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<td class="update_footer" style="text-align:center"><small>SIGNATURE OVER PRINTED NAME</small></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th class="update_footer">Released By:</th>
						<th></th>
						<th class="update_footer">Delivered By:</th>
					</tr>
					<tr>
						<td style="border-bottom-width:2px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" class="update_footer" id="'.$orderID.'" value="'.$order_data["released_by"].'" title="released_by" style="width:100%;text-align:center"></td>
						<td>&nbsp;</td>
						<td style="border-bottom-width:2px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" class="update_footer" id="'.$orderID.'" value="'.$order_data["delivered_by"].'" title="delivered_by" style="width:100%;text-align:center"></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th class="update_footer">Approved By:</th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<td style="border-bottom-width:2px;border-bottom-color:black;border-bottom-style:solid;"><input type="text" class="update_footer" id="'.$orderID.'" value="'.$order_data["approved_by"].'" title="approved_by" style="width:100%;text-align:center"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				</table>
				</div>
			';
			($order_data["pdc_date"]!=0?$pdc_date=date("m/d/Y",$order_data["pdc_date"]):$pdc_date="");
			($order_data["pdc_amount"]!=0?$pdc_amount=number_format($order_data["pdc_amount"],2):$pdc_amount="");
			$status = "";
			echo "<div class='prints'>";
			if($accounting_period == 1){
			if($order_data["deleted"]==0){
				echo "<a href='sales-complete-ink?id=$orderID' class='btn btn-warning btn-lg'>Print in Inkjet</a>";	
				echo "<button type='button' class='btn btn-danger btn-lg' data-toggle='modal' data-target='#myModal'><span class='glyphicon glyphicon-trash'></span> Delete</button>";
				echo "<button type='button' class='btn btn-info btn-lg' id='print'><span class='glyphicon glyphicon-print'></span> Print</button>";	
				if(($order_data["balance"]!=0)){
					echo "<button class='btn btn-success btn-lg payment' id='$orderID' data-toggle='modal' data-target='#payment'><span class='glyphicon glyphicon-shopping-cart'></span> Payment</button>";
				}else{
					/*
					if($order_data["payment"]!=0){
						$status.="<h5>This Delivery Receipt is Paid with CASH, ".number_format($order_data["payment"],2)." on ".date("F d, Y",$order_data["date_payment"])."</h5>";
					}else{


						if($order_data["pdc_status"]==""){
							echo "<button class='btn btn-default btn-lg deposit' id='$orderID'><span class='glyphicon glyphicon-piggy-bank'></span> Deposited</button>";
							echo "<button class='btn btn-warning btn-lg returned' id='$orderID'><span class='glyphicon glyphicon-refresh'></span> Cheque is Returned</button>";
							$pdc_status = "";
						}else{
							$pdc_status = $order_data["pdc_status"];
						}

						$status.="<h5>This Delivery Receipt is Paid with Post-dated Cheque:</h5>
						PDC Date: <b>".$pdc_date."</b><br>
						Bank Name: <b>".$order_data["pdc_bank"]."</b><br>
						PDC Check #: <b>".$order_data["pdc_check_number"]."</b><br>
						PDC Amount: <b>".number_format($order_data["pdc_amount"],2)."</b><br>
						PDC Status: <b>".$pdc_status."</b><br>
						";
					}
					*/
				}
				
		
				if($order_data["approved"]==0){
					echo "<button class='btn btn-primary btn-lg edit' id='$orderID'><span class='glyphicon glyphicon-edit'></span> Sales Return</button>";
				}
			
				// if($order_data["received"]==0){
				// 	echo "<button type='button' class='btn btn-success btn-lg return' title='$orderID'><span class='glyphicon glyphicon-ok'></span> Return</button>";
				// }else{	
				// 	$status .= "<h5>This Delivery Receipt is returned on ".date("F d, Y",$order_data["received"]).".</h5>";
				// }			
			}else{
				$account_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$order_data["deleted_by"]."'"));
				echo "Deleted By: ".$account_data["employee_name"]."<br>";
				echo "Date Deleted: ".date("m/d/Y",$order_data["date_deleted"])."<br>";
				echo "Comments: ".$order_data["delete_comment"]."<br>";
			}
			echo "<br>";
			echo $status;
			
			$pdc_payment_query = mysql_query("SELECT * FROM tbl_payments WHERE orderID='$orderID' AND type_payment='pdc'");
			if(mysql_num_rows($pdc_payment_query)!=0){
				echo'

				<table border="1" style="width:100%">
					
					<tr>
						<th colspan="20" style="text-align:center;">Payment via Post-dated Cheque</th>
					</tr>
					<tr>
						<th style="text-align:center">AR #</th>
						<th style="text-align:center">PDC Date</th>
						<th style="text-align:center">Bank Name</th>
						<th style="text-align:center">PDC Check</th>
						<th style="text-align:center">PDC Amount</th>
						<th style="text-align:center">Cheque Status</th>
					</tr>
					';
					while($pdc_payment_row = mysql_fetch_assoc($pdc_payment_query)){
						echo '
						<tr>
							<th style="text-align:center">'.$pdc_payment_row["ar_number"].'</th>
							<th style="text-align:center">'.date("m/d/Y",$pdc_payment_row["pdc_date"]).'</th>
							<th style="text-align:center">'.$pdc_payment_row["pdc_bank"].'</th>
							<th style="text-align:center">'.$pdc_payment_row["pdc_check_number"].'</th>
							<th style="text-align: right;">'.number_format($pdc_payment_row["amount"],2).'</th>';

							if($pdc_payment_row["status"]==""){
								echo '
								<td style="text-align:center">
									<button class="check-return btn-danger" id="'.$pdc_payment_row["paymentID"].'">Cheque is Returned</button>
									<button class="check-deposit btn-success" id="'.$pdc_payment_row["paymentID"].'">Cheque is Deposited</button>
								</td>
								';
							}else{
                if($pdc_payment_row["status"][0]=="D"){
                  echo '
                    <td style="text-align:center">'.$pdc_payment_row["status"].'<br>
                    <button class="check-return btn-danger" id="'.$pdc_payment_row["paymentID"].'">Cheque is Returned</button>
                    </td>
                  ';
                }else{
                  echo '
                    <td style="text-align:center">'.$pdc_payment_row["status"].'</td>
                  ';
                }
							}

						echo '
						</tr>
						';
					}
				echo '
				</table>
				<br>
				';
			}


				$cash_payment_query = mysql_query("SELECT * FROM tbl_payments WHERE orderID='$orderID' AND type_payment='cash'");
				if(mysql_num_rows($cash_payment_query)!=0){
					echo'
					<table border="1" style="width:100%">
						<tr>
							<th colspan="20" style="text-align:center;">Payment via Cash</th>
						</tr>
						<tr>
							<th style="text-align:center">AR #</th>
							<th style="text-align:center">Date of Payment</th>
							<th style="text-align:center">Cash Amount</th>
							<th style="text-align:center">Balance</th>
							<th style="text-align:center">Change</th>
							<th style="text-align:center">Remaining Balance</th>
						</tr>
						';
						while($cash_payment_row = mysql_fetch_assoc($cash_payment_query)){
							echo '
							<tr>
								<th style="text-align:center">'.$cash_payment_row["ar_number"].'</th>
								<th style="text-align:center">'.date("m/d/Y",$cash_payment_row["date_payment"]).'</th>
								<th style="text-align:right">'.number_format($cash_payment_row["amount"],2).'</th>
								<th style="text-align:right">'.number_format($cash_payment_row["balance"],2).'</th>
								<th style="text-align:right">'.number_format($cash_payment_row["excess"],2).'</th>
								<th style="text-align:right">'.number_format(abs($cash_payment_row["amount"]-$cash_payment_row["balance"]-$cash_payment_row["excess"]),2).'</th>
								';

							echo '
							</tr>
							';
						}
					echo '
					</table>
					';

			echo "<br>";
			echo "<br>";
			echo "<br>";
			}		
			}
			echo "<b>Due Date:</b> ".date("m/d/Y",$order_data["date_due"])."<br>";
			$date1=date_create(date("m/d/Y",$order_data["date_due"]));
			$date2=date_create(date("m/d/Y"));
			$diff=date_diff($date1,$date2);
			$aging = $diff->format("%R%a");
			if((int)$aging>0){
				echo "<b>Aging</b>: ".$aging." days";
			}
			echo "</div>";
			echo "<input type='hidden' value='$orderID' id='orderID'>";
?>


</form>
<div class = "modal fade" id = "payment" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">

   <div class = "modal-dialog">
      <div class = "modal-content">
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Select Payment
            </h4>
         </div>
         
         <div class = "modal-body">
         <div class = "btn-group">
         	<button class='btn btn-success' data-toggle='modal' data-target='#cash_payment'><span class='glyphicon-usd glyphicon'></span> Cash Payment</button>
         	<button class='btn btn-primary' data-toggle='modal' data-target='#pdc_payment'><span class='glyphicon-usd glyphicon'></span> Post-dated Cheque</button>
         </div>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->

<div class = "modal fade" id = "pdc_payment" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         <form action='#' method='post' class='form-horizontal' id="pdc-form">
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Post-dated Cheque
            </h4>
         </div>
         
         <div class = "modal-body">
         <?php
         echo "
         <label>Total: ₱".number_format($order_data["balance"],2)."</label><br>
         <label>PDC Date: <span style='color:red' class='required'></span></label><input type='text' name='pdc_date' class='pdc_date form-control' title='$orderID' placeholder='PDC Date' readonly>
         <label>Bank Name: <span style='color:red' class='required'></span></label><input type='text' name='pdc_bank' class='pdc_bank form-control' id='$orderID' placeholder='PDC Check'>
         <label>PDC Check Number: <span style='color:red' class='required'></span></label><input type='text' name='pdc_check_number' class='pdc_check_number form-control' id='$orderID' placeholder='PDC Check'>
         <label>PDC Amount: <span style='color:red' class='required'></span></label><input type='number' min='0' step='0.01' name='pdc_amount' class='pdc_amount form-control' id='$orderID' placeholder='PDC Amount'>
         <label>Date of Payment:</span></label><input type='text' name='date_payment' class='date_payment form-control' id='$orderID' value='".date("m/d/Y")."' placeholder='Date of Payment' readonly>
         <label>AR Number:</label><input type='text' name='ar_number' class='ar_number form-control' id='$orderID' placeholder='AR Number'>
         ";

         ?>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
            
            <button type = "button" class = "btn btn-danger" id="close_pdc">
               Confirm
            </button>
         </div>
         </form>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->



<div class = "modal fade" id = "cash_payment" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               CASH Payment
            </h4>
         </div>
         
         <div class = "modal-body">
         <form action='cash' method='post' class='form-horizontal' id="payment-cash-form">
         	<label>Total: ₱<span><?php echo number_format($order_data["balance"],2); ?></span><input type="hidden" id="total_amount_of_sales" value="<?php echo $order_data["balance"]; ?>"></label><br>
         	<label>Amount: <span style='color:red' class='required'></span></label>
         	<input type='number' min='0' class='form-control' step="0.01" id="payment_cash" name="cash" placeholder="Amount"><br>
         	<label>AR Number:</label><input type='text' name='ar_number' class='ar_number form-control' id='$orderID' placeholder='AR Number'>
         	<label>Date Payment: <span style='color:red' class='required'></span></label>
         	<input type='text' class='date_payment form-control' id="date_payment" name="date_payment" value="<?php echo date("m/d/Y"); ?>" readonly><br>
         	<label>Change: &nbsp;&nbsp;</label><span id='change'>₱<?php echo number_format($order_data["payment_change"],2); ?></span>
         </form>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
            
            <button type = "button" class = "btn btn-danger close_cash" id="<?php echo $orderID; ?>">
               Confirm
            </button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->



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
            
            <button type = "button" class = "btn btn-danger confirm" id='<?php echo $orderID; ?>' type='submit'>
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