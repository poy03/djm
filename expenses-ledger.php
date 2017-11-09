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
        // alert(data);
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

    $("#expenses-accounts-form").submit(function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        data: $("#expenses-accounts-form :input").serialize(),
        url: $("#expenses-accounts-form").attr("action"),
        cache: false,
        dataType: "json",
        success: function(data){
          if(data.status==1){
            alert("Success! Expense Account is Added.");
            location.reload();
          }else{
            alert("Error! Expense Account is already Added.");
          }
        }
      });
    });



    $(".delete").click(function(e){
      if(confirm("Are you sure you want to delete this Expense Account?")){
        $.ajax({
          type: "POST",
          url: "expenses-accounts-delete",
          data: "id="+e.target.id,
          cache: false,
          success: function(data){
            location.reload();
          }
        });
      }
    });

    $('#type_expense').change(function(e) {
      window.location = "?expense="+e.target.value;
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