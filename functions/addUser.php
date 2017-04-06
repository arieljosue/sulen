<?php
session_start();

require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$filter=new Filter();

$filter_results=$filter->add_user($_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['password'],$_POST['usertype']);

if($filter_results)
{
	if(!$query->fetch_username($username))
	{
			$result=$query->add_user($filter_results[0],$filter_results[1],$filter_results[2],$filter_results[3],$filter_results[4]);

		if($result!=false)
		{
					header('Location:http://localhost:8080/sulen/admin/users.php?trans=true&msg=A new user has been successfully added.');
		}
		else
		{
					header('Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Transaction unsuccessful.');
		}

	}
	else
	{
		header('Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Username is not available');
	}

}
else {
	header('Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Transaction unsuccessful.');
}
?>
