<?php
  include('../connection.php');
  
  $name = $_POST['venueName'];
  $address = $_POST['venueAddress'];

  $sql = "INSERT INTO venue(name,address) VALUES(
    '$name',
    '$address'
  )";

  $result = $conn -> query($sql);

  if($result){
    echo 1;

    $currentDate = date('F j, Y h:i a');
    $message = 'Venue: ' . $name . ' was added.';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }

  $conn -> close();
?>