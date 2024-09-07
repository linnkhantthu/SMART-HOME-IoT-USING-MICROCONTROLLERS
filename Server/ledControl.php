<?php
  include 'secure.php';
  include 'dbconfig.php';
  header('Content-type: application/json');
  try {
    $row = $connect -> query("select * from led");
    foreach ($row as $rows){
      $json[$rows['id']] = array(
         'status' => $rows['status'],
      );
    }
  } catch (Exception $e) {
    echo $e -> getMessage();
  }
  echo "[".json_encode($json)."]";
 ?>
