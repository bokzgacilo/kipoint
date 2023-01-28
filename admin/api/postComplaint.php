<?php
  session_start();
  include('../connection.php');

  $case_number = '';
  $complainant = $_POST['complainant'];
  $defendant = $_POST['defendant'];
  $date_of_incident = $_POST['date_of_incident'];
  $incident_type = $_POST['incident_type'];
  $complaint = $_POST['complaint'];

  $case_number = "BRGY" . $date_of_incident;

  $sql = "INSERT INTO complaints(case_number, complainant, defendant, date_of_incident, incident_type, complaint, assisted_by) VALUES(
    '$case_number',
    '$complainant',
    '$defendant',
    '$date_of_incident',
    '$incident_type',
    '$complaint',
    '".$_SESSION['name']."'
  )";

  $result = $conn -> query($sql);

  if($result){
    echo 1;
  }else {
    echo 0;
  }

  $conn -> close();
?>