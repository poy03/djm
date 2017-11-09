<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$orderID=@$_SESSION['orderID'];

$page=@$_GET['page'];
$c=@$_GET['c'];
$d=@$_GET['d'];
$s=@$_GET['s'];

$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

$cart_query = mysql_query("SELECT * FROM tbl_cart WHERE accountID='$accountID'");
if(mysql_num_rows($cart_query)==0){
	$typeprice=@$_GET['type'];
}else{
	while($cart_row=mysql_fetch_assoc($cart_query)){
		$typeprice=$cart_row["type_price"];
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Sales | Transaction Sheet</title>
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
  .process:hover{
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
$("#Sales").addClass("active");
  	  $(".process").click(function(e){
  	  	window.location = "sales-add-by-ts?id="+e.target.id;
  	  });
	  $("#ts").change(function(){
	  	var dataString = $(this).val();
	  	$.ajax({
	  		type: 'POST',
	  		data: 'ts='+dataString,
	  		cache: false,
	  		url: 'sales-ts-cart-add',
	  		success: function(){

	  		}
	  	});
	  });
	  $("#add_customer").click(function(){
		  window.location= "customer-add";
	  });
	  
	  $(".dr_request").click(function(e){
	  	// $.ajax({
	  	// 	type: "",
	  	// 	url: "",
	  	// 	cache: false,
	  	// 	success: function(data){

	  	// 	}
	  	// });
	  });


	  $("#myTable").tablesorter();
	  $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} );
	  
	  $("#reset").click(function(){
		  var dataString = 'reset=1';
		  $.ajax({
			type: 'POST',
			url: 'sales-ts-cart-add',
			data: dataString,
			cache: false,
			success: function(html){
				location.reload();
			}
		  });
	  });	  
	  $("#reset_cost").click(function(){
		  var dataString = 'reset_cost=1';
		  $.ajax({
			type: 'POST',
			url: 'sales-ts-cart-add',
			data: dataString,
			cache: false,
			success: function(html){
				location.reload();
			}
		  });
	  });
	  
	  $(".quantity").keyup(function(e){
			var dataString = 'id='+ e.target.id + '&value='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
				}
			});
	  });
	  
	  $(".price").keyup(function(e){
			var dataString = 'id='+ e.target.id + '&price='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
				}
			});
	  });	

	  $(".costprice").keyup(function(e){
			var dataString = 'id='+ e.target.id + '&costprice='+e.target.value;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
				}
			});
	  });

	  $(".delete").click(function(e){
	  	if(confirm("Are you sure you want to delete selected item?")){
			var dataString = 'deleteid='+ e.target.id;
			$.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
			});
	  	}
	  });
	  
	  $("#type").change(function(){
		  var n = $(this).val();
		  window.location="sales-ts-type?type="+n;
	  });
	  $("#type_payment_cart").change(function(){
		var type_payment = $(this).val();
		var dataString = 'search='+ type_payment;
		  $.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					
				}
		  });
	  });
	  

	$( "#searchid" ).autocomplete({
      source: 'search-customer-auto',
	  select: function(event, ui){
		  window.location='sales-ts-add-customer?id='+ui.item.data;
	  },
	  change: function(){
		var customer = $(this).val();
		var dataString = 'customer='+customer;
		  $.ajax({
				type: 'POST',
				url: 'sales-ts-add-customer-02',
				data: dataString,
				cache: false,
				success: function(html){
				}
		  });
	  }
    });
		
		
	$( "#itemsearch" ).autocomplete({
      source: 'search-item-auto',
	  select: function(event, ui){
		  window.location='sales-ts-add?id='+ui.item.data;
	  }
    });

 	$( "#itemsearch_cat" ).autocomplete({
      source: 'search-item-category-auto',
	  select: function(event, ui){
		  window.location='sales-add?id='+ui.item.data;
	  }
    });
    

	$("#terms").change(function(){
		var terms = $(this).val();
		var dataString = 'terms='+terms;
		  $.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
				}
		  });
	});
	
	$("#date").change(function(){
		var val = $(this).val();
		window.location = 'sales-ts-list?d='+val;
	});

	$("#customer").change(function(){
		var val = $(this).val();
		window.location = 'sales-ts-list?c='+val;
	});

	$("#salesman").change(function(){
		var val = $(this).val();
		window.location = 'sales-ts-list?s='+val;
	});


	

	$("#delall").click(function(){
		var dataString = 'delall=1';
		  $.ajax({
				type: 'POST',
				url: 'sales-ts-cart-add',
				data: dataString,
				cache: false,
				success: function(html){
					location.reload();
				}
		  });
	});
		
		$('#type_payment').multiselect();
		$('#type_payment').change(function(){
			var type_payment = $(this).val();
			var dataString = "type_payment="+type_payment;
			$.ajax({
				type: 'POST',
				url: 'sales-cart-add',
				data: dataString,
				cache: false,
				success: function(){
				}
			});
		});
		
		$("#del_customer").click(function(){
			window.location='sales-ts-add-customer?id=0';
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
  	<div class='col-md-12'>
	<ol class="breadcrumb">
		<li><a href="sales">Make Delivery Receipt</a></li>
		<li><a href="sales-ts">Make Transaction Sheet</a></li>
		<li class="active">List of Pending Transaction Sheets  <span class='badge'><?php ($badge_sales==0?$badge_sales="":false); echo $badge_sales; ?></span></li>
		<li><a href="sales-dr-list">List of Delivery Receipt</a></li>
	</ol>
	<?php
	if($logged==1||$logged==2){
		if($sales=='1'){
			//date		
			$ts_date_unique_query = mysql_query("SELECT DISTINCT date FROM tbl_ts_orders WHERE deleted='0' AND processed='0' ORDER BY date DESC");
			echo "
			<div class='table-responsive'><label>Filter By:&nbsp;</label>";
			echo "<select id='date'><option value=''>Select Date</option>";
			while ($ts_date_unique_row=mysql_fetch_assoc($ts_date_unique_query)) {
				$filter_date = $ts_date_unique_row["date"];
				echo "<option value='$filter_date' ";
					if(isset($d)&&$d==$filter_date){
						echo "selected='selected'";
					}
					echo ">".date("m/d/Y",$filter_date)."</option>";
			}
			echo "</select>";
			//customer
			$ts_customer_unique_query = mysql_query("SELECT DISTINCT customerID FROM tbl_ts_orders WHERE deleted='0' AND processed='0' ORDER BY date DESC");
			echo "<select id='customer'><option value=''>Select Customers</option>";
			while ($ts_customer_unique_row=mysql_fetch_assoc($ts_customer_unique_query)) {
				$customerID = $ts_customer_unique_row["customerID"];
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));				
				if($customerID!=0){
					echo "<option value='$customerID' ";
					if(isset($c)&&$c==$customerID){
						echo "selected='selected'";
					}
					echo ">".$customer_data["companyname"]."</option>";
				}
			}
			echo "</select>";	
			//customer
			$ts_salesman_unique_query = mysql_query("SELECT DISTINCT salesmanID FROM tbl_ts_orders WHERE deleted='0' AND processed='0' ORDER BY date DESC");

			echo "<select id='salesman'><option value=''>Select Account Specialist</option>";
			while ($ts_salesman_unique_row=mysql_fetch_assoc($ts_salesman_unique_query)) {
				$salesmanID = $ts_salesman_unique_row["salesmanID"];
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				if($salesmanID!=0){
					echo "<option value='$salesmanID' ";
					if(isset($s)&&$s==$salesmanID){
						echo "selected='selected'";
					}
					echo ">".$salesman_data["salesman_name"]."</option>";
				}				
			}
			echo "</select>";	



			echo "
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>TS #</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Account Specialist</th>
							<th>Terms</th>
							<th>Date Due</th>
							<th></th>
						</tr>
					</thead>
					<tbody>";
					$query = "SELECT * FROM tbl_ts_orders WHERE deleted='0' AND processed='0'";
					if(isset($c)&&$c!=""){
						$query.=" AND customerID='$c'";
					}elseif(isset($s)&&$s!=""){
						$query.=" AND salesmanID='$s'";
					}elseif(isset($d)&&$d!=""){
						$query.=" AND date='$d'";
					}					
					$query.=" ORDER BY date ASC";
					if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
					$maxitem = $maximum_items_displayed; // maximum items
					$limit = ($page*$maxitem)-$maxitem;
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
					$ts_query = mysql_query($query);
					if(mysql_num_rows($ts_query)!=0){
						while($ts_row=mysql_fetch_assoc($ts_query)){
							$ts_orderID=$ts_row["ts_orderID"];
							$date=$ts_row["date"];
							$customerID=$ts_row["customerID"];
							$need_approve=$ts_row["need_approve"];
							$date_due=$ts_row["date_due"];
							$terms=$ts_row["terms"];
							if($terms==0){
								$terms = "COD";
							}
							$salesmanID=$ts_row["salesmanID"];
							$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
							$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
							echo "
							<tr>
								<td><a href='sales-ts-complete?id=$ts_orderID'>$ts_orderID</td>
								<td>".date("m/d/Y",$date)."</td>
								<td>".$customer_data["companyname"]."</td>
								<td>".$salesman_data["salesman_name"]."</td>
								<td>".$terms."</td>
								<td>".date("m/d/Y",$date_due)."</td>";

								if($need_approve==1){
									echo '<td>This Transaction Sheet Needs Approval.</td>';
									// echo '<td><a href="#" id="'.$ts_orderID.'" class="dr_request" >Request to Make DR</a></td>';
								}else{
									echo "<td><a id='$ts_orderID' class='process'>Make Delivery Receipt</a></td>";
								}
							echo "</tr>
							";
						}
					}
					echo "</tbody>
				</table>";
			echo "
		<div class='text-center'>
			<ul class='pagination prints'>
			
			";
			if(isset($c)){
				$url = "?c=$c&";
			}elseif(isset($d)){
				$url = "?d=$d&";
			}elseif(isset($s)){
				$url = "?s=$s&";
			}else{
				$url = "?";
			}
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


			echo "</div>
			";
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


