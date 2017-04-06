<?php
session_start();
require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$filter=new Filter();

$name;
$price;
$escaped;
$category;
$uploadfile;
// $no_image="../_assets/img/no_img.jpg"; //default image

$image= basename($_FILES['image']['name']);
$uploaddir = "../product_images/{$_SESSION['id']}/";

//creates temporary folder to store images
mkdir($uploaddir,0777);

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

//determines whether ther is an image uploaded or none
// if($_FILES["image"]["error"] == 4)
// {
	//no image uploaded
	// $uploadfile=$uploaddir."no_img.jpg";
	//COPIES default image to temporary folder
	// if (!copy($no_image, $uploadfile))
	// {
	// 	header("Location:http://localhost/sulen/admin/index.php?trans=false&msg=An error occured.copy");
	// }
// }
// else
if($_FILES["image"]["error"] !== 4)
{
	if(!$filter->file_type($_FILES['image']['type']))
	{
		rmdir($uploaddir);//deletes temporary folder
		header("Location:http://localhost:8080/sulen/admin/index.php?trans=false&msg=Invalid file.");
		exit();
	}

	//an image has been uploaded
	
	$uploadfile = $uploaddir.$image;
	//MOVES uploaded image to temporary folder
	if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile))
	{
	 	header("Location:http://localhost:8080/sulen/admin/index.php?trans=false&msg=An error occured.move");
	}

	$data = file_get_contents($uploadfile);
	$escaped = pg_escape_bytea($data);
}

$result=$query->add_product($name,$price,$category,$escaped);

if(!$result)
{
	 header("Location:http://localhost:8080/sulen/admin/index.php?trans=false&msg=An error occured.insert");
}
else
{
	unlink($uploadfile);//deletes uploaded file in the temporary folder
	rmdir($uploaddir);//deletes temporary folder
	header("Location:http://localhost:8080/sulen/admin/index.php?trans=true&msg=A new product has been added successfully.");
}

// chmod($uploadfile, 0755);
// if($_FILES["image"]["error"] == 4) {
// //means there is no file uploaded
// $uploadfile="../_assets/img/no_img.jpg";
//
// }else
// {
// 	if(!unlink($uploadfile))
// 	{
// 		echo "wala nadelete";
// 	}
//
// }
// 	rmdir($uploaddir);
//
// 	$id=array_shift(pg_fetch_all($result))['id'];
//
// 	foreach(pg_fetch_all($query->select_image($id)) as $data)
// 	{
// 	$img = fopen("product_images/{$data['id']}.jpg", 'wb') or die("cannot open image\n");
// 	fwrite($img, pg_unescape_bytea($data['image'])) or die("cannot write image data\n");
// 	fclose($img);
// 	}
//
//
// }
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/img_res.css" />
	</head>
</html>
