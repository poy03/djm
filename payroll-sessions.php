<?php
ob_start();
session_start();



include 'db.php';
?>

<?php
if($_POST)
{
$type=$_POST['type'];
$_SESSION["LOGTYPE"] = $type;
}
?>
