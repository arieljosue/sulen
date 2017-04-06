<?php
session_start();

require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$filter=new Filter();

$result=$filter->login($_POST['username'],$_POST['password']);

if($result)
{
	$username=$result[0];
	$password=$result[1];
}
else
{
	header("Location:http://localhost:8080/sulen/index.php?trans=false&msg=Invalid input.");
	exit;
}

$result=$query->login($username,$password);

if($result)
{
	$temp=array_shift($result);
	$_SESSION['id']=$temp['id'];
	$_SESSION['user_type']=$temp['usertype'];

	switch(strtolower($_SESSION['user_type']))
	{
		case "a":
			header("Location:http://localhost:8080/sulen/admin/");
			exit;
		case "b":
			header("Location:http://localhost:8080/sulen/admin/");
			exit;
		case "c":
			header("Location:http://localhost:8080/sulen/cashier/");
			exit;
		default:
			header("Location:http://localhost:8080/sulen/");
			exit;
	}
}
else
{
	header("Location:http://localhost:8080/sulen/index.php?trans=false&msg=Invalid username and or password.");
	exit;
}
?>
