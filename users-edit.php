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
  <title><?php echo $app_name; ?> - Edit Users</title>
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
  	$("#Users").addClass("active");

		
  });
  </script>
    <style>

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
	if(isset($_POST["save"])&&isset($_SESSION["selectusers"])){
		$x = array();

		$x = $_SESSION["selectusers"];

		$type = $_POST["type"];
		$employee_name = $_POST["employee_name"];
		$expenses = $_POST["expenses"];
		$sales = $_POST["sales"];
		$receiving = $_POST["receiving"];
		$reports = $_POST["reports"];
		$expenses = $_POST["expenses"];
		$accounts_payable = $_POST["accounts_payable"];
		$payroll = $_POST["payroll"];
		$credits = $_POST["credits"];
		$dbpassword = $_POST["password"];
		$dbusername = $_POST["username"];
		$items = $_POST["items"];
		$items_add = $_POST["items_add"];
		$items_modify = $_POST["items_modify"];
		$customers = $_POST["customers"];
		$customers_add = $_POST["customers_add"];
		$customers_modify = $_POST["customers_modify"];
		$users = $_POST["users"];
		$users_add = $_POST["users_add"];
		$users_modify = $_POST["users_modify"];
		$suppliers = $_POST["suppliers"];
		$suppliers_add = $_POST["suppliers_add"];
		$suppliers_modify = $_POST["suppliers_modify"];
		$salesman = $_POST["salesman"];		
		$salesman_add = $_POST["salesman_add"];		
		$salesman_modify = $_POST["salesman_modify"];		
		$i = 0;
		
		foreach($x as $itemID){
			if($type[$i]=='admin'){
				$items[$i] = $items_add[$i] = $items_modify[$i] = $customers[$i] = $customers_add[$i] = $customers_modify[$i] = $sales[$i] = $receiving[$i] = $users[$i] = $users_add[$i] = $users_modify[$i] = $reports[$i] = $suppliers[$i] = $suppliers_add[$i] = $suppliers_modify[$i] = $credits[$i] = $salesman[$i] = $salesman_modify[$i] = $salesman_add[$i] = $expenses[$i] = $accounts_payable[$i] = $payroll[$i] = '1';
			}

			$searchquery = mysql_query("SELECT * FROM tbl_users WHERE username='$dbusername[$i]' AND deleted='0' AND accountID!='$itemID'");
			if(mysql_num_rows($searchquery)<1){//if username(s) has existed in the database exluding deleted users then update users.
				if($dbpassword[$i]!=""){ //if password textbox has a value then update the password of the user.
				mysql_query("UPDATE tbl_users SET
				password='".md5(mysql_real_escape_string(htmlspecialchars(trim($dbpassword[$i]))))."',
				username='".mysql_real_escape_string(htmlspecialchars(trim($dbusername[$i])))."',
				type='$type[$i]',
				employee_name='".mysql_real_escape_string(htmlspecialchars(trim($employee_name[$i])))."',
				sales='$sales[$i]',
				receiving='$receiving[$i]',
				credits='$credits[$i]',
				items='$items[$i]',
				items_add='$items_add[$i]',
				items_modify='$items_modify[$i]',
				customers='$customers[$i]',
				customers_add='$customers_add[$i]',
				customers_modify='$customers_modify[$i]',
				salesman='$salesman[$i]',
				salesman_add='$salesman_add[$i]',
				salesman_modify='$salesman_modify[$i]',
				users='$users[$i]',
				users_add='$users_add[$i]',
				users_modify='$users_modify[$i]',
				suppliers='$suppliers[$i]',				
				suppliers_add='$suppliers_add[$i]',				
				suppliers_modify='$suppliers_modify[$i]',				
				accounts_payable='$accounts_payable[$i]',				
				payroll='$payroll[$i]',				
				expenses='$expenses[$i]',				
				reports='$reports[$i]'
				WHERE accountID = '$itemID'");
				}else{//if password textbox has a value then do not update the password of the user.
				mysql_query("UPDATE tbl_users SET
				username='".mysql_real_escape_string(htmlspecialchars(trim($dbusername[$i])))."',
				type='$type[$i]',
				employee_name='".mysql_real_escape_string(htmlspecialchars(trim($employee_name[$i])))."',
				sales='$sales[$i]',
				receiving='$receiving[$i]',
				credits='$credits[$i]',
				items='$items[$i]',
				items_add='$items_add[$i]',
				items_modify='$items_modify[$i]',
				customers='$customers[$i]',
				customers_add='$customers_add[$i]',
				customers_modify='$customers_modify[$i]',
				salesman='$salesman[$i]',
				salesman_add='$salesman_add[$i]',
				salesman_modify='$salesman_modify[$i]',
				users='$users[$i]',
				users_add='$users_add[$i]',
				users_modify='$users_modify[$i]',
				suppliers='$suppliers[$i]',				
				suppliers_add='$suppliers_add[$i]',				
				suppliers_modify='$suppliers_modify[$i]',				
				accounts_payable='$accounts_payable[$i]',				
				payroll='$payroll[$i]',				
				expenses='$expenses[$i]',				
				reports='$reports[$i]'
				WHERE accountID = '$itemID'");
				}
			}

			$i++;
		}
			echo "
				<div class = 'alert alert-success alert-dismissable'>
				   <button type = 'button' class = 'close' data-dismiss = 'alert' aria-hidden = 'true'>
					  &times;
				   </button>
					
				   <center><strong>Saved!</strong> Selected Users are updated.<a href='users'>Back to Users.</a></center>
				</div>
				";
				unset($_SESSION["selectusers"]);
				exit;
	}
	?>
	<form action="users-edit" method='post'>


	<div class='table-responsive col-md-12'>
	<table class='table'>
	 <thead>
	  <tr>
	   <th>Previlages</th>
	   <th>Display Name</th>
	   <th>Login Name</th>
	   <th>Password</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Items</th>
	   <th>Add Items</th>
	   <th>Modify Items</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Customers</th>
	   <th>Add Customers</th>
	   <th>Modify Customers</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Users</th>
	   <th>Add Users</th>
	   <th>Modify Users</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Suppliers</th>
	   <th>Add Suppliers</th>
	   <th>Modify Suppliers</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Salesman</th>
	   <th>Add Salesman</th>
	   <th>Modify Salesman</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Sales</th>	   
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Receiving</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Reports</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Accounts Receivable</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Expenses</th>
	   <th style="border-left-style: solid;border-left-width: 1px;border-left-color: black;">Accounts Payable</th>
	   <th style='border-left-style: solid;border-left-width: 1px;border-left-color: black;border-right-style: solid;border-right-width: 1px;border-right-color: black;'>Payroll</th>

	  </tr>
	 </thead>
	 <tbody>
	 <?php
		if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
		$maxitem = 50; // maximum items
		$limit = ($page*$maxitem)-$maxitem;
	 $query = "SELECT * FROM tbl_users";
	 $x = $_SESSION["selectusers"];
	 //var_dump($x);
	 if($x!=NULL){
	 $cnt = 0;
	 foreach($x as $dbaccountID){
		 if($cnt==0){
			 $query.=" WHERE accountID = $dbaccountID";
		 }else{
			 $query.=" OR accountID = $dbaccountID";
		 }
		 $cnt++;
	 }
	 }else{
		 header("location:users");
	 }

	 $query.=" ORDER BY accountID";
	 $numitemquery = mysql_query($query);
	 $numitem = mysql_num_rows($numitemquery);
	 //echo $query;
	 
	 $itemquery = mysql_query($query);
	 if(mysql_num_rows($itemquery)!=0){
		 while($itemrow=mysql_fetch_assoc($itemquery)){
			 $dbusername = $itemrow["username"];
			 $dbpassword = $itemrow["password"];
			 $dbtype = $itemrow["type"];
			 $dbemployee_name = $itemrow["employee_name"];
			 $dbsales = $itemrow["sales"];
			 $dbreceiving = $itemrow["receiving"];
			 $dbreports = $itemrow["reports"];
			 $dbcredits = $itemrow["credits"];
			 $dbexpenses = $itemrow["expenses"];
			 $dbaccounts_payable = $itemrow["accounts_payable"];
			 $dbpayroll = $itemrow["payroll"];

			 $dbitems = $itemrow["items"];
			 $dbcustomers = $itemrow["customers"];
			 $dbsuppliers = $itemrow["suppliers"];
			 $dbusers = $itemrow["users"];
			 $dbsalesman = $itemrow["salesman"];

			 $dbitems_add = $itemrow["items_add"];
			 $dbcustomers_add = $itemrow["customers_add"];
			 $dbsuppliers_add = $itemrow["suppliers_add"];
			 $dbusers_add = $itemrow["users_add"];
			 $dbsalesman_add = $itemrow["salesman_add"];


			 $dbitems_modify = $itemrow["items_modify"];
			 $dbcustomers_modify = $itemrow["customers_modify"];
			 $dbsuppliers_modify = $itemrow["suppliers_modify"];
			 $dbusers_modify = $itemrow["users_modify"];
			 $dbsalesman_modify = $itemrow["salesman_modify"];

			 if($dbtype=='user'){
				 $state = "selected='selected'";
				 
			 }else{
				 $state = '';
			 }
			 echo "
			 <tr>
			  <td>
			  <select class='tbl_row' name='type[]'>
				<option value='admin'>Admin</option>
				<option value='user' $state>User</option>
			  </select>
			  </td>";
			  echo '
			  <td><input type="text" name="employee_name[]" value="'.$dbemployee_name.'" required="required"></td>
			  <td><input type="text" name="username[]" value="'.$dbusername.'" required="required" autocomplete="off"></td>
			  ';
			  echo "
			  <td><input type='text' name='password[]' value='' autocomplete='off'></td>
			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='items[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbitems=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td>
			  <select class='tbl_row' name='items_add[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbitems_add=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>


			  <td>
			  <select class='tbl_row' name='items_modify[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbitems_modify=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
				  
			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='customers[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbcustomers=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td>
			  <select class='tbl_row' name='customers_add[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbcustomers_add=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td>
			  <select class='tbl_row' name='customers_modify[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbcustomers_modify=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='users[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbusers=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td>
			  <select class='tbl_row' name='users_add[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbusers_add=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td>
			  <select class='tbl_row' name='users_modify[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbusers_modify=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>





			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='suppliers[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsuppliers=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
							  				  			  
			  
			  <td>
			  <select class='tbl_row' name='suppliers_add[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsuppliers_add=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
			  
			  <td>
			  <select class='tbl_row' name='suppliers_modify[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsuppliers_modify=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>



			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='salesman[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsalesman=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
							  				  			  
			  
			  <td>
			  <select class='tbl_row' name='salesman_add[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsalesman_add=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
			  
			  <td>
			  <select class='tbl_row' name='salesman_modify[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsalesman_modify=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>




			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='sales[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbsales=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
		  
			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='receiving[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbreceiving=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
			  

			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='reports[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbreports=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='credits[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbcredits=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>

			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='expenses[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbexpenses=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
	
			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;'>
			  <select class='tbl_row' name='accounts_payable[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbaccounts_payable=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
	
			  <td style='border-left-style: solid;border-left-width: 1px;border-left-color: black;border-right-style: solid;border-right-width: 1px;border-right-color: black;'>
			  <select class='tbl_row' name='payroll[]'>
				<option value='0'>Deny</option>
				<option value='1' ";
				if($dbpayroll=='1'){
					echo "selected='selected'";
				}
				echo ">Allow</option>
			  </select>
			  </td>
			 			  
			  ";
			  
			 echo "</tr>
			 ";
		 }
	 }

	 ?>
	 </tbody>
	</table>	
	<div class="span7 text-center"><button class='btn btn-primary' type='save' name='save'><span class='glyphicon glyphicon-floppy-disk'></span> Save</button></div>
	<br>
	</div>
	
	</div>

	</form>

	
	<?php

	}else{
		echo "<strong><center>You do not have the authority to access this module.</center></strong>";
	}
	}else{
		header("location:index");
	}
	?>
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