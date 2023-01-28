<?php
  include('../connection.php');

  $case_number = $_GET['case_number'];

  $sql = "SELECT * FROM complaints WHERE case_number='$case_number'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
      <div class='col-3'>
        <p>Complainant: </p>
        <p>Defendant: </p>
        <p>Date of Incident: </p>
        <p>Incident Type: </p>
        <p>Complaint: </p>
        <p>Assisted By: </p>
        <p>Date Posted: </p>
        <p>Status: </p>
      </div>
      <div class='col'>
        <p>".$row['complainant']."</p>
        <p>".$row['defendant']."</p>
        <p>".$row['date_of_incident']."</p>
        <p>".$row['incident_type']."</p>
        <p>".$row['complaint']."</p>
        <p>".$row['assisted_by']."</p>
        <p>".$row['date_posted']."</p>
        <p>".$row['status']."</p>
      </div>
      ";
  }

  $conn -> close();
?>