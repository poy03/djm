<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$id=@$_GET['id'];
$t=@$_GET['t'];
$f=@$_GET['f'];
$s=@$_GET['s'];
$c=@$_GET['c'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Sales Reports</title>
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
    <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  

  <style>
  .item:hover{
	  cursor:pointer;
  }
  
  </style>
  <script>
		$(document).ready(function(){
			$(".return").click(function(e){
				// alert(e.target.id);
				var dataStr = "id="+e.target.id+"&return=1";
				$.ajax({
					type: 'POST',
					url: 'sales-return',
					data: dataStr,
					cache: false,
					success: function(){
						location.reload();
					}
				});
			});
			$("#Reports").addClass("active");
			$("#salesman").change(function(){
				var f = $("#f").val();
				var t = $("#t").val();
				var c = $("#c").val();
				var s = $(this).val();
				window.location = "?f="+f+"&t="+t+"&s="+s+"&c="+c;
			});
			$("#customer").change(function(){
				var f = $("#f").val();
				var t = $("#t").val();
				var c = $(this).val();
				var s = $("#s").val();
				window.location = "?f="+f+"&t="+t+"&s="+s+"&c="+c;
			});
			$("#date_from").datepicker();
			$("#date_to").datepicker();
			$("#by").change(function(){
				var date_from = $("#date_from").val();
				var date_to = $("#date_to").val();
				var by = $(this).val();
				window.location= "reports?by="+by+"&f="+date_from+"&t="+date_to;
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
	
	
	<?php
	if($logged==1||$logged==2){
	if($reports=='1'){
		if(mysql_num_rows(mysql_query("SELECT * FROM tbl_sales_edit WHERE editID='$id'"))==0){
			header("location:success");
		}
		$edit_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_sales_edit WHERE editID='$id'"));
		$approved_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$edit_data["approved_by"]."'"));
		$deleted_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$edit_data["deleted_by"]."'"));
		$edited_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$edit_data["accountID"]."'"));
		$edited_by = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='".$edit_data["accountID"]."'"));

		if($edit_data["approved_by"]!=0){
			$status = "Approved";
			$status_by = $approved_by["employee_name"];
			$status_date = date("m/d/Y",$edit_data["date_approved"]);
		}elseif($edit_data["deleted_by"]!=0){
			$status = "Deleted";
			$status_by = $deleted_by["employee_name"];
			$status_date = date("m/d/Y",$edit_data["date_deleted"]);
		}else{
			$status = "";
		}
		echo "
		<div class='table-reponsive'>
		Request #: $id<br>
		DR #: <a href='sales-complete?id=".$edit_data["orderID"]."'>".$edit_data["orderID"]."</a><br>
		Edited By: ".$edited_by["employee_name"]."<br>
		Date Edited: ".date("m/d/Y",$edit_data["date"])."<br>";
		if($edit_data["approved_by"]!=0||$edit_data["deleted_by"]!=0){
			echo "
			$status By: ".$status_by."<br>
			Date $status: ".$status_date."<br>
			";
		}

		echo "
			<table class='table table-reponsive'>
				<thead>
					<tr>
						<th>Item</th>
						<th>Quantity</th>
						<th>Returned Quantity</th>
						<th style='text-align:right'>Price</th>
						<th style='text-align:right'>Line Total</th>
					</tr>
				</thead>
				<tbody>";
				$edit_query = mysql_query("SELECT * FROM tbl_sales_edit_items WHERE editID='$id'");

				if(mysql_num_rows($edit_query)!=0){
					$total = 0;
					while($edit_row=mysql_fetch_assoc($edit_query)){
						$editID = $edit_row["editID"];
						$itemID = $edit_row["itemID"];
						$price = $edit_row["price"];
						$new_quantity = $edit_row["new_quantity"];
						$quantity = $edit_row["quantity"];
						$returned = $quantity - $new_quantity;
						$total += ($price*$new_quantity);
						$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
						echo "
						<tr>
							<td>".$item_data["itemname"]."</td>
							<td>".$quantity."</td>
							<td>".$new_quantity."</td>
							<td style='text-align:right'>".number_format($price,2)."</td>
							<td style='text-align:right'>".number_format($price*$new_quantity,2)."</td>
						</tr>
						";
					}
				}
				echo "</tbody>
				<tfoot>";
					if(mysql_num_rows($edit_query)!=0){
						echo "
							<tr>
								<th style='text-align:right' colspan='3'>Total<th>
								<th style='text-align:right'>".number_format($total,2)."<th>
							</tr>
						";
					}
				echo "</tfoot>
			</table>
			</table>
		</div>
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