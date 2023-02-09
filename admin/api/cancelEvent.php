<?php
  include('../connection.php');

  $requestID = $_POST['requestID'];

  $sql = "INSERT INTO cancelled (
    requestID, 
    client_name, 
    starting_date,
    ending_date,
    description,
    venue,
    equipments
    ) SELECT
    requestID, 
    client_name, 
    starting_date,
    ending_date,
    description,
    venue,
    equipments
    FROM requests WHERE requestID='$requestID'
    ";

  $result = $conn -> query($sql);

  if($result){
    echo 1;
    $conn -> query("DELETE FROM requests WHERE requestID='$requestID'");

    $currentDate = date('F j, Y h:i a');
    $message = 'Event ID: ' . $requestID . ' was cancelled';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }
?>