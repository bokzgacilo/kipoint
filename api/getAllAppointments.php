<?php
  include('../connection.php');

  $sql = "SELECT * FROM appointment ORDER BY starting_date ASC";
  $result = $conn -> query($sql);


  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){

      echo "
        <div class='appointment mb-3'>
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
            <button class='btn btn-primary btn-sm'>Show Full Details</button>
          </div>
        </div>
      ";
    }
  }else {
    echo "<p>No Appointments.</p>";
  }

  // $conn -> close();
?>