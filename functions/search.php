<?php
require_once('Query.php');

$query=new Query();

$keyword = strtolower($_REQUEST["keyword"]);

$count=0;
$results="";

foreach($query->fetch_all_products() as $data)
{
  if	(
        strpos(strtolower($data["name"]),$keyword) !== false OR
        strpos(strtolower(number_format($data['price'],2)),$keyword) !== false OR
        strpos(strtolower(category($data["category"])),$keyword) !== false
      )
      {
        	$status=availability($data['available']);
        	$delete=_delete($data['id'],$data['product_is_referenced']);
        	$remove=remove_image($data['id'],$data['image']);
        	$name=htmlspecialchars_decode (htmlspecialchars_decode ($data['name'],ENT_QUOTES));
        	$edit=edit($data['id'],$name,$data['price'],$data['category'],$data['available']);
        	$img=img($data['id'],$data['image']);
        	$replace=replace_img($data['id'],$data['image']);
          $price=number_format($data['price'],2);
          $category=category($data['category']);

        	$results.="<div class=\"col-sm-6 col-md-4\">
        				<div class=\"thumbnail\">
        					{$img}
        						<div align=\"center\">
        						<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
        							{$remove}
        							{$replace}
        						</div>
        						</div>
        					<div class=\"caption\">
        					<h4>{$name}</h4>
        					<div class=\"row\">
        					<div class=\"col-md-6\"><p class=\"small\">Php {$price}<br>{$category}</p></div>
        					<div class=\"col-md-6\" align=\"right\"><p class=\"small\">{$status}</p></div>
        					</div>
        					<div align=\"center\">
        					<div class=\"btn-group\" role=\"group\" aria-label=\"...\">
        							{$edit}
        							{$delete}
        						</div>
        						</div>
        					</div>
        				</div>
        			</div>";

        $count++;
      }
}

if($count==0)
{
	$results="No results found";
}

