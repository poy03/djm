<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$t=@$_GET['t'];
$f=@$_GET['f'];
$s=@$_GET['s'];
$c=@$_GET['c'];
$show_all=@$_GET['show_all'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
      $by=@$_GET['by'];
      $order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Accounts Receivable Reports</title>
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
    <div class='col-md-12'>
  
  
  <?php
  if($logged==1||$logged==2){
  if($reports=='1'){//list of all unpaid purchases
    echo "<h3 style='text-align:center;'>Accounts Payables Ledger</h3>";
            if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
            $maxitem = $maximum_items_displayed; // maximum items
            $limit = ($page*$maxitem)-$maxitem;
            $query = "SELECT * FROM tbl_orders_receiving WHERE type='purchase' AND deleted='0'";

            if(isset($_GET["s"])&&$_GET["s"]!=""){
              $query.=" AND supplierID='".mysql_real_escape_string(htmlspecialchars(trim($_GET["s"])))."'";
            }
            if(isset($_GET['show_all'])){

            }else{
              if(isset($_GET["f"])&&$_GET["f"]!=""&&isset($_GET["t"])&&$_GET["t"]!=""){
                $query.=" AND date_received BETWEEN '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["f"]))))."' AND '".mysql_real_escape_string(htmlspecialchars(trim(strtotime($_GET["t"]))))."'";
              }
            }

            $query.= " ORDER BY date_received DESC";
            $numitemquery = mysql_query($query);
            $numitem = mysql_num_rows($numitemquery);
            // $query.=" LIMIT $limit, $maxitem";
            // echo $query;


            echo '
            <form action="" method="get">
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
            echo '
              <label data-balloon="Overrides Date Range" data-balloon-pos="right"><input id="show-all-checkbox" type="checkbox" name="show_all" value="true"'.(isset($show_all)&&$show_all=="true"?"checked":"").'> Show All</label>
            ';
            echo "
            <input type='text' id='date_from' name='f' placeholder='Date From' value='".$_GET["f"]."' readonly>
            <input type='text' id='date_to' name='t' placeholder='Date To' value='".$_GET["t"]."' readonly>
            ";
            echo "
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
                <th>Payments</th>
              </tr> 
              </thead>
              <tbody>";
              $total_payables = 0;
              $total_payments = 0;
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
                  $total_payables += $balance;
                  $total_payments += $payment;
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
                    <td style='text-align:right'>".number_format($balance,2)."</td>
                    <td style='text-align:right'>".number_format($payment,2)."</td>
                  </tr>
                  ";
                }
              }
              echo "
              </tbody>
              <tfoot>
                <tr>
                  <th colspan='8'>Total</th>
                  <th style='text-align:right'>".number_format($total_payables,2)."</th>
                  <th style='text-align:right'>".number_format($total_payments,2)."</th>
                </tr>
              </tfoot>
            </table>";
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