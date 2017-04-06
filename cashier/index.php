<?php
session_start();

switch ($_SESSION ["user_type"])
{
  case 'a':
    header("Location:http://localhost:8080/sulen/admin");
    exit();

  case 'b':
    header("Location:http://localhost:8080/sulen/admin");
    exit();

  case 'c':
    break;
  default:
    header("Location:http://localhost:8080/sulen/");
    exit();
}

if(!isset($_SESSION["user_type"]))
{
  header("Location:http://localhost:8080/sulen/");
}
elseif($_SESSION ["user_type"]!=='c')
{
  header("Location:http://localhost:8080/sulen/admin/index.php");
}

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
    	  <li role="presentation"  class="active"><a href="index.php">Home</a></li>
    	  <li role="presentation"><a href="orders.php">Orders</a></li>
    	</ul>
    </div>
    <div class="col-md-6"></div>
    </div>
    <br>
    <header align="center" id="error">
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

      <div class="col-md-7">
        <div class="panel panel-danger">
          <div class="panel-body">

            <div class="input-group">
        	  	<input class="form-control" placeholder="Search product" id="search" onkeyup="search(this.value)">
        			<div class="input-group-addon">
        				<span class="glyphicon glyphicon-search"></span>
        			</div>
        		</div>
            <br>
            <div id="results">
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="panel panel-danger">
    		  <div class="panel-heading">Order</div>
    		  <div class="panel-body">
            <div align="center">
              <div class="row">
                <div class="col-md-4"><b>Item</b></div>
                <div class="col-md-3"><b>Quantity</b></div>
                <div class="col-md-3"><b>Unit Price (Php)</b></div>
                <div class="col-md-2"></div>
              </div>
              <hr>
              <div id="orders">
              </div>

              <div id="total">
              </div>

              <br>

              <div align="right">
                <button type="button" class="btn btn-primary" id="checkout" data-toggle="modal" data-target="#cashoutModal">Cashout</button>
                <!--<button type="submit" class="btn btn-primary" id="checkout"onclick="PrintMeSubmitMe()" disabled>Checkout</button>-->
              </div>
            </div>
          </div>
    		</div>
      </div>
      <!-- Modal -->
      <div id="cashoutModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Cashout</h4>
            </div>
            <div class="modal-body">
              <form name="OrderForm" method="post" action="../functions/checkout.php">
                <div class="row">
                  <div class="col-md-6"><b>Cash</b></div>
                  <div class="col-md-4" align="right">
                    <div class="form-group" style="margin-left: 14px;">
              				<div class="input-group">
              				  <div class="input-group-addon">Php</div>
              				  <input type="number" min="" step="any" class="form-control" name="cash" id="cash" placeholder="00.00" required>
              				</div>
              			</div>
                  </div>
                  <div class="col-md-2"></div>
                </div>

                <div id="total_cashout"></div>
                <br>
                <div class="row">
                  <div class="col-md-4"><b>Change</b></div>
                  <div class="col-md-4"></div>
                  <div class="col-md-4" id="change"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6"><b>Customer</b></div>
                  <div class="col-md-4" align="right" style="padding-left: 30px;">
                    <input class="form-control input-sm" type="text" pattern="[a-zA-Z0-9]+[a-zA-Z0-9 ]+{1,50}" required placeholder="Customer's Name" name="customers_name" id="customers_name">
                  </div>
                  <div class="col-md-2"></div>
                </div>
                <div id="order_cashout"></div>
                <br>
                <div align="center">
                  <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="Submit" class="btn btn-primary"id="final_checkout" disabled>Cashout</button>
                </div>
              </form>
              <br>

              </div>
            <div class="modal-footer">
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
  <script src="../_assets\js\jquery-2.1.3.min.js"></script>
  <script src="../_assets\js\bootstrap.min.js"></script>
  <script>
  $( "#results" ).load("products.php");
  </script>
  <script>
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })
  </script>
  <script>
  var change;

  function add(id,name,price)
  {
    $('#'+id+'add').attr('disabled',true);
    append_div="<div class=\"row\"style=\"padding-bottom: 10px;border-top-width: 15px;padding-top: 10px;\">"+
                "<div class=\"col-md-4\"><input value='"+id+"' name=\"id[]\" hidden>"+
                "<input value='"+name.substring(0,15)+"' name=\"product[]\" hidden>"+name.substring(0,15)+"</div>"+
                "<div class=\"col-md-3\"><input class=\"form-control input-sm\" type=\"number\" min=\"1\" value='1' name=\"qty[]\"></div>"+
                "<div class=\"col-md-3\"><input value='"+parseFloat(Math.round(price * 100) / 100).toFixed(2)+"' name=\"price[]\" hidden>"+parseFloat(Math.round(price * 100) / 100).toFixed(2)+"</div>"+
                "<div class=\"col-md-2\"><button class=\"btn btn-xs btn-danger remove\" value=\""+id+"\"><span class=\"glyphicon glyphicon-remove\"></span></button></div>"+
              "</div>";
    $("#orders").append(append_div);
  }

 $(document).on('click', 'button.remove', function () {
   $('#'+$(this).attr("value")+'add').attr('disabled',false);
   $(this).closest('div .row').remove();
     return false;
 });

