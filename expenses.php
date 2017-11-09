<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$tab=@$_GET['tab'];

if(!isset($tab)){
	$tab=1;
}


include 'db.php';


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
		for (var i = 1; i <= 10; i++) {
			$("#datepicker_"+i).datepicker();
		}
		$( "#search" ).autocomplete({
		  source: 'search-item-all',
		  select: function(event, ui){
			  window.location='item?s='+ui.item.data;
		  }
		});
		$(".expenses_admin").autocomplete({
			source: 'search-expenses-admin',
		});
		$(".expenses_selling").autocomplete({
			source: 'search-expenses',
		});

		$("#selling-expenses-form").submit(function(e){
			e.preventDefault();
			$("#selling-expenses-submit").attr("disabled","disabled");
			$.ajax({
				type: "POST",
				url: $("#selling-expenses-form").attr("action"),
				data: $("#selling-expenses-form :input").serialize()+"&save=1",
				cache: false,
				success: function(data){
					$("#selling-expenses-submit").removeAttr("disabled");
					$("#success-modal").modal("show");
					$('#selling-expenses-form')[0].reset();
				}
			});
		});


		$("#admin-expenses-form").submit(function(e){
			e.preventDefault();
			$("#admin-expenses-submit").attr("disabled","disabled");
			$.ajax({
				type: "POST",
				url: $("#admin-expenses-form").attr("action"),
				data: $("#admin-expenses-form :input").serialize()+"&save=1",
				cache: false,
				success: function(data){
				$("#admin-expenses-submit").removeAttr("disabled");
				$("#success-modal").modal("show");
				$('#admin-expenses-form')[0].reset();
				// alert(data);
				}
			});
		});


		$("#capital-expenses-form").submit(function(e){
			e.preventDefault();
			$("#capital-expenses-submit").attr("disabled","disabled");
			$.ajax({
				type: "POST",
				url: $("#capital-expenses-form").attr("action"),
				data: $("#capital-expenses-form :input").serialize()+"&save=1",
				cache: false,
				success: function(data){
				$("#capital-expenses-submit").removeAttr("disabled");
				$("#success-modal").modal("show");
				$('#capital-expenses-form')[0].reset();
				// alert(data);
				}
			});
		});

	});


	$(document).on("change",".selling_expense_account",function(e){
		var data_str = "expense_account="+e.target.value+"&type=selling&tab=1";
		$.ajax({
			type: "POST",
			url: "expenses-accounts-ajax",
			data: data_str,
			cache: false,
			success: function(data){
				$("#"+e.target.id+".selling_select_description").html(data);
			}
		});
	});


	$(document).on("change",".selling_select_description",function(e){
		var expense_account = $("#"+e.target.id+".selling_expense_account").val();
		var data_str = "expense_account="+expense_account+"&description="+e.target.value+"&type=selling&tab=2";
		// alert(data_str);
		$.ajax({
			type: "POST",
			url: "expenses-accounts-ajax",
			data: data_str,
			cache: false,
			success: function(data){
				$("#"+e.target.id+".selling_expense_amount").val(data);
			}
		});
	});




	$(document).on("change",".admin_expense_account",function(e){
		var data_str = "expense_account="+e.target.value+"&type=admin&tab=2";
		$.ajax({
			type: "POST",
			url: "expenses-accounts-ajax",
			data: data_str,
			cache: false,
			success: function(data){
				$("#"+e.target.id+".admin_select_description").html(data);
			}
		});
	});
	$(document).on("change",".admin_select_description",function(e){
		var expense_account = $("#"+e.target.id+".admin_expense_account").val();
		var data_str = "expense_account="+expense_account+"&description="+e.target.value+"&type=admin&tab=2";
		// alert(data_str);
		$.ajax({
			type: "POST",
			url: "expenses-accounts-ajax",
			data: data_str,
			cache: false,
			success: function(data){
				$("#"+e.target.id+".admin_expense_amount").val(data);
			}
		});
	});


	$(document).on("change",".capital_expense_account",function(e){
		var data_str = "expense_account="+e.target.value+"&type=capital&tab=3";
		$.ajax({
			type: "POST",
			url: "expenses-accounts-ajax",
			data: data_str,
			cache: false,
			success: function(data){
				$("#"+e.target.id+".capital_select_description").html(data);
			}
		});
	});
	$(document).on("change",".capital_select_description",function(e){
		var expense_account = $("#"+e.target.id+".capital_expense_account").val();
		var data_str = "expense_account="+expense_account+"&description="+e.target.value+"&type=capital&tab=2";
		// alert(data_str);
		$.ajax({
			type: "POST",
			url: "expenses-accounts-ajax",
			data: data_str,
			cache: false,
			success: function(data){
				$("#"+e.target.id+".capital_expense_amount").val(data);
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

			if($tab==1){

				echo "
				<ol class='breadcrumb'>
				<li class='active'>Selling Expenses</li>
				<li><a href='?tab=2'>Admin Expenses</a></li>
				<li><a href='?tab=3'>Capital Expenditures</a></li>
				<li><a href='expenses-list'>Expenses</a></li>
				</ol>
				<h1 style='text-align:center'>Selling Expenses</h1>

				";
					
					echo "<form action='expenses-selling-form' method='post' class='form-horizontal' id='selling-expenses-form'>
					<div class='col-md-2'>
						<label>Controls:</label>
						<button class='btn btn-primary btn-block' name='save' id='selling-expenses-submit'><span class='glyphicon-floppy-disk glyphicon'></span> Save</button>
						<a href='expenses-accounts?expense=selling' class='btn btn-block btn-default'><span class='glyphicon glyphicon-cog'></span> Expense Accounts</a>
					</div>
					
					<div class='col-md-10'>
					<div class='table-responsive'>
					<table class='table-hover table myTable'>
					<thead>
						<tr>
							<th>Expense Accounts</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Payee</th>
							<th>Terms</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody>";
						
						for($i=1;$i<=10;$i++){
							echo '
							<tr>
								<td>
									<select class="form-control selling_expense_account" id="'.$i.'" name="expense_account[]">
										<option value="">Select Expense Account</option>';
										$expense_accounts_query = mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses_account WHERE type='selling' AND deleted='0'");
										if(mysql_num_fields($expense_accounts_query)!=0){
											while($expense_accounts_row=mysql_fetch_assoc($expense_accounts_query)){
												echo '
												<option value="'.$expense_accounts_row["expense_account"].'">'.$expense_accounts_row["expense_account"].'</option>
												';
											}
										}
									echo '
									</select>
								</td>
								<td>
									<select class="form-control selling_select_description" id="'.$i.'" name="description[]">
										<option value="">Select Description</option>
									</select>
								</td>
								<td><input type="number" min="0" step="0.01" name="amount[]" id="'.$i.'" placeholder="Expense Amount" class="form-control selling_expense_amount"></td>
								<td><input type="text" name="date[]" id="datepicker_'.$i.'" placeholder="Date" class="form-control selling_expense_date" readonly value="'.date("m/d/Y").'"></td>
								<td><input type="text" name="payee[]" id="'.$i.'" placeholder="Payee" class="form-control selling_payee"></td>
								<td><input type="number" min="0" name="term[]" id="'.$i.'" placeholder="Terms" class="form-control selling_term" value="0"></td>
								<td><textarea class="form-control" name="comments[]"></textarea></td>
							</tr>
							';
						}
					echo "
					</tbody>
					<tfoot>
						<tr>

						</tr>
					</tfoot>
					</table>
					
					</div>
					</div>
					</form>";
					
					

			}elseif($tab==2){

				echo "
				<ol class='breadcrumb'>
				<li><a href='expenses'>Selling Expenses</a></li>
				<li class='active'>Admin Expenses</li>
				<li><a href='?tab=3'>Capital Expenditures</a></li>
				<li><a href='expenses-list'>Expenses</a></li>
				</ol>
				<h1 style='text-align:center'>Admin Expenses</h1>
				";
						
					
					echo "<form action='expenses-admin-form' method='post' class='form-horizontal' id='admin-expenses-form'>
					<div class='col-md-2'>
						<label>Controls:</label>
						<button class='btn btn-primary btn-block' name='save' id='admin-expenses-submit'><span class='glyphicon-floppy-disk glyphicon'></span> Save</button>
						<a href='expenses-accounts?expense=admin' class='btn btn-block btn-default'><span class='glyphicon glyphicon-cog'></span> Expense Accounts</a>
					</div>
					
					<div class='col-md-10'>
					<div class='table-responsive'>
					<table class='table-hover table myTable'>
					<thead>
						<tr>
							<th>Expense Accounts</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Payee</th>
							<th>Terms</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody>";
						
						for($i=1;$i<=10;$i++){
							echo '
							<tr>
								<td>
									<select class="form-control admin_expense_account" id="'.$i.'" name="expense_account[]">
										<option value="">Select Expense Account</option>';
										$expense_accounts_query = mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses_account WHERE type='admin' AND deleted='0'");
										if(mysql_num_fields($expense_accounts_query)!=0){
											while($expense_accounts_row=mysql_fetch_assoc($expense_accounts_query)){
												echo '
												<option value="'.$expense_accounts_row["expense_account"].'">'.$expense_accounts_row["expense_account"].'</option>
												';
											}
										}
									echo '
									</select>
								</td>
								<td>
									<select class="form-control admin_select_description" id="'.$i.'" name="description[]">
										<option value="">Select Description</option>
									</select>
								</td>
								<td><input type="number" min="0" step="0.01" name="amount[]" id="'.$i.'" placeholder="Expense Amount" class="form-control admin_expense_amount"></td>
								<td><input type="text" name="date[]" id="datepicker_'.$i.'" placeholder="Date" class="form-control admin_expense_date" readonly value="'.date("m/d/Y").'"></td>
								<td><input type="text" name="payee[]" id="'.$i.'" placeholder="Payee" class="form-control admin_payee"></td>
								<td><input type="number" min="0" name="term[]" id="'.$i.'" placeholder="Terms" class="form-control admin_term" value="0"></td>
								<td><textarea class="form-control" name="comments[]"></textarea></td>
							</tr>
							';
						}
					echo "
					</tbody>
					<tfoot>
						<tr>

						</tr>
					</tfoot>
					</table>
					
					</div>
					</div>
					</form>";
					
					
						
			}elseif ($tab==3) {
				

				echo "
				<ol class='breadcrumb'>
				<li><a href='expenses'>Selling Expenses</a></li>
				<li><a href='?tab=2'>Admin Expenditures</a></li>
				<li class='active'>Capital Expenses</li>
				<li><a href='expenses-list'>Expenses</a></li>
				</ol>
				<h1 style='text-align:center'>Capital Expenditures</h1>
				";
						
					
					echo "<form action='expenses-capital-form' method='post' class='form-horizontal' id='capital-expenses-form'>
					<div class='col-md-2'>
						<label>Controls:</label>
						<button class='btn btn-primary btn-block' name='save' id='capital-expenses-submit'><span class='glyphicon-floppy-disk glyphicon'></span> Save</button>
						<a href='expenses-accounts?expense=capital' class='btn btn-block btn-default'><span class='glyphicon glyphicon-cog'></span> Expense Accounts</a>
					</div>
					
					<div class='col-md-10'>
					<div class='table-responsive'>
					<table class='table-hover table myTable'>
					<thead>
						<tr>
							<th>Expense Accounts</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Payee</th>
							<th>Terms</th>
							<th>Comments</th>
						</tr>
					</thead>
					<tbody>";
						
						for($i=1;$i<=10;$i++){
							echo '
							<tr>
								<td>
									<select class="form-control capital_expense_account" id="'.$i.'" name="expense_account[]">
										<option value="">Select Expense Account</option>';
										$expense_accounts_query = mysql_query("SELECT DISTINCT expense_account FROM tbl_expenses_account WHERE type='capital' AND deleted='0'");
										if(mysql_num_fields($expense_accounts_query)!=0){
											while($expense_accounts_row=mysql_fetch_assoc($expense_accounts_query)){
												echo '
												<option value="'.$expense_accounts_row["expense_account"].'">'.$expense_accounts_row["expense_account"].'</option>
												';
											}
										}
									echo '
									</select>
								</td>
								<td>
									<select class="form-control capital_select_description" id="'.$i.'" name="description[]">
										<option value="">Select Description</option>
									</select>
								</td>
								<td><input type="number" min="0" step="0.01" name="amount[]" id="'.$i.'" placeholder="Expense Amount" class="form-control capital_expense_amount"></td>
								<td><input type="text" name="date[]" id="datepicker_'.$i.'" placeholder="Date" class="form-control capital_expense_date" readonly value="'.date("m/d/Y").'"></td>
								<td><input type="text" name="payee[]" id="'.$i.'" placeholder="Payee" class="form-control capital_payee"></td>
								<td><input type="number" min="0" name="term[]" id="'.$i.'" placeholder="Terms" class="form-control capital_term" value="0"></td>
								<td><textarea class="form-control" name="comments[]"></textarea></td>
							</tr>
							';
						}
					echo "
					</tbody>
					<tfoot>
						<tr>

						</tr>
					</tfoot>
					</table>
					
					</div>
					</div>
					</form>";
					
					
						
				
			}
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