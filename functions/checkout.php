<?php
session_start();
require_once('Query.php');

$query=new Query();

$total;
$order_id;
$customer_id;
$order=[];
$order_list="";

$name=$_POST['customers_name'];
$cash=number_format($_POST['cash'],2);
$item=$_POST['product_name'];
$qty=$_POST['item_qty'];
$product_id=$_POST['product_id'];
$price=$_POST['unit_price'];

foreach($query->add_customer($name) as $data)
{
    $customer_id=$data['customer_id'];
}

for ($x = 0; $x < sizeof($qty); $x++)
{
   $product_name;
   $item_qty=$qty[$x];
   $unit_price=$price[$x];
   $product_name=$item[$x];

   $total+=$item_qty*$unit_price;
   $order_list.= "<tr><td>{$product_name}</td><td>{$item_qty}</td><td>{$unit_price}</td></tr>";
   array_push($order,["product_id"=>$product_id[$x],"qty"=>$qty[$x],"price"=>$price[$x]]);
}
$total=number_format($total,2);
$change=number_format(($cash-$total),2);

foreach($query->add_order($customer_id,$_SESSION['id'],$total) as $data)
{
    $order_id=$data['order_id'];
}

foreach($order as $data)
{
  $query->add_order_details($order_id,$data["product_id"],$data["qty"],$data["price"]);
}

echo               "<table>
                    <thead><tr><th align=\"center\" colspan=\"3\"><u>SULEN</u></th></tr></thead>
                    <thead><tr><th>Item</th><th>Qty</th><th>Price</th></tr></thead>
                    <tbody>
                      {$order_list}
                    </tbody>
                    </table>
                    <br>
                    <table>
                      <tr>
                      <td>Total:</td><td></td><td>{$total}</td>
                      </tr>
                      <tr>
                      <td>Cash:</td><td></td><td>{$cash}</td>
                      </tr>
                      <tr>
                      <td>Change:</td><td></td><td>{$change}</td>
                      </tr>
                    </table>
                    <br>
                    Customer: {$name}<br><small>OR#:{$order_id}</small>";


echo "<script>
      window.print();
      document.location ='http://localhost:8080/sulen/cashier/?trans=true&msg=Order is being processed.';
      </script>";
?>
