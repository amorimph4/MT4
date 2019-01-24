<?php
namespace Core;

use PDO;
use PDOException;

/**
* 
*/
class DataBase 
{


	public static function getDataBase()
	{
		//$conf = include_once __DIR__ . '/../App/database.php';

		$host = 'localhost'; // ou 127.0.0.1
		$db = 'devicers';
		$user = 'pedroamorim';
		$pass = '23312724';		
		
		try 
		{
			$conn = new PDO("mysql:host=$host;dbname=$db",$user, $pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);	

			return $conn;
		}
		catch (PDOException $e) 
		{
			echo $e->getMessage();	
		}
		
	}


	public static function getConn()
	{
		$host = 'localhost'; // ou 127.0.0.1
		$db = 'devicers';
		$user = 'pedroamorim';
		$pass = '23312724';	
		
		@$mysqli = new mysqli($host,$user,$pass,$db);
		
		if( mysqli_connect_errno() )
		{
			return "error :".$mysqli->connect_errno ."motivo ". $mysqli->connect_error;
		}
		else
		{
			
			return $mysqli;			
		}


	}



}

?>