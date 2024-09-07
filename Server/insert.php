<?php
include 'dbconfig.php';
date_default_timezone_set("Asia/Rangoon");
     $now = date("Y-m-d H:i:s");
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
      $sql = "insert into smoke(status,time) values('$mySmoke','$now')";
      Makequery($sql);
      $sql = "insert into flame(status,time) values('$myFlame','$now')";
      Makequery($sql);
      $sql = "insert into vibrate(status,time) values('$myVibrate','$now')";
      Makequery($sql);
	}
  //function
  function Makequery($value)
  {
    include 'dbconfig.php';
    try{
      $rows = $connect -> query($value);
    }
    catch(Exception $e)
    {
      echo "Query Error:" . $e -> getMessage();
    }
  }
 ?>
