<?php
  include('../connection.php');

  $sql = "SELECT * FROM requests ORDER BY starting_date DESC";
  $result = $conn -> query($sql);

  if(($result -> num_rows) > 0){
    $counter = 0;
    while($row = $result -> fetch_array()){
      $counter++;

      if($counter == 1){
        echo "
        <div class='appointment mb-3 w-100'>
          <div>
            <p>Client Name: ".$row['client_name']."</p>
            <p>Venue: ".$row['venue']."</p>
          </div>
          <div>
            <p>Starting Date: ".date("M j, Y h:i a", strtotime($row['starting_date']))."</p>
            <p>Ending Date: ".date("M j, Y h:i a", strtotime($row['ending_date']))."</p>
          </div>
          <div>
            <p>Status: ".$row['status']."</p>
            <button id='".$row['requestID']."' onclick='reviewFirstEvent(this.id)' class='button is-link is-small'>Review Request</button>
          </div>
        </div>
        ";
      }else {
      echo "
        <div class='appointment mb-3 w-100'>
          <div>
            <p>Client Name: ".$row['client_name']."</p>
            <p>Venue: ".$row['venue']."</p>
          </div>
          <div>
            <p>Starting Date: ".date("M j, Y h:i a", strtotime($row['starting_date']))."</p>
            <p>Ending Date: ".date("M j, Y h:i a", strtotime($row['ending_date']))."</p>
          </div>
          <div>
            <p>Status: ".$row['status']."</p>
            <button id='".$row['requestID']."' onclick='reviewEvent(this.id)' class='button is-link is-small'>Review Request</button>
          </div>
        </div>
        ";
      }
    }
  }else {
    echo "<h4 class='is-size-6'>No event request.</h4>";
  }

  $conn -> close();
?>