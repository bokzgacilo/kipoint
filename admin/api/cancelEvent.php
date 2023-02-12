<?php
  include('../connection.php');

  $requestID = $_POST['requestID'];

  $sql = "INSERT INTO cancelled( requestID, client_name, starting_date,ending_date,description, venue, equipments) 
    SELECT requestID, client_name, starting_date, ending_date, description, venue, equipments 
    FROM requests WHERE requestID='$requestID'
    ";

  $result = $conn -> query($sql);

  if($result){

    echo 1; 

    $equipment = [];
    $selectDeletedEvent = $conn -> query("SELECT * FROM requests WHERE requestID='$requestID'");
    
    while($row = $selectDeletedEvent -> fetch_array()){
      $equipment = json_decode($row['equipments'], true);
    }

    for($i = 0; $i < count($equipment); $i++){
      $selectEquipment = $conn -> query("SELECT * FROM inventory WHERE serial_code='".$equipment[$i]['serial_code']."'");
      $available = '';
      $in_reserve = '';
      
      while($eq = $selectEquipment -> fetch_array()){
        $available = $eq['available'];
        $in_reserve = $eq['in_reserve'];
      }

      $newAvailable = $available + $equipment[$i]['item_count'];
      $newReservation = $in_reserve - $equipment[$i]['item_count'];

      $conn -> query("UPDATE inventory SET available='$newAvailable', in_reserve='$newReservation' WHERE serial_code='".$equipment[$i]['serial_code']."'");
    }

    $conn -> query("DELETE FROM requests WHERE requestID='$requestID'");

    $currentDate = date('F j, Y h:i a');
    $message = 'Event ID: ' . $requestID . ' was cancelled';
    $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");
  }else {
    echo 0;
  }

  $conn -> close();
?>