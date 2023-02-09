<?php
  include('../connection.php');

  $eventID = $_GET['requestID'];
  
  $sql = "SELECT * FROM cancelled WHERE requestID='$eventID'";
  $result = $conn -> query($sql);

  echo "
    <div class='bok-modal-header'>
      <h4 class='is-size-4 mt-2'>
        Request ID: $eventID
      </h4>
    </div>
    <div class='event-details'>
  ";

  while($row = $result -> fetch_array()){
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
      <p class='col-3'>Status:</p>
      <p class='col-9'>".$row['status']."</p>
    </div>
    <div class='row'>
    <p class='col-3'>Equipments:</p>
    <div class='equipments-used col-9'>";
    
    if($row['equipments'] == 'None'){
      echo "<h4 class='col-9'>This event has no reserved equipments.</h4>";
    }else {
      $item = json_decode($row['equipments'], true);

      for ($i=0; $i < count($item); $i++) { 
        echo "
          <div class='item'>
            <p>Serial Code: ".$item[$i]['serial_code']."</p>
            <p>Quantity: ".$item[$i]['item_count']."</p>
          </div>
        ";
      }
    }
    echo "
    </div>
    </div>
    <div class='bok-modal-footer'>
      <button onclick='closeModal()' class='button'>Close</button>
    </div>
    ";
  }

  $currentDate = date('F j, Y h:i a');
  $message = 'Event: ' . $eventID . ' was cancelled';
  $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  $conn -> close();
?>