<?php
  include('connection.php');

  $requestID = $_GET['id'];

  $sql = "SELECT * FROM done WHERE requestID='$requestID'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "<div style='display: flex; flex-direction: column; padding: 1rem;'>
        <h4 class='is-size-5'>".$row['client_name']."'s Event</h4>
        <div class='dates mt-2'>
          <div class='date-card mb-4'>
            <h4 class='is-size-6'>Starting Date:</h4>
            <p>".date('F j, Y h:i a', strtotime($row['starting_date']))."</p>
          </div>
          <div class='date-card mb-4'>
            <h4 class='is-size-6'>Ending Date:</h4>
            <p>".date('F j, Y h:i', strtotime($row['ending_date']))."</p>
          </div>
          <div class='date-card mb-4'>
            <h4 class='is-size-6'>Venue:</h4>
            <p>".$row['venue']."</p>
          </div>
        </div>
        <h4 class='is-size-6'>Description</h4>
        <p>".$row['description']."</p>

        <h4 class='is-size-6 mt-4'>Equipment Requested</h4>
        <div class='equipment-req'>";

        if($row['equipments'] == 'None'){
          echo "<p class='is-size-6'>No requested equipment.</p>";
        }else {
          $items = json_decode($row['equipments'], true);

          for ($i=0; $i < count($items); $i++) { 
            echo "
              <div class='item'>
                <p>
                  Serial Code: ".$items[$i]['serial_code']."
                </p>
                <p>Quantity: ".$items[$i]['item_count']."</p>
              </div>
            ";
          }
        }
        echo "</div>
      </div>";
  }
  $conn -> close();
?>  