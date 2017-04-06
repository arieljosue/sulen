<?php
session_start();

require_once('../functions/Query.php');

switch ($_SESSION ["user_type"])
{
  case 'a':
    header("Location:http://localhost:8080/sulen/admin");
    exit();

  case 'b':
    header("Location:http://localhost:8080/sulen/admin");
    exit();

  case 'c':
    break;

  default:
    header("Location:http://localhost:8080/sulen/");
    exit();
}
$query=new Query();
$beverages=$query->fetch_order_beverages();
$pasta=$query->fetch_order_pasta();
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
    	  <li role="presentation"><a href="index.php">Home</a></li>
    	  <li role="presentation"   class="active"><a href="orders.php">Orders</a></li>
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
    <div clas="row">
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
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Customer's Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>";

                foreach($pasta as $data)
                {
                  echo "<tr>
                          <td><b>{$data['name']}</b>
                          <br><small>
                          cashier:{$data['firstname']} {$data['lastname']}
                          <br>OR#: {$data['order_id']}
                          <small></td>
                          <td>{$data['qty']}</td>
                          <td>{$data['customers_name']}</td>
                          <td>
                            <button type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#{$data['order_id']}{$data['product_id']}done\">Done</button>
                          </td>
                        </tr>";

                $form= "<form action=\"../functions/serve.php\" method=\"post\">
                        <input value=\"{$data['order_id']}\" name=\"order_id\" hidden>
                        <input value=\"{$data['product_id']}\" name=\"product_id\" hidden>
                        <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">No</button>
                        <button type=\"submit\" class=\"btn btn-danger btn-sm\">Yes</button>
                        </form><br>";

                echo   "<div class=\"modal fade\" id=\"{$data['order_id']}{$data['product_id']}done\" role=\"dialog\">
                            <div class=\"modal-dialog\">

                              <!-- Modal content-->
                              <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                  <h4 class=\"modal-title\">Confirmation</h4>
                                </div>
                                <div class=\"modal-body\" align=\"center\">
                                  <p>Are you sure the product has been served?</p>
                                  {$form}
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
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Customer's Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>";

                foreach($beverages as $data)
                {
                  echo "<tr>
                          <td><b>{$data['name']}</b>
                          <br><small>
                          cashier:{$data['firstname']} {$data['lastname']}
                          <br>OR#: {$data['order_id']}
                          <small></td>
                          <td>{$data['qty']}</td>
                          <td>{$data['customers_name']}</td>
                          <td>
                            <button type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#{$data['order_id']}{$data['product_id']}done\">Done</button>
                          </td>
                        </tr>";

                $form= "<form action=\"../functions/serve.php\" method=\"post\">
                        <input value=\"{$data['order_id']}\" name=\"order_id\" hidden>
                        <input value=\"{$data['product_id']}\" name=\"product_id\" hidden>
                        <button type=\"button\" class=\"btn btn-default btn-sm\" data-dismiss=\"modal\">No</button>
                        <button type=\"submit\" class=\"btn btn-danger btn-sm\">Yes</button>
                        </form><br>";

                echo   "<div class=\"modal fade\" id=\"{$data['order_id']}{$data['product_id']}done\" role=\"dialog\">
                            <div class=\"modal-dialog\">

                              <!-- Modal content-->
                              <div class=\"modal-content\">
                                <div class=\"modal-header\">
                                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                  <h4 class=\"modal-title\">Confirmation</h4>
                                </div>
                                <div class=\"modal-body\" align=\"center\">
                                  <p>Are you sure the product has been served?</p>
                                  {$form}
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
