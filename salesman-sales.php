<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$id=@$_GET['id'];
$page=@$_GET['page'];




include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Salesman | List of Sales</title>
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
<script src="js/pox.js"></script>  <link rel="stylesheet" href="themes/smoothness/jquery-ui.css">
  <script src="jquery-ui.js"></script>
  <script type="text/javascript" src="js/shortcut.js"></script>
  <style>
  .item:hover{
      cursor:pointer;
  }
  </style>
  <link rel="stylesheet" href="css/theme.default.min.css">
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script> 
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
      $("#myTable").tablesorter();
       $("#myTable").tablesorter( {sortList: [[1,0], [0,0]]} ); 
      $("#add").click(function(){
          window.location="salesman-add";
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
      $("#Salesman").addClass("active");
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
    
    $("#cat").change(function(){
        var cat = $(this).val();
        window.location = "item?cat="+cat;
    });

    
    $( "#search" ).autocomplete({
      source: 'search-item-all',
      select: function(event, ui){
          window.location='item?s='+ui.item.data;
      }
    });
    
    $( "#suppliers" ).autocomplete({
      source: 'search-supplier',
      select: function(event, ui){
          window.location='suppliers?id='+ui.item.data;
      }
    });
    
  });
  
  </script>
  
    <style>
    #item_results
    {
        position:absolute;
        z-index:10;
        width:250px;
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
    
    .tablesorter-default{
        font:20px/20px;
        font-weight:1200;
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
             data-toggle = "collapse" data-target = "#example-navbar-collapse">
             <span class = "sr-only">Toggle navigation</span>
             <span class = "icon-bar"></span>
             <span class = "icon-bar"></span>
             <span class = "icon-bar"></span>
          </button>
          <a class = "navbar-brand" href = "index"><?php echo $app_name; ?></a>
       </div>
       
       <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
          <ul class = "nav navbar-nav  navbar-left">
          <?php
          $header = new Template;
          foreach ($list_modules as $module) {
            if($module==1){
                $badge_arg = $badge_items;
            }elseif($module==3){
                $badge_arg = $badge_sales;
            }elseif($module==9){
                $badge_arg = $badge_credit;
            }else{
                $badge_arg = 0;
            }
            echo $header->header($module,$badge_arg,$display);
          }
          ?>

         <?php if($logged!=0){ ?>
         <div class="form-group navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search" name='search' id='search' autocomplete='off'><div id='item_results'></div>
         </div>
         <?php } ?>
                        
          </ul>

          
          
          <?php 
          if($logged==0){
            
          ?>
            <ul class='nav navbar-nav navbar-right'>
                <li><a href='login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
            </ul>
          <?php }else{ ?>
            <ul class='nav navbar-nav navbar-right'>
                
                
                <li>
                    <a href='#' role='button'
                      data-container = 'body' data-toggle = 'popover' data-placement = 'bottom' 
                      data-content = "
                        <a href='settings' class = 'list-group-item'><span class='glyphicon glyphicon-cog'></span> Settings</a>
                        <a href = 'maintenance' class = 'list-group-item'><span class='glyphicon glyphicon-hdd'></span> Maintenance</a><a href = 'logout' class = 'list-group-item'><span class='glyphicon glyphicon-log-out'></span> Logout</a>
                                                              
                      ">
                    Hi <?php echo $employee_name; ?></a></a>
                </li>               
                
            </ul>
          <?php }?>
          </div>
       </nav>   
<div class="container-fluid">
  <div class='row'>
    <div class='col-md-12 prints'>
    
    <?php
    if($logged==1||$logged==2){
    if($salesman!=1){
        echo "<strong><center>You do not have the authority to access this module.</center></strong>";
        exit;
    }

    $salesman_query = mysql_query("SELECT * FROM tbl_salesman WHERE salesmanID='$id'");
    if(mysql_num_rows($salesman_query)!=0){
        while($salesman_row=mysql_fetch_assoc($salesman_query)){
            $salesman_name = $salesman_row["salesman_name"];
            $salesman_address = $salesman_row["salesman_address"];
            $salesman_contact_number = $salesman_row["salesman_contact_number"];
        }
    }else{
        header("location:success");
    }
    echo "Account Specialist: $salesman_name<br>";
    echo "Address: $salesman_address<br>";
    echo "Contact Number: $salesman_contact_number<br>";
    ?>
    <div class='table-responsive'>
        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>DR #</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Terms</th>
                    <th>Date Due</th>
                    <!-- <th>Status</th>
                    <th>Date Returned</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
                if(!isset($page)){$page=1;}elseif($page<=0){$page=1;}
                $maxitem = $maximum_items_displayed; // maximum items
                $limit = ($page*$maxitem)-$maxitem;

                $query = "SELECT * FROM tbl_orders WHERE deleted='0' and salesmanID='$id' ORDER BY orderID DESC";
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
                        $terms = $order_row["terms"];
                        $customer_data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_customer WHERE customerID = '$customerID'"));
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
                            <td><a href='customer?id=$customerID'>".$customer_data["companyname"]."</a></td>
                            <td style='text-align:right'>".number_format($total_data["total"],2)."</td>
                            <td>".$terms."</td>
                            <td>".date("m/d/Y",$date_due)."</td>
                            <!-- <td>".$status."</td>
                            <td>".$date_returned."</td>-->
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