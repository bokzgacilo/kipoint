<?php
  include('../connection.php');

  $sql = "SELECT * FROM appointment ORDER BY starting_date ASC";
  $result = $conn -> query($sql);

  echo "<h4 class='mt-4 mb-4'>All Reserved Events</h4>";

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){

      echo "
        <div class='appointment mb-3 w-100'>
          <div>
            <p>Client Name: ".$row['client_name']."</p>
            <p>Venue: ".$row['venue']."</p>
          </div>
          <div>
            <p>Starting Date: ".date("M j, Y", strtotime($row['starting_date']))."</p>
            <p>Ending Date: ".date("M j, Y", strtotime($row['ending_date']))."</p>
          </div>
          <div>
            <p>Status: ".$row['status']."</p>
            <button onclick='generateDetails(".$row['id'].")' class='button is-link is-small'>Show Full Details</button>
          </div>
        </div>
      ";
    }
  }else {
    echo "<p>No Appointments.</p>";
  }

  // $conn -> close();
?>