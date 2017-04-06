<?php
session_start();

require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$filter=new Filter();

$escaped;
$uploadfile;
$id=$_POST['pid'];
$image= basename($_FILES['image']['name']);
$uploaddir = "../product_images/{$_SESSION['id']}/";

//creates temporary folder to store images
mkdir($uploaddir,0777);

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
//no file uploaded
if($_FILES["image"]["error"] == 4)
{
	 header("Location:http://localhost:8080/sulen/admin/");
   exit();
}

$query->add_img($id,$escaped);

unlink($uploadfile);//deletes uploaded file in the temporary folder
rmdir($uploaddir);//deletes temporary folder
header("Location:http://localhost:8080/sulen/admin/index.php?trans=true&msg=A new image for the product has been successfully added.");
?>
