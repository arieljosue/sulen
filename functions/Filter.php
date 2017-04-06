<?php

class Filter
{
	function login($username,$password)
	{
		$username	=	trim(filter_var($username, FILTER_SANITIZE_STRING));
		$password	=	trim(filter_var($password, FILTER_SANITIZE_STRING));

		if($username!="" AND $password!="")
		{
			return	[$username,$password];
		}
	}
	function add_user($firstname,$lastname,$username,$password,$usertype)
	{
		$firstname	=	trim(filter_var($firstname, FILTER_SANITIZE_STRING));
		$lastname		=	trim(filter_var($lastname, FILTER_SANITIZE_STRING));
		$usertype		=	trim(filter_var($usertype, FILTER_SANITIZE_STRING));
		$username		=	trim(filter_var($username, FILTER_SANITIZE_STRING));
		$password		=	trim(filter_var($password, FILTER_SANITIZE_STRING));

		$firstname	=	trim(filter_var($firstname, FILTER_VALIDATE_REGEXP,["options"=>["regexp"=>"/[a-zA-Z]+[a-zA-Z ]+/"]]));
		$lastname		=	trim(filter_var($lastname, FILTER_VALIDATE_REGEXP,["options"=>["regexp"=>"/[a-zA-Z]+[a-zA-Z ]+/"]]));
		$username		=	trim(filter_var($username, FILTER_VALIDATE_REGEXP,["options"=>["regexp"=>"/[a-zA-Z0-9_]{5,20}/"]]));
		$password		=	trim(filter_var($password, FILTER_VALIDATE_REGEXP,["options"=>["regexp"=>"/[a-zA-Z0-9]{5,20}/"]]));

		if($firstname!="" AND $lastname!="" AND $usertype!=""AND $username!="" AND $password!="")
		{
			return [
								addslashes($firstname),
								addslashes($lastname),
								addslashes($usertype),
								addslashes($username),
								addslashes($password),
							];
		}
	}

	function file_type($file_type)
	{
		return ($file_type=='image/jpeg' OR $file_type=='image/jpg');
	}

	function add_product($name,$price,$category)
	{
 		$name			=	trim(filter_var($name, FILTER_SANITIZE_STRING));
		$price		=	trim(filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
		$category	=	trim(filter_var($category, FILTER_SANITIZE_NUMBER_INT));

		$name			=	trim(htmlspecialchars($name, ENT_QUOTES));
		$name			=	trim(htmlspecialchars($name));
		$price		=	trim(filter_var($price, FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
		$category	=	trim(filter_var($category, FILTER_VALIDATE_INT));

		if($name!="" AND $price!="" AND $category!="")
		{
			return [
							addslashes($name),
							$price,
							$category
						];
		}
	}


}
?>
