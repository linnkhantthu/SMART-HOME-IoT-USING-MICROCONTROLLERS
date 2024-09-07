<?php
$dsn = "mysql:host=localhost;dbname=id11927374_smarthome";//id10666898_smarthome
$username = "id11927374_smarthome";//id10666898_smarthome
$pwd = "kjkszpj";//kjkszpj
try
{
	$connect = new PDO($dsn , $username , $pwd);
	$connect -> setAttribute(PDO:: ATTR_ERRMODE , PDO:: ERRMODE_EXCEPTION);
	//echo "Successfully connected...";
}catch(Exception $e)
	{
		echo "Database connection failed...<br>" . $e -> getMessage();
	}
  ?>
