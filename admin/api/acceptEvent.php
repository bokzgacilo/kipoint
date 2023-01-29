<?php
  include('../connection.php');

  $requestID = $_POST['requestID'];

  $sql = "INSERT INTO accepted (
    requestID, 
    client_name, 
    starting_date,
    ending_date,
    description,
    venue,
    equipments
    ) SELECT
    requestID, 
    client_name, 
    starting_date,
    ending_date,
    description,
    venue,
    equipments
    FROM requests WHERE requestID='$requestID'
    ";

  $result = $conn -> query($sql);

  if($result){
    echo 1;
    $conn -> query("DELETE FROM requests WHERE requestID='$requestID'");
  }else {
    echo 0;
  }

  $conn -> close();
?>