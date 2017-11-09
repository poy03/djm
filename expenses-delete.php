<?php
ob_start();
session_start();



include 'db.php';
?>

<?php
if($_POST)
{
$id=$_POST['id'];
$deleted_comment=mysql_real_escape_string(htmlspecialchars(trim($_POST['delete_comment'])));
mysql_query("UPDATE tbl_expenses SET deleted='".strtotime($date)."', deleted_by = '$accountID', deleted_comment='$deleted_comment' WHERE expensesID='$id'");
}
?>
