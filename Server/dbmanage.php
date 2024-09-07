<?php
include 'secure.php';
include 'header.php';
include 'dbconfig.php';
if (isset($_POST["weather"])) {
  $tbname = 'weather';
  $sql = "TRUNCATE TABLE `$tbname`";
  try{
    $rows = $connect -> query($sql);
  }
  catch(Exception $e)
  {
    echo "Query Error:" . $e -> getMessage();
  }
}

  if (isset($_POST["smoke"])) {
    $tbname = 'smoke';
    $sql = "TRUNCATE TABLE `$tbname`";
    try{
      $rows = $connect -> query($sql);
    }
  catch(Exception $e)
  {
    echo "Query Error:" . $e -> getMessage();
  }
}

if (isset($_POST["flame"])) {
  $tbname = 'flame';
  $sql = "TRUNCATE TABLE `$tbname`";
  try{
    $rows = $connect -> query($sql);
  }
  catch(Exception $e)
  {
    echo "Query Error:" . $e -> getMessage();
  }
}

if (isset($_POST["vibrate"])) {
  $tbname = 'vibrate';
  $sql = "TRUNCATE TABLE `$tbname`";
  try{
    $rows = $connect -> query($sql);
  }
  catch(Exception $e)
  {
    echo "Query Error:" . $e -> getMessage();
  }
}

function Number($table)
{
  include 'dbconfig.php';
  try
    {
        $sql = "SELECT * FROM `$table`";
        $weather = $connect -> query($sql);
        $notemp = "";
        try {
              foreach ($weather as $w)
              {
                $notemp = $w['id'];
                $btnstatus = "";
              }
            }
            catch (Exception $e)
            {
              echo $e -> getMessage();
            }
    }
      catch(Exception $e)
      {
          echo "Failed query...<br>" . $e -> getMessage();
      }
      if ($notemp == "") {
        $notemp = "0";
        $btnstatus = 'disabled';
      }
    return array($notemp,$btnstatus);
    }
    $weath = 'weather';
    list($no1,$btn1status)=Number($weath);

    $weath = 'smoke';
    list($no2,$btn2status)=Number($weath);

    $weath = 'flame';
    list($no3,$btn3status)=Number($weath);

    $weath = 'vibrate';
    list($no4,$btn4status)=Number($weath);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Data Management</title>
    <link rel="stylesheet" href="css/dbm.css">
  </head>
  <body>
    <div class="dm-span">
      <span>Data Management</span>
    </div>
    <table id="dm-table">
      <tr>
        <th>Name</th>
        <th>Number of Data</th>
        <th>Edit</th>
      </tr>
      <form action="dbmanage.php" method="post">
      <tr>
        <td>Temperature</td>
        <td> <?php echo $no1; ?> </td>
        <td> <input type="submit" class="clear-btn" name="weather" value="Clear Cache" <?php echo $btn1status; ?>> </td>
      </tr>
      <tr>
        <td>Smoke</td>
        <td> <?php echo $no2; ?> </td>
        <td> <input type="submit" class="clear-btn" name="smoke" value="Clear Cache" <?php echo $btn2status; ?>> </td>
      </tr>
      <tr>
        <td>Flame</td>
        <td> <?php echo $no3; ?> </td>
        <td> <input type="submit" class="clear-btn" name="flame" value="Clear Cache" <?php echo $btn3status; ?>> </td>
      </tr>
      <tr>
        <td>Vibration</td>
        <td> <?php echo $no4; ?> </td>
        <td> <input type="submit" class="clear-btn" name="vibrate" value="Clear Cache" <?php echo $btn4status; ?>> </td>
      </tr>
    </form>
    </table>
    <a href="displayhome.php">Back</a>
  </body>
</html>
