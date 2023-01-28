<?php
  include('connection.php');

  $username = $_GET['username'];
  
  $sql = "SELECT * FROM useraccounts WHERE username='$username'";
  $result = $conn -> query($sql);
  

  while($row = $result -> fetch_array()){
    if($row['requestID'] == 0){
      echo "
        <p>No requested reservation.</p>
        <a onclick='makeReservation()' class='mt-3 button is-link is-small w-100'>Request</a>
      ";
    }else {
      echo "
        <p>I requested an event. (".$row['requestID'].")</p>
        <a id='".$row['requestID']."' onclick='openMyReservation(this.id)' class='mt-3 button is-success is-small w-100'>View my Request</a>
      ";
    }
  }
  

  $conn -> close();
?>