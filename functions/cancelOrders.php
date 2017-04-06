<?php
require_once('Query.php');

$query=new Query();

foreach ($_POST['orders_id'] as $data)
{
  $temp=explode("-",$data);
  $query->cancel_order($temp[0],$temp[1]);
}
header("Location:http://localhost:8080/sulen/admin/orders.php?trans=true&msg=Order/s has been cancelled.");

?>
