<?php
  include('../connection.php');

  $sql = "SELECT * FROM cancelled";
  $result = $conn -> query($sql);

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){
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
            <button onclick='viewCancelled(".$row['requestID'].")' class='button is-link is-small'>Show Full Details</button>
          </div>
        </div>
      ";
    }
  }else {
    echo "<h4 class='is-size-6'>No cancelled event.</h4>";
  }

  $conn -> close();
?>