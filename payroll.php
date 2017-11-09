<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
(isset($_SESSION["LOGTYPE"])?$logtype = $_SESSION["LOGTYPE"]:$logtype = "login");

include 'db.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Payroll</title>
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
 <link rel="stylesheet" href="css/balloon.css"><link rel='stylesheet' href='css/font-awesome.min.css'>
<script src="js/pox.js"></script>
 <link href="css/bootstrap-toggle.css" rel="stylesheet">
<script src="js/bootstrap-toggle.js"></script>
<script src="js/moment.min.js"></script>
  <style>
  .item:hover{
	  cursor:pointer;
  }
  .popover{
    width:100%;   
}
  </style>
  <script>
$(document).keypress(function(e){
	if(e.keyCode==105){
		$('#login').prop('checked', true);
		// alert("sdsd");
	}else{
		$('#login').removeAttr('checked');
	}
});



  $(document).ready(function(){
  	$("#time").html(moment().format("hh:mm:ss A"));
  	$("#date").html(moment().format("MMMM DD, YYYY dddd"));
  	setInterval(function() {
  	var rotate = (moment().seconds()*6)+90;
  		$("#time").html(moment().format("hh:mm:ss A"));
	  	$("#date").html(moment().format("MMMM DD, YYYY dddd"));
	  	$("#dates").css({
	  	    'transform': 'rotate('+rotate+'deg)',
	  	    '-moz-transform': 'rotate('+rotate+'deg)',
	  	    '-o-transform': 'rotate('+rotate+'deg)',
	  	    '-webkit-transform': 'rotate('+rotate+'deg)'
	  	});
  	  }, 10
    );

  	$("#Payroll").addClass("active");
  	$("#login").change(function(e){
  		// alert("sd");
  		var state = $(this).prop("checked");
  		if(state==false){
  			var dataStr = "type=logout";
  		}else{
  			var dataStr = "type=login";
  		}
  		// alert(dataStr);
  		$.ajax({
  			type: "POST",
  			url: "payroll-sessions",
  			data: dataStr,
  			cache: false,
  			success: function(html){
  				// alert(html)
  				// location.reload();
  			}
  		});
  	});
  	$( "#search" ).autocomplete({
        source: 'search-item-all',
  	  select: function(event, ui){
  		  window.location='item?s='+ui.item.data;
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
	
	
	<?php
	if($logged==1||$logged==2){
		if($payroll!=1){
			echo "<strong><center>You do not have the authority to access this module.</center></strong>";
			goto exit_program;
		}
		?>
		<form action="#" method="post">
		<div class="col-md-2 prints">
		<input id="login" type="checkbox" data-toggle="toggle" name="logtype" data-width="100%" data-style="quick" data-on="<span class='glyphicon glyphicon-log-in'></span> Login" data-off="<span class='glyphicon glyphicon-log-out'></span> Logout" data-onstyle="info" data-offstyle="warning" value="true" <?php if(isset($logtype)&&$logtype=="login"){ echo "checked"; } ?>>
		</div>
		<div class='col-md-10'>
		<h1 id="date" style="text-align:center">DATE</h1>
		<h1 id="time" style="text-align:center">TIME</h1>
		</div>
	</form>


<?php
if(isset($_POST["save"])){
	(isset($_POST["logtype"])?$state="login":$state="logout");
	echo $state;
}

?>

		<?php
	}else{
		header("location:index");
	} ?>

  </div>
</div>
</body>
</html>
<?php mysql_close($connect);
exit_program:

?>
  <script>
$("[data-toggle=popover]")
.popover({html:true})
</script>