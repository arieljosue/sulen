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

$username=json_encode($query->fetch_all_username());

$allusers = fopen("../json/allusers.json","wb");
$cashiers = fopen("../json/cashiers.json","wb");

fwrite($allusers,json_encode($query->fetch_all_users()));
fwrite($cashiers,json_encode($query->fetch_all_cashiers()));

fclose($allusers);
fclose($cashiers);
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
	  <li role="presentation" class="active"><a href="users.php">Users</a></li>
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
<div class="row">
<br>
	<!--All users-->
	<div class="col-md-9">
		<table class="table table-striped table-bordered table-hover" id="users">
		<thead>
		  <tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Username</th>
			<th>Password</th>
			<th>User Type</th>
			<th colspan="3">Action</th>
		  </tr>
		</thead>
		<tbody>
		</tbody>
	  </table>
	</div>

	<!--Add product-->
	<div class="col-md-3">
		<div class="panel panel-danger">
		  <div class="panel-heading">Add User</div>
		  <div class="panel-body">
			<header id="add_user_error" align="center">

			</header>
			<form method="post" action="../functions/addUser.php">
			<!---->
			<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" pattern="[a-zA-Z]+[a-zA-Z ]+" required>
			<br><!---->
			<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" pattern="[a-zA-Z]+[a-zA-Z ]+" required>
			<br><!--has to be unique-->
			<div class="form-group">
				<div class="input-group">
				  <div class="input-group-addon">@</div>
				  <input type="text" class="form-control" placeholder="User Name" name="username" id="add_username" pattern="[a-zA-Z0-9_]{5,20}" required>
				</div>
			</div>
			<input type="password" class="form-control" placeholder="Password" name="password" id="password" pattern="[a-zA-Z0-9]{5,20}" required>
			<br>
			<div align="center">
				<label class="radio-inline">
				  <input type="radio" value="c" name="usertype" id="usertype" required>Cashier
				</label>
				<label class="radio-inline">
				  <input type="radio" value="b" name="usertype" id="usertype">Administrator
				</label>
			</div>
			<br>
			<div class="pull-right">
				<button type="submit" class="btn btn-default" id="add_submit">Add</button>
				<button type="reset" class="btn btn-default">Cancel</button>
			</div>
			</form>
		  </div>
		</div>
	</div>
<br>
<br>
<footer>
</footer>
</div>

</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="../_assets\js\jquery-2.1.3.min.js"></script>
<script src="../_assets\js\bootstrap.min.js"></script>
<script>
var username=<?php echo $username;?>;

setInterval(
function(){

		if($('#add_username').val().trim().length > 0)
		{
			if(search($('#add_username').val().trim()))
			{
				$('#add_submit').attr('disabled',true);
				document.getElementById("add_user_error").innerHTML="Username not available.";
			}
			else
			{
				$('#add_submit').attr('disabled',false);
				document.getElementById("add_user_error").innerHTML="";
			}
		}
		else
		{
			$('#add_submit').attr('disabled',false);
			document.getElementById("add_user_error").innerHTML="";
		}
});

function search(user_name)
{
	var $i;
	var $result=false;
	for(i=0;i<username.length;i++)
	{
		if(username[i].username==user_name)
		{
			$result=true;
		}
	}
	return $result;
}
</script>
<script>
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
 <script>
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
		var a = {};
		<?php
				$file;
				if($_SESSION['user_type']=='a')
				{
					$file="allusers";
				}
				else if($_SESSION['user_type']=='b')
				{
					$file="cashiers";
				}
		?>
		$.getJSON('../json/<?php echo $file; ?>.json', function (data) {
			a = data;

			$.each(a, function(idx, user){

			$('table#users TBODY').append(
						'<tr><td>'+user.firstname+'</td><td>'+user.lastname+'</td><td>'+user.username+
						'</td><td>'+user.password+'</td><td>'+usertype(user.usertype)+
						'</td><td>'+edit(user.id,user.firstname,user.lastname,user.username,user.password,user.usertype)+'</td><td>'+
						delete_user(user.id,user.user_is_referenced,user.firstname+' '+user.lastname,'@'+user.username)+
						'</td><td>'+active(user.id,user.active,user.username)+'</td></tr>');
			});
		});
function usertype(usertype)
{
	if(usertype=='b')
	{
		return "Admin";
	}
	else if(usertype=='c')
	{
		return "Cashier";
	}
}

