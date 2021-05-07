<?php

$con = mysqli_connect("localhost","gwadaron_ls_user","admin$$123","gwadaron_lsbanking");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
?>