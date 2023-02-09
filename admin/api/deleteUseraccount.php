<?php
  include('../connection.php');

  $userID = $_GET['userID'];

  $deleteSQL = $conn -> query("DELETE FROM useraccounts WHERE id='$userID'");

  if($deleteSQL){
    echo 1;

    $currentDate = date('F j, Y h:i a');
    $message = 'User ID: ' . $userID . ' was removed from Kipoints Database';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }

  $conn -> close();
?>