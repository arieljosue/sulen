<?php
session_start();

require_once('../functions/Query.php');

session_start();

switch ($_SESSION ["user_type"])
{
  case 'a':
    break;
  case 'b':
    break;
  case 'c':
    header("Location:http://localhost:8080/sulen/cashier/index.php");
    exit();

  default:
    header("Location:http://localhost:8080/sulen/");
    exit();
}


$query=new Query();
$query->remove_unreferenced_order();
$beverages=$query->fetch_order_beverages_adm();
$pasta=$query->fetch_order_pasta_adm();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Sulen</title>
<link rel="stylesheet" href="../_assets\css\bootstrap-cosmo.css">
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="#"><font color="white">SULEN</font></a>
      </div>
      <div>
      <ul class="nav navbar-nav pull-right">
        <li class="active"><a href="../functions/logout.php">Logout</a></li>
      </ul>
    </div>
    </div>
  </nav>
<br>
  <div class="container">
    <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-pills">
        <li role="presentation"><a href="index.php">Products</a></li>
        <li role="presentation" class="active"><a href="orders.php">Orders</a></li>
        <li role="presentation"><a href="reports.php">Report</a></li>
        <li role="presentation"><a href="users.php">Users</a></li>
        <li role="presentation"><a href="po.php">Purchase Order</a></li>
      </ul>
    </div>
    <div class="col-md-6">
    	<div  align="right">
    		<div class="input-group  col-md-6">
    			<input class="form-control" type="text" id="search" placeholder="Search">
    			<div class="input-group-addon">
    				<span class="glyphicon glyphicon-search"></span>
    			</div>
    		</div>
    	</div>
    </div>

    </div>
  </div>
    <div class="container-fluid">
    <br>
    <header align="center" id="error">
      <?php
    		if(trim($_GET['trans'])=='true')
    		{
    			echo "<div class=\"alert alert-success\" role=\"alert\">{$_GET['msg']}</div>";		}
    		elseif (trim($_GET['trans'])=='false')
    		{
    			echo "<div class=\"alert alert-danger\" role=\"alert\">{$_GET['msg']}</div>";
    		}
    	?>
    </header>
    <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-6" align="right">
        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" id="cancel_">Cancel</button>
        <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" align="left">Cancel Order</h4>
            </div>
            <div class="modal-body" align="center">
              <p>Are you sure ypu want to cancel the following order?</p>
              <form action="../functions/cancelOrders.php" method="post">
                <div id="cancel_product">
                </div>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger btn-sm">Yes</button>
              </form>
            </div>
            <div class="modal-footer">

            </div>
          </div>

        </div>
      </div>

      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Food</h3>
          </div>
          <div class="panel-body">
            <table class="table">
            <?php
              if($pasta)
              {
                echo" <thead>
                      <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Customer's Name</th>
                        <th>Status</th>
                        <th colspan=\"2\">Action</th>
                      </tr>
                    </thead>";

                foreach($pasta as $data)
                {
                  $served=served($data['served']);
                  echo "<tr>
                          <td><input type=\"checkbox\" name=\"product\" id=\"product\" value=\"{$data['order_id']}-{$data['product_id']}\"></td>
                          <td><b>{$data['name']}</b>
                          <br><small>cashier:{$data['firstname']}
                          <br>OR#: {$data['order_id']}<small></td>
                          <td>{$data['qty']}</td>
                          <td>{$data['customers_name']}</td>
                          <td>{$served}</td>
                          <td>
                            <button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#{$data['order_id']}{$data['product_id']}edit\">Edit</button>
                          </td>
                          <td>
                            <button type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#{$data['order_id']}{$data['product_id']}cancel\">Cancel</button>
                          </td>
                        </tr>";

                $form= "<form action=\"../functions/cancel.php\" method=\"post\">
                        <input value=\"{$data['order_id']}\" name=\"order_id\" hidden>
                        <input value=\"{$data['product_id']}\" name=\"product_id\" hidden>
                        <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">No</button>
                        <button type=\"submit\" class=\"btn btn-danger btn-sm\">Yes</button>
                        </form><br>";

                echo   "<div class=\"modal fade\" id=\"{$data['order_id']}{$data['product_id']}cancel\" role=\"dialog\">
                            <div class=\"modal-dialog\">

                              <!-- Modal content-->
                              <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                  <h4 class=\"modal-title\">Cancel Order</h4>
                                </div>
                                <div class=\"modal-body\" align=\"center\">
                                  <p>Are you sure to cancel the order?</p>
                                  {$form}
                                </div>
                                <div class=\"modal-footer\">
                                </div>
                              </div>

                            </div>
                          </div>";

                          echo   "<div class=\"modal fade\" id=\"{$data['order_id']}{$data['product_id']}edit\" role=\"dialog\">
                                      <div class=\"modal-dialog\">

                                        <!-- Modal content-->
                                        <div class=\"modal-content\">
                                          <div class=\"modal-header\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                            <h4 class=\"modal-title\">Cancel Order</h4>
                                          </div>
                                          <div class=\"modal-body\" align=\"center\">
                                                  <form action=\"../functions/edit.php\" method=\"post\">
                                                  <input value=\"{$data['order_id']}\" name=\"order_id\" hidden>
                                                  <input value=\"{$data['product_id']}\" name=\"product_id\" hidden>
                                                  <input class=\"form-control input-xs\" type=\"number\"value=\"{$data['qty']}\" name=\"qty\" placeholder=\"Quantity\"min=\"1\"><br>
                                                  <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">Cancel</button>
                                                  <button type=\"submit\" class=\"btn btn-danger btn-sm\">Update</button>
                                                  </form><br>
                                          </div>
                                          <div class=\"modal-footer\">
                                          </div>
                                        </div>

                                      </div>
                                    </div>";

                }
              }
            ?>
          </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Beverages</h3>
          </div>
          <div class="panel-body">
            <table class="table">
            <?php
              if($beverages)
              {
                echo" <thead>
                      <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Customer's Name</th>
                        <th>Status</th>
                        <th colspan=\"2\">Action</th>
                      </tr>
                    </thead>";
                foreach($beverages as $data)
                {
                  $served=served($data['served']);
                  echo "<tr>
                          <td><input type=\"checkbox\" name=\"product\" id=\"product\" value=\"{$data['order_id']}-{$data['product_id']}\"></td>
                          <td><b>{$data['name']}</b>
                          <br><small>cashier:{$data['firstname']}
                          <br>OR#: {$data['order_id']}<small></td>
                          <td>{$data['qty']}</td>
                          <td>{$data['customers_name']}</td>
                          <td>{$served}</td>
                          <td>
                            <button type=\"button\" class=\"btn btn-danger btn-xs\" data-toggle=\"modal\" data-target=\"#{$data['order_id']}{$data['product_id']}edit\">Edit</button>
                          </td>
                          <td>
                            <button type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#{$data['order_id']}{$data['product_id']}cancel\">Cancel</button>
                          </td>
                        </tr>";

                $form= "<form action=\"../functions/cancel.php\" method=\"post\">
                        <input value=\"{$data['order_id']}\" name=\"order_id\" hidden>
                        <input value=\"{$data['product_id']}\" name=\"product_id\" hidden>
                        <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">No</button>
                        <button type=\"submit\" class=\"btn btn-danger btn-sm\">Yes</button>
                        </form><br>";

                echo   "<div class=\"modal fade\" id=\"{$data['order_id']}{$data['product_id']}cancel\" role=\"dialog\">
                            <div class=\"modal-dialog\">

                              <!-- Modal content-->
                              <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                  <h4 class=\"modal-title\">Cancel Order</h4>
                                </div>
                                <div class=\"modal-body\" align=\"center\">
                                  <p>Are you sure to cancel the order?</p>
                                  {$form}
                                </div>
                                <div class=\"modal-footer\">
                                </div>
                              </div>

                            </div>
                          </div>";

                          echo   "<div class=\"modal fade\" id=\"{$data['order_id']}{$data['product_id']}edit\" role=\"dialog\">
                                      <div class=\"modal-dialog\">

                                        <!-- Modal content-->
                                        <div class=\"modal-content\">
                                          <div class=\"modal-header\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                            <h4 class=\"modal-title\">Cancel Order</h4>
                                          </div>
                                          <div class=\"modal-body\" align=\"center\">
                                                  <form action=\"../functions/edit.php\" method=\"post\">
                                                  <input value=\"{$data['order_id']}\" name=\"order_id\" hidden>
                                                  <input value=\"{$data['product_id']}\" name=\"product_id\" hidden>
                                                  <input class=\"form-control input-xs\" type=\"number\"value=\"{$data['qty']}\" name=\"qty\" placeholder=\"Quantity\"min=\"1\"><br>
                                                  <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">Cancel</button>
                                                  <button type=\"submit\" class=\"btn btn-danger btn-sm\">Update</button>
                                                  </form><br>
                                          </div>
                                          <div class=\"modal-footer\">
                                          </div>
                                        </div>

                                      </div>
                                    </div>";

                }
              }
            ?>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
  <script src="../_assets\js\jquery-2.1.3.min.js"></script>
  <script src="../_assets\js\bootstrap.min.js"></script>
<script>
setInterval(
  function(){
    var orders=[];
    $("input:checkbox[name=product]:checked").each(function(){
        orders.push($(this).val());
    });

    var i;
    var ordertxtbox="";

    for (i = 0; i < orders.length; i++)
    {
      ordertxtbox +="<input type='text' name=orders_id[] value=\""+orders[i]+"\" hidden>";
    }

    if(orders.length==0)
    {
      $('#cancel_').attr('disabled',true);
    }
    else
    {
      $('#cancel_').attr('disabled',false);
    }
 document.getElementById("cancel_product").innerHTML =ordertxtbox;
});

</script>
  <script>
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })

  $('#search').on('keyup', function(e) {
      if ('' != this.value) {
          var reg = new RegExp(this.value, 'i'); // case-insesitive
  	      $('.table tbody').find('tr').each(function() {
              var $me = $(this);
  			if (!$me.children('td').text().match(reg)) {
                  $me.hide();
              } else {
                  $me.show();
              }

          });

      } else {
          $('.table tbody').find('tr').show();
      }
  });

  </script>

</body>
</html>
<?php
function served($stat)
{
  if($stat=='t')
  {
    return "served";
  }
  elseif($stat='f')
  {
    return "pending";
  }
}
?>
