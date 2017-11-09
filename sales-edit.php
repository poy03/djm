<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
$by=@$_GET['by'];
$order=@$_GET['order'];



include 'db.php';


$orderID=@$_GET['id'];
$order_query = mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID' AND deleted='0'");
if(mysql_num_rows($order_query)==0){
	header("location:success");
}
$order_data = mysql_fetch_assoc($order_query);
if($order_data["approved"]=="1"){
	header("location:success");
}


if(isset($_POST["save"])){
	$purchase_query = mysql_query("SELECT * FROM tbl_purchases WHERE orderID='$orderID'");
	$comments = $_POST["comments"];
	$returned = $_POST["returned"];
	$i=0;
	$total = 0;
	mysql_query("INSERT INTO tbl_sales_edit VALUES ('','$orderID','$accountID','$comments','','".strtotime($datenow)."','".strtotime($timenow)."','','','','','')");
	$latest_sales_editID = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_sales_edit ORDER BY editID DESC LIMIT 0,1"));
	$purchase_query = mysql_query("SELECT * FROM tbl_purchases WHERE orderID='$orderID'");
	$i=0;
	while($purchase_row=mysql_fetch_assoc($purchase_query)){
		$quantity = $purchase_row["quantity"];
		$itemID = $purchase_row["itemID"];
		$price = $purchase_row["price"];
		$orderID = $purchase_row["orderID"];
		mysql_query("INSERT INTO tbl_sales_edit_items VALUES ('','".$latest_sales_editID['editID']."','$itemID','$quantity','$returned[$i]','','$accountID','$orderID','','','$price')");
		$i++;
	}
	mysql_query("UPDATE tbl_orders SET approved = '1' WHERE orderID='$orderID'");
	goto exit_program;
				
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

  	$('#sales-edit-form').submit(function(e) {
  		e.preventDefault();
  		$.ajax({
  			type: "POST",
  			url: $('#sales-edit-form').attr('action'),
  			data: $('#sales-edit-form').serialize()+'&save=1',
  			cache: false,
  			beforeSend: function() {
  				$('button[form="sales-edit-form"]').prop('disabled',true);
  			},
  			success: function(data) {
  				// $('button[form="sales-edit-form"]').prop('disabled',false);
  				location.reload();
  			},
  			complete: function() {
  				// body...
  				// $('button[form="sales-edit-form"]').prop('disabled',false);
  			}
  		});
  	});
	  $("#Sales").addClass("active");
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
		if($sales=='1'){

			?>
			<form action="sales-edit?id=<?php echo $orderID; ?>" method="post" id="sales-edit-form">
				<div class="col-md-2">
					<label>DR #:</label>
					<input type="text" value="<?php echo "S".sprintf("%06d",$orderID); ?>" class="form-control" readonly>
					<br>
					<label>Comments</label>
					<textarea placeholder="Comments" class="form-control" name='comments'></textarea>
					<br>
					<label>Controls:</label>
					<button class="btn btn-block btn-primary" name="save" form="sales-edit-form"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
				</div>
				<div class="col-md-10">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Item Name</th>
									<th>Qty</th>
									<th>Qty of Returns</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$purchase_query = mysql_query("SELECT * FROM tbl_purchases WHERE orderID='$orderID'");
									while($purchase_row=mysql_fetch_assoc($purchase_query)){
										$itemID = $purchase_row["itemID"];
										$quantity = $purchase_row["quantity"];
										$purchaseID = $purchase_row["purchaseID"];
										$price = $purchase_row["price"];
										$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
										echo "
											<tr>
												<td><input type='hidden' name='purchaseID[]' value='$purchaseID'>".$item_data["itemname"]."</td>
												<td>$quantity</td>
												<td><input type='number' min='0' max='$quantity' name='returned[]' value='0' required='required'></td>
												<td><input type='hidden' name='price[]' value='$price'>".number_format($price,2)."</td>
											</tr>
										";
									}

								?>
							</tbody>
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
<?php mysql_close($connect);
exit_program:
?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>