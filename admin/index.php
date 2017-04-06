<?php
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
	  <li role="presentation"  class="active"><a href="index.php">Products</a></li>
	  <li role="presentation"><a href="orders.php">Orders</a></li>
	  <li role="presentation"><a href="reports.php">Report</a></li>
	  <li role="presentation"><a href="users.php">Users</a></li>
	  <li role="presentation"><a href="po.php">Purchase Order</a></li>
	</ul>
</div>
<div class="col-md-6">
	<div  align="right">
		<div class="input-group  col-md-6">
	  	<input class="form-control" placeholder="Search product" id="search" onkeyup="search(this.value)">
			<div class="input-group-addon">
				<span class="glyphicon glyphicon-search"></span>
			</div>
		</div>
	</div>
</div>
</div>
<br>
<header align="center">
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

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="../_assets\js\jquery-2.1.3.min.js"></script>
<script src="../_assets\js\bootstrap.min.js"></script>
<script>
$( "#results" ).load( "../functions/products.php" );
</script>
<script>
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
<script>
function search(keyword) {
    if (keyword.trim().length == 0) {
			$( "#results" ).load( "../functions/products.php" );
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("results").innerHTML = xmlhttp.responseText;
            }
        }
				xmlhttp.open("GET","../functions/search.php?keyword="+keyword.trim(),true);
				xmlhttp.send();
    }
}
</script>
</body>
</html>
