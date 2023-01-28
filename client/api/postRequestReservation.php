<?php
  include('connection.php');

  $client_name = $_POST['client_name'];
  $venue = $_POST['venue'];
  $desc = $_POST['desc'];
  $starting_date = $_POST['starting_date'];
  $ending_date = $_POST['ending_date'];
  $equipment = $_POST['equipmentArray'];
  $requestID = rand(1000, 9999);
  $fullname = '';
  $start = date("F j, Y h:i a", strtotime($starting_date));
  $end = date("F j, Y h:i a", strtotime($ending_date));

  // echo $start;
  // echo $end;
  $equipmentArray = json_decode($equipment, true);

  if(count($equipmentArray) === 0){
    $equipmentArray = 'None';
  }else {
    for ($i = 0; $i < count($equipmentArray); $i++) { 
      $available = '';
      $in_reserved = '';
      echo $equipmentArray[$i]['serial_code'] . ', ' . $equipmentArray[$i]['item_count'];
      $selectItem = $conn -> query("SELECT * FROM inventory WHERE serial_code='".$equipmentArray[$i]['serial_code']."'");
      
      while($item = $selectItem -> fetch_array()){
        $available = $item['available'];
        $in_reserved = $item['in_reserve'];
      }

      $newAvailable = $available - $equipmentArray[$i]['item_count'];
      $newInReserve = $in_reserved + $equipmentArray[$i]['item_count'];
      
      $updateItem = $conn -> query("UPDATE inventory SET in_reserve='$newInReserve', available='$newAvailable' WHERE serial_code='".$equipmentArray[$i]['serial_code']."'");
    }
  }

  $getFullname = $conn -> query("SELECT * FROM useraccounts WHERE username='$client_name'");
  while($get = $getFullname -> fetch_array()){
    $fullname = $get['fullname'];
  }
  

  $insertSQL = "INSERT INTO requests(
    requestID,
    client_name,
    starting_date,
    ending_date,
    description,
    venue,
    equipments
  ) VALUES(
    '$requestID',
    '$fullname',
    '$start',
    '$end',
    '$desc',
    '$venue',
    '$equipment'
  )";

  $result = $conn -> query($insertSQL);

  if($result){
    $updateRequestID = $conn -> query("UPDATE useraccounts SET requestID='$requestID' WHERE username='$client_name'");
    echo 'success';
  }
  

  $conn -> close();
?>