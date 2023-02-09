<?php
  include('../connection.php');

  $requestID = $_POST['requestID'];
  $days = $_POST['days'];

  $selectEvent = $conn -> query("SELECT * FROM requests WHERE requestID='$requestID'");
  $starting = '';
  $ending = '';

  while($row = $selectEvent -> fetch_array()){
    $starting = $row['starting_date'];
    $ending = $row['ending_date'];
  }
  
  $newStarting = date('F j, Y h:i a', strtotime($starting. ' + '.$days.' days'));
  $newEnding = date('F j, Y h:i a', strtotime($ending. ' + '.$days.' days'));

  $updateDates = $conn -> query("UPDATE requests SET starting_date='$newStarting', ending_date='$newEnding' WHERE requestID='$requestID'");
  if($updateDates){
    echo 1;

    $currentDate = date('F j, Y h:i a');
    $message = 'Event ID: ' . $requestID . ' was rescheduled in ' . $days . ' days ('.$newEnding.')';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  }else {
    echo 0;
  }
  // echo 'Starting: ' . $newStarting . ', Ending: ' . $newEnding;


  $conn -> close();
?>