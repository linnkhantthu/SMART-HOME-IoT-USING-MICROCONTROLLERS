<?php
include 'dbconfig.php';
	if(isset($_POST["temp"]) && isset($_POST["hum"]) && isset($_POST["smoke"]) && isset($_POST["flame"]) && isset($_POST["vibrate"])){
      //getData
      $temperature = $_POST["temp"];
	    $humidity = $_POST["hum"];
      $mySmoke = $_POST["smoke"];
      $myFlame = $_POST["flame"];
      $myVibrate = $_POST["vibrate"];
      //query
      $sql = "insert into weather(temp,hum) values('$temperature','$humidity')";
      Makequery($sql);
      $sql = "insert into smoke(status) values('$mySmoke')";
      Makequery($sql);
      $sql = "insert into flame(status) values('$myFlame')";
      Makequery($sql);
      $sql = "insert into vibrate(status) values('$myVibrate')";
      Makequery($sql);
	}
  //function
  function Makequery($value)
  {
    try{
      $rows = $connect -> query($value);
    }
    catch(Exception $e)
    {
      echo "Query Error:" . $e -> getMessage();
    }
  }
 ?>
