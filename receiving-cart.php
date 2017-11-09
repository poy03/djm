<?php
ob_start();
session_start();



include 'db.php';

?>

<?php
if($_POST)
{
$supplierID = $_POST["supplierID"];
$comments = mysql_real_escape_string($_POST["comments"]);

if(isset($supplierID)){
	mysql_query("UPDATE tbl_cart_receiving SET supplierID = '$supplierID' WHERE accountID='$accountID'");
}elseif(isset($comments)){
	mysql_query("UPDATE tbl_cart_receiving SET comments = '$comments' WHERE accountID='$accountID'");
}

}
?>
