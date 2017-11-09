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



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Purchases</title>
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
  <link rel="stylesheet" type="text/css" href="alertify-css/alertify.css">
  <link rel="stylesheet" type="text/css" href="alertify-css/themes/default.min.css">
  <script src="jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/balloon.css">
<link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>  <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script src="alertify.min.js"></script>
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
  </style>
  <script>
  $(document).ready(function(){
  	$("#print").click(function(){
  		window.print();
  	}); 

  	$(".confirm").click(function(e){
  		var comments = $("#comments").val();
  		var dataStr = "delete="+e.target.id+"&comments="+comments;
  		if(comments!=""){
        $(this).prop('disabled',true);
  			$.ajax({
  				type: "POST",
  				url: "receiving-delete",
  				data: dataStr,
  				cache: false,
  				success: function(html){
  					location.reload();
  				}
  			});
  		}
  	}); 
	
  	$("#total_amount").html($("#total").html());
  	$("#Purchases").addClass("active");		
  	$(".confirm_payment").click(function(e){
  		var amount = $("#amount").val();
  		var date_payment = $("#date_payment").val();
  		var check_number = $("#check_number").val();
  		if(amount<=0){
  			$(".required").html("Required");
  		}
  		var dataStr = "amount="+amount+"&id="+e.target.id+"&check_number="+check_number+"&date_payment="+date_payment+"&payment=purchases";
  		// alert(dataStr);
  		$.ajax({
  			type: "POST",
  			url: "receiving-payment",
  			data: dataStr,
  			cache: false,
        beforeSend: function(data) {
          $('button').prop('disabled',true);
        },
  			success: function(html){
  				location.reload();
  			}
  		});

  	});


  	$(".confirm_freight_payment").click(function(e){
  		var amount = $("#freight_amount").val();
  		var date_payment = $("#freight_date_payment").val();
  		var check_number = $("#freight_check_number").val();
  		if(amount<=0){
  			$(".required").html("Required");
  		}
  		var dataStr = "amount="+amount+"&id="+e.target.id+"&check_number="+check_number+"&date_payment="+date_payment+"&payment=freight";
  		// alert(dataStr);
  		$.ajax({
  			type: "POST",
  			url: "receiving-payment",
  			data: dataStr,
  			cache: false,
        beforeSend: function() {
          $('.confirm_freight_payment').prop('disabled',true);
        },
        success: function(html){
          // console.log(html);
          // alert(html);
          
          location.reload();
          // $('.confirm_freight_payment').prop('disabled',true);
  			}
  		});

  	});  

    $('#clear-payment').click(function(e) {
      if(confirm('Are you sure you want to clear this payment?')){
        $.ajax({
          type: 'POST',
          url: 'receiving-clear-payment',
          data: "type=payment&id=<?php echo $orderID; ?>",
          cache: false,
          success: function() {
            location.reload();
          }
        });
      }
    });

    $('#clear-freight').click(function(e) {
      if(confirm('Are you sure you want to clear this freight payment?')){
        $.ajax({
          type: 'POST',
          url: 'receiving-clear-payment',
          data: "type=freight&id=<?php echo $orderID; ?>",
          cache: false,
          success: function() {
            location.reload();
          }
        });
      }
    });
    $('#refresh_page').hide();
    $('#edit_purchases_form').submit(function(e) {
      e.preventDefault();
      if(confirm('Please note this is NOT reversible, continue?')){
        $.ajax({
          type: "POST",
          url: "receiving-complete-edit",
          data: $('#edit_purchases_form').serialize(),
          cache: false,
          dataType: 'json',
          beforeSend: function() {
            $('button[form="edit_purchases_form"]').prop('disabled',true);
          },
          success: function(data) {
            var has_failed = false;
            var has_success = false;
            $.each(data.failed, function( index, value ) {
              alertify.error("Not enough quantity to return the item <b>"+value.itemname + "</b>. ",0);
              has_failed = true;
            });

            $.each(data.success, function( index, value ) {
              alertify.success("The item <b>"+value.itemname + "</b> has been returned.",0);
              has_success = true;
            });

            if(has_failed==false&&has_success==false){

            }else{
              $('button[form="edit_purchases_form"]').hide();
              $('#refresh_page').show();
            }
          },
          complete: function(data) {
              $('button[form="edit_purchases_form"]').prop('disabled',false);
            // body...
          }

        });
      }
    });




  	$("#date_payment,#freight_date_payment").datepicker();
   });
	  
  </script>
    <style>
  
	
	.page{
		display:none;
	}
		th, td{
	}
