<?php
  include('../connection.php');

  $sql = "SELECT * FROM complaints";
  $result = $conn -> query($sql);

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){
      echo "<div class='complaint mb-2'>
        <p class='col-1 complaint-action'>
        
        </p>
        <p class='col'>".$row['case_number']."</p>
        <p class='col'>".$row['incident_type']."</p>
        <p class='col'>".$row['date_posted']."</p>
        <p class='col'>".$row['status']."</p>
        <div class='col'>
          <p class='btn btn-primary btn-sm' id='".$row['case_number']."' onclick='readcomplaint(this.id)'>Read Complaint</p>
        </div>
      </div>";
    }
  }else {
    echo "<h6>No complaints to show. </h6>";
  }

  $conn -> close();
?>