<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$id=@$_GET['id'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];
$total = 0;


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
  <script src="jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/balloon.css">
<link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>  <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>

  <style>
  .item:hover{
	  cursor:pointer;
  }
  
  </style>
  <script>
	$(document).ready(function(){
	$( "#itemsearch" ).autocomplete({
      source: 'search-item-all',
	  select: function(event, ui){
		  window.location='receiving-add?id='+ui.item.data;
	  }
    });		


 	$( "#itemsearch_cat" ).autocomplete({
      source: 'search-item-category-all',
	  select: function(event, ui){
		  window.location='receiving-add?id='+ui.item.data;
	  }
    });
    
	$("#Purchases").addClass("active");

		$("#remove_supplier").click(function(){
		var dataString = 'supplierID=0';
		  $.ajax({
				type: 'POST',
				url: 'receiving-cart',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
		  });
		});

		$(".quantity").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&value='+e.target.value;
			// alert(dataString);
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// alert(html);
					$("#total_of_"+e.target.id).html(html);
					var dataString = 'total=receiving'; 
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

		$("#freight").on("blur", function(e){
			var dataString = '&freight='+e.target.value;
			// alert(dataString);
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// alert(html);
					$("#total_of_"+e.target.id).html(html);
					var dataString = 'total=receiving'; 
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

		$(".costprice").on("blur", function(e){
			var dataString = 'id='+ e.target.id + '&costprice='+e.target.value;
			// alert(dataString);
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					// alert(html);
					$("#total_of_"+e.target.id).html(html);
						var dataString = 'total=receiving'; 
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



		$("#terms").on("blur", function(e){
			var dataString = 'terms='+ e.target.value;
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
			});
		});

		$("#reset").on("click", function(e){
			var dataString = 'reset=1';
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
			});
		});

		$("#supplier").on("blur", function(e){
			var dataString = 'supplier='+ e.target.value;
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
			});
		});

		$("#date").datepicker();
		$("#date").on("blur", function(e){
			var dataString = 'date='+ e.target.value;
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
			});
		});

		$("#invoice_number").on("blur", function(e){
			var dataString = 'invoice_number='+ e.target.value;
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
			});
		});

		$("#type").on("change", function(e){
			var dataString = 'type='+ e.target.value;
			$.ajax({
				type: 'POST',
				url: 'receiving-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
			});
		});

			$("#mode").change(function(){
				var mode = $(this).val();
				window.location='receiving-add?mode='+mode;
			});
			
	 $(".delete").click(function(e){
		  if(conf = confirm("Are you sure you want to delete selected item?")){
		  	var dataString = 'delete_item=1&id='+ e.target.id;
		  	$.ajax({
		  		type: 'POST',
		  		url: 'receiving-cart-add',
		  		data: dataString,
		  		cache: false,
		  		success: function(html){
		  			location.reload();
		  		}
		  	});
		  }		  
	  });
			
	  $("#delete_all").click(function(e){
	 	  if(conf = confirm("Are you sure you want to delete all item?")){
	 	  	var dataString = 'delall=1';
	 	  	$.ajax({
	 	  		type: 'POST',
	 	  		url: 'receiving-cart-add',
	 	  		data: dataString,
	 	  		cache: false,
	 	  		success: function(html){
	 	  			location.reload();
	 	  		}
	 	  	});
	 	  }		  
	   });
	 					

	
	$( "#Purchases" ).autocomplete({
      source: 'search-item-all',
	  select: function(event, ui){
		  window.location='receiving-add?id='+ui.item.data;
	  }
    });
	
	$( "#suppliers" ).autocomplete({
      source: 'search-supplier',
	  select: function(event, ui){
		  //window.location='receiving-add?id='+ui.item.data;
		  
		var dataString = 'supplierID='+ ui.item.data;
		  $.ajax({
				type: 'POST',
				url: 'receiving-cart',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
		  });
	  }
    });
	
	$("#comments").on("blur", function(e){
		var dataString = 'comments='+ e.target.value;
		  $.ajax({
				type: 'POST',
				url: 'receiving-cart',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
		  });
	});


	$("#receiving-form").submit(function(e){
		e.preventDefault();
		$("#receiving-submit").attr("disabled","disabled");
		$.ajax({
			type: "POST",
			url: $("#receiving-form").attr("action"),
			data: $("#receiving-form").serialize()+"&save=1",
			cache: false,
			dataType: "json",
			success: function(data){
				window.location = "receiving-complete?id="+data.orderID;
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
  	
	
	
	<?php
	if($logged==1||$logged==2){
	if($receiving==0){
		echo "<strong><center>You do not have the authority to access this module.</center></strong>";
		goto exit_program;
	}
	$cart_query = mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID'");
	echo "
	<form action='receiving-form' method='post' id='receiving-form'>
	<div class='col-md-10 prints'>
	<div class='table-reponsive'>
		<div class='col-md-6'>
		<label><b>Add Item:</b></label>
		<div class = 'form-group'>
		   <input type = 'text' class = 'form-control itemsearch' name='itemname' id='itemsearch' autocomplete='off' placeholder='Type for Item Name Or Item Code'>
		</div>			
		</div>		
		<div class='col-md-6'>
		<label><b>Add Item:</b></label>
		<div class = 'form-group'>
		   <input type = 'text' class = 'form-control' name='itemname' id='itemsearch_cat' autocomplete='off' placeholder='Type for Category'>
		</div>		
		</div>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>Item Name</th>
					<th>Remaining</th>
					<th>Quantity</th>
					<th>Cost Price</th>
					<th>Line Total</th>
					<th></th>
				</tr>
			</thead>
			<tbody>";
			if(mysql_num_rows($cart_query)!=0){
				while($cart_row=mysql_fetch_assoc($cart_query)){
					$itemID = $cart_row["itemID"];
					$quantity = $cart_row["quantity"];
					$supplierID = $cart_row["supplierID"];
					$costprice = $cart_row["costprice"];
					$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
					($costprice==0?$costprice=$item_data["costprice"]:false);
					$line_total = $costprice*$quantity;
					echo "
						<tr>
							<td>".$item_data["itemname"]."</td>
							<td>".$item_data["quantity"]."</td>
							<td><input type='number' min='0' placeholder='Quantity' value='$quantity' id='$itemID' class='quantity'></td>
							<td><input type='number' min='0' placeholder='Cost' value='$costprice' id='$itemID' class='costprice'step='0.01'></td>
							<td style='text-align:right'><span id='total_of_$itemID'>".number_format($line_total,2)."</span></td>
							<td><span class='delete btn btn-danger' id='$itemID'>X</span></td>
						</tr>
					";
				}
			}
				
			echo "</tbody>
			<tfoot>";

				$total_query = mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID'");
				if(mysql_num_rows($total_query)!=0){
					$total=0;
					while($total_row=mysql_fetch_assoc($total_query)){
						$costprice = $total_row["costprice"];
						$quantity = $total_row["quantity"];
						$itemID = $total_row["itemID"];
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						($costprice==0?$costprice=$item_data["costprice"]:false);
						$subtotal = ($quantity*$costprice);
						$total += $subtotal;
					}
					echo "
					<tr>
						<th style='text-align:right' colspan='4'>Total:</th>
						<th style='text-align:right'><span id='total'>".number_format($total,2)."</span></th>
					</tr>
					";
				}else{
					echo "
					<tr>
						<td colspan='20' align='center'><b style='font-size:200%'>No Items to Show.</b></td>
					</tr>
					<tr>
					<th>
					</th>
					</tr>
					";
				}
			echo "</tfoot>
		</table>
	</div>
	";
	echo "</div>";
	if(mysql_num_rows($cart_query)!=0){
		$cart_query = mysql_query("SELECT * FROM tbl_cart_receiving WHERE accountID='$accountID'");
		while($cart_unique_row=mysql_fetch_assoc($cart_query)){
			$invoice_number = $cart_unique_row["invoice_number"];
			$terms = $cart_unique_row["terms"];
			$type = $cart_unique_row["type"];
			$freight = $cart_unique_row["freight"];
			$comments = $cart_unique_row["comments"];
			$db_supplierID = $cart_unique_row["supplierID"];
			$date_selected = $cart_unique_row["date"];
			($date_selected!=0?$date_selected=date("m/d/Y",$cart_unique_row["date"]):$date_selected=$date);
		}
		echo "
		<div class='col-md-2 prints'>
		<label>Supplier:</label>
		<select class='form-control' name='supplierID' required='required' id='supplier'>
			<option value=''>Select Supplier</option>";
			$supplier_query = mysql_query("SELECT * FROM tbl_suppliers WHERE deleted='0'");
			if(mysql_num_rows($supplier_query)!=0){
				while($supplier_row=mysql_fetch_assoc($supplier_query)){
					$supplierID = $supplier_row["supplierID"];
					$supplier_name = $supplier_row["supplier_name"];
					echo "<option value='$supplierID' ";
					if($supplierID==$db_supplierID){
						echo "selected='selected'";
					}
					echo ">$supplier_name</option>";
				}
			}
		echo "
		</select>";

		echo '
		<label>Date:</label>
		<input type="text" name="date" class="form-control" id="date" placeholder="Date" value="'.$date_selected.'" required="required">
		<label>Invoice Number:</label>
		<input type="text" name="invoice_number" class="form-control" id="invoice_number" placeholder="Invoice Number" value="'.$invoice_number.'" required="required">
		<label>Terms:</label>
		<input type="number" name="terms" min="0" step="0.01" class="form-control" id="terms" placeholder="Terms" value="'.$terms.'" required="required">
		<label>Freight Charges:</label>
		<input type="number" step="0.01" min="0" name="freight" class="form-control" id="freight" placeholder="Freight" value="'.$freight.'" required="required">
		<label>Comments:</label>
		<textarea placeholder="Comments" name="comments" class="form-control" id="comments">'.$comments.'</textarea>
		<label>Type:</label>
		<select name="type" class="form-control" id="type">
			<option value="purchase" '.($type=="purchase"?"selected":"").'>Purchase</option>
			<option value="bad order" '.($type=="bad order"?"selected":"").'>Bad Order</option>
			<option value="good order" '.($type=="good order"?"selected":"").'>Good Order</option>
		</select>
		<br>
		
		<label>Controls:</label>
		<a class="btn btn-block btn-info" id="reset"><span class="glyphicon glyphicon-refresh"></span> Reset Cost Prices</a>
		<button class="btn btn-block btn-primary" name="save" id="receiving-submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
		<a class="btn btn-block btn-danger" id="delete_all"><span class="glyphicon glyphicon-trash"></span> Cancel</a>
		</div>';
	}
	echo "
	</form>
	";
	
	}else{
		header("location:index");
	} ?>
  </div>
</div>
</body>
</html>
<?php mysql_close($connect);
exit_program:
?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>