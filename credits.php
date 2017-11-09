<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$tab=@$_GET['tab'];
$id=@$_GET['id'];
$b=@$_GET['b'];
$o=@$_GET['o'];
$c=@$_GET['c'];
$t=@$_GET['t'];
$f=@$_GET['f'];
$s=@$_GET['s'];
(!isset($tab)?$tab=1:false);
(!isset($b)?$b="due":false);
(!isset($o)?$o="ASC":false);

$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';
if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Credits</title>
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
  .popover{
    width:100%;   
}
  </style>
  <script>
	$(document).ready(function(){
		$("#date_from,#date_to,.pdc_date,#date_from_ar,#date_to_ar").datepicker();
		$("#dr").autocomplete({
			source: "search-dr?tab=2",
			select: function(event,ui){
				var date_to = $("#date_to").val();
				var date_from = $("#date_from").val();
				var order = $("#order").val();
				var salesman = $("#salesman").val();
				var customer = $("#customer").val();
				var tab = $("#tab").val();
				var dr = $("#dr").val();
				window.location="?tab="+tab+"&f="+date_from+"&t="+date_to+"&o="+order+"&c="+customer+"&s="+salesman+"&dr="+ui.item.data;
			}
		});


		$("#dr-searchbox").autocomplete({
			source: "search-dr?tab=1",
			select: function(event,ui){
				window.location="sales-complete?id="+ui.item.data;
			}
		});

		$("#order,#salesman,#customer,#date_to,#date_from,#dr").change(function(e){
			var date_to = $("#date_to").val();
			var date_from = $("#date_from").val();
			var order = $("#order").val();
			var salesman = $("#salesman").val();
			var customer = $("#customer").val();
			var tab = $("#tab").val();
			var dr = $("#dr").val();
			window.location="?tab="+tab+"&f="+date_from+"&t="+date_to+"&o="+order+"&c="+customer+"&s="+salesman+"&dr="+dr;
		});

		$(".pdc_date").change(function(e){
			var dataStr = "id="+e.target.id+"&pdc_date="+e.target.value;
			// alert(dataStrSt);
			$.ajax({
				type: 'POST',
				url: 'credits-pdc',
				data: dataStr,
				cache: false,
				success: function(html){
					// alert(html);
				}
			});
		});

		$(".pdc_check_number").change(function(e){
			var dataStr = "id="+e.target.id+"&pdc_check_number="+e.target.value;
			// alert(dataStrSt);
			$.ajax({
				type: 'POST',
				url: 'credits-pdc',
				data: dataStr,
				cache: false,
				success: function(html){
					// alert(html);
				}
			});
		});

		$(".pdc_amount").change(function(e){
			var dataStr = "id="+e.target.id+"&pdc_amount="+e.target.value;
			// alert(dataStrSt);
			$.ajax({
				type: 'POST',
				url: 'credits-pdc',
				data: dataStr,
				cache: false,
				success: function(html){
					// alert(html);
				}
			});
		});
		$("#Credits").addClass("active");
	$( "#ar_no" ).autocomplete({
      source: 'ar-search',
	  select: function(event, ui){
		  window.location='item?s='+ui.item.data;
	  }
    });
			

	$( "#customer" ).autocomplete({
      source: 'search-customer-auto',
	  select: function(event, ui){
		  window.location='credits?tab=2&id='+ui.item.data;
	  }
    });
	$( "#search_customer" ).autocomplete({
      source: 'search-customer-auto',
	  select: function(event, ui){
		  var tab = $("#tab").val();
		  window.location='credits?tab='+tab+'&id='+ui.item.data;
	  }
    });
	$("#date_now").datepicker();
	$("#date_now").change(function(){
		var date_now = $(this).val();
		window.location = 'credits?d='+date_now;
	});
	
		 $('.selected').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
	
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
	<form action='credits?tab=2' method='post'>
	<div class='col-md-2 prints'>
	<?php
	($badge_credit==0?$badge_credit="":false);



	($badge_credit_1==0?$badge_credit_1="":false);
	($badge_credit_2==0?$badge_credit_2="":false);
	($badge_credit_3==0?$badge_credit_3="":false);
	($badge_credit_4==0?$badge_credit_4="":false);


		echo "<input type='hidden' id='tab' value='$tab'>";
		echo "<label>Navigation:</label><a href = '?tab=1' class = 'list-group-item"; if(isset($tab)&&$tab=='1'){echo " active"; } echo "'>Accounts Receivable</a>";
		// echo "<a href = '?tab=2' class = 'list-group-item"; if(isset($tab)&&$tab=='2'){echo " active"; } echo "'>Customer&#39s Credits</a>";
		// echo "<a href = '?tab=3' class = 'list-group-item"; if(isset($tab)&&$tab=='3'){echo " active"; } echo "'>Paid Accounts</a>";
		echo "<a href = '?tab=9' class = 'list-group-item"; if(isset($tab)&&$tab=='9'){echo " active"; } echo "'>Due <span class='badge'>$badge_credit_1</span></a>";
		echo "<a href = '?tab=4' class = 'list-group-item"; if(isset($tab)&&$tab=='4'){echo " active"; } echo "' data-balloon='(1-30 Days)' data-balloon-pos='down'>Past Due<span class='badge'>$badge_credit_2</span></a>";
		echo "<a href = '?tab=7' class = 'list-group-item"; if(isset($tab)&&$tab=='7'){echo " active"; } echo "' data-balloon='(31-60 Days)' data-balloon-pos='down'>Past Due<span class='badge'>$badge_credit_3</span></a>";
		echo "<a href = '?tab=8' class = 'list-group-item"; if(isset($tab)&&$tab=='8'){echo " active"; } echo "' data-balloon='(over 61 Days)' data-balloon-pos='down'>Past Due<span class='badge'>$badge_credit_4</span></a>";
		echo "<a href = '?tab=5' class = 'list-group-item"; if(isset($tab)&&$tab=='5'){echo " active"; } echo "'>Paid with Cash</a>";
		// echo "<a href = '?tab=4' class = 'list-group-item"; if(isset($tab)&&$tab=='4'){echo " active"; } echo "'>Expenses</a>";
		echo "<a href = '?tab=6' class = 'list-group-item"; if(isset($tab)&&$tab=='6'){echo " active"; } echo "'>Paid with PDC</a>";
		// echo "<a href = '?tab=7' class = 'list-group-item"; if(isset($tab)&&$tab=='7'){echo " active"; } echo "'>Detailed Reports</a>";
		// $credit_num_rows = mysql_num_rows(mysql_query("SELECT * FROM tbl_payments WHERE type_payment LIKE '%credit%' AND customerID='$id' AND deleted='0'"));
		// if($tab==2&&isset($id)&&$credit_num_rows!=0){
		// 	echo "
		// 	<br>
		// 	<label>Controls:</label>
		// 		<button class='btn btn-block btn-primary' type='submit' name='a_report'>Payments</button>
		// 		<button class='btn btn-block btn-primary' type='submit' name='s_account'>Statement of Account</button>
		// 	";

		// }

		echo "<li class = 'list-group-item'>
		<input type='text' id='dr-searchbox' placeholder='Search DR' class='form-control'>
		</li>";
		
	?>
	</div>
  	<div class='col-md-10 prints'>
	
	
	<?php
	if($logged==1||$logged==2){
		if($credits=='1'){

		if($tab==1){

			echo "
			<h3 style='text-align:center;'>View Accounts Receivable</h3>
			<div class='table-responsive'>
			<table class='table table-hover'>
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Delivery Date</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Date Due</th>
				<th>Amount</th>
				<th>TS #</th>
				<th>PDC Date</th>
				<th>PDC Check Number</th>
				<th>PDC Amount</th>
				<th>balance</th>
			</tr>
			<tbody>";
			echo "
			<label>Filter By:</label>
			<input type='text' id='date_from' placeholder='Date From' value='";
			if(isset($f)&&$f!=""){
				echo $f;
			}
			echo "'><input type='text' id='date_to' placeholder='Date To' value='";
			if(isset($t)&&$t!=""){
				echo $t;
			}
			echo "'>
			</select>
			<select id='order'>
				<option value='ASC' ";
					if(isset($o)&&$o=="ASC"){
						echo "selected='selected'";
					}
				echo">Ascending</option>
				<option value='DESC' ";
					if(isset($o)&&$o=="DESC"){
						echo "selected='selected'";
					}
				echo">Discending</option>
			</select>
			";
			$dr= @$_GET["dr"];
			echo "<input type='text' id='dr' placeholder='Search DR' value='".$dr."'>";
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND balance!= 0";
			$customer_unique = "SELECT DISTINCT customerID FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND balance!= 0";
			if(isset($s)&&$s!=""){
				$customer_unique.= " AND salesmanID='$s'";
			}
			if(isset($c)&&$c!=""){
				$query.= " AND customerID = '$c'";
			}

			if(isset($f)&&isset($t)&&$f!=""&&$t!=""){
				$query.=" AND date_delivered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."'";
			}


			$customer_unique = mysql_query($customer_unique);
			echo "
				<select id='customer'>
					<option value=''>All Customers</option>";
					while($customer_unique_row=mysql_fetch_assoc($customer_unique)){
						$customer_unique_customerID = $customer_unique_row["customerID"];
						$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customer_unique_customerID'"));
						if($customer_unique_customerID!=""){
							echo "<option value='$customer_unique_customerID' ";
							if(isset($c)&&$c==$customer_unique_customerID){
								echo "selected='selected'";
							}
							echo">".$customer_data["companyname"]."</option>";
						}
					}
			echo "<select>";

			$salesman_unique = "SELECT DISTINCT salesmanID FROM tbl_orders WHERE fully_paid='0' AND deleted='0'";
			if(isset($c)&&$c!=""){
				$salesman_unique.= " AND customerID='$c'";
			}
			if(isset($s)&&$s!=""){
				$query.= " AND salesmanID = '$s'";
			}

			
			if(isset($dr)&&$dr!=""){
				$query.= " AND orderID LIKE '$dr%'";
			}

			$salesman_unique = mysql_query($salesman_unique);
			echo "
				<select id='salesman'>
					<option value=''>All Salesman</option>";
					while($salesman_unique_row=mysql_fetch_assoc($salesman_unique)){
						$salesman_unique_salesmanID = $salesman_unique_row["salesmanID"];
						$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesman_unique_salesmanID'"));
						if($salesman_unique_salesmanID!=""){
							echo "<option value='$salesman_unique_salesmanID' ";
							if(isset($s)&&$s==$salesman_unique_salesmanID){
								echo "selected='selected'";
							}
							echo">".$salesman_data["salesman_name"]."</option>";
						}
					}
			echo "<select>";

			// echo $query;
			if(strtolower($b)=="due"){
				$query.=" ORDER BY date_due";
			}elseif(strtolower($b)=="date"){
				$query.=" ORDER BY date_delivered";
			}else{
				$query.=" ORDER BY orderID";
			}
			if(strtolower($o)=="desc"){
				$query.=" DESC";
			}else{
				$query.=" ASC, orderID DESC";
			}
			$numitemquery = mysql_query($query);
			$numitem = mysql_num_rows($numitemquery);
			$export_query = $query;
			$query.=" LIMIT $limit, $maxitem";
			// echo $query;
			$order_query = mysql_query($query);

			 		if(($numitem%$maxitem)==0){
						$lastpage=($numitem/$maxitem);
					}else{
						$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
					}
					$maxpage = 3;

			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$orderID = $order_row["orderID"];
					$date_ordered = $order_row["date_delivered"];
					$total = $order_row["total"];
					$date_due = $order_row["date_due"];
					$ts_orderID = $order_row["ts_orderID"];
					$terms = $order_row["terms"];
					$customerID = $order_row["customerID"];
					$salesmanID = $order_row["salesmanID"];
					$balance = $order_row["balance"];
					$pdc_check_number = $order_row["pdc_check_number"];
					$pdc_amount = $order_row["pdc_amount"];
					($order_row["pdc_date"]==0?$pdc_date="":$pdc_date = date("m/d/Y",$order_row["pdc_date"]));
					($order_row["pdc_amount"]==0?$pdc_amount="":$pdc_amount = number_format($order_row["pdc_amount"],2));
					
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
					$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
					($date_due<=strtotime($date)?$status="warning":$status="");
					($terms==0?$terms="COD":false);
					echo "
						<tr class='$status'>
							<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
							<td>$terms</td>
							<td>".date("m/d/Y",$date_ordered)."</td>
							<td>".$customer_data["companyname"]."</td>
							<td>".$salesman_data["salesman_name"]."</td>
							<td>".date("m/d/Y",$date_due)."</td>
							<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
							<td><a href='sales-ts-complete?id=$ts_orderID'>$ts_orderID</a></td>
							<td>$pdc_date</td>
							<td>$pdc_check_number</td>
							<td>$pdc_amount</td>
							<td>".number_format($balance,2)."</td>
						</tr>
					";
				}
			}
			echo "
			</tbody>
			</thead>
			</table>";			
			echo "
			<div class='text-center'>
			<ul class='pagination prints'>
			
			";
			$url="?b=$b&o=$o&c=$c&s=$s&";
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
			

			echo "</div>
			";
			?>
			</form>
			<!--
			<form action='#' method='post'>
			<button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Report</button>
			</form>
			-->
				<?php
					if(isset($_POST["download"])){
						$filename = "reports-files\sales-reports-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
						// echo $filename;
						$fp = fopen($filename, 'w');
						$fields = array("Date","DR #","Customer","Account Specialist","SKU Code","Product Name","Supplier","Category","UOM","QTY","Price","Total Amount","Status","Date Returned");
						fputcsv($fp, $fields);
						$export_query = mysql_query($export_query);
						while ($export_row=mysql_fetch_assoc($export_query)) {
							$date_ordered = $export_row["date_ordered"];
							$customerID = $export_row["customerID"];
							$itemID = $export_row["itemID"];
							$salesmanID = $export_row["salesmanID"];
							$quantity = $export_row["quantity"];
							$orderID = $export_row["orderID"];
							$price = $export_row["price"];
							$amount = $price*$quantity;
							$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
							$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
							$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
							$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
							$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID = '".$item_data["supplierID"]."'"));
							$received = $order_data["received"];
							if($received!=0){
								$status = "Returned";
								$received_date = date("m/d/Y",$order_data["received"]);
							}else{
								$status = "";
								$received_date = "";
							}

							$fields = array(date("m/d/Y",$date_ordered),$orderID,$customer_data["companyname"],$salesman_data["salesman_name"],$item_data["item_code"],$item_data["itemname"],$supplier_data["supplier_company"],$item_data["category"],$item_data["unit_of_measure"],number_format($quantity),number_format($price,2),number_format($amount,2),$status);
							fputcsv($fp, $fields);
							# code...
						}
						$fields = array('','','','','','','','','','','TOTAL',number_format($total_amount["total_amount"],2),'','','');
						fputcsv($fp, $fields);
						fclose($fp);
						header("location:".$filename);
					}	
				?>
			<?php
		}elseif($tab==2){
			if(!isset($id)){
				echo "
				<div class='col-md-6 row'>
				<h3 style='text-align:center'>Customer&#39s Credits</h3>
				<form action='#' method='get'>
					<div class='form-group'>
					<label>Customer Name:</label>
					<input type='text' name='customer' id='customer' placeholder='Customer Name' class='form-control'>
					</div>
				</form>
				</div>
				";
			}else{
				

				$query = "SELECT * FROM tbl_customer WHERE customerID='$id'";
				$customer_query = mysql_query($query);
				if(mysql_num_rows($customer_query)!=0){
					while($customer_row=mysql_fetch_assoc($customer_query)){
						$companyname = $customer_row["companyname"];
						$address = $customer_row["address"];
						$phone = $customer_row["phone"];
						$contactperson = $customer_row["contactperson"];
					}
				}else{
					$companyname = $address = $phone = $contactperson = "";
				}
				
				echo "
				<input type='hidden' name='customerID' value='$id'>
				<h3 style='text-align:center'>Customer&#39s Credits</h3>
				<p><label>Company Name: </label> $companyname
				<br><label>Address: </label> $address
				<br><label>Contact Number: </label> $phone
				<br><label>Contact Person: </label> $contactperson</p>
				<div class='table-responsive'>
				<table class='table table-hover'>
				<thead>
				<tr>
					<th></th>
					<th>DR #</th>
					<th>Date</th>
					<th>Time</th>
					<th>Date Due</th>
					<th>Invoice #</th>
				</tr>
				</thead>
				<tbody>";
				$maxitem = $maximum_items_displayed; // maximum items
				$limit = ($page*$maxitem)-$maxitem;
				$query="SELECT * FROM tbl_orders WHERE type_payment LIKE '%credit%' AND customerID='$id' AND deleted='0'";
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
				
				$credit_query = mysql_query($query);
				if(mysql_num_rows($credit_query)!=0){
					while($credit_row=mysql_fetch_assoc($credit_query)){
						$orderID = $credit_row["orderID"];
						$date = $credit_row["date_ordered"];
						$time = $credit_row["time_ordered"];
						$comments = $credit_row["comments"];
						$date_due = date("m/d/Y",$credit_row["date_due"]);
						echo "
						<tr class='selected'>
							<td><input type='checkbox' value='$orderID' name='select[]'></td>
							<td><a href='sales-re?id=$orderID'>S".sprintf("%06d",$orderID)."</a></td>
							<td>$date</td>
							<td>$time</td>
							<td>$date_due</td>
							<td>$comments</td>
						</tr>
				";
					}
				}
				echo "
				</tbody>
				</table>
				</div>
				
				";
				echo "</table>
			";
			
			echo "
			<div class='text-center'>
			<ul class='pagination prints'>
			
			";
			$url="?tab=2&id=$id&";
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
			
			echo "
			</div>
			"; 
				
			}
			
			if(isset($_POST["a_report"])){
				$select = $_POST["select"];
				$customerID = $_POST["customerID"];
				if($select!=NULL){
					$_SESSION["selectcredit"]= $select;				
					header("location:credits-payments");					
				}else{
					header("location:credits?tab=2&id=".$customerID);
				}

			}
			if(isset($_POST["s_account"])){
				$customerID = $_POST["customerID"];
				$select = @$_POST["select"];
				if($select!=NULL){
					$_SESSION["selectcredit"]= $select;

					$paymentID = implode(",",$select);
					mysql_query("INSERT INTO tbl_soa VALUES ('','$','$accountID','0','$datenow','$timenow','$paymentID','$customerID','','')");
					$soa_query = mysql_query("SELECT * FROM tbl_soa ORDER BY soaID DESC LIMIT 0,1");
					if(mysql_num_rows($soa_query)!=0){
						while($soa_row=mysql_fetch_assoc($soa_query)){
							$soaID = $soa_row["soaID"];
						}
					header("location:credits-soa?id=".$soaID);
					}
				}else{
					header("location:credits?tab=2&id=".$customerID);
				}
			}
			
		}elseif($tab==3){
			echo "
			</form>
			<div class='row'>
				<div class='col-md-12'>
				<h3 style='text-align:center'>Paid Accounts</h3>
				<div class='pull-left input-group col-md-3'>
				<input type='hidden' name='tab' value='3' id='tab'>
				<input type='text' class='form-control' placeholder='Search for Customer' id='search_customer'>
				</div>
				
				<form action='credits' method='get'>
				<div class='pull-right input-group col-md-3'>
				<input type='hidden' name='tab' value='3'>
				<span class='input-group-addon'>AR</span>
				<input type='number' min='0' class='form-control' placeholder='Search for AR Number' name='ar'>
				</form>
				</div>
				
				
				</div>
			</div>
			<br>
			<div class='table-responsive'>
			<table class='table table-hover'>
			<thead>
				<tr>
					<th>AR #</th>
					<th>Sale ID</th>
					<th>Invoice #</th>
					<th>Date and Time Paid</th>
					<th style='text-align:right'>Amount</th>
					<th style='text-align:right'>Payment Received</th>
					<th>Payment Type</th>
					<th>Customer</th>
					<th>Received By</th>
					<th>Comments</th>
				</tr>
			</thead>";
			$creditID=@$_GET["ar"];
			$customerID=@$_GET["id"];
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;
			$query ="SELECT * FROM tbl_credits";
			if(isset($creditID)){
				$query.=" WHERE creditID='$creditID'";
			}elseif(isset($customerID)){
				$query.=" WHERE customerID='$customerID'";
			}
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
			$credit_query = mysql_query($query);
			if(mysql_num_rows($credit_query)!=0){
				while($credit_row=mysql_fetch_assoc($credit_query)){
					$creditID = $credit_row["creditID"];
					$dbaccountID = $credit_row["accountID"];
					$dbcustomerID = $credit_row["customerID"];
					$dbamount = $credit_row["amount"];
					$dbpayment = $credit_row["payment"];
					$dbpaymentID = $credit_row["paymentID"];
					$dbtype_payment = $credit_row["type_payment"];
					$dbcomments = $credit_row["comments"];
					$account_query = mysql_query("SELECT * FROM tbl_users WHERE accountID='$dbaccountID'");{
						while($account_row=mysql_fetch_assoc($account_query)){
							$db_employee_name = $account_row["employee_name"];
						}
					}
					$customer_query= mysql_query("SELECT * FROM tbl_customer WHERE customerID='$dbcustomerID'");{
						while($customer_row=mysql_fetch_assoc($customer_query)){
							$companyname = $customer_row["companyname"];
						}
					}
					$dbpaymentID_array = explode(",",$dbpaymentID);
					
					$orderID_array=array();
					$invoice_array=array();
					foreach($dbpaymentID_array as $dbpaymentID){
					$payments_query = mysql_query("SELECT * FROM tbl_payments WHERE paymentID='$dbpaymentID'");
						while($payments_row=mysql_fetch_assoc($payments_query)){
							$orderID_array[] = $payments_row["orderID"];
							$date = $payments_row["date"];
							$time = $payments_row["time"];
							$amount = $payments_row["time"];
							$invoice_array[] = $payments_row["comments"];
							
						}	
					}
					

					echo "
					<tr>
						<td><a href='credits-ar?id=$creditID'>AR".sprintf("%06d",$creditID)."</a></td>
						<td>";
						$i=0;
						foreach($orderID_array as $orderID){
							if($i==0){
								echo "<a href='sales-re?id=$orderID'>S".sprintf("%06d",$orderID)."</a>";
							}else{
								echo "<br><a href='sales-re?id=$orderID'>S".sprintf("%06d",$orderID)."</a>";
							}
							$i++;
						}
						
					echo "	</td>
					<td>";
						$i=0;
						foreach($invoice_array as $invoice){
							if($i==0){
								echo "$invoice";
							}else{
								echo "<br>$invoice";
							}
							$i++;
						}
						
					echo "	</td>
						<td>$date $time</td>
						<th style='text-align:right'>₱".number_format($dbamount,2)."</th>
						<th style='text-align:right'>₱".number_format($dbpayment,2)."</th>
						<td>$dbtype_payment</td>
						<td><a href='?tab=3&id=$dbcustomerID'>$companyname</a></td>
						<td>$db_employee_name</td>
						<td>$dbcomments</td>
					</tr>
					";
				}
			}else{
			echo "
			<tr>
				<td colspan='20' align='center'><b style='font-size:200%'>No Results Found.</b></td>
			</tr>
			<tfoot>
				<tr>
					<td></td>
				</tr>
			</tfoot>
			";
			}
			echo "</table>
			</div>";
			if(!isset($_GET['ar'])){
			echo "
			<div class='text-center'>
			<ul class='pagination prints'>
			
			";
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$url="?tab=3&id=$id&";
			}else{
				$url="?tab=3&";
			}
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
			echo "</ul><span class='page' >Page $page</span>
			</div>";
			}

		}elseif($tab==4){
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$date_from = $_GET["date_from"];
			$date_to = $_GET["date_to"];
			$ar_number = $_GET["ar"];
			$get_customerID = $_GET["c"];
			$get_salesmanID = $_GET["s"];
			echo "<h3 style='text-align:center;'>Past Due Accounts Receivable (1-30 Days)</h3>";
			$query = "SELECT * FROM tbl_orders WHERE  fully_paid='0' AND deleted='0' AND balance!= 0 AND date_due< '".strtotime($date)."' AND overdue_date_1 >= '".strtotime($date)."' ORDER BY date_due DESC, time_ordered DESC";
			// echo $query;
			$order_query = mysql_query($query);
			$customers = array();
			$salesman = array();
			if(mysql_num_rows($order_query)!=0){
				while($order_row = mysql_fetch_assoc($order_query)){
					if($order_row["customerID"]!=0){
						$customers[] = $order_row["customerID"];
					}
					if($order_row["salesmanID"] != 0){
						$salesman[] = $order_row["salesmanID"];
					}
				}
			}
			$customers = array_unique($customers);
			$salesman = array_unique($salesman);


			echo '
			</form>
			<form action="" method="get">
				<input type="text" name="date_from" id="date_from_ar" placeholder="Date From" value="'.$date_from.'">
				<input type="text" name="date_to" id="date_to_ar" placeholder="Date To" value="'.$date_to.'">
				';
			echo '<select name="c">';
			$get_customerID = $_GET["c"];
			echo '<option value="">All Customers</option>';
			foreach ($customers as $customerID) {
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
				echo '<option value="'.$customerID.'" ';
				echo ($get_customerID==$customerID?'selected="selected"':false);
				echo '>'.$customer_data["companyname"].'</option>';
			}
			echo '</select>';
			echo '<select name="s">';
			$get_salesmanID = $_GET["s"];
			echo '<option value="">All Salesman</option>';
			foreach ($salesman as $salesmanID) {
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo '<option value="'.$salesmanID.'" ';
				echo ($get_salesmanID==$salesmanID?'selected="selected"':false);
				echo '>'.$salesman_data["salesman_name"].'</option>';
			}
			echo '</select>';
			echo '
				<input type="hidden" name="tab" value="4">
				<input type="submit" name="search" value="Search">
			</form>
			';
			echo "
			<div class='table-responsive'>
			<table class='table table-hover'>
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Delivery Date</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Date Due</th>
				<th>Amount</th>
				<th>TS #</th>
			</tr>
			<tbody>";


			$query = "SELECT * FROM tbl_orders WHERE  fully_paid='0' AND deleted='0' AND balance!= 0 AND date_due< '".strtotime($date)."' AND overdue_date_1 >= '".strtotime($date)."'";

			if($date_from != "" && $date_to != ""){
				$query .= " AND date_delivered BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}
			if($get_customerID != ""){
				$query .= " AND customerID='".$get_customerID."'";
			}
			if($get_salesmanID != ""){
				$query .= " AND salesmanID='".$get_salesmanID."'";
			}
			$query .= " ORDER BY date_due DESC, time_ordered DESC";

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


			$order_query = mysql_query($query);
			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$orderID = $order_row["orderID"];
					$date_ordered = $order_row["date_ordered"];
					$total = $order_row["total"];
					$date_due = $order_row["date_due"];
					$date_delivered = $order_row["date_delivered"];
					$terms = $order_row["terms"];


					$date1=date_create(date("m/d/Y",$date_due));
					$date2=date_create(date("m/d/Y"));
					$diff=date_diff($date1,$date2);
					$aging = $diff->format("%a days");

					$ts_orderID = $order_row["ts_orderID"];
					$customerID = $order_row["customerID"];
					$customer = $order_row["customer"];
					$salesmanID = $order_row["salesmanID"];
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
					$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
					($date_due<=strtotime($date)?$status="warning":$status="");
					($terms==0?$terms="COD":false);
					echo "
						<tr class='$status'>
							<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
							<td>$terms</td>
							<td>".date("m/d/Y",$date_delivered)."</td>
							<td>".$customer."</td>
							<td>".$salesman_data["salesman_name"]."</td>
							<td>".date("m/d/Y",$date_due)."</td>
							<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
							<td>$ts_orderID</td>
						</tr>
					";
				}
			}
			echo "
			</tbody>
			</thead>
			</table>";

			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?date_from=$date_from&date_to=$date_to&c=$get_customerID&s=$get_salesmanID&tab=$tab&";
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
			echo "
			</div>
			";
			
		}elseif($tab==5){
			$date_from = $_GET["date_from"];
			$date_to = $_GET["date_to"];
			$ar_number = $_GET["ar"];
			$query = "SELECT * FROM tbl_payments WHERE type_payment='cash' AND deleted='0'";
			if($date_from != "" && $date_to != ""){
				$query .= " AND date_payment BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}

			// echo $query;
			$cash_payment_query = mysql_query($query);
			$customers = array();
			$salesman = array();
			if(mysql_num_rows($cash_payment_query)!=0){
				while($cash_payment_row=mysql_fetch_assoc($cash_payment_query)){
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='".$cash_payment_row["orderID"]."'"));

					if($order_data["customerID"]!=0){
						$customers[] = $order_data["customerID"];
					}

					if($order_data["salesmanID"]!=0){
						$salesman[] = $order_data["salesmanID"];
					}
				}
			}
			$customers = array_unique($customers);
			$salesman = array_unique($salesman);
			// var_dump($salesman);
			echo '
			</form>
			<h3 style="text-align:center;">Paid with Cash</h3>
			<form action="" method="get">
				<input type="text" name="date_from" id="date_from_ar" placeholder="Date From" value="'.$date_from.'">
				<input type="text" name="date_to" id="date_to_ar" placeholder="Date To" value="'.$date_to.'">
				<input type="text" name="ar" placeholder="AR Number" value="'.$ar_number.'">
				';
			echo '<select name="c">';
			$get_customerID = $_GET["c"];
			echo '<option value="">All Customers</option>';
			foreach ($customers as $customerID) {
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
				echo '<option value="'.$customerID.'" ';
				echo ($get_customerID==$customerID?'selected="selected"':false);
				echo '>'.$customer_data["companyname"].'</option>';
			}
			echo '</select>';
			echo '<select name="s">';
			$get_salesmanID = $_GET["s"];
			echo '<option value="">All Salesman</option>';
			foreach ($salesman as $salesmanID) {
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo '<option value="'.$salesmanID.'" ';
				echo ($get_salesmanID==$salesmanID?'selected="selected"':false);
				echo '>'.$salesman_data["salesman_name"].'</option>';
			}
			echo '</select>';
			echo '
				<input type="hidden" name="tab" value="5">
				<input type="submit" name="search" value="Search">
			</form>
			';
			echo '
			
			<div class="table-responsive">
			<table class="table table-hover">
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Date Due</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Total</th>
				<th>Balance</th>
				<th>Amount of Payment</th>
				<th>Date of Payment</th>
				<th>AR #</th>
			</tr>
			<tbody>';
			$get_customerID = $_GET["c"];
			$get_salesmanID = $_GET["s"];

			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$query = "SELECT * FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_payments.type_payment='cash' AND tbl_payments.deleted='0'";
			if($date_from != "" && $date_to != ""){
				$query .= " AND tbl_payments.date_payment BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}
			if($ar_number != ""){
				$query .= " AND tbl_payments.ar_number LIKE '".$ar_number."'";
			}
			if($get_customerID != ""){
				$query .= " AND tbl_orders.customerID='".$get_customerID."'";
			}
			if($get_salesmanID != ""){
				$query .= " AND tbl_orders.salesmanID='".$get_salesmanID."'";
			}

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

			$cash_payment_query = mysql_query($query);
			if(mysql_num_rows($cash_payment_query)!=0){
				while($cash_payment_row=mysql_fetch_assoc($cash_payment_query)){
					$orderID = $cash_payment_row["orderID"];
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='".$order_data["salesmanID"]."'"));
					$terms = $order_data["terms"];
					($terms==0?$terms="COD":false);
					echo '
					<tr>
						<td><a href="sales-complete?id='.$orderID.'">'.$orderID.'</a></td>
						<td>'.$terms.'</td>
						<td>'.date("m/d/Y",$order_data["date_due"]).'</td>
						<td>'.$order_data["customer"].'</td>
						<td>'.$salesman_data["salesman_name"].'</td>
						<td style="text-align: right;">'.number_format($order_data["total"],2).'</td>
						<td style="text-align: right;">'.number_format($order_data["balance"],2).'</td>
						<td style="text-align: right;">'.number_format($cash_payment_row["amount"],2).'</td>
						<td>'.date("m/d/Y",$cash_payment_row["date_payment"]).'</td>
						<td>'.$cash_payment_row["ar_number"].'</td>
					</tr>
					';
				}
			}
			echo '
			</tbody>
			</table>';
			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?date_from=$date_from&date_to=$date_to&ar=$ar_number&c=$get_customerID&s=$get_salesmanID&tab=$tab&";
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
			echo '
			</div>
			';
			echo '
			</div>
			';







			/*




echo "
<h3 style='text-align:center;'>Paid with Cash</h3>
<div class='table-responsive'>
<table class='table table-hover'>
<thead>
<tr>
	<th>DR #</th>
	<th>Terms</th>
	<th>Date</th>
	<th>Customer</th>
	<th>Account Specialist</th>
	<th>Date Due</th>
	<th>Amount</th>
	<th>Payments</th>
	<th>Date of Payment</th>
	<th>TS #</th>
</tr>
<tbody>";
echo "
<label>Filter By:</label>
<input type='text' id='date_from' placeholder='Date From' value='";
if(isset($f)&&$f!=""){
	echo $f;
}
echo "'>
<input type='text' id='date_to' placeholder='Date To' value='";
if(isset($t)&&$t!=""){
	echo $t;
}
echo "'>
</select>
<select id='order'>
	<option value='ASC' ";
		if(isset($o)&&$o=="ASC"){
			echo "selected='selected'";
		}
	echo">Ascending</option>
	<option value='DESC' ";
		if(isset($o)&&$o=="DESC"){
			echo "selected='selected'";
		}
	echo">Discending</option>
</select>
";
if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
$maxitem = $maximum_items_displayed; // maximum items
$limit = ($page*$maxitem)-$maxitem;

$query = "SELECT * FROM tbl_orders WHERE deleted='0' AND payment!='0'";
$customer_unique = "SELECT DISTINCT customerID FROM tbl_orders WHERE deleted='0' AND payment!='0'";
if(isset($s)&&$s!=""){
	$customer_unique.= " AND salesmanID='$s'";
}
if(isset($c)&&$c!=""){
	$query.= " AND customerID = '$c'";
}

if(isset($f)&&isset($t)&&$f!=""&&$t!=""){
	$query.=" AND date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."'";
}


$customer_unique = mysql_query($customer_unique);
echo "
	<select id='customer'>
		<option value=''>All Customers</option>";
		while($customer_unique_row=mysql_fetch_assoc($customer_unique)){
			$customer_unique_customerID = $customer_unique_row["customerID"];
			$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customer_unique_customerID'"));
			if($customer_unique_customerID!=""){
				echo "<option value='$customer_unique_customerID' ";
				if(isset($c)&&$c==$customer_unique_customerID){
					echo "selected='selected'";
				}
				echo">".$customer_data["companyname"]."</option>";
			}
		}
echo "<select>";

$salesman_unique = "SELECT DISTINCT salesmanID FROM tbl_orders WHERE deleted='0' AND payment!='0'";
if(isset($c)&&$c!=""){
	$salesman_unique.= " AND customerID='$c'";
}
if(isset($s)&&$s!=""){
	$query.= " AND salesmanID = '$s'";
}


$salesman_unique = mysql_query($salesman_unique);
echo "
	<select id='salesman'>
		<option value=''>All Salesman</option>";
		while($salesman_unique_row=mysql_fetch_assoc($salesman_unique)){
			$salesman_unique_salesmanID = $salesman_unique_row["salesmanID"];
			$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesman_unique_salesmanID'"));
			if($salesman_unique_salesmanID!=""){
				echo "<option value='$salesman_unique_salesmanID' ";
				if(isset($s)&&$s==$salesman_unique_salesmanID){
					echo "selected='selected'";
				}
				echo">".$salesman_data["salesman_name"]."</option>";
			}
		}
echo "<select>";

// echo $query;
if(strtolower($b)=="due"){
	$query.=" ORDER BY date_due";
}elseif(strtolower($b)=="date"){
	$query.=" ORDER BY date_ordered";
}else{
	$query.=" ORDER BY orderID";
}
if(strtolower($o)=="desc"){
	$query.=" DESC";
}else{
	$query.=" ASC";
}
$numitemquery = mysql_query($query);
$numitem = mysql_num_rows($numitemquery);
$export_query = $query;
$query.=" LIMIT $limit, $maxitem";
// echo $query;
$order_query = mysql_query($query);

 		if(($numitem%$maxitem)==0){
			$lastpage=($numitem/$maxitem);
		}else{
			$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
		}
		$maxpage = 3;

if(mysql_num_rows($order_query)!=0){
	while($order_row=mysql_fetch_assoc($order_query)){
		$orderID = $order_row["orderID"];
		$date_ordered = $order_row["date_ordered"];
		$total = $order_row["total"];
		$date_due = $order_row["date_due"];
		$ts_orderID = $order_row["ts_orderID"];
		$date_payment = $order_row["date_payment"];
		$payment_change = $order_row["payment_change"];
		$payment = $order_row["payment"];
		$terms = $order_row["terms"];
		$customerID = $order_row["customerID"];
		$salesmanID = $order_row["salesmanID"];
		$pdc_check_number = $order_row["pdc_check_number"];
		$pdc_amount = $order_row["pdc_amount"];
		$total_amount_payment = $payment-$payment_change;
		($order_row["pdc_date"]==0?$pdc_date="":$pdc_date = date("m/d/Y",$order_row["pdc_date"]));
		($order_row["pdc_amount"]==0?$pdc_amount="":$pdc_amount = number_format($order_row["pdc_amount"],2));
		
		$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
		$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
		$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
		($date_due<=strtotime($date)?$status="warning":$status="");
		echo "
			<tr class='$status'>
				<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
				<td>$terms</td>
				<td>".date("m/d/Y",$date_ordered)."</td>
				<td><a href='?tab=2&id=$customerID'>".$customer_data["companyname"]."</a></td>
				<td>".$salesman_data["salesman_name"]."</td>
				<td>".date("m/d/Y",$date_due)."</td>
				<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
				<td style='text-align:right'>".number_format($total_amount_payment,2)."</td>
				<td>".date("m/d/y",$date_payment)."</td>
				<td>$ts_orderID</td>
			</tr>
		";
	}
}
echo "
</tbody>
</thead>
</table>";			
echo "
<div class='text-center'>
<ul class='pagination prints'>

";
$url="?b=$b&o=$o&c=$c&s=$s&";
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


echo "</div>
";
?>
</form>
<!--
<form action='#' method='post'>
<button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Report</button>
</form>
-->
	<?php
		if(isset($_POST["download"])){
			$filename = "reports-files\sales-reports-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
			// echo $filename;
			$fp = fopen($filename, 'w');
			$fields = array("Date","DR #","Customer","Account Specialist","SKU Code","Product Name","Supplier","Category","UOM","QTY","Price","Total Amount","Status","Date Returned");
			fputcsv($fp, $fields);
			$export_query = mysql_query($export_query);
			while ($export_row=mysql_fetch_assoc($export_query)) {
				$date_ordered = $export_row["date_ordered"];
				$customerID = $export_row["customerID"];
				$itemID = $export_row["itemID"];
				$salesmanID = $export_row["salesmanID"];
				$quantity = $export_row["quantity"];
				$orderID = $export_row["orderID"];
				$price = $export_row["price"];
				$amount = $price*$quantity;
				$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
				$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
				$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID = '".$item_data["supplierID"]."'"));
				$received = $order_data["received"];
				if($received!=0){
					$status = "Returned";
					$received_date = date("m/d/Y",$order_data["received"]);
				}else{
					$status = "";
					$received_date = "";
				}

				$fields = array(date("m/d/Y",$date_ordered),$orderID,$customer_data["companyname"],$salesman_data["salesman_name"],$item_data["item_code"],$item_data["itemname"],$supplier_data["supplier_company"],$item_data["category"],$item_data["unit_of_measure"],number_format($quantity),number_format($price,2),number_format($amount,2),$status);
				fputcsv($fp, $fields);
				# code...
			}
			$fields = array('','','','','','','','','','','TOTAL',number_format($total_amount["total_amount"],2),'','','');
			fputcsv($fp, $fields);
			fclose($fp);
			header("location:".$filename);
		}	
	?>
<?php



			*/



		}elseif ($tab==6) {
			$date_from = $_GET["date_from"];
			$date_to = $_GET["date_to"];
			$ar_number = $_GET["ar"];
			$query = "SELECT * FROM tbl_payments WHERE type_payment='pdc' AND deleted='0'";
			if($date_from != "" && $date_to != ""){
				$query .= " AND date_payment BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}

			// echo $query;
			$cash_payment_query = mysql_query($query);
			$customers = array();
			$salesman = array();
			if(mysql_num_rows($cash_payment_query)!=0){
				while($cash_payment_row=mysql_fetch_assoc($cash_payment_query)){
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='".$cash_payment_row["orderID"]."'"));

					if($order_data["customerID"]!=0){
						$customers[] = $order_data["customerID"];
					}

					if($order_data["salesmanID"]!=0){
						$salesman[] = $order_data["salesmanID"];
					}
				}
			}
			$customers = array_unique($customers);
			$salesman = array_unique($salesman);
			// var_dump($salesman);
			echo '
			</form>
			<h3 style="text-align:center;">Paid with PDC</h3>
			<form action="" method="get">
				<input type="text" name="date_from" id="date_from_ar" placeholder="Date From" value="'.$date_from.'">
				<input type="text" name="date_to" id="date_to_ar" placeholder="Date To" value="'.$date_to.'">
				<input type="text" name="ar" placeholder="AR Number" value="'.$ar_number.'">
				';
			echo '<select name="c">';
			$get_customerID = $_GET["c"];
			echo '<option value="">All Customers</option>';
			foreach ($customers as $customerID) {
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
				echo '<option value="'.$customerID.'" ';
				echo ($get_customerID==$customerID?'selected="selected"':false);
				echo '>'.$customer_data["companyname"].'</option>';
			}
			echo '</select>';
			echo '<select name="s">';
			$get_salesmanID = $_GET["s"];
			echo '<option value="">All Salesman</option>';
			foreach ($salesman as $salesmanID) {
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo '<option value="'.$salesmanID.'" ';
				echo ($get_salesmanID==$salesmanID?'selected="selected"':false);
				echo '>'.$salesman_data["salesman_name"].'</option>';
			}
			echo '</select>';
			echo '
				<input type="hidden" name="tab" value="6">
				<input type="submit" name="search" value="Search">
			</form>
			';


			echo '
			
			<div class="table-responsive">
			<table class="table table-hover">
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Date Due</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Total</th>
				<th>Balance</th>
				<th>AR #</th>
				<th>PDC Date</th>
				<th>PDC Check Number</th>
				<th>PDC Amount</th>
				<th>Date Deposited</th>
			</tr>
			<tbody>';


			$get_customerID = $_GET["c"];
			$get_salesmanID = $_GET["s"];
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$query = "SELECT *, tbl_payments.date_payment as pdc_date_payment  FROM tbl_payments INNER JOIN tbl_orders ON tbl_payments.orderID = tbl_orders.orderID WHERE tbl_payments.type_payment='pdc' AND tbl_payments.deleted='0'";
			if($date_from != "" && $date_to != ""){
				$query .= " AND tbl_payments.date_payment BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}
			if($ar_number != ""){
				$query .= " AND tbl_payments.ar_number LIKE '".$ar_number."'";
			}
			if($get_customerID != ""){
				$query .= " AND tbl_orders.customerID='".$get_customerID."'";
			}
			if($get_salesmanID != ""){
				$query .= " AND tbl_orders.salesmanID='".$get_salesmanID."'";
			}
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

			$cash_payment_query = mysql_query($query);
			if(mysql_num_rows($cash_payment_query)!=0){
				while($cash_payment_row=mysql_fetch_assoc($cash_payment_query)){
					$orderID = $cash_payment_row["orderID"];
					$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='".$order_data["salesmanID"]."'"));
					$terms = $order_data["terms"];
					($terms==0?$terms="COD":false);
					echo '
					<tr>
						<td><a href="sales-complete?id='.$orderID.'">'.$orderID.'</a></td>
						<td>'.$terms.'</td>
						<td>'.date("m/d/Y",$order_data["date_due"]).'</td>
						<td>'.$order_data["customer"].'</td>
						<td>'.$salesman_data["salesman_name"].'</td>
						<td style="text-align: right;">'.number_format($order_data["total"],2).'</td>
						<td style="text-align: right;">'.number_format($order_data["balance"],2).'</td>
						<td>'.$cash_payment_row["ar_number"].'</td>
						<td style="text-align: right;">'.number_format($cash_payment_row["amount"],2).'</td>
						<td>'.date("m/d/Y",$cash_payment_row["pdc_date_payment"]).'</td>
						<td>'.$cash_payment_row["ar_number"].'</td>
					</tr>
					';
				}
			}
			echo '
			</tbody>
			</table>';
			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?date_from=$date_from&date_to=$date_to&ar=$ar_number&c=$get_customerID&s=$get_salesmanID&tab=$tab&";
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
			echo '
			</div>
			';





		/*





echo "
<h3 style='text-align:center;'>Paid with PDC</h3>
<div class='table-responsive'>
<table class='table table-hover'>
<thead>
<tr>
	<th>DR #</th>
	<th>Terms</th>
	<th>Date</th>
	<th>Customer</th>
	<th>Account Specialist</th>
	<th>Date Due</th>
	<th>Amount</th>
	<th>TS #</th>
	<th>PDC Date</th>
	<th>PDC Check Number</th>
	<th>PDC Amount</th>
</tr>
<tbody>";
echo "
<label>Filter By:</label>
<input type='text' id='date_from' placeholder='Date From' value='";
if(isset($f)&&$f!=""){
	echo $f;
}
echo "'>
<input type='text' id='date_to' placeholder='Date To' value='";
if(isset($t)&&$t!=""){
	echo $t;
}
echo "'>
</select>
<select id='order'>
	<option value='ASC' ";
		if(isset($o)&&$o=="ASC"){
			echo "selected='selected'";
		}
	echo">Ascending</option>
	<option value='DESC' ";
		if(isset($o)&&$o=="DESC"){
			echo "selected='selected'";
		}
	echo">Discending</option>
</select>
";
if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
$maxitem = $maximum_items_displayed; // maximum items
$limit = ($page*$maxitem)-$maxitem;

$query = "SELECT * FROM tbl_orders WHERE pdc_amount!='0' AND deleted='0'";
$customer_unique = "SELECT DISTINCT customerID FROM tbl_orders WHERE pdc_amount!='0' AND deleted='0'";
if(isset($s)&&$s!=""){
	$customer_unique.= " AND salesmanID='$s'";
}
if(isset($c)&&$c!=""){
	$query.= " AND customerID = '$c'";
}

if(isset($f)&&isset($t)&&$f!=""&&$t!=""){
	$query.=" AND date_ordered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."'";
}


$customer_unique = mysql_query($customer_unique);
echo "
	<select id='customer'>
		<option value=''>All Customers</option>";
		while($customer_unique_row=mysql_fetch_assoc($customer_unique)){
			$customer_unique_customerID = $customer_unique_row["customerID"];
			$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customer_unique_customerID'"));
			if($customer_unique_customerID!=""){
				echo "<option value='$customer_unique_customerID' ";
				if(isset($c)&&$c==$customer_unique_customerID){
					echo "selected='selected'";
				}
				echo">".$customer_data["companyname"]."</option>";
			}
		}
echo "<select>";

$salesman_unique = "SELECT DISTINCT salesmanID FROM tbl_orders WHERE pdc_amount!='0' AND deleted='0'";
if(isset($c)&&$c!=""){
	$salesman_unique.= " AND customerID='$c'";
}
if(isset($s)&&$s!=""){
	$query.= " AND salesmanID = '$s'";
}


$salesman_unique = mysql_query($salesman_unique);
echo "
	<select id='salesman'>
		<option value=''>All Salesman</option>";
		while($salesman_unique_row=mysql_fetch_assoc($salesman_unique)){
			$salesman_unique_salesmanID = $salesman_unique_row["salesmanID"];
			$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesman_unique_salesmanID'"));
			if($salesman_unique_salesmanID!=""){
				echo "<option value='$salesman_unique_salesmanID' ";
				if(isset($s)&&$s==$salesman_unique_salesmanID){
					echo "selected='selected'";
				}
				echo">".$salesman_data["salesman_name"]."</option>";
			}
		}
echo "<select>";

// echo $query;
if(strtolower($b)=="due"){
	$query.=" ORDER BY date_due";
}elseif(strtolower($b)=="date"){
	$query.=" ORDER BY date_ordered";
}else{
	$query.=" ORDER BY orderID";
}
if(strtolower($o)=="desc"){
	$query.=" DESC";
}else{
	$query.=" ASC";
}
$numitemquery = mysql_query($query);
$numitem = mysql_num_rows($numitemquery);
$export_query = $query;
$query.=" LIMIT $limit, $maxitem";
// echo $query;
$order_query = mysql_query($query);

 		if(($numitem%$maxitem)==0){
			$lastpage=($numitem/$maxitem);
		}else{
			$lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
		}
		$maxpage = 3;

if(mysql_num_rows($order_query)!=0){
	while($order_row=mysql_fetch_assoc($order_query)){
		$orderID = $order_row["orderID"];
		$date_ordered = $order_row["date_ordered"];
		$total = $order_row["total"];
		$date_due = $order_row["date_due"];
		$ts_orderID = $order_row["ts_orderID"];
		$terms = $order_row["terms"];
		$customerID = $order_row["customerID"];
		$salesmanID = $order_row["salesmanID"];
		$pdc_check_number = $order_row["pdc_check_number"];
		$pdc_amount = $order_row["pdc_amount"];
		($order_row["pdc_date"]==0?$pdc_date="":$pdc_date = date("m/d/Y",$order_row["pdc_date"]));
		($order_row["pdc_amount"]==0?$pdc_amount="":$pdc_amount = number_format($order_row["pdc_amount"],2));
		
		$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
		$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
		$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
		($date_due<=strtotime($date)?$status="warning":$status="");
		echo "
			<tr class='$status'>
				<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
				<td>$terms</td>
				<td>".date("m/d/Y",$date_ordered)."</td>
				<td><a href='?tab=2&id=$customerID'>".$customer_data["companyname"]."</a></td>
				<td>".$salesman_data["salesman_name"]."</td>
				<td>".date("m/d/Y",$date_due)."</td>
				<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
				<td>$ts_orderID</td>
				<td>$pdc_date</td>
				<td>$pdc_check_number</td>
				<td style='text-align:right'>$pdc_amount</td>
			</tr>
		";
	}
}
echo "
</tbody>
</thead>
</table>";			
echo "
<div class='text-center'>
<ul class='pagination prints'>

";
$url="?b=$b&o=$o&c=$c&s=$s&";
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


echo "</div>
";
?>
</form>
<!--
<form action='#' method='post'>
<button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Report</button>
</form>
-->
	<?php
		if(isset($_POST["download"])){
			$filename = "reports-files\sales-reports-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
			// echo $filename;
			$fp = fopen($filename, 'w');
			$fields = array("Date","DR #","Customer","Account Specialist","SKU Code","Product Name","Supplier","Category","UOM","QTY","Price","Total Amount","Status","Date Returned");
			fputcsv($fp, $fields);
			$export_query = mysql_query($export_query);
			while ($export_row=mysql_fetch_assoc($export_query)) {
				$date_ordered = $export_row["date_ordered"];
				$customerID = $export_row["customerID"];
				$itemID = $export_row["itemID"];
				$salesmanID = $export_row["salesmanID"];
				$quantity = $export_row["quantity"];
				$orderID = $export_row["orderID"];
				$price = $export_row["price"];
				$amount = $price*$quantity;
				$order_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_orders WHERE orderID='$orderID'"));
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
				$item_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_items WHERE itemID='$itemID'"));
				$supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID = '".$item_data["supplierID"]."'"));
				$received = $order_data["received"];
				if($received!=0){
					$status = "Returned";
					$received_date = date("m/d/Y",$order_data["received"]);
				}else{
					$status = "";
					$received_date = "";
				}

				$fields = array(date("m/d/Y",$date_ordered),$orderID,$customer_data["companyname"],$salesman_data["salesman_name"],$item_data["item_code"],$item_data["itemname"],$supplier_data["supplier_company"],$item_data["category"],$item_data["unit_of_measure"],number_format($quantity),number_format($price,2),number_format($amount,2),$status);
				fputcsv($fp, $fields);
				# code...
			}
			$fields = array('','','','','','','','','','','TOTAL',number_format($total_amount["total_amount"],2),'','','');
			fputcsv($fp, $fields);
			fclose($fp);
			header("location:".$filename);
		}	
	?>
<?php

# code...


		*/

		}elseif ($tab==7) {

			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$date_from = $_GET["date_from"];
			$date_to = $_GET["date_to"];
			$ar_number = $_GET["ar"];
			$get_customerID = $_GET["c"];
			$get_salesmanID = $_GET["s"];

			echo "<h3 style='text-align:center;'>Past Due Accounts Receivable (31-60 Days)</h3>";
			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND balance!= 0 AND overdue_date_1< '".strtotime($date)."' AND overdue_date_2 >= '".strtotime($date)."' ORDER BY date_due DESC, time_ordered DESC";
			// echo $query;
			$order_query = mysql_query($query);
			$customers = array();
			$salesman = array();
			if(mysql_num_rows($order_query)!=0){
				while($order_row = mysql_fetch_assoc($order_query)){
					if($order_row["customerID"]!=0){
						$customers[] = $order_row["customerID"];
					}
					if($order_row["salesmanID"] != 0){
						$salesman[] = $order_row["salesmanID"];
					}
				}
			}
			$customers = array_unique($customers);
			$salesman = array_unique($salesman);

			echo '
			</form>
			<form action="" method="get">
				<input type="text" name="date_from" id="date_from_ar" placeholder="Date From" value="'.$date_from.'">
				<input type="text" name="date_to" id="date_to_ar" placeholder="Date To" value="'.$date_to.'">
				';
			echo '<select name="c">';
			$get_customerID = $_GET["c"];
			echo '<option value="">All Customers</option>';
			foreach ($customers as $customerID) {
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
				echo '<option value="'.$customerID.'" ';
				echo ($get_customerID==$customerID?'selected="selected"':false);
				echo '>'.$customer_data["companyname"].'</option>';
			}
			echo '</select>';
			echo '<select name="s">';
			$get_salesmanID = $_GET["s"];
			echo '<option value="">All Salesman</option>';
			foreach ($salesman as $salesmanID) {
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo '<option value="'.$salesmanID.'" ';
				echo ($get_salesmanID==$salesmanID?'selected="selected"':false);
				echo '>'.$salesman_data["salesman_name"].'</option>';
			}
			echo '</select>';
			echo '
				<input type="hidden" name="tab" value="7">
				<input type="submit" name="search" value="Search">
			</form>
			';

			echo "
			
			<div class='table-responsive'>
			<table class='table table-hover'>
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Date</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Date Due</th>
				<th>Amount</th>
				<th>TS #</th>
			</tr>
			<tbody>";

			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND balance!= 0 AND overdue_date_1< '".strtotime($date)."' AND overdue_date_2 >= '".strtotime($date)."'";

			if($date_from != "" && $date_to != ""){
				$query .= " AND date_delivered BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}
			if($get_customerID != ""){
				$query .= " AND customerID='".$get_customerID."'";
			}
			if($get_salesmanID != ""){
				$query .= " AND salesmanID='".$get_salesmanID."'";
			}
			$query .= " ORDER BY date_due DESC, time_ordered DESC";

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
			$order_query = mysql_query($query);
			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$orderID = $order_row["orderID"];
					$date_ordered = $order_row["date_ordered"];
					$total = $order_row["total"];
					$date_due = $order_row["date_due"];
					$terms = $order_row["terms"];
					$ts_orderID = $order_row["ts_orderID"];
					$customer = $order_row["customer"];
					$customerID = $order_row["customerID"];
					$salesmanID = $order_row["salesmanID"];


					$date1=date_create(date("m/d/Y",$date_due));
					$date2=date_create(date("m/d/Y"));
					$diff=date_diff($date1,$date2);
					$aging = $diff->format("%a days");


					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
					$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
					($date_due<=strtotime($date)?$status="warning":$status="");
					($terms==0?$terms="COD":false);
					echo "
						<tr class='$status'>
							<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
							<td>$terms</td>
							<td>".date("m/d/Y",$date_ordered)."</td>
							<td>$customer</td>
							<td>".$salesman_data["salesman_name"]."</td>
							<td>".date("m/d/Y",$date_due)."</td>
							<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
							<td>$ts_orderID</td>
						</tr>
					";
				}
			}
			echo "
			</tbody>
			</thead>
			</table>";

			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?date_from=$date_from&date_to=$date_to&c=$get_customerID&s=$get_salesmanID&tab=$tab&";
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
			echo "
			</div>
			";
			echo "
			</div>
			";
			
			
		}elseif ($tab==8) {
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;
			
			$date_from = $_GET["date_from"];
			$date_to = $_GET["date_to"];
			$ar_number = $_GET["ar"];
			$get_customerID = $_GET["c"];
			$get_salesmanID = $_GET["s"];

			echo "<h3 style='text-align:center;'>Past Due Accounts Receivable (over 61 Days)</h3>";
			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND balance!= 0 AND deleted='0' AND balance!= 0 AND overdue_date_2< '".strtotime($date)."' ORDER BY date_due DESC, time_ordered DESC";
			// echo $query;
			$order_query = mysql_query($query);
			$customers = array();
			$salesman = array();
			if(mysql_num_rows($order_query)!=0){
				while($order_row = mysql_fetch_assoc($order_query)){
					if($order_row["customerID"]!=0){
						$customers[] = $order_row["customerID"];
					}
					if($order_row["salesmanID"] != 0){
						$salesman[] = $order_row["salesmanID"];
					}
				}
			}
			$customers = array_unique($customers);
			$salesman = array_unique($salesman);

			echo '
			</form>
			<form action="" method="get">
				<input type="text" name="date_from" id="date_from_ar" placeholder="Date From" value="'.$date_from.'">
				<input type="text" name="date_to" id="date_to_ar" placeholder="Date To" value="'.$date_to.'">
				';
			echo '<select name="c">';
			$get_customerID = $_GET["c"];
			echo '<option value="">All Customers</option>';
			foreach ($customers as $customerID) {
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
				echo '<option value="'.$customerID.'" ';
				echo ($get_customerID==$customerID?'selected="selected"':false);
				echo '>'.$customer_data["companyname"].'</option>';
			}
			echo '</select>';
			echo '<select name="s">';
			$get_salesmanID = $_GET["s"];
			echo '<option value="">All Salesman</option>';
			foreach ($salesman as $salesmanID) {
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo '<option value="'.$salesmanID.'" ';
				echo ($get_salesmanID==$salesmanID?'selected="selected"':false);
				echo '>'.$salesman_data["salesman_name"].'</option>';
			}
			echo '</select>';
			echo '
				<input type="hidden" name="tab" value="8">
				<input type="submit" name="search" value="Search">
			</form>
			';

			echo "
			
			<div class='table-responsive'>
			<table class='table table-hover'>
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Aging</th>
				<th>Delivery Date</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Date Due</th>
				<th>Amount</th>
				<th>TS #</th>
			</tr>
			<tbody>";

			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND balance!= 0 AND deleted='0' AND overdue_date_2< '".strtotime($date)."'";

			if($date_from != "" && $date_to != ""){
				$query .= " AND date_delivered BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}
			if($get_customerID != ""){
				$query .= " AND customerID='".$get_customerID."'";
			}
			if($get_salesmanID != ""){
				$query .= " AND salesmanID='".$get_salesmanID."'";
			}
			$query .= " ORDER BY date_due DESC, time_ordered DESC";


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


			$order_query = mysql_query($query);
			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$orderID = $order_row["orderID"];
					$date_ordered = $order_row["date_ordered"];
					$total = $order_row["total"];
					$date_due = $order_row["date_due"];
					$terms = $order_row["terms"];
					$ts_orderID = $order_row["ts_orderID"];
					$customerID = $order_row["customerID"];
					$customer = $order_row["customer"];
					$salesmanID = $order_row["salesmanID"];

					$date1=date_create(date("m/d/Y",$date_due));
					$date2=date_create(date("m/d/Y"));
					$diff=date_diff($date1,$date2);
					$aging = $diff->format("%a days");

					($terms==0?$terms="COD":false);
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
					$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
					($date_due<=strtotime($date)?$status="warning":$status="");
					echo "
						<tr class='$status'>
							<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
							<td>$terms</td>
							<td>$aging</td>
							<td>".date("m/d/Y",$date_ordered)."</td>
							<td>$customer</td>
							<td>".$salesman_data["salesman_name"]."</td>
							<td>".date("m/d/Y",$date_due)."</td>
							<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
							<td>$ts_orderID</td>
						</tr>
					";
				}
			}
			echo "
			</tbody>
			</thead>
			</table>";

			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?date_from=$date_from&date_to=$date_to&c=$get_customerID&s=$get_salesmanID&tab=$tab&";
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
			echo "
			</div>
			";
			
		}elseif ($tab==9) {
			if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
			$maxitem = $maximum_items_displayed; // maximum items
			$limit = ($page*$maxitem)-$maxitem;

			$date_from = $_GET["date_from"];
			$date_to = $_GET["date_to"];
			$ar_number = $_GET["ar"];
			$get_customerID = $_GET["c"];
			$get_salesmanID = $_GET["s"];

			echo "<h3 style='text-align:center;'>Due Accounts Receivable</h3>";
			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND balance!= 0 AND date_due= '".strtotime($date)."' ORDER BY date_due DESC, time_ordered DESC";
			// echo $query;
			$order_query = mysql_query($query);
			$customers = array();
			$salesman = array();
			if(mysql_num_rows($order_query)!=0){
				while($order_row = mysql_fetch_assoc($order_query)){
					if($order_row["customerID"]!=0){
						$customers[] = $order_row["customerID"];
					}
					if($order_row["salesmanID"] != 0){
						$salesman[] = $order_row["salesmanID"];
					}
				}
			}
			$customers = array_unique($customers);
			$salesman = array_unique($salesman);

			echo '
			</form>
			<form action="" method="get">
				<input type="text" name="date_from" id="date_from_ar" placeholder="Date From" value="'.$date_from.'">
				<input type="text" name="date_to" id="date_to_ar" placeholder="Date To" value="'.$date_to.'">
				';
			echo '<select name="c">';
			$get_customerID = $_GET["c"];
			echo '<option value="">All Customers</option>';
			foreach ($customers as $customerID) {
				$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID='$customerID'"));
				echo '<option value="'.$customerID.'" ';
				echo ($get_customerID==$customerID?'selected="selected"':false);
				echo '>'.$customer_data["companyname"].'</option>';
			}
			echo '</select>';
			echo '<select name="s">';
			$get_salesmanID = $_GET["s"];
			echo '<option value="">All Salesman</option>';
			foreach ($salesman as $salesmanID) {
				$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$salesmanID'"));
				echo '<option value="'.$salesmanID.'" ';
				echo ($get_salesmanID==$salesmanID?'selected="selected"':false);
				echo '>'.$salesman_data["salesman_name"].'</option>';
			}
			echo '</select>';
			echo '
				<input type="hidden" name="tab" value="9">
				<input type="submit" name="search" value="Search">
			</form>
			';

			echo "
			<div class='table-responsive'>
			<table class='table table-hover'>
			<thead>
			<tr>
				<th>DR #</th>
				<th>Terms</th>
				<th>Delivery Date</th>
				<th>Customer</th>
				<th>Account Specialist</th>
				<th>Date Due</th>
				<th>Amount</th>
				<th>TS #</th>
			</tr>
			<tbody>";

			$query = "SELECT * FROM tbl_orders WHERE fully_paid='0' AND deleted='0' AND date_due= '".strtotime($date)."'";


			if($date_from != "" && $date_to != ""){
				$query .= " AND date_delivered BETWEEN ".strtotime($date_from)." AND ".strtotime($date_to);
			}
			if($get_customerID != ""){
				$query .= " AND customerID='".$get_customerID."'";
			}
			if($get_salesmanID != ""){
				$query .= " AND salesmanID='".$get_salesmanID."'";
			}
			$query .= " ORDER BY date_due DESC, time_ordered DESC";

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
			$order_query = mysql_query($query);
			if(mysql_num_rows($order_query)!=0){
				while($order_row=mysql_fetch_assoc($order_query)){
					$orderID = $order_row["orderID"];
					$date_ordered = $order_row["date_ordered"];
					$date_delivered = $order_row["date_delivered"];
					$total = $order_row["total"];
					$date_due = $order_row["date_due"];
					$terms = $order_row["terms"];
					($terms==0?$terms="COD":false);

					$date1=date_create(date("m/d/Y",$date_due));
					$date2=date_create(date("m/d/Y"));
					$diff=date_diff($date1,$date2);
					$aging = $diff->format("%a days");

					$ts_orderID = $order_row["ts_orderID"];
					$customerID = $order_row["customerID"];
					$customer = $order_row["customer"];
					$salesmanID = $order_row["salesmanID"];
					$customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
					$salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
					$total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
					($date_due<=strtotime($date)?$status="warning":$status="");
					echo "
						<tr class='$status'>
							<td><a href='sales-complete?id=$orderID'>$orderID</a></td>
							<td>$terms</td>
							<td>".date("m/d/Y",$date_delivered)."</td>
							<td>$customer</td>
							<td>".$salesman_data["salesman_name"]."</td>
							<td>".date("m/d/Y",$date_due)."</td>
							<td style='text-align:right'>".number_format($total_data["total"],2)."</td>
							<td>$ts_orderID</td>
						</tr>
					";
				}
			}
			echo "
			</tbody>
			</thead>
			</table>";
			echo "<div class='text-center'><ul class='pagination prints'>
			
			";
			$url="?date_from=$date_from&date_to=$date_to&c=$get_customerID&s=$get_salesmanID&tab=$tab&";
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
			echo "
			</div>
			";
			echo "
			</div>
			";
			
			
		}
			
		}else{
			echo "<strong><center>You do not have the authority to access this module.</center></strong>";
		}
	}else{
			header("location:index");

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