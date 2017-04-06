<?php
require_once('Query.php');

$query=new Query();

  $result=$query->delete_user($_POST['uid']);

  if($result!=false)
  {
    header("Location:http://localhost:8080/sulen/admin/users.php?trans=true&msg={$_POST['username']} has been deleted.");
  }
  else
  {
    header("Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Transaction unsuccessful.");
  }

?>
