<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
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
  <title><?php echo $app_name; ?> - Add Items</title>
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
  
  <script src="jquery.min.js"></script>  <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/balloon.css">
<link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>
  <style>
  .item:hover{
	  cursor:pointer;
  }
  </style>
  <script>
  $(document).ready(function(){
//customer ajax search
$("#Items").addClass("active");

    $( "#category" ).autocomplete({
      source: 'search'
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
	#result,#itemresult,#item_results
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
		z-index:5;
		position:absolute;
	}
	#item_results{
		width:250px;

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
  	<div class='col-md-12 prints'>
	
	<?php
	if($logged==1||$logged==2){
	if($items=='1'){
if(isset($_POST["submit"])){
		$category = mysql_real_escape_string(htmlspecialchars(trim($_POST["category"])));
		// $category = str_replace("&", "and", $category);
		$std_price_to_trade_terms = mysql_real_escape_string(htmlspecialchars(trim($_POST["std_price_to_trade_terms"])));
		$std_price_to_trade_cod = mysql_real_escape_string(htmlspecialchars(trim($_POST["std_price_to_trade_cod"])));
		$price_to_distributors = mysql_real_escape_string(htmlspecialchars(trim($_POST["price_to_distributors"])));
		$unit_of_measure = mysql_real_escape_string(htmlspecialchars(trim($_POST["unit_of_measure"])));
		$itemname = mysql_real_escape_string(htmlspecialchars(trim($_POST["itemname"])));
		$sub_costprice = mysql_real_escape_string(htmlspecialchars(trim($_POST["sub_costprice"])));
		$costprice = mysql_real_escape_string(htmlspecialchars(trim($_POST["sub_costprice"])));
		$reorder = mysql_real_escape_string(htmlspecialchars(trim($_POST["reorder"])));
		$srp = mysql_real_escape_string(htmlspecialchars(trim($_POST["srp"])));
		$supplier = mysql_real_escape_string(htmlspecialchars(trim($_POST["supplier"])));
		$quantity = mysql_real_escape_string(htmlspecialchars(trim($_POST["quantity"])));
		$item_code = mysql_real_escape_string(htmlspecialchars(trim($_POST["item_code"])));
		// $comment = $_POST["comment"];
		$searchquery = mysql_query("SELECT * FROM tbl_items WHERE category='$category' AND itemname='$itemname' AND item_code='$item_code' AND deleted='0'");
		if(mysql_num_rows($searchquery)<1){//if category and itemname have existed in the database exluding deleted items, then add items.
		mysql_query("INSERT INTO tbl_items VALUES ('','$itemname','$category','$sub_costprice','$srp','$supplier','$quantity','$costprice','','$reorder','$item_code','$std_price_to_trade_terms','$std_price_to_trade_cod','$price_to_distributors','$unit_of_measure')");
		
		echo "
				<div class = 'alert alert-success alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>$itemname</strong> is successfuly saved.
				</div>
		
		";
		}else{
					echo "
				<div class = 'alert alert-danger alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>$itemname</strong> is already added.
				</div>
		
		";
		}
		
	}
	
	?>
	<form action="item-add" method='post' class='form-horizontal'>	
	<div class='col-md-2'>
		<span><b>Controls:</b></span>	

	<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-floppy-disk'></span> Save
	</button>
	</div>
	<div class='col-md-10'>

	<div class='form-group ui-widget'>
		<label for="category" class='col-md-2'>Category:</label>
	<div class='col-md-10'>
		<input type='text' class='form-control search' id='category' name='category' placeholder='Category' required='required' autocomplete='off'>
	</div>
	
	</div>
	
	<div class='form-group'>
		<label for="itemname" class='col-md-2'>Item Name:</label>
	<div class='col-md-10'>
		<input type='text' class='form-control' name='itemname' placeholder='Item Name' required='required'>
	</div>
	</div>


	<div class='form-group'>
		<label for="item_code" class='col-md-2'>Item Code:</label>
	<div class='col-md-10'>
		<input type='text' class='form-control' name='item_code' placeholder='Item Code' required='required'>
	</div>
	</div>

	<div class='form-group'>
		<label for="supplier" class='col-md-2'>Supplier:</label>
	<div class='col-md-10'>
		<select name="supplier" class="form-control">
			<option>Select Supplier</option>
			<?php
			$supplier_query = mysql_query("SELECT * FROM tbl_suppliers WHERE deleted='0'");
			if(mysql_num_rows($supplier_query)!=0){
				while($supplier_row=mysql_fetch_assoc($supplier_query)){
					$supplierID = $supplier_row["supplierID"];
					$supplier_name = $supplier_row["supplier_company"];
					echo "<option value='$supplierID'>$supplier_name</option>";
				}
			}

			?>
		</select>
	</div>
	</div>

	<div class='form-group'>
		<label for="unit_of_measure" class='col-md-2'>Unit of Measurement:</label>
	<div class='col-md-10'>
		<input type='text' class='form-control' name='unit_of_measure' placeholder='Unit of Measurement' required='required'>
	</div>
	</div>
	
	<div class='form-group'>
		<label for="sub_costprice" class='col-md-2'>Sub Cost Price:</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='sub_costprice' placeholder='Sub Cost Price' required='required'>
	</div>
	</div>

	<!--
	<div class='form-group'>
		<label for="costprice" class='col-md-2'>Total Cost Price:</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='costprice' placeholder='Total Cost Price' required='required'>
	</div>
	</div>
	-->

	<div class='form-group'>
		<label for="srp" class='col-md-2'>WPP:</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='srp' placeholder='WPP' required='required'>
	</div>
	</div>
	<!--
	<div class='form-group'>
		<label for="dp" class='col-md-2'>Dealer Price:</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='dp' placeholder='Dealer Price' required='required'>
	</div>
	</div>
	-->
	<div class='form-group'>
		<label for="std_price_to_trade_terms" class='col-md-2'>STD Price to Trade (Terms):</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='std_price_to_trade_terms' placeholder='STD Price to Trade (Terms)' required='required'>
	</div>
	</div>

	<div class='form-group'>
		<label for="std_price_to_trade_cod" class='col-md-2'>STD Price to Trade (COD):</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='std_price_to_trade_cod' placeholder='STD Price to Trade (COD)' required='required'>
	</div>
	</div>

	<div class='form-group'>
		<label for="price_to_distributors" class='col-md-2'>Price to Distributors:</label>
	<div class='col-md-10'>
		<input step='0.01' min='0' max='99999999' type='number' class='form-control' name='price_to_distributors' placeholder='Price to Distributors' required='required'>
	</div>
	</div>

	<div class='form-group'>
		<label for="quantity" class='col-md-2'>Quantity:</label>
	<div class='col-md-10'>
		<input min='0' max='99999999' type='number' class='form-control' name='quantity' placeholder='Quantity' required='required'>
	</div>
	</div>

	<div class='form-group'>
		<label for="quantity" class='col-md-2'>Reorder Level:</label>
	<div class='col-md-10'>
		<input min='0' max='99999999' type='number' class='form-control' name='reorder' placeholder='Reorder Level' required='required'>
	</div>
	</div>	
	<!--
	<div class='form-group'>
		<label for="comment" class='col-md-2'>Comment:</label>
	<div class='col-md-10'>
		<textarea class='form-control' name='comment'></textarea>
	</div>
	</div>
	-->
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