function category($cat)
{
  if($cat==1)
  {
    return "Pasta";
  }
  elseif($cat==2)
  {
    return "Beverage";
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

function replace_img($id,$img)
{
	$button;
	$modal	=	"<div class=\"modal fade\" id=\"{$id}rep\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
				  <div class=\"modal-dialog\" role=\"document\">
					<div class=\"modal-content\">
					  <div class=\"modal-header\">
						<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
						<h4 class=\"modal-title\" id=\"myModalLabel\">Add/Replace Image</h4>
					  </div>
					  <div class=\"modal-body\">
							<form method=\"post\" action=\"../functions/replaceImage.php\" enctype=\"multipart/form-data\">
								<input type=\"text\" name=\"pid\" value=\"{$id}\" hidden>
								<div class=\"panel panel-default\">
									<div class=\"panel-body\">
										<input type=\"file\" placeholder=\"Image\" accept=\"image/jpg, image/jpeg\" id=\"image\" name=\"image\">
									</div>
								</div>
								<button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">Cancel</button>
								<button type=\"submit\" class=\"btn btn-default btn-sm btn-danger\">Upload</button>
							</form>
						</div>
					  <div class=\"modal-footer\">
					  </div>
					</div>
				  </div>
				</div>";

	if($img!='\x')
	{
		$button="<button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#{$id}rep\">
						  Replace Image
						</button>";
	}
	else
	{
		$button="<button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#{$id}rep\">
						  Add Image
						</button>";
	}

	return $button.$modal;
}

function remove_image($id,$img)
{
$button	=	"<button type=\"button\" class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#{$id}rem\">
			  Remove Image
			</button>";

$modal	=	"<div class=\"modal fade\" id=\"{$id}rem\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
			  <div class=\"modal-dialog\" role=\"document\">
				<div class=\"modal-content\">
				  <div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					<h4 class=\"modal-title\" id=\"myModalLabel\">Remove Image</h4>
				  </div>
				  <div class=\"modal-body\">
						<form method=\"post\" action=\"../functions/removeImage.php\">
							<input type=\"text\" name=\"uid\" value=\"{$id}\" hidden>
							<p>Are you sure you want to remove the image of this product?</p>
							<button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">No</button>
							<button type=\"submit\" class=\"btn btn-default btn-sm btn-danger\">Yes</button>
						</form>
					</div>
				  <div class=\"modal-footer\">
				  </div>
				</div>
			  </div>
			</div>";

	if($img!='\x')
	{
				return $button.$modal;
	}
}
function _delete($id,$is_referenced)
{
$button	=	"<button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#{$id}del\">
			  Delete
			</button>";

$button_disabled	=	"<button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" disabled>
						  Delete
						</button>";

$modal	=	"<div class=\"modal fade\" id=\"{$id}del\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
			  <div class=\"modal-dialog\" role=\"document\">
				<div class=\"modal-content\">
				  <div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					<h4 class=\"modal-title\" id=\"myModalLabel\">Delete Product</h4>
				  </div>
				  <div class=\"modal-body\">
						<form method=\"post\" action=\"../functions/deleteProduct.php\">
							<p>Are you sure you want to delete this product?<p>
							<input type=\"text\" name=\"uid\" value=\"{$id}\" hidden>
							<br>
							<button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">No</button>
							<button type=\"submit\" class=\"btn btn-default btn-sm btn-danger\">Yes</button>
						</form>
					</div>
				  <div class=\"modal-footer\">
				  </div>
				</div>
			  </div>
			</div>";

	if($is_referenced=='f')
	{
		return $button.$modal;
	}
	else
	{
		return $button_disabled;
	}
}
function selected_stock($availability)
{
	if($availability=='t')
	{
		return	"<option value=\"true\" selected>Available</option>
						<option value=\"false\">Out of Stock</option>";
	}
	else
	{
		return	"<option value=\"true\">Available</option>
						<option value=\"false\" selected>Out of Stock</option>";
	}
}

function edit($id,$name,$price,$category,$availability)
{
$selected=selected($category);
$stock=selected_stock($availability);

$button	=	"<button type=\"button\" class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#{$id}edit\">
			  Edit
			</button>";

$modal	=	"<div class=\"modal fade\" id=\"{$id}edit\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
			  <div class=\"modal-dialog\" role=\"document\">
				<div class=\"modal-content\">
				  <div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					<h4 class=\"modal-title\" id=\"myModalLabel\">Edit Product</h4>
				  </div>
				  <div class=\"modal-body\">
					<form method=\"post\" action=\"../functions/editProduct.php\">
						<input type=\"text\" name=\"pid\" value=\"{$id}\" hidden>
						<input class=\"form-control\" type=\"text\" placeholder=\"Product Name\" name=\"name\" id=\"name\" value=\"{$name}\"required><br>
						<div class=\"form-group\">
							<div class=\"input-group\">
							  <div class=\"input-group-addon\">Php</div>
							  <input type=\"number\" min=\"0.01\" step=\"any\" class=\"form-control\" name=\"price\" id=\"price\" value=\"{$price}\"placeholder=\"00.00\" required>
							</div>
						</div>
						<select class=\"form-control\" name=\"category\" id=\"category\" required>
							{$selected}
						</select>
						<br>
						<select class=\"form-control\" name=\"availability\" id=\"availability\" required>
							{$stock}
						</select>
						<br>
						<button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">Close</button>
						<button type=\"submit\" class=\"btn btn-default btn-sm btn-danger\">Save changes</button>
						</form>
					</div>
				  <div class=\"modal-footer\">
				  </div>
				</div>
			  </div>
			</div>";

	return $button.$modal;

}

function selected($category)
{

	if($category==1)
	{
		return	"<option value=\"1\" selected>Pasta</option>
				<option value=\"2\">Beverage</option>";
	}
	else
	{
		return	"<option value=\"1\">Pasta</option>
				<option value=\"2\" selected>Beverage</option>";
	}
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

echo  $results;

?>
