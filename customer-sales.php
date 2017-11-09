<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$id=@$_GET['id'];
$keyword=@$_GET['keyword'];
$customerID=@$_GET['id'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Customers | List of Sales</title>
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
  <style>
  .item:hover{
	  cursor:pointer;
  }
  </style>
    
  <link rel="stylesheet" href="css/theme.default.min.css">
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>   <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <script>
  $(document).ready(function(){
      $(".return").click(function(e){
        // alert(e.target.id);
        var dataStr = "id="+e.target.id+"&return=1";
        $.ajax({
            type: 'POST',
            url: 'sales-return',
            data: dataStr,
            cache: false,
            success: function(){
                location.reload();
            }
        });
    });	
  	$("#Customers").addClass("active");
	  $("#myTable").tablesorter();
	   $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} ); 
	  $("#add").click(function(){
		  window.location="customer-add";
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

	
	$( "#search_customer" ).autocomplete({
      source: 'search-customer-auto',
	  select: function(event, ui){
		  window.location='customer?id='+ui.item.data;
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
    if($customers!=1){
        echo "<strong><center>You do not have the authority to access this module.</center></strong>";
        exit;
    }

    $customer_query = mysql_query("SELECT * FROM tbl_customer WHERE customerID='$id'");
    if(mysql_num_rows($customer_query)!=0){
        while($customer_row=mysql_fetch_assoc($customer_query)){
            $companyname = $customer_row["companyname"];
            $address = $customer_row["address"];
            $phone = $customer_row["phone"];
            $email = $customer_row["email"];
            $contactperson = $customer_row["contactperson"];
            $tin_id = $customer_row["tin_id"];
        }
    }else{
        header("location:success");
    }
    $receivables = mysql_fetch_assoc(mysql_query("SELECT SUM(balance) as receivables FROM tbl_orders WHERE deleted='0' and customerID='$id'"));
    $receivables = number_format($receivables['receivables'],2);
    echo "Company Name: $companyname<br>";
    echo "Address: $address<br>";
    echo "Phone: $phone<br>";
    echo "Email: $email<br>";
    echo "Contact Person: $contactperson<br>";
    echo "Tin ID: $tin_id<br>";
    echo "Total Receivables: $receivables<br>";
    ?>
    <div class='table-responsive'>
        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>DR #</th>
                    <th>Account Specialist</th>
                    <th>Total Amount</th>
                    <th>Terms</th>
                    <th>Date Due</th>
                    <th>Receivables</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
                $maxitem = $maximum_items_displayed; // maximum items
                $limit = ($page*$maxitem)-$maxitem;

                $query = "SELECT * FROM tbl_orders WHERE deleted='0' and customerID='$id' ORDER BY orderID DESC";
                $numitemquery = mysql_query($query);
                $numitem = mysql_num_rows($numitemquery);
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
                        $customerID = $order_row["customerID"];
                        $date_ordered = $order_row["date_ordered"];
                        $total = $order_row["total"];
                        $received = $order_row["received"];
                        $date_due = $order_row["date_due"];
                        $balance = number_format($order_row["balance"],2);
                        $salesmanID = $order_row["salesmanID"];
                        $terms = $order_row["terms"];
                        $salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
                        if($received!=0){
                            $date_returned = date("m/d/Y",$received);
                            $status = "Returned";
                        }else{
                            $date_returned = "";
                            $status = "<a href='#' id='$orderID' class='return'>Mark as Returned</a>";
                        }
                        $total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
                        echo "

                        <tr>
                            <td>".date("m/d/Y",$date_ordered)."</td>
                            <td><a href='sales-complete?id=$orderID'>".$orderID."</a></td>
                            <td><a href='salesman?id=$salesmanID'>".$salesman_data["salesman_name"]."</a></td>
                            <td style='text-align:right'>".number_format($total_data["total"],2)."</td>
                            <td>".$terms."</td>
                            <td>".date("m/d/Y",$date_due)."</td>
                            <td style='text-align:right'>".$balance."</td>
                        </tr>
                        ";
                    }
                }
                ?>
            </tbody>
        </table>
            <div class='text-center'>
        <?php
                    echo "<ul class='pagination prints'>
                    
                    ";
                    $url="?id=$id&";
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