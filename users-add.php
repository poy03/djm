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
  <title><?php echo $app_name; ?> - Add Users</title>
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
  <link rel="stylesheet" href="css/theme.default.min.css">
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>   <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <style>
  .item:hover{
	  cursor:pointer;
  }
  
  </style>
  <script>
  $(document).ready(function(){
  	$("#Users").addClass("active");
	   $("#myTable").tablesorter();
	   $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} );
$("#add").click(function(){
	window.location = "users-add";
});

$("#type").change(function(){
	var type=$(this).val();
	if(type=='user'){
		$(":checkbox").each(function(){
			this.checked = false;
			$(".module").removeAttr("disabled");			
		});
	}else{
		$(":checkbox").each(function(){
			this.checked = true;    
			$(".module").attr("disabled","disabled");			
		});
	}
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
	if($users=='1'){
	if(isset($_POST["edit"])){
		$x = array();
		$x = $_POST["select"];
		$_SESSION["selectusers"]=$x;
		header("location:users-edit");
	}


	if(isset($_POST["delete"])){
		$x = array();
		$x = @$_POST["select"];
		$_SESSION["selectusers"]=$x;
		if($x!=NULL){ 
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				 var conf = confirm("Are you sure you want to delete selected items?");
				 if(conf==true){
					 window.location="users-delete";
				 }
			});
		</script>
		<?php

		}
	}
	if(isset($_POST["save"])){
		$type = $_POST["type"];
		$username = mysql_real_escape_string(htmlspecialchars(trim($_POST["username"])));
		$password = mysql_real_escape_string(htmlspecialchars(trim($_POST["password"])));
		$name = mysql_real_escape_string(htmlspecialchars(trim($_POST["name"])));
		$items = @$_POST["items"];
		$customers = @$_POST["customers"];
		$sales = @$_POST["sales"];
		$receiving = @$_POST["receiving"];
		$users = @$_POST["users"];
		$reports = @$_POST["reports"];
		$expenses = @$_POST["expenses"];
		$suppliers = @$_POST["suppliers"];
		$credits = @$_POST["credits"];
		$items_modify = @$_POST["items_modify"];
		$customers_modify = @$_POST["customers_modify"];
		$suppliers_modify = @$_POST["suppliers_modify"];
		$users_modify = @$_POST["users_modify"];
		$salesman_modify = @$_POST["salesman_modify"];
		$salesman = @$_POST["salesman"];
		$items_add = @$_POST["items_add"];
		$customers_add = @$_POST["customers_add"];
		$suppliers_add = @$_POST["suppliers_add"];
		$users_add = @$_POST["users_add"];
		$salesman_add = @$_POST["salesman_add"];		
		$items_quantity = @$_POST["items_quantity"];
		$items_delete = @$_POST["items_delete"];
		$customers_delete = @$_POST["customers_delete"];
		$suppliers_delete = @$_POST["suppliers_delete"];
		$users_delete = @$_POST["users_delete"];
		$salesman_delete = @$_POST["salesman_delete"];
		$receiving_modify = @$_POST["receiving_modify"];
		if($type=='admin'){
			$items = $items_modify = $items_add = $customers = $customers_modify = $customers_add = $sales = $receiving = $users = $users_modify = $users_add = $reports = $suppliers = $suppliers_modify = $suppliers_add = $credits = $salesman = $salesman_modify = $salesman_add = $expenses = $accounts_payable = $payroll = '1';
		}
		$searchquery = mysql_query("SELECT * FROM tbl_users WHERE username='$username' AND deleted='0'");
		if(mysql_num_rows($searchquery)==0){
			mysql_query("INSERT INTO tbl_users (
				accountID,
				username,
				password,
				type,
				employee_name,
				themes,
				deleted,
				items,
				customers,
				sales,
				receiving,
				users,
				reports,
				suppliers,
				credits,
				expenses,
				items_modify,
				customers_modify,
				suppliers_modify,
				users_modify,
				salesman,
				salesman_modify,
				items_add,
				customers_add,
				suppliers_add,
				users_add,
				salesman_add,
				accounts_payable,
				payroll,
				display,
				items_quantity,
				items_delete,
				customers_delete,
				suppliers_delete,
				users_delete,
				salesman_delete,
				receiving_modify
			) VALUES(
				'',
				'$username',
				'".md5($password)."',
				'$type',
				'$name',
				'',
				'',
				'$items',
				'$customers',
				'$sales',
				'$receiving',
				'$users',
				'$reports',
				'$suppliers',
				'$credits',
				'$expenses',
				'$items_modify',
				'$customers_modify',
				'$suppliers_modify',
				'$users_modify',
				'$salesman',
				'$salesman_modify',
				'$items_add',
				'$customers_add',
				'$suppliers_add',
				'$users_add',
				'$salesman_add',
				'$payroll',
				'$accounts_payable',
				'1',
				'$items_quantity',
				'$items_delete',
				'$customers_delete',
				'$suppliers_delete',
				'$users_delete',
				'$salesman_delete',
				'$receiving_modify'
			)");
			header("location:users");
		}else{
					echo "
				<div class = 'alert alert-danger alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
				   <center><strong>$username</strong> is already exist.<center>
				</div>
				";
		}
	}
	?>
	
	
	<form action='users-add' method='post' class='form-horizontal'>
	<div class='col-md-2'>
		<span><b>Controls:</b></span>	
	<button class='btn btn-primary btn-block' name='save'><span class='glyphicon glyphicon-floppy-disk'></span> Save</button>
	</div>
	<div class='col-md-10' >
	
	<div class='form-group'>
	<label for='type' class='col-md-2'>Previlages:</label>
	<div class='col-md-10'>
	<select class='form-control' name='type' id='type'>
		<option value='user'>User</option>
		<option value='admin'>Admin</option>
	</select>
	</div>
	</div>
	
	
	<div class='form-group'>
	<label for='username' class='col-md-2'>Username:</label>
	<div class='col-md-10'>
	<input type='text' name='username' placeholder='Username' class='form-control' autocomplete="off" required='required'>
	</div>
	</div>
	
	<div class='form-group'>
	<label for='password' class='col-md-2'>Password:</label>
	<div class='col-md-10'>
	<input type='password' name='password' placeholder='Password' class='form-control' autocomplete="off" required='required'>
	</div>
	</div>
	
	<div class='form-group'>
	<label for='name' class='col-md-2'>Full Name:</label>
	<div class='col-md-10'>
	<input type='text' name='name' placeholder='Full Name' class='form-control' autocomplete="off" required='required'>
	</div>
	</div>	
	
	<div id='admin'>
	<span><b>Access to modules:</b></span>
	<div class='row'>
	<div class="checkbox col-md-2">
      <label><input type='checkbox' name='items' value='1' class='module'>Items</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='items_add' value='1' class='module'>Add Items</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='items_modify' value='1' class='module'>Modify Items</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='items_delete' value='1' class='module'>Delete Items</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='items_quantity' value='1' class='module'>Modify Quantity</label>
    </div>
	<div class="checkbox col-md-2">
      <label><input type='checkbox' name='customers' value='1' class='module'>Customers</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='customers_add' value='1' class='module'>Add Customers</label>
      <br>      
      &nbsp;&nbsp;<label><input type='checkbox' name='customers_modify' value='1' class='module'>Modify Customers</label>
      <br>      
      &nbsp;&nbsp;<label><input type='checkbox' name='customers_delete' value='1' class='module'>Delete Customers</label>      
    </div>
	<div class="checkbox col-md-2">
      <label><input type='checkbox' name='sales' value='1' class='module'>Sales</label>
    </div>
		<div class="checkbox col-md-2">
	      <label><input type='checkbox' name='salesman' value='1' class='module'>Salesman</label>
	      <br>
	      &nbsp;&nbsp;<label><input type='checkbox' name='salesman_add' value='1' class='module'>Add Salesman</label>
	      <br>      
	      &nbsp;&nbsp;<label><input type='checkbox' name='salesman_modify' value='1' class='module'>Modify Salesman</label>
	      <br>      
	      &nbsp;&nbsp;<label><input type='checkbox' name='salesman_delete' value='1' class='module'>Delete Salesman</label>      
	    </div>
	<div class="checkbox col-md-2">
      <label><input type='checkbox' name='suppliers' value='1' class='module'>Suppliers</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='suppliers_add' value='1' class='module'>Add Suppliers</label>
      <br>      
      &nbsp;&nbsp;<label><input type='checkbox' name='suppliers_modify' value='1' class='module'>Modify Suppliers</label>
      <br>      
      &nbsp;&nbsp;<label><input type='checkbox' name='suppliers_delete' value='1' class='module'>Delete Suppliers</label>      
    </div>
	<div class="checkbox col-md-2">
      <label><input type='checkbox' name='users' value='1' class='module'>Users</label>
      <br>
      &nbsp;&nbsp;<label><input type='checkbox' name='users_add' value='1' class='module'>Add Users</label>
      <br>      
      &nbsp;&nbsp;<label><input type='checkbox' name='users_modify' value='1' class='module'>Modify Users</label>
      <br>      
      &nbsp;&nbsp;<label><input type='checkbox' name='users_delete' value='1' class='module'>Delete Users</label>      
    </div>
    </div>
    <hr>
	<div class='row'>
	<div class="checkbox col-md-2">
      <label>	<input type='checkbox' name='reports' value='1' class='module'>Reports</label>
    </div>
	<div class="checkbox col-md-2">
      <label>	<input type='checkbox' name='credits' value='1' class='module'>Accounts Receivable</label>
    </div>
	<div class="checkbox col-md-2">
      <label><input type='checkbox' name='expenses' value='1' class='module'>Expenses</label>
    </div>
	<div class="checkbox col-md-2">
		<label><input type='checkbox' name='receiving' value='1' class='module'>Receiving</label>
		<br>      
		&nbsp;&nbsp;<label><input type='checkbox' name='receiving_modify' value='1' class='module'>Modify Receiving</label>      
	</div> 
	<div class="checkbox col-md-2">
		<label><input type='checkbox' name='accounts_payable' value='1' class='module'>Accounts Payable</label>
	</div> 
	<div class="checkbox col-md-2">
		<label><input type='checkbox' name='payroll' value='1' class='module'>Payroll</label>
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
<?php mysql_close($connect); ?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>