<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$tab=@$_GET['tab'];
(isset($tab)?false:$tab=1);

include 'db.php';
// echo $month_start;



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Accounts Payable</title>
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
 <link rel="stylesheet" href="css/balloon.css">
 <link rel='stylesheet' href='css/font-awesome.min.css'>
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
  	$("#accounts_payable").addClass("active");
  	$( "#search_invoice" ).autocomplete({
  		source: 'search-account-payable',
  		select: function(event, ui){
  			window.location='receiving-complete?id='+ui.item.data;
  		}
  	});

  	$("#date_payment,#date_from,#date_to").datepicker();
  });
  
  $(document).on("click",".expenses-payment",function(e){
  	$("#expenses-payment-modal").modal("show");
  	$("#expensesID").val(e.target.id);
  });

  $(document).on("submit","#expenses-payment-form",function(e){
  	e.preventDefault();
  		$.ajax({
  			type: 'POST',
  			url: $("#expenses-payment-form").attr("action"),
  			data: $("#expenses-payment-form :input").serialize(),
  			cache: false,
  			success: function(data){
  				alert("Success! The Expenses has been paid.");
  				// alert(data);
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
		if($accounts_payable==1){


			($badge_accounts_payable_page==0?$badge_accounts_payable_page="":false);
			($badge_expenses==0?$badge_expenses="":false);
			($badge_expenses_due==0?$badge_expenses_due="":false);
			echo "
			<div class='col-md-2'>";
			echo "
			<label>Purchases:</label>
			<a href = '?tab=1' class = 'list-group-item"; if(isset($tab)&&$tab=='1'){echo " active"; } echo "'>View Purchases</a>";
			echo "<a href = '?tab=2' class = 'list-group-item"; if(isset($tab)&&$tab=='2'){echo " active"; } echo "'>Due and Past Due <span class='badge'>$badge_accounts_payable_page</span></a>";
			echo "<a href = '?tab=3' class = 'list-group-item"; if(isset($tab)&&$tab=='3'){echo " active"; } echo "'>Paid Accounts</a>";
			echo "<label>Expenses:</label>";
			echo "<a href = '?tab=4' class = 'list-group-item"; if(isset($tab)&&$tab=='4'){echo " active"; } echo "'>Expenses  <span class='badge'>$badge_expenses</span></a>";
			echo "<a href = '?tab=5' class = 'list-group-item"; if(isset($tab)&&$tab=='5'){echo " active"; } echo "'>Due and Past Due  <span class='badge'>$badge_expenses_due</span></a>";
			echo "</div>
			<div class='col-md-10'>";
			if($tab==1){//list of all unpaid purchases
						if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
						$maxitem = $maximum_items_displayed; // maximum items
						$limit = ($page*$maxitem)-$maxitem;
						$query = "SELECT * FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0' AND payment='0'";

						if(isset($_GET["s"])&&$_GET["s"]!=""){
							$query.=" AND supplierID='".mysql_real_escape_string(htmlspecialchars(trim($_GET["s"])))."'";
						}

						if(isset($_GET["f"])&&$_GET["f"]!=""&&isset($_GET["t"])&&$_GET["t"]!=""){
							$query.=" AND date_received BETWEEN '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["f"]))))."' AND '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["t"]))))."'";
						}

						$query.= " OR (freight_needs_payment='1' AND freight_payment='0') ORDER BY date_received DESC";
						$numitemquery = mysql_query($query);
						$numitem = mysql_num_rows($numitemquery);
						$query.=" LIMIT $limit, $maxitem";
						// echo $query;


						echo '
						<form action="accounts-payable" method="get">
						';
						$supplier_query = mysql_query("SELECT DISTINCT supplierID FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0' AND payment='0'");
						echo "<label>Filter By:</label><select id='supplier' name='s'><option value=''>All Supplier</option>";
						if(mysql_num_rows($supplier_query)!=0){
							while($supplier_row=mysql_fetch_assoc($supplier_query)){
								$supplierID = $supplier_row["supplierID"];
								$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
								echo "<option value='$supplierID'";
								if(isset($_GET["s"])&&$_GET["s"]==$supplierID){
									echo "selected='selected'";
								}
								echo ">".$supplier_data["supplier_name"]."</option>";
							}
						}

						echo "</select>";

						echo "<input type='text' placeholder='Search for Invoice Number' id='search_invoice'>";
						$payable_query = mysql_query($query);
				 		if(($numitem%$maxitem)==0){
							$lastpage=($numitem/$maxitem);
						}else{
							$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
						}
						$maxpage = 3;
						echo "
						<input type='text' id='date_from' name='f' placeholder='Date From' value='".$_GET["f"]."' readonly>
						<input type='text' id='date_to' name='t' placeholder='Date To' value='".$_GET["t"]."' readonly>
						<button class='btn btn-primary' type='submit'><span class='glyphicon glyphicon-search'></span></button>
						</form>
						<div class='table-responsive'>
						<table class='table table-hover'>
							<thead>
							<tr>
								<th>#</th>
								<th>Invoice Number</th>
								<th>Date</th>
								<th>Supplier</th>
								<th>Terms</th>
								<th>Freight Charges</th>
								<th>Total Cost</th>
								<th>Due Date</th>
								<th>Payables</th>
							</tr>	
							</thead>
							<tbody>";
							if(mysql_num_rows($payable_query)!=0){
								while($payable_row=mysql_fetch_assoc($payable_query)){
									$receivingID = $payable_row["orderID"];
									$invoice_number = $payable_row["invoice_number"];
									$date_received = $payable_row["date_received"];
									$time_received = $payable_row["time_received"];
									$comments = $payable_row["comments"];
									$supplierID = $payable_row["supplierID"];
									$terms = $payable_row["terms"];
									$freight = $payable_row["freight"];
									$date_due = $payable_row["date_due"];
									$freight_payment = $payable_row["freight_payment"];
									$payment = $payable_row["payment"];
									$total_cost = $payable_row["total_cost"];
									$received_by = $payable_row["accountID"];

									($payment==0?$balance=($total_cost-$payment)+($freight-$freight_payment):$balance=$freight-$freight_payment);
									if(strtotime($date)>=$date_due){
										$status = "danger";
									}else{
										$status = "";
									}
									$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
									echo "
									<tr class='$status'>
										<td><a href='receiving-complete?id=$receivingID'>".$receivingID."</a></td>
										<td>".$invoice_number."</td>
										<td>".date("m/d/Y",$date_received)."</td>
										<td>".$supplier_data["supplier_name"]."</td>
										<td>".$terms."</td>
										<td style='text-align:right'>".number_format($freight,2)."</td>
										<td style='text-align:right'>".number_format($total_cost,2)."</td>
										<td>".date("m/d/Y",$date_due)."</td>
										<td style='text-align:right'>".number_format($balance,2)."</td>
									</tr>
									";
								}
							}
							echo "
							</tbody>
						</table>";

						echo "<div class='text-center'><ul class='pagination prints'>
						
						";
						$url="?";
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
						echo "</div>";
			}elseif($tab==2){ // list of all past due purchases

						if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
						$maxitem = $maximum_items_displayed; // maximum items
						$limit = ($page*$maxitem)-$maxitem;
						$date = "01/31/2018";
						$query = "SELECT * FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0'";
						if(isset($_GET["s"])&&$_GET["s"]!=""){
							$query.= " AND supplierID='".mysql_real_escape_string(htmlspecialchars(trim($_GET["s"])))."'";
						}


						if(isset($_GET["f"])&&$_GET["f"]!=""&&isset($_GET["t"])&&$_GET["t"]!=""){
							$query.=" AND date_due BETWEEN '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["f"]))))."' AND '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["t"]))))."'";
						}


						$query.=" AND (payment='0' AND date_due <= '".strtotime($date)."') OR (freight_needs_payment='1' AND freight_payment='0'  AND date_due <= '".strtotime($date)."') ORDER BY date_received DESC";





						$numitemquery = mysql_query($query);
						$numitem = mysql_num_rows($numitemquery);
						$query.=" LIMIT $limit, $maxitem";
						// echo $query;
						echo '<form action="#" method="get"><input type="hidden" name="tab" value="2">';
						$supplier_query = mysql_query("SELECT DISTINCT supplierID FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0' AND (payment='0' AND date_due <= '".strtotime($date)."') OR (freight_needs_payment='1' AND freight_payment='0'  AND date_due <= '".strtotime($date)."')");
						echo "<label>Filter By:</label><select id='supplier' name='s'><option value=''>All Supplier</option>";
						if(mysql_num_rows($supplier_query)!=0){
							while($supplier_row=mysql_fetch_assoc($supplier_query)){
								$supplierID = $supplier_row["supplierID"];
								$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
								echo "<option value='$supplierID' ";
								if(isset($_GET["s"])&&$_GET["s"]!=""&&$supplierID==$_GET["s"]){
									echo "selected='selected'";
								}
								echo ">".$supplier_data["supplier_name"]."</option>";
							}
						}

						echo "</select>";

						echo "<input type='text' placeholder='Search for Invoice Number' id='search_invoice'>";
						$payable_query = mysql_query($query);
				 		if(($numitem%$maxitem)==0){
							$lastpage=($numitem/$maxitem);
						}else{
							$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
						}
						$maxpage = 3;
						echo "
						<input type='text' id='date_from' name='f' placeholder='Date Due From' value='".$_GET["f"]."' readonly>
						<input type='text' id='date_to' name='t' placeholder='Date Due To' value='".$_GET["t"]."' readonly>
						<button class='btn btn-primary' type='submit'><span class='glyphicon glyphicon-search'></span></button>
						</form>
						<div class='table-responsive'>
						<table class='table table-hover'>
							<thead>
							<tr>
								<th>#</th>
								<th>Invoice Number</th>
								<th>Date</th>
								<th>Supplier</th>
								<th>Terms</th>
								<th>Freight Charges</th>
								<th>Total Cost</th>
								<th>Due Date</th>
								<th>Payables</th>
							</tr>	
							</thead>
							<tbody>";
							if(mysql_num_rows($payable_query)!=0){
								while($payable_row=mysql_fetch_assoc($payable_query)){
									$receivingID = $payable_row["orderID"];
									$invoice_number = $payable_row["invoice_number"];
									$date_received = $payable_row["date_received"];
									$time_received = $payable_row["time_received"];
									$comments = $payable_row["comments"];
									$supplierID = $payable_row["supplierID"];
									$terms = $payable_row["terms"];
									$freight = $payable_row["freight"];
									$date_due = $payable_row["date_due"];
									$freight_payment = $payable_row["freight_payment"];
									$payment = $payable_row["payment"];
									$total_cost = $payable_row["total_cost"];
									$received_by = $payable_row["accountID"];
									($payment==0?$balance=($total_cost-$payment)+($freight-$freight_payment):$balance=$freight-$freight_payment);
									if(strtotime($date)>=$date_due){
										$status = "danger";
									}else{
										$status = "";
									}
									$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
									echo "
									<tr class='$status'>
										<td><a href='receiving-complete?id=$receivingID'>".$receivingID."</a></td>
										<td>".$invoice_number."</td>
										<td>".date("m/d/Y",$date_received)."</td>
										<td>".$supplier_data["supplier_name"]."</td>
										<td>".$terms."</td>
										<td style='text-align:right'>".number_format($freight,2)."</td>
										<td style='text-align:right'>".number_format($total_cost,2)."</td>
										<td>".date("m/d/Y",$date_due)."</td>
										<td style='text-align:right'>".number_format($balance,2)."</td>
									</tr>
									";
								}
							}
							echo "
							</tbody>
						</table>";
						echo "<div class='text-center'><ul class='pagination prints'>
						
						";
						$url="?";
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
						echo "</div>";
				
			}elseif($tab==3){//list of all paid purchases


						if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
						$maxitem = $maximum_items_displayed; // maximum items
						$limit = ($page*$maxitem)-$maxitem;
						$query = "SELECT * FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0' AND payment!='0'";

						if(isset($_GET["s"])&&$_GET["s"]!=""){
							$query.=" AND supplierID='".mysql_real_escape_string(htmlspecialchars(trim($_GET["s"])))."'";
						}



						if(isset($_GET["f"])&&$_GET["f"]!=""&&isset($_GET["t"])&&$_GET["t"]!=""){
							$query.=" AND date_payment BETWEEN '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["f"]))))."' AND '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["t"]))))."'";
						}


						$query.=" ORDER BY date_payment DESC";
						$numitemquery = mysql_query($query);
						$numitem = mysql_num_rows($numitemquery);
						$query.=" LIMIT $limit, $maxitem";
						// echo $query;


						echo '<form action="#" method="get"><input type="hidden" name="tab" value="3">';
						$supplier_query = mysql_query("SELECT DISTINCT supplierID FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0' AND payment!='0'");
						echo "<label>Filter By:</label><select id='supplier' name='s'><option value=''>All Supplier</option>";
						if(mysql_num_rows($supplier_query)!=0){
							while($supplier_row=mysql_fetch_assoc($supplier_query)){
								$supplierID = $supplier_row["supplierID"];
								$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
								echo "<option value='$supplierID' ";
								if(isset($_GET["s"])&&$_GET["s"]==$supplierID){
									echo "selected='selected'";
								}
								echo ">".$supplier_data["supplier_name"]."</option>";
							}
						}

						echo "</select>";

						echo "<input type='text' placeholder='Search for Invoice Number' id='search_invoice'>";
						$payable_query = mysql_query($query);
				 		if(($numitem%$maxitem)==0){
							$lastpage=($numitem/$maxitem);
						}else{
							$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
						}
						$maxpage = 3;
						echo "
						<input type='text' id='date_from' name='f' placeholder='Date of Payment From' value='".$_GET["f"]."' readonly>
						<input type='text' id='date_to' name='t' placeholder='Date of Payment To' value='".$_GET["t"]."' readonly>
						<button class='btn btn-primary' type='submit'><span class='glyphicon glyphicon-search'></span></button>
						</form>
						<div class='table-responsive'>
						<table class='table table-hover'>
							<thead>
							<tr>
								<th>#</th>
								<th>Invoice Number</th>
								<th>Date</th>
								<th>Supplier</th>
								<th>Terms</th>
								<th>Freight Charges</th>
								<th>Total Cost</th>
								<th>Due Date</th>
								<th>Payment</th>
								<th>Check Number</th>
								<th>Date of Payment</th>
							</tr>	
							</thead>
							<tbody>";
							if(mysql_num_rows($payable_query)!=0){
								while($payable_row=mysql_fetch_assoc($payable_query)){
									$receivingID = $payable_row["orderID"];
									$invoice_number = $payable_row["invoice_number"];
									$date_received = $payable_row["date_received"];
									$time_received = $payable_row["time_received"];
									$comments = $payable_row["comments"];
									$supplierID = $payable_row["supplierID"];
									$terms = $payable_row["terms"];
									$freight = $payable_row["freight"];
									$date_due = $payable_row["date_due"];
									$date_due = $payable_row["date_due"];
									$total_cost = $payable_row["total_cost"];
									$check_number = $payable_row["check_number"];
									$date_payment = $payable_row["date_payment"];
									$payment = $payable_row["payment"];
									$received_by = $payable_row["accountID"];
									if(strtotime($date)>=$date_due){
										$status = "danger";
									}else{
										$status = "";
									}
									$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
									echo "
									<tr>
										<td><a href='receiving-complete?id=$receivingID'>".$receivingID."</a></td>
										<td>".$invoice_number."</td>
										<td>".date("m/d/Y",$date_received)."</td>
										<td>".$supplier_data["supplier_name"]."</td>
										<td>".$terms."</td>
										<td style='text-align:right'>".number_format($freight,2)."</td>
										<td style='text-align:right'>".number_format($total_cost,2)."</td>
										<td>".date("m/d/Y",$date_due)."</td>
										<td>".$payment."</td>
										<td>".$check_number."</td>
										<td>".date("m/d/Y",$date_payment)."</td>
									</tr>
									";
								}
							}
							echo "
							</tbody>
						</table>";
						echo "<div class='text-center'><ul class='pagination prints'>
						
						";
						$url="?";
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
						echo "</div>";
				
				
			}elseif ($tab==4) {
				echo '
				<!-- Modal -->
				<div id="expenses-payment-modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Expenses Payments</h4>
				      </div>
				      <div class="modal-body">
				        <form action="expenses-payments" id="expenses-payment-form" method="post" class="form-horizontal">
				        	<div class="form-group">
				        	  <label for="email">Date of Payment:</label>
				        	  <input type="text" class="form-control" id="date_payment" name="date_payment" value="'.date("m/d/Y").'" readonly>
				        	</div>

				        	<div class="form-group">
				        	  <label for="email">Payment Comments:</label>
				        	  <textarea name="comment_payment" class="form-control"></textarea>
				        	</div>

				        	<input type="hidden" name="expensesID" id="expensesID" value="0">

				        </form>
				      </div>
				      <div class="modal-footer">
				        <button type="submit" class="btn btn-primary" form="expenses-payment-form">Save</button>
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>

				<!-- Modal -->
				<div id="expenses-payment-success-modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Success!</h4>
				      </div>
				      <div class="modal-body">
				      	<p>Payments for expenses has been saved.</p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>


				';
				echo '
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Expense Accounts</th>
								<th>Description</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Payee</th>
								<th>Terms</th>
								<th>Date Due</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>';
						$query = "SELECT * FROM tbl_expenses WHERE fully_paid = '0' AND deleted='0' AND date_due > '".strtotime(date("m/d/Y"))."'";
						$expenses_query = mysql_query($query);
						if(mysql_num_rows($expenses_query)!=0){
							while($expenses_row=mysql_fetch_assoc($expenses_query)){
								echo '
								<tr>
									<td>'.$expenses_row["expense_account"].'</td>
									<td>'.$expenses_row["description"].'</td>
									<td>'.number_format($expenses_row["amount"],2).'</td>
									<td>'.date("m/d/Y",$expenses_row["date"]).'</td>
									<td>'.$expenses_row["payee"].'</td>
									<td>'.$expenses_row["terms"].'</td>
									<td>'.date("m/d/Y",$expenses_row["date_due"]).'</td>
									<td>'.$expenses_row["comments"].'</td>
									<td><a href="#" id="'.$expenses_row["expensesID"].'" class="expenses-payment">Payment</a></td>
								</tr>
								';
							}
						}

						echo '
						</tbody>
					</table>
				</div>
				';
				
			}elseif ($tab==5) {
				echo '
				<!-- Modal -->
				<div id="expenses-payment-modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Expenses Payments</h4>
				      </div>
				      <div class="modal-body">
				        <form action="expenses-payments" id="expenses-payment-form" method="post" class="form-horizontal">
				        	<div class="form-group">
				        	  <label for="email">Date of Payment:</label>
				        	  <input type="text" class="form-control" id="date_payment" name="date_payment" value="'.date("m/d/Y").'" readonly>
				        	</div>

				        	<div class="form-group">
				        	  <label for="email">Payment Comments:</label>
				        	  <textarea name="comment_payment" class="form-control"></textarea>
				        	</div>

				        	<input type="hidden" name="expensesID" id="expensesID" value="0">

				        </form>
				      </div>
				      <div class="modal-footer">
				        <button type="submit" class="btn btn-primary" form="expenses-payment-form">Save</button>
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>

				<!-- Modal -->
				<div id="expenses-payment-success-modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Success!</h4>
				      </div>
				      <div class="modal-body">
				      	<p>Payments for expenses has been saved.</p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>

				  </div>
				</div>


				';
				echo '
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Expense Accounts</th>
								<th>Description</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Payee</th>
								<th>Terms</th>
								<th>Date Due</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>';
						$query = "SELECT * FROM tbl_expenses WHERE fully_paid = '0' AND deleted='0' AND date_due <= '".strtotime(date("m/d/Y"))."'";
						$expenses_query = mysql_query($query);
						if(mysql_num_rows($expenses_query)!=0){
							while($expenses_row=mysql_fetch_assoc($expenses_query)){
								echo '
								<tr>
									<td>'.$expenses_row["expense_account"].'</td>
									<td>'.$expenses_row["description"].'</td>
									<td>'.number_format($expenses_row["amount"],2).'</td>
									<td>'.date("m/d/Y",$expenses_row["date"]).'</td>
									<td>'.$expenses_row["payee"].'</td>
									<td>'.$expenses_row["terms"].'</td>
									<td>'.date("m/d/Y",$expenses_row["date_due"]).'</td>
									<td>'.$expenses_row["comments"].'</td>
									<td><a href="#" id="'.$expenses_row["expensesID"].'" class="expenses-payment">Payment</a></td>
								</tr>
								';
							}
						}

						echo '
						</tbody>
					</table>
				</div>
				';
				
			}
			echo "</div>";
		}
	}else{
		header("location:index");
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