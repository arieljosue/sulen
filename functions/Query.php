<?php
require_once('DB.php');

class Query
{
	private $db;

	function get_category()
		{
			$query="SELECT * FROM category";
			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
	
	function __construct()
	{
		$this->db=new DB();
	}

	function login($username,$password)
	{
		$query	=	"SELECT
						user_id as id,usertype
					FROM
						users
					WHERE
						username='{$username}' AND password='{$password}' AND active=true";
		return pg_fetch_all(pg_query($this->db->connect(),$query));

	}

	function add_product($name,$price,$category,$image)
	{
		$query	=	"INSERT INTO
						products(name,current_price,category,available,image)
					VALUES
						('{$name}','{$price}',{$category},TRUE,'{$image}')
					RETURNING
						product_id";
		return pg_query($this->db->connect(),$query);
	}

	function select_image($id)
	{
		$query	=	"SELECT
						product_id,image
					FROM
						products
					WHERE
						id={$id}";

		return pg_query($this->db->connect(),$query);
	}

	function add_user($firstname,$lastname,$usertype,$username,$password)
	{
		$query	=	"INSERT INTO
						users(firstname,lastname,active,usertype,username,password)
					VALUES
					('{$firstname}','{$lastname}',true,'{$usertype}','{$username}','{$password}')";

		return pg_query($this->db->connect(),$query);
	}

	function fetch_username($username)
	{
		$query	=	"SELECT
						user_id
					FROM
						users
					WHERE
						username='{$username}'";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}

	function fetch_all_username()
	{
		$query	=	"SELECT
						username
					FROM
						users";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}

	function fetch_all_products()
	{
		$query	=	"SELECT
						product_id as id,product_is_referenced(product_id),name,current_price as price,available,category,image
					FROM
						products
					ORDER BY
						name ASC";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}
	function fetch_all_users()
	{
		$query	=	"SELECT
						user_id as id,user_is_referenced(user_id),firstname,lastname,active,usertype,username,password
					FROM
						users
					WHERE
						usertype <> 'a'
					ORDER BY
						usertype ASC";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}

	function fetch_all_cashiers()
	{
		$query	=	"SELECT
						user_id as id,user_is_referenced(user_id),firstname,lastname,active,usertype,username,password
					FROM
						users
					WHERE
						usertype ='c'
					ORDER BY
						firstname ASC";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}

	function fetch_all_pasta_dishes()
	{
		$query	=	"SELECT
						product_id as id,product_is_referenced(product_id),name,current_price as price,available,category,image
					FROM
						products
					WHERE
						category=1
					ORDER BY
						name ASC";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}

	function fetch_all_beverages()
	{
		$query	=	"SELECT
						product_id as id,product_is_referenced(product_id),name,current_price as price,available,category,image
					FROM
						products
					WHERE
						category=2
					ORDER BY
						name ASC";

		return pg_fetch_all(pg_query($this->db->connect(),$query));
	}

	function update_status($id,$status)
	{
		$query	=	"UPDATE
						users
					SET
						active={$status}
					WHERE
						user_id={$id}";

		return pg_query($this->db->connect(),$query);
	}

	function delete_product($id)
	{
		$query	=	"DELETE FROM
						products
					WHERE
						product_id={$id}";

		return pg_query($this->db->connect(),$query);
	}

		function delete_user($id)
		{
			$query	=	"DELETE FROM
							users
						WHERE
							user_id={$id}";

			return pg_query($this->db->connect(),$query);
		}

		function fetch_user($id)
		{
			$query	=	"SELECT * FROM
								users
							WHERE
								user_id={$id}";

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}

		function update_user($id,$firstname,$lastname,$usertype,$username,$password)
		{
			$query	=	"UPDATE users SET
									firstname='{$firstname}',
									lastname='{$lastname}',
									usertype='{$usertype}',
									username='{$username}',
									password='{$password}'
								WHERE
									user_id={$id}";
			return pg_query($this->db->connect(),$query);
		}

		function update_product($id,$name,$price,$category,$availability)
		{
			$query="UPDATE products SET
								name='{$name}',
								current_price='{$price}',
								category={$category},
								available={$availability}
							WHERE
								product_id={$id}";
			pg_query($this->db->connect(),$query);
		}
		function remove_image($id)
		{
			$image;
			$query="UPDATE products SET image='{$image}' WHERE product_id={$id}";
			pg_query($this->db->connect(),$query);
		}

		function add_img($id,$img)
		{
			$query="UPDATE products SET
								image='{$img}'
							WHERE
								product_id={$id}";
			pg_query($this->db->connect(),$query);
		}

		function add_order_details($order_id,$product_id,$qty,$price)
		{
				$query="INSERT INTO
									order_details
								VALUES({$order_id},{$product_id},{$qty},'{$price}',false)";

				return pg_query($this->db->connect(),$query);
		}

		function fetch_order_pasta()
		{
			$query="SELECT order_details.order_id,order_details.product_id,customers_name,firstname,lastname,name,qty, served FROM order_details
							FULL JOIN orders ON order_details.order_id=orders.order_id
							JOIN products ON order_details.product_id=products.product_id
							JOIN users ON users.user_id=orders.cashier
							JOIN customer ON customer.customer_id=orders.customer
							WHERE served=false AND products.category=1";

				return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		function fetch_order_pasta_adm()
		{
			$query="SELECT order_details.order_id,order_details.product_id,customers_name,firstname,lastname,name,qty, served FROM order_details
							FULL JOIN orders ON order_details.order_id=orders.order_id
							JOIN products ON order_details.product_id=products.product_id
							JOIN users ON users.user_id=orders.cashier
							JOIN customer ON customer.customer_id=orders.customer
							WHERE products.category=1";

				return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		
		function fetch_order_beverages_adm()
		{
			$query="SELECT order_details.order_id,order_details.product_id,customers_name,firstname,lastname,name,qty, served FROM order_details
							FULL JOIN orders ON order_details.order_id=orders.order_id
							JOIN products ON order_details.product_id=products.product_id
							JOIN users ON users.user_id=orders.cashier
							JOIN customer ON customer.customer_id=orders.customer
							WHERE products.category=2";

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		function fetch_order_beverages()
		{
			$query="SELECT order_details.order_id,order_details.product_id,customers_name,firstname,lastname,name,qty, served FROM order_details
							FULL JOIN orders ON order_details.order_id=orders.order_id
							JOIN products ON order_details.product_id=products.product_id
							JOIN users ON users.user_id=orders.cashier
							JOIN customer ON customer.customer_id=orders.customer
							WHERE served=false AND products.category=2";

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		
		function serve_product($order_id,$product_id)
		{
			$query="UPDATE order_details SET served=true
							WHERE
									order_id={$order_id} AND product_id={$product_id}";

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}

		function cancel_order($order_id,$product_id)
		{
			$query="DELETE FROM order_details
							WHERE
									order_id={$order_id}
							AND
										product_id={$product_id}";

			pg_query($this->db->connect(),"update orders set total_amount=total_amount-(select qty*price from order_details where order_id={$order_id} AND product_id={$product_id}) where order_id={$order_id}");
			return pg_query($this->db->connect(),$query);
		}

		function sales($from,$to)
		{
			$query="";

			if(empty($from) OR empty($to))
			{
				$query="select order_id,date_of_purchase,total_amount from orders";
				// $query="SELECT products.name as item,sum(qty) as qty ,sum(order_details.price *qty) as sales
				// 				FROM order_details FULL JOIN products on order_details.product_id=products.product_id
				// 				GROUP BY products.product_id";
			}
			else
			{
				$query="select order_id,date_of_purchase,total_amount from orders WHERE orders.date_of_purchase BETWEEN '{$from}' AND '{$to}'";
				// $query="SELECT products.name as item,sum(qty) as qty ,sum(order_details.price *qty) as sales
				// 				FROM orders FULL JOIN order_details on order_details.order_id=orders.order_id
				// 				JOIN products on order_details.product_id=products.product_id
				// 				WHERE orders.date_of_purchase BETWEEN '{$from}' AND '{$to}' GROUP BY products.product_id";
			}

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		function summary($from,$to)
		{
			$query="";

			if(empty($from) OR empty($to))
			{
				$query="select sum(total_amount) from orders";
				// $query="SELECT products.name as item,sum(qty) as qty ,sum(order_details.price *qty) as sales
				// 				FROM order_details FULL JOIN products on order_details.product_id=products.product_id
				// 				GROUP BY products.product_id";
			}
			else
			{
				$query="select sum(total_amount) from orders WHERE orders.date_of_purchase BETWEEN '{$from}' AND '{$to}'";
				// $query="SELECT products.name as item,sum(qty) as qty ,sum(order_details.price *qty) as sales
				// 				FROM orders FULL JOIN order_details on order_details.order_id=orders.order_id
				// 				JOIN products on order_details.product_id=products.product_id
				// 				WHERE orders.date_of_purchase BETWEEN '{$from}' AND '{$to}' GROUP BY products.product_id";
			}
			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		function add_order($name,$uid,$total)
		{
			$query="INSERT INTO
								orders(cashier,customer,date_of_purchase,total_amount)
							VALUES({$uid},{$name},current_date,'{$total}')
							RETURNING order_id";

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
		function update_order($order_id,$product_id,$qty)
		{
			$query="UPDATE order_details SET qty={$qty}
							WHERE order_id={$order_id}
							AND	product_id={$product_id}";

			pg_query($this->db->connect(),$query);
			pg_query($this->db->connect(),"update orders set total_amount=(select sum(qty*price) from order_details where order_id={$order_id}) where order_id={$order_id}");
		}

		function remove_unreferenced_order()
		{
			$query="DELETE FROM orders
							WHERE
							NOT EXISTS ( SELECT FROM order_details WHERE order_details.order_id=orders.id )";

			return pg_query($this->db->connect(),$query);
		}

		function add_customer($name)
		{
			$query="INSERT INTO
								customer(customers_name)
							VALUES('{$name}')
							RETURNING customer_id";

			return pg_fetch_all(pg_query($this->db->connect(),$query));
		}
}
?>
