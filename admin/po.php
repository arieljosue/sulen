<?php
session_start();

require_once('../functions/Query.php');

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

$username=json_encode($query->fetch_all_products());

$allusers = fopen("../json/allusers.json","wb");
$cashiers = fopen("../json/cashiers.json","wb");

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
	  <li role="presentation"><a href="orders.php">Orders</a></li>
	  <li role="presentation"><a href="reports.php">Report</a></li>
	  <li role="presentation"><a href="users.php">Users</a></li>
	  <li role="presentation" class="active"><a href="po.php">Purchase Order</a></li>
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
			echo "<div class=\"alert alert-success\" role=\"alert\">{$_GET['msg']}</div>";
		}
		elseif (trim($_GET['trans'])=='false')
		{
			echo "<div class=\"alert alert-danger\" role=\"alert\">{$_GET['msg']}</div>";
		}
	?>
</header>

<div class="col-md-9">
		<table class="table table-striped table-bordered table-hover" id="users">
		<thead>
		  <tr>
			<th> PO num</th>
			<th>Amount</th>
			<th>Date</th>
			<th colspan="3">Action</th>
		  </tr>
		</thead>
		<tbody>
		</tbody>
	  </table>
	</div>

</div>


</body>
</html>
