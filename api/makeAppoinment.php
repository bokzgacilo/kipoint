<?php
  include('../connection.php');

  print_r($_POST);
  $equipment_parent_array = $_POST['item_quantity'];
  $getAllInventoryName = $conn -> query("SELECT * FROM inventory");
  $equipments = [];

  while($inventory_name = $getAllInventoryName -> fetch_array()){
    if($equipment_parent_array[$inventory_name['serial_code']][0] != 0){
      array_push($equipments, $inventory_name['serial_code'] . ", " .  $equipment_parent_array[$inventory_name['serial_code']][0]);
    }
  }
  
  if(empty($equipments)){
    $equipments = "No Equipment Ordered.";
  }else {
    $equipments = implode('%%', $equipments);
  }

  $client_name = $_POST['client_name'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $description = $_POST['description'];
  $venue = $_POST['venue'];
  
  $sql = "INSERT INTO appointment(client_name, starting_date, ending_date, description, equipments, venue) VALUES(
    '$client_name',
    '$start_date',
    '$end_date',
    '$description',
    '$equipments',
    '$venue'
  )";
  $result = $conn -> query($sql);

  if($result){
    echo "success";
    echo "<a href=\"javascript:history.go(-1)\">Go Back</a>";
  }

  $conn -> close();
?>