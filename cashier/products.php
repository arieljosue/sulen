<?php
require_once('../functions/Query.php');

$query=new Query();

echo "<div class=\"col-md-12\"><h3>Food</h3></div>";
foreach($query->fetch_all_pasta_dishes() as $data)
{
  	$status=availability($data['available']);
    $name=htmlspecialchars_decode (htmlspecialchars_decode ($data['name'],ENT_QUOTES));
  	$img=img($data['id'],$data['image']);
  	$price=number_format($data['price'],2 );
    $add=add($data['id'],$data['name'],$data['price'],$data['available']);

    echo   "<div class=\"col-sm-6 col-md-4\">
          <div class=\"thumbnail\">
            {$img}
            <div class=\"caption\">
            <h4>{$name}</h4>
            <div class=\"row\">
            <div class=\"col-md-6\"><p class=\"small\">Php {$price}</p></div>
            <div class=\"col-md-6\" align=\"right\"><p class=\"small\">{$status}</p></div>
            </div>
            {$add}
            </div>
          </div>
        </div>";
}

echo "<div class=\"col-md-12\"><h3>Beverages</h3></div>";
foreach($query->fetch_all_beverages() as $data)
{
$status=availability($data['available']);
$name=htmlspecialchars_decode (htmlspecialchars_decode ($data['name'],ENT_QUOTES));
$img=img($data['id'],$data['image']);
$price=number_format($data['price'],2 );
$add=add($data['id'],$data['name'],$data['price'],$data['available']);

echo   "<div class=\"col-sm-6 col-md-4\">
      <div class=\"thumbnail\">
        {$img}
        <div class=\"caption\">
        <h4>{$name}</h4>
        <div class=\"row\">
        <div class=\"col-md-6\"><p class=\"small\">Php {$price}</p></div>
        <div class=\"col-md-6\" align=\"right\"><p class=\"small\">{$status}</p></div>
        </div>
        {$add}
        </div>
      </div>
    </div>";

}

function add($id,$name,$price,$availability)
{
  $button="<button id=\"{$id}add\" class=\"btn btn-block btn-danger\" onclick=\"add('{$id}','{$name}','{$price}')\">Add</button>";;

  if($availability=='t')
	{
		return $button;
	}
	elseif($availability=='f')
	{
		return "<button class=\"btn btn-block btn-danger\" disabled>Add</button>";
	}
}

function img($id,$img)
{
	if($img!='\x')
	{
		create_img($id,$img);
		return "<img class=\"thumbnail\" style=\"margin-bottom: 5px;\" src=\"../product_images/{$id}.jpg\">";
	}
	else
	{
		return "<img class=\"thumbnail\" style=\"margin-bottom: 5px;\" src=\"../_assets/img/no_img.jpg\">";
	}
}

function create_img($id,$image)
{
	$img = fopen("../product_images/{$id}.jpg", 'wb') or die("cannot open image\n");
	fwrite($img, pg_unescape_bytea($image)) or die("cannot write image data\n");
	fclose($img);
}

function availability($status)
{
	if($status=='t')
	{
		return "<span class=\"label label-success\">Available</span>";
	}
	else
	{
		return "<span class=\"label label-danger\">Out of Stock</span>";
	}
}

?>
