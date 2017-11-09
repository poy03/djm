<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$keyword=@$_GET['keyword'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];



include 'db.php';
include 'importer.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $app_name; ?> - Maintenance</title>
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
			$(".download").click(function(e){
				window.location = 'backups/'+e.target.id;
			});
			$(".download_items").click(function(e){
				window.location = 'list-of-items/'+e.target.id;
			});
			$(".delete").click(function(e){
				$.ajax({
					type: "POST",
					url: "maintenance-delete",
					data: "delete=1&id="+e.target.id,
					cache: false,
					success: function(html){
						location.reload();
					}
				});
			});
			$(".delete_items").click(function(e){
				$.ajax({
					type: "POST",
					url: "maintenance-delete",
					data: "delete_items=1&id="+e.target.id,
					cache: false,
					success: function(html){
						location.reload();
						// alert(html);
					}
				});
			});			

	$( "#search" ).autocomplete({
      source: 'search-item-all',
	  select: function(event, ui){
		  window.location='item?s='+ui.item.data;
	  }

    });
		  
		 $("#download").click(function(){
		 	window.location = 'export-db';
		 });
  });
  </script>
    <style>
		#item_results
	{
		position:absolute;
		width:250px;
		z-/:5;
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

		// if($type=='admin'){
			?>
			<form action="maintenance" method="post"  enctype='multipart/form-data'>
			<div class="col-md-2">
				<label>Upload your Database:</label>
				<input type="file" name="sql" accept=".sql">
				<?php
					if(isset($_POST['submit'])){
						$import = new Import;
						$sql = $_FILES['sql'];
						// var_dump($sql);
						$import->import_tables("localhost","root","",DBNAME,$sql['tmp_name'], true,$sql['name']);
					}

				?>
				<br>			
				<button type="submit" name="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
			</div>
			<div class="col-md-10">
				<label>Backup a Database:</label>
				<a class="btn btn-success" id='download' href="#"><span class="glyphicon glyphicon-hdd"></span> Make a Backup of your Database.</a>
				<br>
				<br>

				<h3 style="text-align:center">Stored Backups</h3>
				<div class="table-resposive">
					<table class="table-hover table">
						<thead>
							<tr>
								<th>File Name</th>
								<th>Date</th>
								<th>Time</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php

								$dir = "backups/";

								// Open a directory, and read its contents
								if (is_dir($dir)){
								  if ($dh = opendir($dir)){
								  	$i = 0;
								    while (($file = readdir($dh)) !== false){
								      if($file!='.'&&$file!='..'){
								      	echo "
								      		<tr>
								      			<td>$file</td>
								      			<td>".gmdate ("F d Y", filemtime($dir.$file))."</td>
								      			<td>".gmdate ("h:i:s A", filemtime($dir.$file)+(3600*8))."</td>
								      			<td><a href='#' id='$file' class='download'>Download</a></td>
								      			<td><a href='#' id='$file' class='delete'>Delete</a></td>
								      		</tr>
								      	";
								      	$i++;
								      }
								    }
								    closedir($dh);
								  }
								}
							?>
						</tbody>
					</table>	
				</div>
				<br>
	


			</div>
			</form>
			<?php
		// }else{
		// 	echo "<strong><center>You do not have the authority to access this module.</center></strong>";
		// }
	?>

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