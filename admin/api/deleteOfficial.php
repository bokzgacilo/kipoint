<?php
  include('../connection.php');

  $officialID = $_GET['officialID'];

  $deleteSQL = $conn -> query("DELETE FROM officials WHERE id='$officialID'");

  if($deleteSQL){
    echo 1;

    $currentDate = date('F j, Y h:i a');
    $message = 'Official ID: ' . $officialID . ' was removed from Kipoints Database';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }

  $conn -> close();
?>