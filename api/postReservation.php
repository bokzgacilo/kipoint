<?php 
  include('../connection.php');

  $client_name = $_POST['client_name'];
  $venue = $_POST['venue'];
  $event_description = $_POST['event_description'];
  $starting_date = $_POST['starting_date'];
  $ending_date = $_POST['ending_date'];
  $itemArray = $_POST['item'];
  $itemObject = [];

  // $itemArray = implode('%%', $itemArray);
  // echo $itemArray;
  foreach ($itemArray as $item => $value) {
    // print_r($itemArray[$item]);
    if (in_array(0, $itemArray[$item])) {
      unset($itemArray[$item]);
    } else { 
      array_push($itemObject, [
        'item_serial_code' => $item,
        'item_quantity' => $value[0],
      ]);
    }
  }

  $json = json_encode((object)$itemObject);
  // print_r($json);

  $sql = "INSERT INTO appointment(
    client_name,
    starting_date,
    ending_date,
    description,
    venue,
    equipments
  ) VALUES(
    '".$client_name."',
    '".$starting_date."',
    '".$ending_date."',
    '".$event_description."',
    '".$venue."',
    '".$json."'
  )";

  $result = $conn -> query($sql);

  if($result){
    echo 1;
  }else {
    echo 0;
  }
    
  $conn -> close();
?>