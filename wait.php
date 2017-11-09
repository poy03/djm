<?php
ob_start();
session_start();
$accountID=@$_SESSION['accountID'];
$page=@$_GET['page'];
$cat=@$_GET['cat'];
$id=@$_GET['id'];
$s=@$_GET['s'];
$search=@$_GET['search'];
			$by=@$_GET['by'];
			$order=@$_GET['order'];


include 'db.php';
if($updates==0){
	header("location:index");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Updating....</title>
</head>
<body>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<center>
<img src="maintmode1.gif">
</img>
<br>
<br>
<br>

<br>
</center>
<?php

// header( "Refresh:3; url=//www.facebook.com", true, 303);
?>
</body>
</html>