<?php
require_once('Query.php');

$query=new Query();

$result=$query->delete_product($_POST['uid']);

if(!$result AND $result!=='')
{
		header("Location:http://localhost:8080/sulen/admin/index.php?trans=false&msg=An error occured. Transaction unsuccessful.");
}
else
{
		header("Location:http://localhost:8080/sulen/admin/index.php?trans=true&msg=Product has been deleted");
}
?>
