<?php
  include('../connection.php');

  $result = $conn -> query("SELECT * FROM accepted");
  $schedules = [];
  
  
  foreach($result -> fetch_all(MYSQLI_ASSOC) as $row){
      $row['sdate'] = date("F d, Y h:i A", strtotime($row['starting_date']));
      $row['edate'] = date("F d, Y h:i A", strtotime($row['ending_date']));
      $schedules[$row['requestID']] = $row;
  }

  echo json_encode($schedules);

  $conn -> close();
?>