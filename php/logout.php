<?php
	session_start();
	unset($_SESSION["userid"]);
	unset($_SESSION["username"]);
	if(!isset($_SESSION["userid"]) && !isset($_SESSION["username"])){
		echo 1;
	}else{
		echo error;
	}