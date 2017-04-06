<?php
session_start();

	unset($_SESSION['id']);
	unset($_SESSION['user_type']);
	session_destroy();

	header("Location:http://localhost:8080/sulen/");
	exit;
?>
