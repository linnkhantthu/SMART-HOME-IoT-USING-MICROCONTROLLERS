<?php
 ob_start();
 include 'secure.php';
 include 'header.php';
 include 'dbconfig.php';
 $led1iconstatus="";
 $led2iconstatus="";
 $led3iconstatus="";
 $led4iconstatus="";
 $led5iconstatus="";
 $led6iconstatus="";
 $led7iconstatus="";
 $smokestatus = "";
 $flamestatus = "";
 $timeSmoke = "";
 $timeFlame = "";
 $timeVibrat = "";
 $tempSmoke = "";
 $tempFlame = "";
 $tempVibrat = "";
 function diffTime($that_time)
 {
     date_default_timezone_set("Asia/Rangoon");
     $now = date("Y-m-d H:i:s");
     //echo $now;
     $that_day = new DateTime($now);
     $result = $that_day -> diff(new DateTime($that_time));
     $totalmin = $result -> days * 24*60;
     $totalmin += $result -> h * 60;
     $totalmin += $result -> i;
     $final_time = $totalmin/60;
     $final_time = (float)($final_time);
     //echo "<br>" . $final_time . "Hours" ;
     return $final_time;
 }
 //**********************************functions******************************************//
 function dbshow(int $id){
   try {
     include 'dbconfig.php';
     $row = $connect -> query("SELECT * FROM `led` WHERE `id` = $id");
     foreach ($row as $rows){
       $led_st = $rows['status'];
     }
   } catch (Exception $e) {
     echo $e->getMessage();
   }
   return $led_st;
 }
 function ledCondition($led_sta,$lediconstatus){
   if ($led_sta == "OFF") {
     $led_sta = "ON";
     $lediconstatus = '<span class="led-off-icon-div"></span>';
   }else {
     $led_sta = "OFF";
     $lediconstatus = '<span class="led-on-icon-div"></span>';
   }
   return array($led_sta,$lediconstatus);
 }
 function postData(int $id,$ledName,$led_sta){
   include 'dbconfig.php';
   if (isset($_POST[$ledName])) {
       $row = $connect -> query("UPDATE `led` SET `status` = '$led_sta' WHERE `led`.`id` = $id");
       header("location:displayhome.php"); ob_end_flush();
   }
 }
 //***********************************End Functions*********************************************//
   $led_1s=dbshow(1);
   list($led_1s,$led1iconstatus)=ledCondition($led_1s,$led1iconstatus);
   postData(1,"led_1",$led_1s);

   $led_2s=dbshow(2);
   list($led_2s,$led2iconstatus)=ledCondition($led_2s,$led2iconstatus);
   postData(2,"led_2",$led_2s);

   $led_3s=dbshow(3);
   list($led_3s,$led3iconstatus)=ledCondition($led_3s,$led3iconstatus);
   postData(3,"led_3",$led_3s);

   $led_4s=dbshow(4);
   list($led_4s,$led4iconstatus)=ledCondition($led_4s,$led4iconstatus);
   postData(4,"led_4",$led_4s);

   $led_5s=dbshow(5);
   list($led_5s,$led5iconstatus)=ledCondition($led_5s,$led5iconstatus);
   postData(5,"led_5",$led_5s);

   $led_6s=dbshow(6);
   list($led_6s,$led6iconstatus)=ledCondition($led_6s,$led6iconstatus);
   postData(6,"led_6",$led_6s);

   $led_7s=dbshow(7);
   list($led_7s,$led7iconstatus)=ledCondition($led_7s,$led7iconstatus);
   postData(7,"led_7",$led_7s);

   //*****************************************sensors********************************************//
   $smok = $connect -> query("select * from smoke");
   try {
     foreach ($smok as $f)
     {
       $smokestatus = $f['status'];
       if ($smokestatus == "Smoke Detected!") {
         $timeSmoke = $f['time'];
         $timeSmoke = diffTime($timeSmoke);
         if ($timeSmoke == 0)
         {
              $timeSmoke = "NOW!";
          }
       }
     }
   } catch (Exception $e) {
     echo $e -> getMessage();
   }

   $flam = $connect -> query("select * from flame");
   try {
     foreach ($flam as $f)
     {
       $flamestatus = $f['status'];

       if ($flamestatus == "Flame Detected!") {
         $timeFlame = $f['time'];
         $timeFlame = diffTime($timeFlame);
         if ($timeFlame == 0)
         {
              $timeFlame = "NOW!";
         }
       }
       
     }
   } catch (Exception $e) {
     echo $e -> getMessage();
   }

   $vibrat = $connect -> query("select * from vibrate");
   try {
     foreach ($vibrat as $f)
     {
       $vibrat = $f['status'];
       if ($vibrat == "Vibrate Detected!") {
         $timeVibrat = $f['time'];
         $timeVibrat = diffTime($timeVibrat);
         if ($timeVibrat == 0)
         {
              $timeVibrat = "NOW!";
          }
       }
     }
   } catch (Exception $e) {
     echo $e -> getMessage();
   }
    
   if ($timeSmoke < 0.25) {
     $smokestatus = ' <i class="fa fa-warning" style="font-size:48px;color:red"></i>';
   }
   else {
     $smokestatus = ' <i class="fas fa-shield-alt" style="font-size:50px;color:green"></i>';
   }

   if ($timeFlame < 0.25) {
     $flamestatus = ' <i class="fa fa-fire" style="font-size:48px;color:red"></i>';
   }
   else {
     $flamestatus = ' <i class="fa fa-fire" style="font-size:48px;color:green"></i>';
   }

   if ($timeVibrat < 0.25) {
     $vibrat = ' <i class="material-icons" style="font-size:48px;color:red">vibration</i>';
   }
   else {
     $vibrat = ' <i class="material-icons" style="font-size:48px;color:green">vibration</i>';
   }

   //*****************************************End Sensors****************************************//
