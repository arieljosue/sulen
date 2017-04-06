<?php
require_once('Query.php');

$query=new Query();

$query->serve_product($_POST["order_id"],$_POST["product_id"]);

header("Location:http://localhost:8080/sulen/cashier/orders.php?trans=true&msg=Order has been served.");
?>
