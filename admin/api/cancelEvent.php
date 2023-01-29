<?php
  include('../connection.php');

  $requestID = $_POST['requestID'];

  $sql = "INSERT INTO cancelled (
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
    FROM accepted WHERE requestID='$requestID'
    ";

  $result = $conn -> query($sql);

  if($result){
    echo 1;
    $conn -> query("DELETE FROM accepted WHERE requestID='$requestID'");
  }else {
    echo 0;
  }
?>