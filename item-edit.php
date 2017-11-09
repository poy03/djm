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


if($items=='1'){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Edit Items</title>
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
input[type="text"] {
    width: 150px;
    display: block;
    margin-bottom: 10px;
}
  </style>
 <script>
		$(document).ready(function(){
			$("#Items").addClass("active");

  	      $( ".category" ).autocomplete({
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

	if(isset($_POST["save"])&&isset($_SESSION["selectitem"])){
		$x = array();
		$x = $_SESSION["selectitem"];
			 $itemname = $_POST["itemname"];
			 $item_code = $_POST["item_code"];
			 $supplierID = $_POST["supplierID"];
			 $unit_of_measure = $_POST["unit_of_measure"];
			 $category = $_POST["category"];
			 $costprice = $_POST["costprice"];
			 $sub_costprice = $_POST["costprice"];
			 $srp = $_POST["srp"];
			 $std_price_to_trade_terms = $_POST["std_price_to_trade_terms"];
			 $std_price_to_trade_cod = $_POST["std_price_to_trade_cod"];
			 $price_to_distributors = $_POST["price_to_distributors"];
			 $reorder = $_POST["reorder"];
			 $quantity = $_POST["quantity"];
		$i = 0;

		foreach($x as $itemID){
		$query = "SELECT * FROM tbl_items WHERE item_code='".mysql_real_escape_string(htmlspecialchars(trim($item_code[$i])))."' AND deleted='0' AND itemID!='$itemID'";
		$searchquery = mysql_query($query);
		// echo $query;
		// echo "<br>";
		if(mysql_num_rows($searchquery)<1){//if category and itemname have existed in the database exluding deleted items, then update items.
			$category[$i] = str_replace("&", "and", $category[$i]);
			mysql_query("UPDATE tbl_items SET
			 itemname = '".mysql_real_escape_string(htmlspecialchars(trim($itemname[$i])))."',
			 item_code = '".mysql_real_escape_string(htmlspecialchars(trim($item_code[$i])))."',
			 supplierID = '".mysql_real_escape_string(htmlspecialchars(trim($supplierID[$i])))."',
			 unit_of_measure = '".mysql_real_escape_string(htmlspecialchars(trim($unit_of_measure[$i])))."',
			 category = '".mysql_real_escape_string(htmlspecialchars(trim($category[$i])))."',
			 costprice = '".mysql_real_escape_string(htmlspecialchars(trim($costprice[$i])))."',
			 sub_costprice = '".mysql_real_escape_string(htmlspecialchars(trim($sub_costprice[$i])))."',
			 srp = '".mysql_real_escape_string(htmlspecialchars(trim($srp[$i])))."',
			 std_price_to_trade_terms = '".mysql_real_escape_string(htmlspecialchars(trim($std_price_to_trade_terms[$i])))."',
			 std_price_to_trade_cod = '".mysql_real_escape_string(htmlspecialchars(trim($std_price_to_trade_cod[$i])))."',
			 price_to_distributors = '".mysql_real_escape_string(htmlspecialchars(trim($price_to_distributors[$i])))."',
			 reorder = '".mysql_real_escape_string(htmlspecialchars(trim($reorder[$i])))."',
			 quantity = '".mysql_real_escape_string(htmlspecialchars(trim($quantity[$i])))."'
			WHERE itemID = '$itemID'");
		}
			
			$i++;
		}
		echo "
				<div class = 'alert alert-success alert-dismissable' style='text-align:center'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>Saved! </strong>Selected Items are updated. <a href='item'>Back to Items.</a>
				</div>
				";
				unset($_SESSION["selectitem"]);
		exit;
	}
	?>
	<form action="item-edit" method='post'>


	<div class='table-responsive col-md-12'>
	<table class='table'>
	 <thead>
	  <tr>
	   <th>Category</th>
	   <th>Item Name</th>
	   <th>Item Code</th>
	   <th>Supplier</th>
	   <th>UOM</th>
	   <th>Quantity</th>
	   <th>Subcost Price</th>
	   <th>SRP</th>
	   <th>STD Price to Trade (Terms)</th>
	   <th>STD Price to Trade (COD)</th>
	   <th>Price to Distributors</th>
	   <th>Reorder Level</th>
	  </tr>
	 </thead>
	 <tbody>
	 <?php
		if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
		$maxitem = 50; // maximum items
		$limit = ($page*$maxitem)-$maxitem;
	 $query = "SELECT * FROM tbl_items";
	 $x = $_SESSION["selectitem"];
	 if($x!=NULL){
	 $cnt = 0;
	 foreach($x as $itemID){
		 if($cnt==0){
			 $query.=" WHERE itemID = $itemID";
		 }else{
			 $query.=" OR itemID = $itemID";
		 }
		 $cnt++;
	 }
	 }else{
		 header("location:item");
	 }
	 $query.=" ORDER BY itemname";
	 $numitemquery = mysql_query($query);
	 $numitem = mysql_num_rows($numitemquery);
	 //echo $query;
	 $itemquery = mysql_query($query);
	 
	 
	 		if(($numitem%$maxitem)==0){
				$lastpage=($numitem/$maxitem);
			}else{
				$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
			}
			$maxpage = 3;
			
	 
	 
	 if(mysql_num_rows($itemquery)!=0){
		 while($itemrow=mysql_fetch_assoc($itemquery)){
			 $dbitemID = $itemrow["itemID"];
			 $dbitemname = $itemrow["itemname"];
			 $dbitem_code = $itemrow["item_code"];
			 $dbsupplierID = $itemrow["supplierID"];
			 $dbunit_of_measure = $itemrow["unit_of_measure"];
			 $dbcategory = $itemrow["category"];
			 $dbcostprice = $itemrow["costprice"];
			 $dbsub_costprice = $itemrow["sub_costprice"];
			 $dbsrp = $itemrow["srp"];
			 $dbstd_price_to_trade_terms = $itemrow["std_price_to_trade_terms"];
			 $dbstd_price_to_trade_cod = $itemrow["std_price_to_trade_cod"];
			 $dbprice_to_distributors = $itemrow["price_to_distributors"];
			 $dbreorder = $itemrow["reorder"];
			 $dbquantity = $itemrow["quantity"];
			 echo '
			 <tr>
			  <td><div class="ui-widget"><input type="text" name="category[]" value="'.$dbcategory.'" required="required" class="category"></div></td>
			  <td><input type="text" name="itemname[]" value="'.$dbitemname.'" required="required"></td>
			  <td><input type="text" name="item_code[]" value="'.$dbitem_code.'" required="required"></td>
			  <td>
			  	<select name="supplierID[]">
			  		<option>Select Supplier</option>';
			  		$supplier_query = mysql_query("SELECT * FROM tbl_suppliers WHERE deleted='0'");
			  		if(mysql_num_rows($supplier_query)!=0){
			  			while($supplier_row=mysql_fetch_assoc($supplier_query)){
			  				$database_supplierID = $supplier_row["supplierID"];
			  				$database_supplier_name = $supplier_row["supplier_company"];
			  				echo "<option value='$database_supplierID' ";
			  				if($database_supplierID==$dbsupplierID){
			  					echo "selected='selected'";
			  				}
			  				echo ">$database_supplier_name</option>";
			  			}
			  		}
			  	echo '
			  	</select>
			  </td>
			  <td><input type="text" name="unit_of_measure[]" value="'.$dbunit_of_measure.'" required="required"></td>
			  <td><input type="number" min="0" name="quantity[]" value="'.$dbquantity.'" required="required"></td>
			  <td><input type="number" step="0.01" min="0" name="costprice[]" value="'.$dbcostprice.'" required="required"></td>
			  <td><input type="number" step="0.01" min="0" name="srp[]" value="'.$dbsrp.'" required="required"></td>
			  <td><input type="number" step="0.01" min="0" name="std_price_to_trade_terms[]" value="'.$dbstd_price_to_trade_terms.'" required="required"></td>
			  <td><input type="number" step="0.01" min="0" name="std_price_to_trade_cod[]" value="'.$dbstd_price_to_trade_cod.'" required="required"></td>
			  <td><input type="number" step="0.01" min="0" name="price_to_distributors[]" value="'.$dbprice_to_distributors.'" required="required"></td>
			  <td><input type="number" min="0" name="reorder[]" value="'.$dbreorder.'" required="required"></td>
			 </tr>
			 ';
		 }
	 }
	 ?>
	 </tbody>
	</table>	
	</div>
	<div class="span7 text-center"><button class='btn btn-primary' type='save' name='save'><span class='glyphicon glyphicon-floppy-disk'></span> Save</button></div>
	
	</div>

	</form>

	
	<?php
	
	}else{
header("location:index");
	} ?>
	</div>
  </div>
</div>
</body>
</html>
<?php mysql_close($connect);}else{
		echo "<strong><center>You do not have the authority to access this module.</center></strong>";
	}?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>