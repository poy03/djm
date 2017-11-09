
<?php

// $order=$_GET['"wala ko knows"'];
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
// echo strtotime(date("m/d/Y"));
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title><?php echo $app_name; ?> - Home</title>
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
  
  <script src="jquery-ui.js"></script><script type="text/javascript" src="js/shortcut.js"></script>
 <link rel="stylesheet" href="css/balloon.css"><link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>
  <style>
  .item:hover{
	  cursor:pointer;
  }
  .popover{
    width:100%;   
}
  </style>
  <script>
		$(document).ready(function(){

  
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
  	<div class='col-md-12 prints'>
	
	
	<?php
	if($logged==1||$logged==2){

	?>

		<div class='jumbotron' style='padding-top:5px;'>
			<h2 style='text-align:center;'><b>Welcome to <?php echo "$app_name, $employee_name!";?></b></h2>
			<div class='row text-center' style='font-size:150%;'>
			
			<?php
			function display_modules($module,$badge){
				($badge==0?$badge="":$badge=$badge);
				switch ($module) {
					case 1:
						return "
							 <div class='col-md-3'><a href='item'><br><span class = 'glyphicon glyphicon-briefcase'></span> Items <span class = 'badge'>$badge</span></a>
							 <br>
							 - View Items<br>
							 - Add Items<br>
							 - Edit Items<br>
							 - Delete Items
							 </div>
						";
						# code...
						break;
					case 2:
						return "
							 <div class='col-md-3'><a href='customer'><br><span class = 'glyphicon glyphicon-user'></span> Customers</a>
							 <br>
							 - View Customers<br>
							 - Add Customers<br>
							 - Edit Customers<br>
							 - Delete Customers
							 </div>	
						";
						# code...
						break;
					case 3:
					return "
						<div class='col-md-3'><a href='sales'><br><span class = 'glyphicon glyphicon-shopping-cart'></span> Sales <span class = 'badge'>$badge</span></a>
						<br>
						- Add Sales<br>
						- Edit Sales<br>
						- Cancel Sales<br>
						- Receive Payments
						</div> ";
						# code...
						break;
					case 4:
					return "
						<div class='col-md-3'><a href='salesman'><br><span class = 'glyphicon glyphicon-user'></span> Salesman</a>
						<br>
						- Add Salesman<br>
						- Edit Salesman<br>
						- Cancel Salesman<br>
						</div> ";
						# code...
						break;						
					case 5:
						return "
						 <div class='col-md-3'><a href='receiving'><br><span class = 'glyphicon glyphicon-download-alt'></span> Purchases <span class = 'badge'>$badge</span></a>
						 			 <br>
						 - Receive Items<br>
						 - Restock Items
						 </div>	
						 ";					

							# code...
							break;
					case 6:
						return "
						 <div class='col-md-3'><a href='users'><br><span class = 'glyphicon glyphicon-user'></span> Users</a>
						 <br>
						 - Add Users<br>
						 - Edit Users<br>
						 - Delete Users
						 </div>	
						";
						# code...
						break;
					case 7:
						return "
						 <div class='col-md-3'><a href='reports'><br><span class = 'glyphicon glyphicon-stats'></span> Reports <span class = 'badge'>$badge</span></a>
						 <br>
						 - View Expenses<br>
						 - View Receiving Cost<br>
						 - View Sales<br>
						 - View Reports
						 </div>	
						";					

						# code...
						break;
					case 8:
						return "
							<div class='col-md-3'><a href='suppliers'><br><span class='glyphicon glyphicon-phone'></span> Suppliers</a>
							<br>
							- View Suppliers<br>
							- Add Suppliers<br>
							- Edit Suppliers<br>
							- Delete Suppliers
							</div>
						";					

						# code...
						break;
					case 9:
						return "
						 <div class='col-md-3'><a href='credits'><br><span class = 'glyphicon glyphicon-copyright-mark'></span> Accounts Receivable <span class = 'badge'>$badge</span></a>
						 			 <br>
						 - Manage Accounts Receivable<br>
						 - View Past Due Accounts Receivable<br>
						 - Receive Payments
						 </div>	
						";
						# code...
						break;
					case 10:
						return "
						 <div class='col-md-3'><a href='expenses'><br><span class = 'glyphicon glyphicon-list-alt'></span> Expenses</a>
						 <br>
						 - Add Expenses<br>
						 - Edit Expenses<br>
						 - Delete Expenses
						 </div>
						";
						# code...
						break;
					case 11:
						return "
						 <div class='col-md-3'><a href='accounts-payable'><br><span class = 'glyphicon glyphicon-pushpin'></span> Accounts Payable</a>
						 <br>
						 - Manage Accounts Payable<br>
						 - View Past Due Accounts Payable
						 </div>
						";					
					case 12:
						return "
						 <div class='col-md-3'><a href='maintenance'><br><span class = 'glyphicon glyphicon-hdd'></span> Maintenance</a>
						 <br>
						 - Backups Data<br>
						 - Restore Data<br>
						 - Delete a Backups<br>
						 - Download a Backups<br>
						 </div>
						";
						# code...
						break;
					case 13:
						return "
						 <div class='col-md-3'><a href='settings'><br><span class = 'glyphicon glyphicon-cog'></span> Settings</a>
						 <br>
						 - Edit Preferences<br>
						 - Edit Application Name<br>
						 - Edit Company Name<br>
						 - Edit Payment Types
						 </div>
						";
						# code...
						break;
					default:
						return "";
						# code...
						break;
				}
			}
			// echo $total_modules;

			for ($i=0; $i < $total_modules; $i++) { //change to zero
				// echo "$i";
				if($i%4==0){
					echo "<div class='row'>";
					// echo "row";
					// echo "<br>";
					// echo "</div>";
					// echo display_modules($i,1);
				}
				if($list_modules[$i]==1){
					$badge_arg = $badge_items;
				}elseif($list_modules[$i]==3){
					$badge_arg = $badge_sales;
				}elseif($list_modules[$i]==7){
					$badge_arg = $badge_reports;
				}elseif($list_modules[$i]==9){
					$badge_arg = $badge_credit;
				}else{
					$badge_arg = 0;
				}
				echo display_modules($list_modules[$i],$badge_arg);
				if($i%4==3){
					// echo "<div class='row'>";
					echo "</div>";
					// echo "end row";
					// echo "<br>";
				}
				if($i==$total_modules-1){
					echo "</div>";
				}
			}


			?>



		</div>
	
	<?php
	}else{

	$user_query = mysql_query("SELECT * FROM tbl_users WHERE deleted='0'");
	if(mysql_num_rows($user_query)!=0){
		echo "
		<div class='col-md-5 col-md-offset-3'>
			<label>Login:</label>
			<form action='login' role='form' method='post'>
			<input type='text' name='username' placeholder='Login Name' class='form-control'>
			<input type='Password' name='password' placeholder='Password' class='form-control'>
			<div class='checkbox'>
				<label><input type='checkbox' name='remember'> Remember Me</label>
			</div>
			<button class='btn btn-primary' name='login' type='submit'>Login
			</button>
			</form>		
		</div>
		";
		
	}else{
		header("location:setup");
	}
	?>

	<?php 
	} ?>
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