<?php
require_once('DB.php');
$db=new DB();

 // $res = pg_query($db->connect(),"SELECT encode(image, 'base64') AS image FROM product WHERE id=5");  
  // $raw = pg_fetch_result($res, 'image');
  
  //Convert to binary and send to the browser
  // header('Content-type: image/jpeg');
  // echo base64_decode($raw);
   // $res = pg_query("SELECT data FROM gallery WHERE name='Pine trees'");  
  // $raw1 = pg_fetch_result($res, 'data');
  
  // Convert to binary and send to the browser
  // header('Content-type: image/jpeg');
 
  
 $res = pg_query($db->connect(),"SELECT id,image FROM product");  
  // $raw2 = pg_fetch_result($res, 'image');
  foreach(pg_fetch_all($res) as $data)
  {
	$img = fopen("product_images/{$data['id']}.jpg", 'wb') or die("cannot open image\n");
	fwrite($img, pg_unescape_bytea($data['image'])) or die("cannot write image data\n");
	fclose($img);

	}
  echo "success";
  
  // Convert to binary and send to the browser
  // header('Content-type: image/jpeg');
   // echo pg_unescape_bytea($raw1);
   // echo pg_unescape_bytea($raw2);
  ?>