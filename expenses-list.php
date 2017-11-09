<?php
ob_start();
session_start();
include 'db.php';

$page=$_GET['page'];
$cat=$_GET['cat'];
$f=$_GET['f'];
$t=$_GET['t'];
$ea=$_GET['ea'];
$ea_des=$_GET['ea_des'];
// echo $_GET["description"];
// exit;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Expenses</title>
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
  
  </style>
  <script>
	$(document).ready(function(){
		$("#Expenses").addClass("active");
		$( "#search" ).autocomplete({
		  source: 'search-item-all',
		  select: function(event, ui){
			  window.location='item?s='+ui.item.data;
		  }
		});

		$("#date_to,#date_from").datepicker();
		show_expenses();
		$("#expenses-sort-form").submit(function(e){
			e.preventDefault();
			show_expenses();
		});

		$('#type').change(function(e) {
			var type = $("#type").val();
			var expense_account = $("#expense_account").val();
			var description = $('#description').val();
			window.location = "?type="+type+"&expense_account="+expense_account+"&description="+description;
		});

		$('#expense_account').change(function(e) {
			var type = $("#type").val();
			var expense_account = $("#expense_account").val();
			var description = $('#description').val();
			window.location = "?type="+type+"&expense_account="+expense_account+"&description="+description;
		});

		$('#description').change(function(e) {
			var type = $("#type").val();
			var expense_account = $("#expense_account").val();
			var description = $('#description').val();
			// alert(description);
			window.location = "?type="+type+"&expense_account="+expense_account+"&description="+description;
		});
	});




	function show_expenses(page=1) {
		$.ajax({
			type: "POST",
			data: $("#expenses-sort-form").serialize()+"&sort=1",
			url: $("#expenses-sort-form").attr("action"),
			cache: false,
			success: function(data){
				// alert(data);
				$("table#expenses-table tbody").html(data);
			}
		});
	}
	$(document).on("click",".delete",function(e){
		$("#delete-expenses-modal").modal("show");
		$("#expenseID").val(e.target.id);
	});
	$(document).on("submit","#expenses-delete",function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",
			data: $("#expenses-delete :input").serialize(),
			url: $("#expenses-delete").attr("action"),
			cache: false,
			success: function(data){
				alert("Successfully Deleted!");
				location.reload();
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
		
		if($expenses=='1'){
		?>

		<ol class='breadcrumb'>
		<li><a href='expenses'>Selling Expenses</a></li>
		<li><a href='expenses?tab=2'>Admin Expenditures</a></li>
		<li><a href='expenses?tab=3'>Capital Expenses</a></li>
		<li class='active'>Expenses</a></li>
		</ol>
		<div class="table-reponsive">
			

		<!-- Modal -->
		<div id="delete-expenses-modal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Delete Expense</h4>
		      </div>
		      <div class="modal-body">
		        <form action="expenses-delete" method="post" id="expenses-delete">
		        	<label>Reason for Deleting:</label>
		        	<textarea class="form-control" name="delete_comment"></textarea>
		        	<input type="hidden" id="expenseID" name="id">
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-primary" form="expenses-delete">Save</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div>

		  </div>
		</div>

				<form id="expenses-sort-form" action="expenses-list-ajax" method="post" class="form-inline">
				<div class="row">
					<div class="col-md-12">
					<div class="form-group">
						<label>Type of Expenses:</label><br>
						<select name="category" class="form-control" id="type">
							<option value="">All</option>
							<option value="admin" <?php echo (isset($_GET['type'])&&$_GET['type']=="admin"?"selected":"")?> >Admin Expenses</option>
							<option value="selling" <?php echo (isset($_GET['type'])&&$_GET['type']=="selling"?"selected":"")?> >Selling Expenses</option>
							<option value="capital" <?php echo (isset($_GET['type'])&&$_GET['type']=="capital"?"selected":"")?> >Capital Expenses</option>
						</select>
					</div>
					<div class="form-group">
						<label>Expense Account:</label><br>
						<select id="expense_account" name="expense_account" class="form-control">
							<option value="">Select Expense Account</option>
							<?php
								$ea = mysql_real_escape_string(htmlentities(trim($_GET["expense_account"])));
								$description = mysql_real_escape_string(htmlentities(trim($_GET["description"])));
								$date_from = strtotime($f);
								$date_to = strtotime($t);
								$query = "SELECT DISTINCT expense_account FROM tbl_expenses WHERE deleted='0' AND category='".$_GET['type']."'";
								$expense_account_query = mysql_query($query);
								if(mysql_num_rows($expense_account_query)!=0){
									while ($expense_account_row=mysql_fetch_assoc($expense_account_query)) {
										echo '<option value="'.urlencode(htmlspecialchars_decode($expense_account_row["expense_account"])).'" ';
										if($ea==$expense_account_row["expense_account"]){
											echo 'selected="selected"';
										}
										echo '>'.$expense_account_row["expense_account"].'</option>';
									}
								}
							?>

						</select>
					</div>
					<div class="form-group">
						<label>Description:</label><br>
						<select id="description" name="description" class="form-control">
							<option value="">Select Description</option>
							<?php
								$ea = mysql_real_escape_string(htmlentities(trim($_GET["expense_account"])));
								$description = mysql_real_escape_string(htmlentities(trim($_GET["description"])));
								$date_from = strtotime($f);
								$date_to = strtotime($t);
								$query = "SELECT DISTINCT description FROM tbl_expenses WHERE deleted='0' AND category='".$_GET['type']."' AND expense_account='".$ea."'";
								$expense_account_query = mysql_query($query);
								if(mysql_num_rows($expense_account_query)!=0){
									while ($expense_account_row=mysql_fetch_assoc($expense_account_query)) {
										echo '<option value="'.urlencode(htmlspecialchars_decode($expense_account_row["description"])).'" ';
										if($description==$expense_account_row["description"]){
											echo 'selected="selected"';
										}
										echo '>'.$expense_account_row["description"].'</option>';
									}
								}
							?>
						</select>

					</div>


					<div class="form-group">
						<label>Payee:</label><br>
						<select name="payee" class="form-control">
							<option value="">All</option>
							<?php
							$payee_query = mysql_query("SELECT DISTINCT payee FROM tbl_expenses WHERE deleted='0'");
							if(mysql_num_rows($payee_query)!=0){
								while($payee_row=mysql_fetch_assoc($payee_query)){
									echo '
									<option value="'.$payee_row["payee"].'">'.$payee_row["payee"].'</option>
									';
								}
							}

							?>
						</select>
						
					</div>

					</div>
					</div>
					<br>
					<div class="row">
					<div class="col-md-12">
					<div class="form-group">
						<label>&nbsp;</label><br>
						<select name="sort_by" class="form-control">
							<option value="date">Date of Expense</option>
							<option value="date_due">Due Dates</option>
							<option value="date_payment">Date of Payment</option>
						</select>
						
					</div>

					<div class="form-group">
						<label>Date From:</label><br>
						<input type="text" class="form-control" id="date_from" name="date_from" value="<?php if($f!=""){ echo $f; }else{ echo date("m/d/Y"); } ?>" readonly>
					</div>
					<div class="form-group">
						<label>Date To:</label><br>
						<input type="text" class="form-control" id="date_to" name="date_to" value="<?php if($t!=""){ echo $t; }else{ echo date("m/d/Y"); } ?>" readonly>
					</div>
					<div class="form-group">
						<div class="checkbox">
						  <label data-balloon="Overrides Date Range" data-balloon-pos="right"><input type="checkbox" value="true" name="show_all">Show All</label>
						</div>
					</div>

					<div class="form-group">
						<label>Expense Status:</label><br>
						<select id="expense_status" name="fully_paid" class="form-control">
							<option value="">All</option>
							<option value="1">Paid</option>
							<option value="0">Unpaid</option>

						</select>
					</div>

					<div class="form-group">
						<label>&nbsp;</label><br>
						<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Sort</button>
					</div>

					</div>
					</div>

				</form>
				<table class="table table-hover" id="expenses-table">
				<thead>
					<tr>
						<th>Expense Account</th>
						<th>Description</th>
						<th>Amount</th>
						<th>Payee</th>
						<th>Date</th>
						<th>Terms</th>
						<th>Date Due</th>
						<th>Type Expense</th>
						<th>Date of Payment</th>
						<th>Comments</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
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

  <!-- Modal -->
  <div id="success-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Success!</h4>
        </div>
        <div class="modal-body">
          <p>Expenses are Recorded.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

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