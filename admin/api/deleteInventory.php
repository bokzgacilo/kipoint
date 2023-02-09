<?php
  include('../connection.php');

  $serial_code = $_POST['serial_code'];

  $deleteSQL = $conn -> query("DELETE FROM inventory WHERE serial_code='$serial_code'");

  if($deleteSQL){
    echo 1;

    $currentDate = date('F j, Y h:i a');
    $message = 'Inventory: ' . $serial_code . ' was removed from Kipoints Database';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }

  $conn -> close();
?>