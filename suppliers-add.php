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
  <title><?php echo $app_name; ?> - Add Suppliers</title>
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
  <script src="jquery-ui.js"></script><script type="text/javascript" src="js/shortcut.js"></script>
  <style>
  .item:hover{
	  cursor:pointer;
  }
  </style>
  <script>
		$(document).ready(function(){

    $("#Suppliers").addClass("active");
  });
  </script>
    <style>
	
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
  	<div class='col-md-12 prints'>
	
	<?php
	if($logged==1||$logged==2){
	if($customers=='1'){
if(isset($_POST["submit"])){
		$supplier_name = mysql_real_escape_string(htmlspecialchars(trim($_POST["supplier_name"])));
		$supplier_address = mysql_real_escape_string(htmlspecialchars(trim($_POST["supplier_address"])));
		$supplier_company = mysql_real_escape_string(htmlspecialchars(trim($_POST["supplier_company"])));
		$supplier_number = mysql_real_escape_string(htmlspecialchars(trim($_POST["supplier_number"])));
		$searchquery = mysql_query("SELECT * FROM tbl_suppliers WHERE supplier_name='$supplier_name' AND supplier_company='$supplier_company' AND deleted = '0'");
		if(mysql_num_rows($searchquery)<1){
		mysql_query("INSERT INTO tbl_suppliers VALUES ('','$supplier_name','$supplier_company','$supplier_number','$supplier_address','0','','')");
		
		echo "
				<div class = 'alert alert-success alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>$supplier_company</strong> is successfuly saved.
				</div>
		
		";
		}else{
		echo "
				<div class = 'alert alert-danger alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>$supplier_company</strong> is already added.
				</div>
		
		";	
		}
		
	}
	?>
	<form action="suppliers-add" method='post' class='form-horizontal'>	
	<div class='col-md-2'>
			<span><b>Controls:</b></span>	

	<button class='btn btn-primary btn-block' type='submit' name='submit'><span class='glyphicon glyphicon-floppy-disk'></span> Save
	</button>
	</div>
	<div class='col-md-10'>

	<div class='form-group'>
		<label for="supplier_name" class='col-md-3'>Supplier's Name:</label>
	<div class='col-md-9'>
		<input type='text' class='form-control' name='supplier_name' placeholder="Supplier's Name">
	</div>
	</div>
	
	<div class='form-group'>
		<label for="supplier_company" class='col-md-3'>Supplier's Company:</label>
	<div class='col-md-9'>
		<input type='text' class='form-control' name='supplier_company' placeholder="Supplier's Company Name" required='required'>
	</div>
	</div>
	
	<div class='form-group'>
		<label for="supplier_number" class='col-md-3'>Contact Number:</label>
	<div class='col-md-9'>
		<input type='number' class='form-control' name='supplier_number' placeholder='Contact Number'>
	</div>
	</div>

	<div class='form-group'>
		<label for="supplier_address" class='col-md-3'>Supplier's Address:</label>
	<div class='col-md-9'>
		<input type='text' class='form-control' name='supplier_address' placeholder="Supplier's Address">
	</div>
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
<?php mysql_close($connect);?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>