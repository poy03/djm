<?php
ob_start();
session_start();

if($_POST){
	if($_POST["confirm"]==1){
		exec("shutdown -s -t 0");
	}
}

?>