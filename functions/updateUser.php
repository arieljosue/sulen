<?php
require_once('Query.php');
require_once('Filter.php');

$query=new Query();
$filter=new Filter();
$uid=$_POST['uid'];
$id;

$filter_results=$filter->add_user($_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['password'],$_POST['usertype']);

foreach ($query->fetch_user($uid) as $data)
{
  if( $filter_results[0]==$data['firstname'] AND
      $filter_results[1]==$data['lastname'] AND
      $filter_results[2]==$data['usertype'] AND
      $filter_results[3]==$data['username'] AND
      $filter_results[4]==$data["password"]
    )
  {
    header("Location:http://localhost:8080/sulen/admin/users.php");
    exit;
  }
}

foreach($query->fetch_username($filter_results[3]) as $data)
{
  $id=$data["id"];
}

if($filter_results)
{
  if(($id==$uid) OR ($id==""))
  {
    $result=$query->update_user($uid,$filter_results[0],$filter_results[1],$filter_results[2],$filter_results[3],$filter_results[4]);

    if($result!=false)
    {
          header("Location:http://localhost:8080/sulen/admin/users.php?trans=true&msg=User <i>{$filter_results[3]}</i> has been successfully updated.");
    }
    else
    {
          header('Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Transaction unsuccessful.');
    }
  }
  else
  {
          header('Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Username is not available.');
  }
}
else
{
    header("Location:http://localhost:8080/sulen/admin/users.php?trans=false&msg=Transaction unsuccessful.");
}

?>
