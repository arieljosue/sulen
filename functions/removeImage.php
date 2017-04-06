<?php
require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$result=$query->remove_image($_POST['uid']);
header("Location:http://localhost:8080/sulen/admin/index.php?trans=true&msg=Product image has been removed.");
?>
