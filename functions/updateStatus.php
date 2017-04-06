<?php
require_once('Query.php');

$query=new Query();
$query->update_status($_POST['uid'],$_POST['status']);

$msg="";

if($_POST['status']=='true')
{
  $msg="<i>@{$_POST['username']}</i> has been successfully activated!";
}
elseif($_POST['status']=='false')
{
    $msg="<i>@{$_POST['username']}</i> has been successfully deactivated!";
}
header("Location:http://localhost:8080/sulen/admin/users.php?trans=true&msg={$msg}");
?>
