<?php
ob_start();
session_start();



include 'db.php';

?>

<?php
if($_POST)
{
$delete=@$_POST['delete'];
$delete_items=@$_POST['delete_items'];
if(isset($delete)){
	$id=$_POST['id'];
	if(isset($delete)){
		unlink("backups/".$id);
	}
}
if(isset($delete_items)){
	$id=$_POST['id'];
	if(isset($delete_items)){
		unlink("list-of-items/".$id);
	}
}
}
?>