@media print{
	input {
    border: none;
    background: transparent;
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
		if($receiving=='1'||$reports=='1'){
			$order_query = mysql_query("SELECT * FROM tbl_orders_receiving WHERE orderID='$orderID'");
			if(mysql_num_rows($order_query)==0){
				// header("location:sales");
			}
			$order_data = mysql_fetch_assoc($order_query);
			$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='".$order_data["supplierID"]."'"));
			$purchase_query = mysql_query("SELECT * FROM tbl_receiving WHERE orderID='$orderID'");

			echo "
				<center style='font-size:12pt;font-weight:bold;text-align:center'><u>$app_company_name</u></center>
				<center style='font-size:6pt;text-align:center'>$address</center>
				<center style='font-size:6pt;text-align:center'>TEL. <i class='fa fa-phone' aria-hidden='true'></i> $contact_number</center>
				<div class='dr'>
				
				
				<table style='width:100%' style=''>
					<tr>
						<th colspan='20'>PURCHASES<img src='$logo' style='height:50px;position:absolute;right:0;padding-right:25px'></th>
						
					</tr>

					<tr>
						<th style=''>No $orderID</th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>Date:</th>
						<th style='width:30%;border-bottom-width:1pt;border-bottom-style:solid'>".date("F d, Y",$order_data["date_received"])."</th>
						<th style='width:50%;'></th>
					</tr>
					<tr>
						<th>Supplier's Name</th>
						<th style='border-bottom-width:1pt;border-bottom-style:solid' colspan='2'>".$supplier_data["supplier_name"]."</th>
					</tr>
					<tr>
						<th>Delivery Address</th>
						<th style='border-bottom-width:1pt;border-bottom-style:solid' colspan='2'>".$supplier_data["supplier_address"]."</th>
					</tr>
					<tr>
						<th colspan='20'>TRANSACTION DETAILS</th>
					</tr>
					<tr>
						<th colspan='20'>Transaction Proposed:</th>
					</tr>
				</table>
				<table style='width:98%;margin-left:auto;margin-right:auto;' class='order_details'>
					<thead>
					<tr>
						<th style='border-width:0px'>Amount</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'><span id='total_amount'></span></th>
					</tr>
					<tr>
						<th style='border-width:0px'>Credit Terms</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'>".$order_data["terms"]."</th>
					</tr>
					<tr>
						<th style='border-width:0px'>Invoice Number</th>
						<th style='border-right-width:0px;border-top-width:0px;border-left-width:0px;'>".$order_data["invoice_number"]."</th>
					</tr>
					<tr>
						<th style='border-width:0px'>&nbsp;<br>Purchase Details</th>
					</tr>
					<tr>
						<th style='text-align:center'>SKU CODE</th>
						<th style='text-align:center'>SKU Description</th>
						<th style='text-align:center'>Unit</th>
						<th style='text-align:center'>Qty</th>
						<th style='text-align:center'>Cost Price</th>
						<th style='text-align:center'>Total Amount</th>
					</tr>
					</thead>
					<tbody>";
					$total= 0;
					$number_of_items = mysql_num_rows($purchase_query);					
					while($purchase_row=mysql_fetch_assoc($purchase_query)){
						$itemID = $purchase_row["itemID"];
						$quantity = $purchase_row["quantity"];
						$price = $purchase_row["costprice"];
						$line_total = $quantity*$price;
						$total += $line_total;
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						echo "
						<tr>
							<td>".$item_data["item_code"]."</td>
							<td>".$item_data["itemname"]."</td>
							<td style='text-align:center'>".$item_data["unit_of_measure"]."</td>
							<td style='text-align:center'>".$quantity."</td>
							<td style='text-align:right'>".number_format($price,2)."</td>
							<td style='text-align:right'>".number_format($line_total,2)."</td>
						</tr>
						";
					}
					while($number_of_items<20){
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
					echo "
					</tbody>
					<tfoot>
						<tr>
							<th style='text-align:right' colspan='5'>Sub Total:</th>
							<th style='text-align:right'><span>".number_format($total,2)."</span></th>
						</tr>
						<tr>
							<th style='text-align:right' colspan='5'>FREIGHT CHARGES:</th>
							<th style='text-align:right'><span>".number_format($order_data["freight"],2)."</span></th>
						</tr>
						<tr>
							<th style='text-align:right' colspan='5'>TOTAL PURCHASES:</th>
							<th style='text-align:right'><span id='total'>".number_format($total+$order_data["freight"],2)."</span></th>
						</tr>
						<tr>
							<th colspan='20' style='border-width:0px;text-align:center'>RECEIVED THE PRODUCTS / ITEMS IN GOOD CONDITION</th>
						</tr>
					</tfoot>
				</table>
				</div>
				<!--
				<div class='dr' style='position:relative;top:-2pt'>
				<table  style='width:98%;margin-left:auto;margin-right:auto;'>
				<thead>
					<tr>
						<th style='width:20%'>Prepared By:</th>
						<th style='width:20%'></th>
						<th style='width:20%'>Received By:</th>
					</tr>
					<tr>
						<td style='border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;'>&nbsp;</td>
						<td>&nbsp;</td>
						<td style='border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;'>&nbsp;</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<td style='text-align:center'><small>SIGNATURE OVER PRINTED NAME</small></td>
					</tr>
					<tr>
						<th>Released By:</th>
						<th></th>
						<th>Delivered By:</th>
					</tr>
					<tr>
						<td style='border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;'>&nbsp;</td>
						<td>&nbsp;</td>
						<td style='border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;'>&nbsp;</td>
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
						<td style='border-bottom-width:1px;border-bottom-color:black;border-bottom-style:solid;'>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>

				</thead>
				</table>
				</div>
				-->
			";

			$status = "";
			echo "<div class='prints'>";
		if($accounting_period == 1){
			if($order_data["deleted"]==0){
				echo "<button type='button' class='btn btn-danger btn-lg' data-toggle='modal' data-target='#myModal'><span class='glyphicon glyphicon-trash'></span> Delete</button>";
				echo "<button type='button' class='btn btn-info btn-lg' id='print'><span class='glyphicon glyphicon-print'></span> Print</button>";
				if($order_data["payment"]==0){
					echo "<button type='button' class='btn btn-success btn-lg' id='payment' data-toggle='modal' data-target='#payment_modal'><span class='glyphicon glyphicon-shopping-cart'></span> Purchases Payment</button>";	
				}else{
          echo "<button type='button' class='btn btn-warning btn-lg' id='clear-payment'><span class='glyphicon glyphicon-shopping-cart'></span> Clear Payment</button>"; 
					$status .= "<h5>This Transaction is paid with ".number_format($order_data["payment"],2)." on ".date("m/d/Y",$order_data["date_payment"])."</h5>";
				}

				if($order_data["freight_payment"]==0&&$order_data["freight"]!=0){
					echo "<button type='button' class='btn btn-success btn-lg' id='payment' data-toggle='modal' data-target='#freight_payment_modal'><span class='glyphicon glyphicon-shopping-cart'></span> Freight Payment</button>";	
				}elseif($order_data["freight"]==0){

        }else{
          echo "<button type='button' class='btn btn-warning btn-lg' id='clear-freight'><span class='glyphicon glyphicon-shopping-cart'></span> Clear Freight Payment</button>"; 
					$status .= "<h5>The Freight of Transaction this Transaction is paid with ".number_format($order_data["freight_payment"],2)." on ".date("m/d/Y",$order_data["freight_payment_date"])."</h5>";
				}

        if($order_data["payment"]==0){
          if($order_data["freight_needs_payment"]==1&&$order_data["freight_payment"]==0){
            echo "<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#edit_purchases_modal'><span class='glyphicon glyphicon-shopping-cart'></span> Return Items</button>"; 
          }elseif ($order_data["freight_needs_payment"]==1&&$order_data["freight_payment"]!=0) {
            # code...
          }else{
            echo "<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#edit_purchases_modal'><span class='glyphicon glyphicon-shopping-cart'></span> Return Items</button>"; 
          }
        }
 
			}else{
				$account_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$order_data["deleted_by"]."'"));
				echo "Deleted By: ".$account_data["employee_name"]."<br>";
				echo "Date Deleted: ".date("m/d/Y",$order_data["date_deleted"])."<br>";
				echo "Comments: ".$order_data["deleted_comments"]."<br>";
			}
			if($order_data["date_due"]<=strtotime($date)){
				$status.="<h5 class='bg-danger'>The Due Date of this transaction is on ".date("m/d/Y",$order_data["date_due"])."</h5>";
			}else{
				$status.="<h5>The Due Date of this transaction is on ".date("m/d/Y",$order_data["date_due"])."</h5>";
			}
			echo "<br>";
			echo $status;
			echo "</div>";
			echo "<input type='hidden' value='$orderID' id='orderID'>";
?>


</form>

<div class = "modal fade" id = "payment_modal" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         <form action='#' method='get'>
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Payment
            </h4>
         </div>
         
         <div class = "modal-body">
         	<label>Total: <?php echo number_format($total,2); ?></label><br>
         	<label>Date:<span class="required"></span></label>
         	<input type='text' id='date_payment' class='form-control' value="<?php echo date("m/d/Y"); ?>" readonly>
         	<label>Amount:<span class="required"></span></label>
         	<input type='number' id='amount' min='0' class='form-control' value="<?php echo $total ?>" readonly>
         	<label>Referrence Number:<span class="required"></span></label>
         	<input type='text' id='check_number' class='form-control'>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
            
            <button type = "button" class = "btn btn-danger confirm_payment" id="<?php echo $orderID; ?>" type='submit'>
               Confirm
            </button>
         </div>
         </form>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->


<div class = "modal fade" id = "edit_purchases_modal" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Return Items
            </h4>
         </div>
         
         <div class = "modal-body">
         </form>
          <form id="edit_purchases_form">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style='text-align:center'>SKU CODE</th>
                <th style='text-align:center'>SKU Description</th>
                <th style='text-align:center'>Unit</th>
                <th style='text-align:center'>Qty</th>
                <th style='text-align:center'>Return Qty</th>
                <th style='text-align:center'>Cost Price</th>
              </tr>
            </thead>
            <tbody>
          <?php
          $purchase_query = mysql_query("SELECT * FROM tbl_receiving WHERE orderID='$orderID'");
          $number_of_items = mysql_num_rows($purchase_query);
          while($purchase_row=mysql_fetch_assoc($purchase_query)){
            $itemID = $purchase_row["itemID"];
            $id = $purchase_row["receiveID"];
            $quantity = $purchase_row["quantity"];
            $price = $purchase_row["costprice"];
            $line_total = $quantity*$price;
            $total += $line_total;
            $item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
            echo "
            <tr>
              <td>".$item_data["item_code"]."
              <input type='hidden' value='".$id."' name='receiveID[]'>
              <input type='hidden' value='".$orderID."' name='orderID'>
              </td>
              <td>".$item_data["itemname"]."<input type='hidden' value='".$itemID."' name='itemID[]'></td>
              <td style='text-align:center'>".$item_data["unit_of_measure"]."</td>
              <td style='text-align:center'>$quantity</td>
              <td style='text-align:center'><input type='number' min='0' max='$quantity' name='return_quantity[]' value='0'</td>
              <td style='text-align:right'>".number_format($price,2)."</td>
            </tr>
            ";
          }

          ?>
          </tbody>
          </table>
          </form>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
            
            <button type = "submit" class = "btn btn-danger" form="edit_purchases_form">
               Confirm
            </button>

            <a href="" class = "btn btn-danger" id="refresh_page">
               Refresh Page
            </a>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->




<div class = "modal fade" id = "freight_payment_modal" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         <form action='#' method='get'>
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               Payment
            </h4>
         </div>
         
         <div class = "modal-body">
         	<label>Total: <?php echo number_format($order_data["freight"],2); ?></label><br>
         	<label>Date:<span class="required"></span></label>
         	<input type='text' id='freight_date_payment' class='form-control' value="<?php echo date("m/d/Y"); ?>" readonly>
         	<label>Amount:<span class="required"></span></label>
         	<input type='number' id='freight_amount' min='0' class='form-control' value="<?php echo $order_data["freight"]; ?>" readonly>
         	<label>Referrence Number:<span class="required"></span></label>
         	<input type='text' id='freight_check_number' class='form-control'>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Cancel
            </button>
            
            <button type = "button" class = "btn btn-danger confirm_freight_payment" id="<?php echo $orderID; ?>" type='submit'>
               Confirm
            </button>
         </div>
         </form>
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

		
	}
	}else{
			echo "<strong><center>You do not have the authority to access this module.</center></strong>";
	}
	}else{
		header("location:index");
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