function active(id,type,username)
{
	switch(type) {
    case 't':
        return 	'<form method="post" action="../functions/updateStatus.php">'+
				'<input type="text" name="status" value="false" hidden>'+
				'<input type="text" name="username" value="'+username+'" hidden>'+
				'<input type="text" name="uid" value="'+id+'" hidden>'+
				'<button class="btn btn-default btn-xs btn-success" type="submit"">Deactivate</button>'+
				'</form>';
        break;

    case 'f':
		return 	'<form method="post" action="../functions/updateStatus.php">'+
				'<input type="text" name="status" value="true" hidden>'+
				'<input type="text" name="username" value="'+username+'" hidden>'+
				'<input type="text" name="uid" value="'+id+'" hidden>'+
				'<button class="btn btn-default btn-xs btn-info" type="submit"">Activate</button>'+
				'</form>';
		break;
    }
}
function edit(id,firstname,lastname,username,password,usertype)
{
	button 	=	'<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#'+id+'">'+
				  'Edit'+
				'</button>'

	modal	=	'<div class="modal fade" id="'+id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
				  '<div class="modal-dialog" role="document">'+
					'<div class="modal-content">'+
					  '<div class="modal-header">'+
						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						'<h4 class="modal-title" id="myModalLabel">Edit User</h4>'+
					  '</div>'+
					  '<div class="modal-body">'+
						'<div align="center">'+
							'<header id="editError"></header>'+
							'<form method="post" action="../functions/updateUser.php">'+
								'<input type="text" name="uid" id="edit_uid" value="'+id+'" hidden>'+
								'<input type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname" value="'+firstname+'"pattern="[a-zA-Z]+[a-zA-Z ]+" required><br>'+
								'<input type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname" value="'+lastname+'"pattern="[a-zA-Z]+[a-zA-Z ]+" required><br>'+								'<div class="form-group">'+
									'<div class="input-group">'+
										'<div class="input-group-addon">@</div>'+
										'<input type="text" class="form-control" placeholder="User Name" name="username" id="edit_username" value="'+username+'" pattern="[a-zA-Z0-9_]{5,20}" required>'+
									'</div><br>'+
								'<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="'+password+'" pattern="[a-zA-Z0-9]{5,20}" required><br>'+
								'<br>'+
								selected(usertype)+
							'</div><br>'+
							'<div align="center">'+
								'<button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>&nbsp'+
								'<button class="btn btn-default btn-sm" type="submit" id="edit_submit">Save changes</button>'+
							'</div><br>'+
							'</form>'+
					  '</div>'+
					  '<div class="modal-footer">'+
						'</div>'+
					'</div>'+
				  '</div>'+
				'</div>';

	return button+modal;
}
function selected(usertype)
{
	if(usertype=='b')
	{
	radio	=	'<label class="radio-inline">'+
				  '<input type="radio" value="c" name="usertype" id="usertype" required>Cashier'+
				'</label>'+
				'<label class="radio-inline">'+
					'<input type="radio" value="b" checked="checked" name="usertype" id="usertype">Administrator'+
				'</label>';
	}
	else if(usertype=='c')
	{
	radio	=	'<label class="radio-inline">'+
				  '<input type="radio" value="c" checked="checked" name="usertype" id="usertype" required>Cashier'+
				'</label>'+
				'<label class="radio-inline">'+
					'<input type="radio" value="b" name="usertype" id="usertype">Administrator'+
				'</label>';
	}
	return radio;
}
function delete_user(id,is_referenced,name,username)
{
	button 	=	'<button class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#'+id+'del">'+
				  'Delete'+
				'</button>'
	button_disabled	=	'<button class="btn btn-default btn-xs btn-danger" disabled>'+
				  'Delete'+
				'</button>'

	modal	=	'<div class="modal fade" id="'+id+'del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
				  '<div class="modal-dialog" role="document">'+
					'<div class="modal-content">'+
					  '<div class="modal-header">'+
						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
						'<h4 class="modal-title" id="myModalLabel">Delete User</h4>'+
					  '</div>'+
					  '<div class="modal-body">'+
							'<form method="post" action="../functions/deleteUser.php">'+
								'<input type="text" value="'+id+'" name="uid" id="uid" hidden>'+
								'<input type="text" value="'+username+'" name="username" id="username" hidden>'+
								'<div align="center"><p>Are you sure you want to delete this user?</p>'+
								'<i>'+name+'<br>'+username+'</i>'+
										'<br><br>'+
										'<button class="btn btn-default btn-sm" data-dismiss="modal">Close</button>&nbsp'+
										'<button class="btn btn-default btn-sm">Save changes</button>'+
									'</div>'+
							'</form>'+
						'</div>'+
					  '<div class="modal-footer">'+
						'</div>'+
					'</div>'+
				  '</div>'+
				'</div>';
	if(is_referenced=='f')
	{
		return button+modal;
	}
	else
	{
		return button_disabled;
	}
}
</script>

</body>
</html>
