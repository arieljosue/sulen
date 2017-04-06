<?php
session_set_cookie_params(0, '/', 'http://localhost:8080/sulen/');
session_start();

switch ($_SESSION ["user_type"])
{
  case 'a':
    echo "<script>document.location ='http://localhost:8080/sulen/admin'</script>";
		break;

  case 'b':
		echo "<script>document.location ='http://localhost:8080/sulen/admin'</script>";
    break;

  case 'c':
		echo "<script>document.location ='http://localhost:8080/sulen/cashier'</script>";
		break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Sulen</title>
<link rel="stylesheet" href="_assets\css\bootstrap-cosmo.css">
<link rel="stylesheet" href="_assets\css\img_res.css">
</head>
<body>
<div class="container">
  <br>
  <header id="error">
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
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <h3 align="center">Sulen</h3>
      <form method="post" action="functions/login.php">
      <input class="form-control" type="text" placeholder="Username" name="username" id="username"><br>
      <input class="form-control" type="password" placeholder="Password" name="password" id="password"><br>
      <button class="btn btn-danger btn-block btn-md" type="submit" id="login" disabled>Log in</button>
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
setInterval(
function()
{
	if($('#username').val().trim().length>0 &&
		$('#password').val().trim().length>0
	)
	{
		$('#login').attr('disabled',false);
	}
	else
	{
		$('#login').attr('disabled',true);
	}
});
</script>
</html>
