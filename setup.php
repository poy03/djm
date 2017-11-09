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
  
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <style>
  .item:hover{
	  cursor:pointer;
  }
  .popover{
    width:100%;   
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
	<form action='setup' method='post' class='form-horizontal' enctype='multipart/form-data'>
  	<div class='col-md-2 prints'>
	<?php
	
		if(isset($_POST["save"])){
			$username = $_POST["username"];
			$password = $_POST["password"];
			$employee_name = $_POST["employee_name"];
			$app_name = $_POST["app_name"];
			$type_payment = $_POST["type_payment"];
			$address = $_POST["address"];
			$contact_number = $_POST["contact_number"];
			$app_company_name = $_POST["app_company_name"];
			$maximum_items_displayed = $_POST["maximum_items_displayed"];
			$file = $_FILES["logo"];
			$themes = $_POST["themes"];
			if(isset($file)&&(	$file["type"]=='image/png' || $file["type"]=='image/jpeg' || $file["type"]=='image/pjpeg' || $file["type"]=='image/gif')){
				
				move_uploaded_file ($file['tmp_name'],$file['name']);
			}
			
			mysql_query("INSERT INTO tbl_users VALUES ('','$username','".md5($password)."','admin','$employee_name','$themes','','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1')");
			mysql_query("UPDATE app_config SET app_company_name='$app_company_name', app_name = '$app_name', type_payment = '$type_payment', address = '$address', contact_number = '$contact_number',maximum_items_displayed='$maximum_items_displayed', logo='".$file['name']."' WHERE id='1'");
		}
	
	$user_query = mysql_query("SELECT * FROM tbl_users WHERE deleted='0'");
	if(mysql_num_rows($user_query)!=0){
	}else{
		echo "<h3 style='text-align:center'>&nbsp;</h3>
		<button class='btn btn-primary btn-block' type='submit' name='save'><span class='glyphicon glyphicon-floppy-disk'></span> Save</butto\n>";
	}
	
	?>
	</div>
	<div class='col-md-10 prints'>
	<?php
	if($logged==1||$logged==2){

		header("location:index");

	}else{

		if(isset($_POST["save"])){
			
			echo "
				<div class = 'alert alert-success alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <strong>Successfuly Saved. Returning to Home in 3 seconds</strong>
				</div>
				";
				header( "Refresh:3; url=index", true, 303);
		}
	
	$user_query = mysql_query("SELECT * FROM tbl_users WHERE deleted='0'");
	if(mysql_num_rows($user_query)!=0){

		header("location:index");
	}else{
		
		
		echo "
		<div class='row'>
			<div class='col-md-7'>
				<h3 style='text-align:center'>Administrator Account Setup</h3>
			</div>
		</div>
		<div class='form-group'>
		<label class='col-md-2'>Login Name:</label>
		<div class='col-md-5'>
		<input type='text' name='username' placeholder='Login Name' class='form-control' required='required'>
		</div>
		</div>

		<div class='form-group'>
		<label class='col-md-2'>Password:</label>
		<div class='col-md-5'>
		<input type='password' name='password' placeholder='Password' class='form-control' required='required'>
		</div>
		</div>

		<div class='form-group'>
		<label class='col-md-2'>Display Name:</label>
		<div class='col-md-5'>
		<input type='text' name='employee_name' placeholder='Display Name or Full Name' class='form-control' required='required'>
		</div>
		</div>";
		
		?>
		
			<div class='row'>
				<div class='col-md-7'>
					<h3 style='text-align:center'>System Preferences</h3>
				</div>
			</div>
			<div class='form-group'>
			<label for='app_name' class='col-md-2'>Application Name:</label>
			<div class='col-md-5'>
			<input type='text' class='form-control' name='app_name' value='<?php			
			echo $app_name; ?>'>
			</div>
			</div>
			
			<div class='form-group'>
			<label for='app_company_name' class='col-md-2'>Company Name:</label>
			<div class='col-md-5'>
			<input type='text' class='form-control' name='app_company_name' value='<?php			
			echo $app_company_name; ?>'>
			</div>
			</div>
			
			
			<div class='form-group'>
			<label for='address' class='col-md-2'>Address:</label>
			<div class='col-md-5'>
			<input type='text' class='form-control' name='address' value='<?php			
			echo $address; ?>'>
			</div>
			</div>
			
			<div class='form-group'>
			<label for='contact_number' class='col-md-2'>Contact Number:</label>
			<div class='col-md-5'>
			<input type='text' class='form-control' name='contact_number' value='<?php			
			echo $contact_number; ?>'>
			</div>
			</div>
			
			<div class='form-group'>
			<label for='type_of_payments' class='col-md-2'>Type of Payments:</label>
			<div class='col-md-5'>
			<input type='text' class='form-control' name='type_payment' value='<?php			
			echo $type_payment; ?>'>
			<i style='font-size:75%;'>* Separated by Commas(,).</i>
			</div>
			</div>
			
			<div class='form-group'>
			<label for='type_of_payments' class='col-md-2'>Maximum Items Displayed:</label>
			<div class='col-md-5'>
			<input type='number' min='0' max='100000' class='form-control' name='maximum_items_displayed' value='<?php			
			echo $maximum_items_displayed; ?>'>
			<i style='font-size:75%;'>* Applies in all table.</i>
			
			</div>
			</div>
			
			<div class='form-group'>
			<label for='type_of_payments' class='col-md-2'>Logo:</label>
			<div class='col-md-5'>
			<input type='file' name='logo' accept="image/*">
			<i style='font-size:75%;'>* .JPG,.PNG,.GIF Allowed.</i>
			
			</div>
			</div>
			
			
		<?php
		echo "
		<div class='form-group'>
		<label class='col-md-2'>Theme:</label>
		<div class='col-md-5'>
			<select name='themes' class='form-control'>
				<option value='bootstrap.min.css'>Default Theme</option>
				<option value='cosmo-bootstrap.min.css'>Cosmo Theme</option>
				<option value='cerulean-bootstrap.min.css'>Cerulean Theme</option>
				<option value='simplex-bootstrap.min.css'>Simplex Theme</option>
				<option value='lumen-bootstrap.min.css'>Lumen Theme</option>
				<option value='flatly-bootstrap.min.css'>Flatly Theme</option>
				<option value='sandstone-bootstrap.min.css'>Sandstone Theme</option>
				<option value='united-bootstrap.min.css'>United Theme</option>
				<option value='spacelab-bootstrap.min.css'>Spacelab Theme</option>
			</select>
		</div>
		</div>
		";
	}
	?>


	<?php 
	} ?>
	</div>
	</form>
  </div>
</div>
</body>
</html>
<?php mysql_close($connect);?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>