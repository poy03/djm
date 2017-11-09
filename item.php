<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
error_reporting(0);
if(isset($_GET['cat'])){
	$cat = mysql_real_escape_string(htmlspecialchars(trim($_GET['cat'])));
}
$sort=@$_GET['sort'];
if(!isset($sort)){
	$sort = "A-Z";
}
$keyword=@$_GET['s'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php 
  echo $app_name; ?> - Items</title>
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
  <link rel="stylesheet" href="css/theme.default.min.css">
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script> 
  <script>
  $(document).ready(function(){
  	$("#Items").addClass("active");
	  $("#myTable").tablesorter();
	   $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} ); 
	  $("#add").click(function(){
		  window.location="item-add";
	  });
	  
	  $('#select-all').click(function() {   
		if(this.checked) {
			// Iterate each checkbox
			$(':checkbox').each(function() {
				this.checked = true;                        
			});
			}else{
			// Iterate each checkbox
			$(':checkbox').each(function() {
				this.checked = false;                        
			});
			}
	  });
	  
	  $(".select").change(function(){
		  if(this.checked){
			  
		  }else{
			  $("#select-all").prop( "checked", false );
		  }
	  });
	  
	 $('.selected').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
	
	$("#cat,#sort,#supplier").change(function(){
		var sort = $("#sort").val();
		var supplier = $("#supplier").val();
		var cat = $("#cat").val();
		window.location = "item?cat="+cat+"&sort="+sort+"&supplier="+supplier;
	});
	

	
  });
  
  </script>
  
    <style>

	.tablesorter-default{
		font:20px/20px;
		font-weight:1200;
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

	*{
		line-height: 1 !important;
		font-size:8pt !important;
	} 
	th, td{
		margin: 0pt !important;
		padding: 0pt !important;
		padding-left: 1pt !important;
		padding-right: 1pt !important;
		border-style: solid  !important;
		border-width: 1pt  !important;
		border-color: black  !important;
		text-align: center !important;
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
	if($items==1){

		
	if(isset($_POST["edit"])){
		$x = array();
		$x = $_POST["select"];
		$_SESSION["selectitem"]=$x;
		header("location:item-edit");
	}

	if(isset($_POST["sales"])){
		$x = array();
		$x = $_POST["select"];
		foreach($x as $itemID){
			$cartquery = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID' AND itemID='$itemID'");
			if(mysql_num_rows($cartquery)==0){
				mysql_query("INSERT INTO tbl_cart VALUES ('','$itemID','1','0','0','$accountID','','','','')");
			}else{
				$searchquery = mysql_query("SELECT * FROM tbl_cart WHERE itemID='$itemID'");
				while($searchrow=mysql_fetch_assoc($searchquery)){
					$quantity = $searchrow["quantity"];
					$quantity++;
				}
				$updatequery = mysql_query("UPDATE tbl_cart SET quantity='$quantity' WHERE itemID='$itemID'");
			}
		}
		header("location:sales");
	}
	if(isset($_POST["delete"])){
		$x = array();
		$x = @$_POST["select"];
		$_SESSION["selectitem"]=$x;
		if($x!=NULL){ 
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				 var conf = confirm("Are you sure you want to delete selected items?");
				 if(conf==true){
					 window.location="item-delete";
				 }
			});
		</script>
		<?php

		}
	}
	?>
	<form action="item" method='post' id='main_form'>
	<div class='col-md-2 prints'>
	<?php if($items_modify=='1'||$items_modify=='1'){
		echo "<label>Controls:</label>";} ?>
	<?php if($items_add=='1'){
		
		echo "<span class='btn btn-primary btn-block' name='add' id='add'><span class='glyphicon glyphicon-briefcase'></span> Add Items</span>";
	}?>

	<?php if($items_modify=='1'){ ?>	
	<button class='btn btn-primary btn-block' name='edit' type='submit'><span class='glyphicon glyphicon-edit'></span> Edit Items</button>
	<?php } ?>

	<?php if($items_delete=='1'){ ?>	
	<button class='btn btn-danger btn-block' name='delete' type='submit' id='delete'><span class='glyphicon glyphicon-trash'></span> Delete Items</button>
	<?php } ?>

	<br>
	<label>Category:</label>
	<select class='form-control' id='cat'>
		<option value='all'>All</option>
		<?php
			$categoryquery = mysql_query("SELECT DISTINCT category FROM tbl_items WHERE deleted='0' ORDER BY category");
			if(mysql_num_rows($categoryquery)!=0){
				while($categoryrow=mysql_fetch_assoc($categoryquery)){
					$dbcategory = $categoryrow["category"];
					$cat_items_query = mysql_query("SELECT * FROM tbl_items WHERE quantity<=reorder AND deleted='0' AND category='".mysql_real_escape_string(htmlspecialchars(trim($dbcategory)))."'");
					$cat_i = mysql_num_rows($cat_items_query);
					if($cat_i==0){
						$cat_i='';
					}else{
						$cat_i = "($cat_i)";
					}
					
					echo '
					<option value="'.$dbcategory.'" ';
					if(isset($cat)&&$cat==mysql_real_escape_string(htmlspecialchars(trim($dbcategory)))){
						
						echo "selected='selected'";
					}
					
					echo ">".htmlspecialchars_decode($dbcategory)." $cat_i</option>
					";
				}
			}
		?>
	</select>
	<label>Supplier</label>
	<select class="form-control" id="supplier">
		<option value="all">All</option>
		<?php
		$supplier_query = mysql_query("SELECT * FROM tbl_suppliers");
		$supplier = @$_GET["supplier"];
		if(mysql_num_rows($supplier_query)!=0){
			while($supplier_row=mysql_fetch_assoc($supplier_query)){
				echo "
				<option value='".$supplier_row["supplierID"]."' ";
				if(isset($supplier)&&$supplier!=""){
					if($supplier==$supplier_row["supplierID"]){
						echo "selected='selected'";
					}
				}

				echo ">".$supplier_row["supplier_name"]."</option>
				";
			}
		}

		?>
	</select>

	<br>
	<span><b>Sort:</b></span>
	<select class='form-control' id='sort'>
		<option value='A-Z' <?php if(strtolower($sort)=='a-z'){
			echo "selected";}?>>A-Z</option>
		<option value='Z-A' <?php if(strtolower($sort)=='z-a'){
			echo "selected";}?>>Z-A</option>
		<option value='Q-R' <?php if(strtolower($sort)=='q-r'){
			echo "selected";}?>>Quantity < Reorder Level</option>
		<option value='Q-D' <?php if(strtolower($sort)=='q-d'){
			echo "selected";}?>>Quantity DESC</option>
		<option value='Q-A' <?php if(strtolower($sort)=='q-a'){
			echo "selected";}?>>Quantity ASC</option>
	</select>
	<br>
	</form>
	<?php
	if($items_modify=='1'){
		?>
	<form action="export-to-excel" method='post'>
	<label>Export to Excel Including:</label>
	<input type='hidden' name='category' value="<?php echo $cat; ?>">
	<input type='hidden' name='supplier' value="<?php
	$supplier = $_GET["supplier"];
	 echo $supplier; ?>">
	<div class="col-md-12">
      <label><input type='checkbox' name='sub_costprice' value='1' checked> Sub Cost Price</label>
    </div>
	<div class="col-md-12">
      <label><input type='checkbox' name='costprice' value='1' checked> Total Cost Price</label>
    </div>
	<div class="col-md-12">
      <label><input type='checkbox' name='srp' value='1' checked> WPP</label>
    </div>
	<div class="col-md-12">
      <label><input type='checkbox' name='std_price_to_trade_terms' value='1' checked> STD Price to Terms</label>
    </div>
    <div class="col-md-12">
      <label><input type='checkbox' name='std_price_to_trade_cod' value='1' checked> STD Price to COD</label>
    </div>
    <div class="col-md-12">
      <label><input type='checkbox' name='price_to_distributors' value='1' checked> Price to Distributors</label>
    </div>

    <button class='btn btn-block btn-primary' name='export' type='submit'><span class='glyphicon glyphicon-file'></span> Export</button>
	</form>
		
		<?php
	}

	?>
	</div>
	<div class='col-md-10'>
	<div class="table-responsive ">
	<table class='table table-hover tablesorter tablesorter-default' id='myTable'>
	 <thead>
	  <tr>
	   <th class='prints'><input type="checkbox" id="select-all" value='all'> All</th>
	   <th>Category</th>
	   <th>Supplier</th>
	   <th>Item Name</th>
	   <th>Item Code</th>
	   <th>UOM</th>
	   <th>Remaining Quantity</th>
	   <th>Sub Cost Price</th>
	   <th>Total Cost Price</th>
	   <th>WPP</th>
	   <th>STD Price to Trade (Terms):</th>
	   <th>STD Price to Trade (COD):</th>
		<th>Price to Distributors:</th>
	   <th class='prints'>Reorder Level</th>
	  </tr>


	 </thead>
	 <tbody>
	 <?php
		if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
		$maxitem = $maximum_items_displayed; // maximum items
		$limit = ($page*$maxitem)-$maxitem;
	 $query = "SELECT * FROM tbl_items WHERE deleted = 0";
	 if(isset($keyword)){
		 $query.=" AND itemID='$keyword'";
	 }
	 if(isset($cat)&&strtolower($cat)!='all'){
		 if($cat==''){
		 }else{
		 	// $cat = mysql_real_escape_string(htmlspecialchars(trim($cat)));
		 $query.=" AND category='$cat'";
		 // $query.=" AND category LIKE '%".mysql_real_escape_string($cat)."%'";
		 }
	 }
	 $supplier = @$_GET["supplier"];
	  if(isset($supplier)&&strtolower($supplier)!='all'){
	 	 if($supplier==''){

	 	 }else{
	 	 $query.=" AND supplierID='$supplier'";
	 	 // $query.=" AND category LIKE '%".mysql_real_escape_string($cat)."%'";
	 	 }
	  }

	 if(strtolower($sort)=="a-z"){
		$query.=" ORDER BY itemname";
	 }elseif(strtolower($sort)=="z-a"){
		$query.=" ORDER BY itemname DESC";
	 }elseif(strtolower($sort)=="q-r"){
		$query.=" ORDER BY quantity>reorder, itemname";
	 }elseif(strtolower($sort)=="q-a"){
		$query.=" ORDER BY quantity ASC";
	 }elseif(strtolower($sort)=="q-d"){
		$query.=" ORDER BY quantity DESC";
	 }else{
		$query.=" ORDER BY itemname";
	 }
	 $numitemquery = mysql_query($query);
	 $numitem = mysql_num_rows($numitemquery);
	 $query.=" LIMIT $limit, $maxitem";
	 
	 // echo $query;
	 
	 
	 		if(($numitem%$maxitem)==0){
				$lastpage=($numitem/$maxitem);
			}else{
				$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
			}
			$maxpage = 3;
			
	 $itemquery = mysql_query($query);
	 
	 
	 if(mysql_num_rows($itemquery)!=0){
		$i =0;
		$q = @$_POST['select'];
		
		 while($itemrow=mysql_fetch_assoc($itemquery)){
			 $itemID = $itemrow["itemID"];
			 $itemname = $itemrow["itemname"];
			 $std_price_to_trade_terms = $itemrow["std_price_to_trade_terms"];
			 $std_price_to_trade_cod = $itemrow["std_price_to_trade_cod"];
			 $price_to_distributors = $itemrow["price_to_distributors"];
			 $category = $itemrow["category"];
			 $costprice = $itemrow["costprice"];
			 $srp = $itemrow["srp"];
			 $supplierID = $itemrow["supplierID"];
			 $quantity = $itemrow["quantity"];
			 $item_code = $itemrow["item_code"];
			 $unit_of_measure = $itemrow["unit_of_measure"];
			 $sub_costprice = $itemrow["sub_costprice"];
			 $reorder_value = $itemrow["reorder"];
			 if($reorder_value>=$quantity){
				 $reorder = "warning";
			 }else{
				 $reorder = "";
			 }
			 
			 echo "
			 <tr class='selected $reorder'>
			  <td class='prints'><input type='checkbox' name='select[]' value='$itemID' class='select' ";
			  if(isset($_POST["select"])){
				  if(in_array($itemID,$_POST['select'])) 
				  	echo 'checked';
			  }
			  $supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
			  echo " form='main_form'></td>
			  <td>$category</td>
			  <td>".$supplier_data["supplier_name"]."</td>
			  <td>$itemname</td>
			  <td>$item_code</td>
			  <td>$unit_of_measure</td>
			  <td>$quantity</td>
			  <td>₱".number_format($costprice,2)."</td>
			  <td>₱".number_format($quantity*$costprice,2)."</td>
			  <td>₱".number_format($srp,2)."</td>
			  <td>₱".number_format($std_price_to_trade_terms,2)."</td>
			  <td>₱".number_format($std_price_to_trade_cod,2)."</td>
			  <td>₱".number_format($price_to_distributors,2)."</td>
			  <td class='prints'>$reorder_value</td>
			 </tr>
			 ";
	     $i++;
		 }
	 }
	 ?>
	 </tbody>

	</table>
	</div>
<?php
			
			echo "
		<div class='text-center'>
			<ul class='pagination prints'>
			
			";
			$url="?cat=$cat&sort=$sort&supplier=$supplier&";
			$cnt=0;
			if($page>1){
				$back=$page-1;
				
				echo "<li><a href = '".$url."page=1'>&laquo;&laquo;</a></li>";	
				
				echo "<li><a href = '".$url."page=$back'>&laquo;</a></li>";	
				for($i=($page-$maxpage);$i<$page;$i++){
					if($i>0){
						
						echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
					}
					$cnt++;
					if($cnt==$maxpage){
						break;
					}
				}
			}
			
			$cnt=0;
			for($i=$page;$i<=$lastpage;$i++){
				$cnt++;
				if($i==$page){
					
					echo "<li class='active'><a href = '#'>$i</a></li>";	
				}else{
					
					echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				}
				if($cnt==$maxpage){
					break;
				}
			}
			
			$cnt=0;
			for($i=($page+$maxpage);$i<=$lastpage;$i++){
				$cnt++;
				
				echo "<li><a href = '".$url."page=$i'>$i</a></li>";	
				if($cnt==$maxpage){
					break;
				}
			}
			if($page!=$lastpage&&$numitem>0){
				$next=$page+1;
				
				echo "<li><a href = '".$url."page=$next'>&raquo;</a></li>";
				
				echo "<li><a href = '".$url."page=$lastpage'>&raquo;&raquo;</a></li>";
			}
			
			echo "</ul><span class='page' >Page $page</span>
			</div>
			";
			
			?>
	</div>
	</div>
	

	
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