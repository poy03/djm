<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$f=@$_GET['f'];
$t=@$_GET['t'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
      $by=@$_GET['by'];
      $order=@$_GET['order'];



include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Good Orders Reports</title>
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
    echo "<center><h3>Good Orders in <br>".date("F d, Y",strtotime($f))." - ".date("F d, Y",strtotime($t))."</h3></center>";
  ?>
  <div class='table-responsive'>
    <table class='table table-hover'>
    <thead>
      <tr>
        <th>Receive #</th>
        <th>Invoice #</th>
        <th>Date</th>
        <th>Terms</th>
        <th>Freight</th>
        <th>Supplier</th>
        <th style='text-align:right'>Total Cost</th>
        <th>Comments</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
    $maxitem = $maximum_items_displayed; // maximum items
    $limit = ($page*$maxitem)-$maxitem;
    
    $query = "SELECT * FROM tbl_orders_receiving WHERE date_received BETWEEN '".strtotime($f)."' AND '".strtotime($t)."' AND deleted='0' AND type='good order'";
    $numitemquery = mysql_query($query);
    $numitem = mysql_num_rows($numitemquery);
    $query.=" LIMIT $limit, $maxitem";
    //echo "$query";
    $salesquery = mysql_query($query);
    
    if(($numitem%$maxitem)==0){
      $lastpage=($numitem/$maxitem);
    }else{
      $lastpage=($numitem/$maxitem)-(($numitem%$maxitem)/$maxitem)+1;
    }
    $maxpage = 3;
    
    
    if(mysql_num_rows($salesquery)!=0){
      while($row=mysql_fetch_assoc($salesquery)){
        $orderID=$row["orderID"];
        $date_received=$row["date_received"];
        $invoice_number=$row["invoice_number"];
        $freight=$row["freight"];
        $terms=$row["terms"];
        $supplierID=$row["supplierID"];
        $supplier_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_suppliers WHERE supplierID='$supplierID'"));
        $purchase_query = mysql_query("SELECT * FROM tbl_receiving WHERE orderID='$orderID'");
        while($purchase_row=mysql_fetch_assoc($purchase_query)){
          $itemID = $purchase_row["itemID"];
          $quantity = $purchase_row["quantity"];
          $costprice = $purchase_row["costprice"];
        }
        $comment_query = mysql_query("SELECT * FROM tbl_orders_receiving WHERE type='good order' AND orderID='$orderID'");
        while($comment_row=mysql_fetch_assoc($comment_query)){
          $total_cost = $comment_row["total_cost"];
          $comments = $comment_row["comments"];
        }
        
        echo "
        <tr title='$comments'>
          <td><a href='receiving-complete?id=$orderID'>$orderID</a></td>
          <td>$invoice_number</td>
          <td>".date("m/d/Y",$date_received)."</td>
          <td>$terms</td>
          <td align='right'>".number_format($freight,2)."</td>
          <td><a href='suppliers?id=6'>".$supplier_data['supplier_name']."</a></td>
          <td align='right'>".number_format($total_cost,2)."</td>
          <td>$comments</td>
        </tr>
        ";
      }
    }
    
    ?>
    </tbody>
    <tfoot>
      <?php
      if(mysql_num_rows($salesquery)!=0){
        $total_purchases = mysql_query("SELECT SUM(total_cost) as total_purchases FROM tbl_orders_receiving WHERE type='good order' AND date_received BETWEEN '".strtotime($f)."' AND '".strtotime($t)."'");
        $total_purchases=mysql_fetch_assoc($total_purchases);
        $total_freight = mysql_fetch_assoc(mysql_query("SELECT SUM(freight) as total_freight FROM tbl_orders_receiving WHERE type='good order' AND date_received BETWEEN '".strtotime($f)."' AND '".strtotime($t)."'"));
        echo "
        <tr>
          <th style='text-align:right;'></th>
          <th style='text-align:right;' colspan='5'>TOTAL:</th>
          <th style='text-align:right;'>".number_format($total_purchases["total_purchases"],2)."</th>
          <th style='text-align:right;'></th>
        </tr>
        <tr>
          <th style='text-align:right;'></th>
          <th style='text-align:right;' colspan='5'>TOTAL FREIGHT:</th>
          <th style='text-align:right;'>".number_format($total_freight["total_freight"],2)."</th>
          <th style='text-align:right;'></th>
        </tr>
        <tr>
          <th style='text-align:right;'></th>
          <th style='text-align:right;' colspan='5'>TOTAL GOOD ORDERS:</th>
          <th style='text-align:right;'>".number_format($total_freight["total_freight"]+$total_purchases["total_purchases"],2)."</th>
          <th style='text-align:right;'></th>
        </tr>

        ";

      }
      ?>
      <tr>
        <td colspan='20'>
        <div class='text-center'>
      <?php
      echo "<ul class='pagination prints'>
      
      ";
      $url="?f=$f&t=$t&";
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
        
        
        </td>
      
      </tr>
      
    </tfoot>
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
</div>
</body>
</html>
<?php mysql_close($connect);?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>