//******************op***********************//
function time_ad($sen_type)
{
  $tempp = $sen_type;
  $sen_type = (float)($sen_type);
  $sen_type = round($sen_type*60);
  if ($sen_type >= 1 && $sen_type < 60)
  {
    $sen_type = (string)($sen_type) . "min ago";
  }
  else if($tempp < 1){
    $sen_type = "0s ago";
  }
  else{
    $sen_type = round($sen_type/60);
    $sen_type = (string)($sen_type) . "hour ago";
  }
  return $sen_type;
}
$tempSmoke=time_ad($timeSmoke);
$tempFlame=time_ad($timeFlame);
$tempVibrat=time_ad($timeVibrat);

/////////////////////////////////////////////
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 	<head>
 		<meta charset="utf-8">
 		<meta name="viewport" content="width=device-width, initial-scale=1.0">
 		<meta http-equiv="refresh" content="15">
 		<title>My Home</title>
 		<script src='https://kit.fontawesome.com/a076d05399.js'></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 		<link rel="stylesheet" href="css/login_success_css.css">
 	</head>
 	<body>
 		<?php
 		try
 			{
         $tem ="";
         $humid = "";
 				$weather = $connect -> query("select * from weather");
         try {
           foreach ($weather as $w)
   				{
   					$tem = $w['temp'];
   					$humid = $w['hum'];
   				}
         } catch (Exception $e) {
           echo "";
         }
 			}
 				catch(Exception $e)
 				{
 					echo "Failed query...<br>" . $e -> getMessage();
 				}
         $status=0.0;
         $sta="";
         $status = (float)$tem;
         if ($status > 50.0) {
           echo '<embed src="alarm.mp3" autostart="true" loop="true" hidden="true">';
           $sta = "Too Hot";
         }

 		 ?>
 		<div class="detail-div">
 			<span class="detail-span">
 				<i id="detail-i" class='fas fa-cloud-sun'></i>
 				<i id="detail-i-detail"><?php
 				echo $tem;
 				 ?>&#8451;</i><i class="alarm"><?php echo $sta; ?></i>
 			</span>
 			<span class="detail-span">
 				<img src="images/icons/humidity-300x300.png" alt="humidity" height="100px" width="100px" />
 				<i id="detail-i-detail"><?php
 				echo $humid;
 				 ?>%</i>
 			</span>
 		</div>
     <form class="led-div" action="displayhome.php" method="post">
         <span class="led-span" >
           <label>Bath room:</label>
           <input class="led-toggle-size" type="submit" name="led_1" value="<?php echo "Turn ".$led_1s; ?>">
           <?php echo $led1iconstatus; ?>
         </span>

         <span class="led-span">
           <span><label>Corrider:</label></span>
           <input class="led-toggle-size" type="submit" name="led_2" value="<?php echo "Turn ".$led_2s; ?>">
           <?php echo $led2iconstatus; ?>
         </span>

         <span class="led-span">
           <span><label>Kitchen:</label></span>
           <input class="led-toggle-size" type="submit" name="led_3" value="<?php echo "Turn ".$led_3s; ?>">
           <?php echo $led3iconstatus; ?>
         </span>

         <span class="led-span">
           <span><label>Garage:</label></span>
           <input class="led-toggle-size" type="submit" name="led_4" value="<?php echo "Turn ".$led_4s; ?>">
           <?php echo $led4iconstatus; ?>
         </span>

         <span class="led-span">
           <span><label>Bed Room:</label></span>
           <input class="led-toggle-size" type="submit" name="led_5" value="<?php echo "Turn ".$led_5s; ?>">
           <?php echo $led5iconstatus; ?>
         </span>

         <span class="led-span">
           <span><label>Toilet</label></span>
           <input class="led-toggle-size" type="submit" name="led_6" value="<?php echo "Turn ".$led_6s; ?>">
           <?php echo $led6iconstatus; ?>
         </span>

         <span class="led-span">
           <span><label>Multimedia Room:</label></span>
           <input class="led-toggle-size" type="submit" name="led_7" value="<?php echo "Turn ".$led_7s; ?>">
           <?php echo $led7iconstatus; ?>
         </span>
     </form>
     <div class="detail-div">
         <p class="detail-span" ><i style="font-size:45px">Smoke  </i><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $smokestatus; echo "<br>Last detected: ". $tempSmoke; ?></i></p>
         <p class="detail-span" ><i style="font-size:45px">Fire  </i><i>&nbsp;<?php echo $flamestatus; echo "<br>Last detected: ". $tempFlame; ?></i></p>
         <p class="detail-span" ><i style="font-size:45px">Vibration  </i><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vibrat; echo "<br>Last detected: ". $tempVibrat; ?></i></p>
     </div>
 	</body>
 </html>
