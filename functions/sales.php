<?php
require_once('Query.php');

$query=new Query();
$sales=$query->sales($_REQUEST["from"],$_REQUEST["to"]);

$sales_summary=$query->summary($_REQUEST["from"],$_REQUEST["to"]);

  if($sales)
  {
    foreach($sales_summary as $data)
    {
      echo "<div align='right'><b>Sales Summary: Php </b>".number_format($data['sum'],2)."</div><br>";
    }

    $row.="<thead><tr>
            <th>OR #</th>
            <th>Date of Purchase</th>
            <th>Total Amount (Php)</th>
          </tr></thead><tbody>";
    foreach($sales as $data)
    {

    $row.="<tr>
            <td>{$data['order_id']}</td>
            <td>{$data['date_of_purchase']}</td>
            <td>{$data['total_amount']}</td>
          </tr>";
    }
    echo "<table class=\"table table-striped table-bordered\">{$row}</tbody></table>";
  }
  else
  {
      echo "No sales report for the given date range";
  }


?>
