<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$t=@$_GET['t'];
$f=@$_GET['f'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];

#$connect = mysql_connect("localhost","qfcdavao_capital","_39a11nwpm");
#mysql_select_db("qfcdavao_dbinventory");

include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Expenses Reports</title>
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
			$("#date_from").datepicker();
			$("#date_to").datepicker();
			$("#by").change(function(){
				var date_from = $("#date_from").val();
				var date_to = $("#date_to").val();
				var by = $(this).val();
				window.location= "reports?by="+by+"&f="+date_from+"&t="+date_to;
			});
			
			
		$(".delete").click(function(e){
			if(confirm("Are you sure you want to delete? This cannot be undone.")){
				var dataStr = "id="+e.target.id;
				$.ajax({
					type: 'POST',
					data: dataStr,
					url: 'expenses-delete',
					cache: false,
					success: function(){
						location.reload();
					}
				});
			}
		});


		
$("#Reports").addClass("active");
  
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
	if($reports=='1'){
		echo "<center><h3>Expenses in ".date("F d, Y",strtotime($f))." - ".date("F d, Y",strtotime($t))."</h3></center>";
	?>
	<div class='row'>
		



	<div class='col-md-4'>
	<div class='table-responsive'>
	<table class='table table-responsive'>
	<center><h2>Selling Expenses Summary</h2></center>
	<thead>
		<tr>
			<th>Expense Account</th>
			<th style='text-align:right'>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT DISTINCT expense_account FROM tbl_expenses WHERE category='selling' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'";
		// $query = "SELECT * FROM tbl_expenses WHERE expense_account IN (SELECT DISTINCT expense_account FROM tbl_expenses WHERE category='admin' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0')";
		$export_query_summary = $query;
		$expenses_query = mysql_query($query);
		$total_expenses = 0;
		// echo $query;
		if(mysql_num_rows($expenses_query)!=0){
			while($expenses_row=mysql_fetch_assoc($expenses_query)){
				$expense_account=$expenses_row["expense_account"];
				$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_amount FROM tbl_expenses WHERE category='selling' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND expense_account='".mysql_real_escape_string(htmlspecialchars(trim($expense_account)))."'"));
				$total_expenses+=$total_amount["total_amount"];
				echo '
				<tr>
					<td><a href="expenses-list?f='.urlencode($f).'&t='.urlencode($t).'&ea='.urlencode($expense_account).'&type=selling">'.$expense_account.'</a></td>
					<td style="text-align:right">₱'.number_format($total_amount["total_amount"],2).'</td>
				</tr>
				';
			}
		}
		?>
	</tbody>
	<tfoot>
	<?php
	if(mysql_num_rows($expenses_query)!=0){ 
		echo "
		<tr>
			<th style='text-align:right'>Total Expenses:</th>
			<th style='text-align:right'>₱".number_format($total_expenses,2)."</th>
		<tr>
		";
	}
	?>
	</tfoot>
	</table>
	<form action='#' method='post'>
	<button name='download_summary_selling'><span class='glyphicon glyphicon-download'></span> Download this Detailed Summary Report</button>
	</form>
		<?php
		// echo $export_query_summary;
			if(isset($_POST["download_summary_selling"])){
				$filename = "reports-files/selling-expenses-reports-summary-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
				// echo $filename;
				$fp = fopen($filename, 'w');
				$fields = array("Selling Expenses from ",date("F d, Y",strtotime($f))." to ".date("F d, Y",strtotime($t)));
				fputcsv($fp, $fields);
				$fields = array("Expense Account","Amount");
				fputcsv($fp, $fields);
				$export_query_summary = mysql_query($export_query_summary);
				while ($export_summary_row=mysql_fetch_assoc($export_query_summary)) {
					$expense_account=$export_summary_row["expense_account"];
					$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_amount FROM tbl_expenses WHERE category='selling' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND expense_account='".mysql_real_escape_string(htmlspecialchars(trim($expense_account)))."'"));

					$fields = array($expense_account,number_format($total_amount["total_amount"],2));
					fputcsv($fp, $fields);
				}
				$fields = array('TOTAL',number_format($total_expenses,2));
				fputcsv($fp, $fields);
				fclose($fp);
				header("location:".$filename);
			}	
		?>
	</div>
	</div>




	<div class='col-md-4'>
	<div class='table-responsive'>
	<table class='table table-responsive'>
	<center><h2>Admin Expenses Summary</h2></center>
	<thead>
		<tr>
			<th>Expense Account</th>
			<th style='text-align:right'>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT DISTINCT expense_account FROM tbl_expenses WHERE category='admin' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'";
		// $query = "SELECT * FROM tbl_expenses WHERE expense_account IN (SELECT DISTINCT expense_account FROM tbl_expenses WHERE category='admin' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0')";
		$export_query_summary = $query;
		$expenses_query = mysql_query($query);
		$total_expenses = 0;
		// echo $query;
		if(mysql_num_rows($expenses_query)!=0){
			while($expenses_row=mysql_fetch_assoc($expenses_query)){
				$expense_account=$expenses_row["expense_account"];
				$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_amount FROM tbl_expenses WHERE category='admin' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND expense_account='".mysql_real_escape_string(htmlspecialchars(trim($expense_account)))."'"));
				$total_expenses+=$total_amount["total_amount"];
				echo '
				<tr>
					<td><a href="expenses-list?f='.urlencode($f).'&t='.urlencode($t).'&ea='.urlencode($expense_account).'&type=admin">'.$expense_account.'</a></td>
					<td style="text-align:right">₱'.number_format($total_amount["total_amount"],2).'</td>
				</tr>
				';
			}
		}
		?>
	</tbody>
	<tfoot>
	<?php
	if(mysql_num_rows($expenses_query)!=0){ 
		echo "
		<tr>
			<th style='text-align:right'>Total Expenses:</th>
			<th style='text-align:right'>₱".number_format($total_expenses,2)."</th>
		<tr>
		";
	}
	?>
	</tfoot>
	</table>
	<form action='#' method='post'>
	<button name='download_summary_admin'><span class='glyphicon glyphicon-download'></span> Download this Detailed Summary Report</button>
	</form>
		<?php
		// echo $export_query_summary;
			if(isset($_POST["download_summary_admin"])){
				$filename = "reports-files/admin-expenses-reports-summary-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
				// echo $filename;
				$fp = fopen($filename, 'w');
				$fields = array("Admin Expenses from ",date("F d, Y",strtotime($f))." to ".date("F d, Y",strtotime($t)));
				fputcsv($fp, $fields);
				$fields = array("Expense Account","Amount");
				fputcsv($fp, $fields);
				$export_query_summary = mysql_query($export_query_summary);
				while ($export_summary_row=mysql_fetch_assoc($export_query_summary)) {
					$expense_account=$export_summary_row["expense_account"];
					$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_amount FROM tbl_expenses WHERE category='admin' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND expense_account='".mysql_real_escape_string(htmlspecialchars(trim($expense_account)))."'"));

					$fields = array($expense_account,number_format($total_amount["total_amount"],2));
					fputcsv($fp, $fields);
				}
				$fields = array('TOTAL',number_format($total_expenses,2));
				fputcsv($fp, $fields);
				fclose($fp);
				header("location:".$filename);
			}	
		?>
	</div>
	</div>




	<div class='col-md-4'>
	<div class='table-responsive'>
	<table class='table table-responsive'>
	<center><h2>Capital Expenditures Summary</h2></center>
	<thead>
		<tr>
			<th>Expense Account</th>
			<th style='text-align:right'>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$query = "SELECT DISTINCT expense_account FROM tbl_expenses WHERE category='capital' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'";
		// $query = "SELECT * FROM tbl_expenses WHERE expense_account IN (SELECT DISTINCT expense_account FROM tbl_expenses WHERE category='admin' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0')";
		$export_query_summary = $query;
		$expenses_query = mysql_query($query);
		$total_expenses = 0;
		// echo $query;
		if(mysql_num_rows($expenses_query)!=0){
			while($expenses_row=mysql_fetch_assoc($expenses_query)){
				$expense_account=$expenses_row["expense_account"];
				$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_amount FROM tbl_expenses WHERE category='capital' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND expense_account='".mysql_real_escape_string(htmlspecialchars(trim($expense_account)))."'"));
				$total_expenses+=$total_amount["total_amount"];
				echo '
				<tr>
					<td><a href="expenses-list?f='.urlencode($f).'&t='.urlencode($t).'&ea='.urlencode($expense_account).'&type=capital">'.$expense_account.'</a></td>
					<td style="text-align:right">₱'.number_format($total_amount["total_amount"],2).'</td>
				</tr>
				';
			}
		}
		?>
	</tbody>
	<tfoot>
	<?php
	if(mysql_num_rows($expenses_query)!=0){ 
		echo "
		<tr>
			<th style='text-align:right'>Total Expenses:</th>
			<th style='text-align:right'>₱".number_format($total_expenses,2)."</th>
		<tr>
		";
	}
	?>
	</tfoot>
	</table>
	<form action='#' method='post'>
	<button name='download_summary_capital'><span class='glyphicon glyphicon-download'></span> Download this Detailed Summary Report</button>
	</form>
		<?php
		// echo $export_query_summary;
			if(isset($_POST["download_summary_capital"])){
				$filename = "reports-files/capital-expenses-reports-summary-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
				// echo $filename;
				$fp = fopen($filename, 'w');
				$fields = array("Capital Expenditures from ",date("F d, Y",strtotime($f))." to ".date("F d, Y",strtotime($t)));
				fputcsv($fp, $fields);
				$fields = array("Expense Account","Amount");
				fputcsv($fp, $fields);
				$export_query_summary = mysql_query($export_query_summary);
				while ($export_summary_row=mysql_fetch_assoc($export_query_summary)) {
					$expense_account=$export_summary_row["expense_account"];
					$total_amount = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_amount FROM tbl_expenses WHERE category='capital' AND date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND expense_account='".mysql_real_escape_string(htmlspecialchars(trim($expense_account)))."'"));

					$fields = array($expense_account,number_format($total_amount["total_amount"],2));
					fputcsv($fp, $fields);
				}
				$fields = array('TOTAL',number_format($total_expenses,2));
				fputcsv($fp, $fields);
				fclose($fp);
				header("location:".$filename);
			}	
		?>
	</div>
	</div>



	</div>
	<br>
	<br>
	<div class='table-responsive'>
	<center><h2>Expenses in <br> <?php echo date("F d, Y",strtotime($f))." - ".date("F d, Y",strtotime($t));?></h2></center>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>Type</th>
					<th>Date</th>
					<th>Account</th>
					<th>Description</th>
					<th>Amount</th>
					<th>Comments</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
					$maxitem = $maximum_items_displayed; // maximum items
					$limit = ($page*$maxitem)-$maxitem;
				$query = "SELECT * FROM tbl_expenses WHERE date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'";
				$export_query = $query;
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
						
				$expenses_query = mysql_query($query);
				if(mysql_num_rows($expenses_query)!=0){
					while($expenses_row=mysql_fetch_assoc($expenses_query)){
						$description = $expenses_row["description"];
						$expensesID = $expenses_row["expensesID"];
						$date = $expenses_row["date"];
						$comments = $expenses_row["comments"];
						$amount = $expenses_row["amount"];
						$category = $expenses_row["category"];
						$db_accountID = $expenses_row["accountID"];
						$account_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_users WHERE accountID='$db_accountID'"));
						echo "
						<tr>
							<td>".ucfirst($category)." Expenses</td>
							<td>".date("m/d/Y",$date)."</td>
							<td>".$account_data["employee_name"]."</td>
							<td>$description</td>
							<td style='text-align:right'>".number_format($amount,2)."</td>
							<td>$comments</td>
							<td><a href='#' id='$expensesID' class='delete'>Delete</a></td>
						</tr>
						";
					}
				}
				?>
			</tbody>

			<tfoot>
			<?php
			if(mysql_num_rows($expenses_query)!=0){
				$total_expenses = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total_expenses FROM tbl_expenses WHERE date BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0'"));
				echo "
				<tr>
					<th style='text-align:right' colspan='3'>Total Expenses:</th>
					<th style='text-align:right'>₱".number_format($total_expenses["total_expenses"],2)."</th>
				<tr>
				";
			}
			?>
			</tfoot>
		</table>
			<form action='#' method='post'>
			<button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Detailed Report</button>
			</form>
				<?php
				// echo $export_query;
					if(isset($_POST["download"])){
						$filename = "reports-files/expenses-reports-detailed-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
						// echo $filename;

						$fp = fopen($filename, 'w');
						$fields = array("Detailed Expenses from ",date("F d, Y",strtotime($f))." to ".date("F d, Y",strtotime($t)));
						fputcsv($fp, $fields);
						$fields = array("Type","Date","Expense Account","Description","Amount","Comments");
						fputcsv($fp, $fields);
						$export_query = mysql_query($export_query);
						while ($export_row=mysql_fetch_assoc($export_query)) {
							$expense_account = $export_row["expense_account"];
							$description = $export_row["description"];
							$date = $export_row["date"];
							$category = $export_row["category"];
							$amount = $export_row["amount"];
							$comments = $export_row["comments"];
							$db_accountID = $export_row["accountID"];
							$fields = array(ucfirst($type)." Expenses",date("m/d/Y",$date),$expense_account,$description,number_format($amount,2),$comments);
							fputcsv($fp, $fields);
							# code...
						}
						$fields = array('','','','TOTAL',number_format($total_expenses,2));
						fputcsv($fp, $fields);
						fclose($fp);
						header("location:".$filename);
					}	
				?>
			<div class='text-center'>
<?php
			echo "<ul class='pagination prints'>
			
			";
			$url="?f=$f&t=$t&submit=&";
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
			echo "</ul><span class='page' >Page $page</span></div>";
			
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