setInterval(
  function()
  {

    var id=[];
    var qty = [];
    var price=[];
    var product=[];

  $('input[name^="product"]').each(function()
  {
    product.push($(this).val());
  });

  $('input[name^="id"]').each(function()
  {
    id.push($(this).val());
  });

  $('input[name^="qty"]').each(function()
  {
    qty.push($(this).val());
  });

  $('input[name^="price"]').each(function()
  {
    price.push($(this).val());
  });

  var i;
  var total=0;

  for (i = 0; i < qty.length; i++)
  {
    total +=(qty[i]*price[i]);
  }

  var j;
  var order="";

  for (j = 0; j< qty.length; j++)
  {
    order +="<input name=\"product_id[]\" value='"+id[j]+"' hidden>"+
            "<input name=\"product_name[]\" value='"+product[j]+"' hidden>"+
            "<input name=\"item_qty[]\" value='"+qty[j]+"'hidden>"+
            "<input name=\"unit_price[]\" value='"+price[j]+"'hidden>";
  }

  $('#cash').attr('min',total);

  if(total==0)
  {
    total="";
    $('#checkout').attr('disabled',true);
  }
  else
  {
    change=parseFloat(Math.round(($('#cash').val().trim()-total) * 100) / 100).toFixed(2);

    total_amt=parseFloat(Math.round(total * 100) / 100).toFixed(2);

    total =   "<hr>"+
              "<div class=\"row\">"+
                "<div class=\"col-md-4\"><b>TOTAL</b></div>"+
                "<div class=\"col-md-3\"></div>"+
                "<div class=\"col-md-3\"><b>"+total_amt+"</b></div>"+
                "<div class=\"col-md-2\"></div>"+
              "</div>";
    total_cashout = "<div class=\"row\">"+
                      "<div class=\"col-md-4\"><b>Total</b></div>"+
                      "<div class=\"col-md-4\"></div>"+
                      "<div class=\"col-md-4\"><b>"+total_amt+"</b></div>"+
                    "</div>";

    $('#checkout').attr('disabled',false);
  }
  if($('#cash').val().trim()==0)
  {
    change=0.00;
  }

  document.getElementById("change").innerHTML =change;
  document.getElementById("order_cashout").innerHTML=order;
  document.getElementById("total").innerHTML =total;
  document.getElementById("total_cashout").innerHTML =total_cashout;
  }
);
setInterval(
  function()
  {
   $('input[name^="id"]').each(function()
   {
     $('#'+$(this).val()+'add').attr('disabled',true);
   });
});


setInterval(
 function()
 {
     if(
        $('#cash').val().trim().length>0 &&
        change >= 0               &&
        $('#customers_name').val().trim().length>0
       )
     {
       $('#final_checkout').attr('disabled',false);
     }
     else
     {
       $('#final_checkout').attr('disabled',true);
     }

});
</script>
<script>
function search(keyword) {
    if (keyword.trim().length == 0) {
			$( "#results" ).load( "products.php" );
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("results").innerHTML = xmlhttp.responseText;
            }
        }
				xmlhttp.open("GET","search.php?keyword="+keyword.trim(),true);
				xmlhttp.send();
    }
}
</script>
</body>
</html>
