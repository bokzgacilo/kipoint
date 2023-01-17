<?php
  include('../connection.php');

  $eventID = $_GET['eventID'];
  
  $sql = "SELECT * FROM appointment WHERE id='$eventID'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    $equipmentString = explode('%%', $row['equipments']);
    $start = strtotime($row['starting_date']);
    $end = strtotime($row['ending_date']);
    
    echo "
    <div class='row'>
      <p class='col-3'>Client Name:</p>
      <p class='col-9'>".$row['client_name']."</p>
    </div>
    <div class='row'>
      <p class='col-3'>Venue:</p>
      <p class='col-9'>".$row['venue']."</p>
    </div>
    <div class='row'>
      <p class='col-3'>Description:</p>
      <p class='col-9'>".$row['description']."</p>
    </div>
    <div class='row'>
      <p class='col-3'>Starting Date:</p>
      <p class='col-9'>".date('d F, Y (l), h:i A', $start)."</p>
    </div>
    <div class='row'>
      <p class='col-3'>Ending Date:</p>
      <p class='col-9'>".date('d F, Y (l), h:i A', $end)."</p>
    </div>
    <div class='row'>
      <p class='col-3'>Equipments:</p>
    ";
    
    if(count($equipmentString) == 0){
      echo "<p class='col-9'>This event has no reserved equipments.</p>";
    }else {
      echo "<div class='equipments-used col-9'>";
      foreach ($equipmentString as $equipment) {
        $item = explode(',', $equipment);

        echo "
        <div class='row'>
          <p class='col-3'>".$item[0]."</p>
          <p class='col'>Quantity: ".$item[1]."</p>
        </div>
        ";
      }
      echo "</div>";
    }
    echo "
    </div>
    <div class='row'>
      <p class='col-3'>Status:</p>
      <p class='col-9'>".$row['status']."</p>
    </div>
    ";
  }

  $conn -> close();
?>