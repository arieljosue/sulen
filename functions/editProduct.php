<?php
require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$filter=new Filter();

$id=$_POST['pid'];
$availability=$_POST['availability'];
$name;
$price;
$category;
$filter_result=$filter->add_product($_POST['name'],$_POST['price'],$_POST['category']);
//filter user input
if(!$filter_result)
{
		header("Location:http://localhost:8080/sulen/admin/index.php?trans=false&msg=Invalid input");
}
else
{
	$name				=	$filter_result[0];
	$price			=	$filter_result[1];
	$category		=	$filter_result[2];
}

$query->update_product($id,$name,$price,$category,$availability);
header("Location:http://localhost:8080/sulen/admin/index.php?trans=true&msg=Product has been successfully updated.");
?>
