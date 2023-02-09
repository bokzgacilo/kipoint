<?php
  include('../connection.php');

  $current_datetime = strtotime(date("F j, Y h:i a"));
  
  $getLatestEvent = $conn -> query("SELECT * FROM requests");

  while($row = $getLatestEvent -> fetch_array()){
    $date1 = strtotime($row['ending_date']);
    if($date1 < $current_datetime){
      $equipment = json_decode($row['equipments'], true);
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
      $copyRowToDone = $conn -> query(
      "INSERT INTO done(requestID, client_name, starting_date, ending_date, description, venue, equipments) 
      SELECT requestID, client_name, starting_date, ending_date, description, venue, equipments FROM requests WHERE requestID='".$row['requestID']."'
      ");
      
      if($copyRowToDone){
        $conn -> query("DELETE FROM requests WHERE requestID='".$row['requestID']."'");
      }
    }
  }
  $conn -> close();
?>