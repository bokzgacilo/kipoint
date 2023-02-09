<?php
  include('../connection.php');

  $result = $conn -> query("SELECT * FROM requests");
  $events = [];

  while($row = $result -> fetch_array()){
    $stringstart = strtotime($row['starting_date']);
    $stringend = strtotime($row['ending_date']);
    
    array_push($events, (object)[
      'client_name' => $row['client_name'],
      'sdate' => date('Y-m-d H:i', $stringstart),
      'edate' => date('Y-m-d H:i' , $stringend),
      'requestID' => $row['requestID'],
    ]);
  }

  echo json_encode($events);

  $conn -> close();
?>