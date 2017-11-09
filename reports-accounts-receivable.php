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

          $("#date_from,#date_to,.pdc_date,#date_from_ar,#date_to_ar").datepicker();
          $("#dr").autocomplete({
            source: "search-dr?tab=2",
            select: function(event,ui){
              var date_to = $("#date_to").val();
              var date_from = $("#date_from").val();
              var order = $("#order").val();
              var salesman = $("#salesman").val();
              var customer = $("#customer").val();
              var show_all = ($('#show-all-checkbox').is(':checked')?"true":"false");
              var tab = $("#tab").val();
              var dr = $("#dr").val();
              window.location="?show_all="+show_all+"&f="+date_from+"&t="+date_to+"&o="+order+"&c="+customer+"&s="+salesman+"&dr="+ui.item.data;
            }
          });

          $("#show-all-checkbox").click(function(e) {
            var date_to = $("#date_to").val();
            var date_from = $("#date_from").val();
            var order = $("#order").val();
            var salesman = $("#salesman").val();
            var customer = $("#customer").val();
            var show_all = ($('#show-all-checkbox').is(':checked')?"true":"false");
            var tab = $("#tab").val();
            var dr = $("#dr").val();
            window.location="?show_all="+show_all+"&f="+date_from+"&t="+date_to+"&o="+order+"&c="+customer+"&s="+salesman+"&dr="+dr;
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
            var show_all = ($('#show-all-checkbox').is(':checked')?"true":"false");
            var tab = $("#tab").val();
            var dr = $("#dr").val();
            window.location="?show_all="+show_all+"&f="+date_from+"&t="+date_to+"&o="+order+"&c="+customer+"&s="+salesman+"&dr="+dr;
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
    <div class='col-md-12'>
  
  
  <?php
  if($logged==1||$logged==2){
  if($reports=='1'){

      echo "
      <h3 style='text-align:center;'>Accounts Receivable Ledger</h3>
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
        <th>Cash</th>
        <th>PDC Amount</th>
        <th>Deposited PDC Amount</th>
        <th>Balance</th>
      </tr>
      </thead>
      <tbody>";
      echo '
      <div class="checkbox">
        <label data-balloon="Overrides Date Range" data-balloon-pos="right"><input id="show-all-checkbox" type="checkbox" name="show_all" value="true"'.(isset($show_all)&&$show_all=="true"?"checked":"").'>Show All</label>
      </div>
      ';
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

      $query = "SELECT * FROM tbl_orders WHERE deleted='0'";
      $customer_unique = "SELECT DISTINCT customerID FROM tbl_orders WHERE deleted='0'";
      if(isset($s)&&$s!=""){
        $customer_unique.= " AND salesmanID='$s'";
      }
      if(isset($c)&&$c!=""){
        $query.= " AND customerID = '$c'";
      }

      if(isset($_GET['show_all'])&&$_GET['show_all']=="true"){
        
      }else{
        if(isset($f)&&isset($t)&&$f!=""&&$t!=""){
          $query.=" AND date_delivered BETWEEN '".strtotime($f)."' AND '".strtotime($t)."'";
        }
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
      // echo $query;
      $numitemquery = mysql_query($query);
      $numitem = mysql_num_rows($numitemquery);
      $export_query = $query;
      // $query.=" LIMIT $limit, $maxitem";
      // echo $query;
      $order_query = mysql_query($query);

          if(($numitem%$maxitem)==0){
            $lastpage=($numitem/$maxitem);
          }else{
            $lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
          }
          $maxpage = 3;

      if(mysql_num_rows($order_query)!=0){
        $total_cash = 0;
        $total_pdc_deposited = 0;
        $total_pdc_undeposited = 0;
        $total_balance = 0;
        $total_amount = 0;
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
          $cash = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0' and type_payment='cash'"));
          $pdc_deposited = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0' AND status!='' and type_payment='pdc'"));
          $pdc_undeposited = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0' AND status='' and type_payment='pdc'"));
          $total_cash+=$cash['total'];
          $total_pdc_deposited+=$pdc_deposited['total'];
          $total_pdc_undeposited+=$pdc_undeposited['total'];
          $total_balance+=$balance;
          $total_amount+=$total_data["total"];
          echo "
            <tr>
              <td><a href='sales-complete?id=$orderID'>$orderID</a></td>
              <td>$terms</td>
              <td>".date("m/d/Y",$date_ordered)."</td>
              <td>".$customer_data["companyname"]."</td>
              <td>".$salesman_data["salesman_name"]."</td>
              <td>".date("m/d/Y",$date_due)."</td>
              <td style='text-align:right'>".number_format($total_data["total"],2)."</td>
              <td><a href='sales-ts-complete?id=$ts_orderID'>$ts_orderID</a></td>
              <td style='text-align:right'>".number_format($cash['total'],2)."</td>
              <td style='text-align:right'>".number_format($pdc_undeposited['total'],2)."</td>
              <td style='text-align:right'>".number_format($pdc_deposited['total'],2)."</td>
              <td style='text-align:right'>".number_format($balance,2)."</td>
            </tr>
          ";
        }
      }
      echo "
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>".number_format($total_amount,2)."</th>
          <th></th>
          <th style='text-align:right'>".number_format($total_cash,2)."</th>
          <th style='text-align:right'>".number_format($total_pdc_undeposited,2)."</th>
          <th style='text-align:right'>".number_format($total_pdc_deposited,2)."</th>
          <th style='text-align:right'>".number_format($total_balance,2)."</th>
        </tr>
      </tfoot>
      </table>";      
     /* echo "
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
      ";*/
      ?>
      </form>
      
      <form action='#' method='post'>
      <button name='download' id='download'><span class='glyphicon glyphicon-download'></span> Download this Report</button>
      </form>
      
        <?php
          if(isset($_POST["download"])){
            $filename = "reports-files\accounts-receivable-".date("F-d-Y-",strtotime($f)).date("F-d-Y",strtotime($t)).".csv";
            // echo $filename;
            $fp = fopen($filename, 'w');
            $fields = array("DR #","Terms","Delivery Date","Customer","Account Specialist","Date Due","Amount","TS #","Cash","PDC Amount","Deposited PDC Amount","Balance");
            fputcsv($fp, $fields);
            $export_query = mysql_query($export_query);
            while ($export_row=mysql_fetch_assoc($export_query)) {


              $orderID = $export_row["orderID"];
              $date_ordered = $export_row["date_delivered"];
              $total = $export_row["total"];
              $date_due = $export_row["date_due"];
              $ts_orderID = $export_row["ts_orderID"];
              $terms = $export_row["terms"];
              $customerID = $export_row["customerID"];
              $salesmanID = $export_row["salesmanID"];
              $balance = $export_row["balance"];
              $pdc_check_number = $export_row["pdc_check_number"];
              $pdc_amount = $export_row["pdc_amount"];
              ($export_row["pdc_date"]==0?$pdc_date="":$pdc_date = date("m/d/Y",$export_row["pdc_date"]));
              ($export_row["pdc_amount"]==0?$pdc_amount="":$pdc_amount = number_format($export_row["pdc_amount"],2));
              
              $customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
              $salesman_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID = '$salesmanID'"));
              $total_data = mysql_fetch_assoc(mysql_query("SELECT SUM(subtotal) as total FROM tbl_purchases WHERE orderID='$orderID'"));
              ($date_due<=strtotime($date)?$status="warning":$status="");
              ($terms==0?$terms="COD":false);
              $cash = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0' and type_payment='cash'"));
              $pdc_deposited = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0' AND status!='' and type_payment='pdc'"));
              $pdc_undeposited = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as total FROM tbl_payments WHERE orderID='$orderID' AND not_valid='0' AND status='' and type_payment='pdc'"));
              $fields = array(
                $orderID,
                $terms,
                date("m/d/Y",$date_ordered),
                $customer_data["companyname"],
                $salesman_data["salesman_name"],
                date("m/d/Y",$date_due),
                $total_data["total"],
                $ts_orderID,
                $cash['total'],
                $pdc_undeposited['total'],
                $pdc_deposited['total'],
                ($balance==0?"":$balance)
              );
              fputcsv($fp, $fields);
              # code...
            }
            $fields = array('','','','','','TOTAL',$total_amount,'',$total_cash,$total_pdc_undeposited,$total_pdc_deposited,$total_balance);
            fputcsv($fp, $fields);
            fclose($fp);
            header("location:".$filename);
          } 
        ?>
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