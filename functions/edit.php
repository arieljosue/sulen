<?php
require_once('Query.php');

$query=new Query();
$query->update_order($_POST['order_id'],$_POST['product_id'],$_POST['qty']);
header("Location:http://localhost:8080/sulen/admin/orders.php?trans=true&msg=Order has been updated.");
?>
