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
$date=getdate(date("U"));
$current_date="$date[year]-";
if($date[mon]<=9)
{
  $current_date.="0$date[mon]-";
}
else
{
  $current_date.="$date[mon]-";
}

if($date[mday]<=9)
{
  $current_date.="0$date[mday]";
}
else
{
  $current_date.="$date[mday]";
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
        <li role="presentation"><a href="index.php">Products</a></li>
        <li role="presentation"><a href="orders.php">Orders</a></li>
        <li role="presentation"  class="active"><a href="reports.php">Report</a></li>
        <li role="presentation"><a href="users.php">Users</a></li>
        <li role="presentation"><a href="po.php">Purchase Order</a></li>
      </ul>
    </div>
    <div class="col-md-6" align="right">
      <form class="form-inline">
      from
      <input type="date" class="form-control input-sm" onchange="getSales()" name="from" id="from" max="<?php echo $current_date;?>">
      &nbsp;
      To
      <input type="date" class="form-control  input-sm" onchange="getSales()" name="to" id="to" max="<?php echo $current_date;?>">
    </form>
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
    <div align="center">
      <br><br>
    <div class="row" align="center">
        <div class="col-md-1"></div>
        <div class="col-md-10" id="sales">
        </div>
        <div class="col-md-1"></div>
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

function getSales()
{
  from_date=$("#from").val().trim();
  to_date=$("#to").val().trim();
var xmlhttp;
// if (str=="")
//   {
//   document.getElementById("sales").innerHTML="";
//   return;
//   }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("sales").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","../functions/sales.php?from="+from_date+"&to="+to_date,true);
xmlhttp.send();
}
$( "#sales" ).load( "../functions/sales.php" );
  </script>

</body>
</html>
