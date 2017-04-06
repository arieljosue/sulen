<?php
class DB
{
	function connect()
	{
		$connection_string	=	"host		= 	localhost
								port		=	5432
								dbname		=	POS
								user		=	postgres
								password	=	pass";
						  
		return pg_connect($connection_string); 
	}
	
	function error()
	{
		return pg_last_error($this->connect());
	}
}
?>