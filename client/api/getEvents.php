<?php
  include('connection.php');

  $sql = "SELECT * FROM done";
  $result = $conn -> query($sql);

  if(($result -> num_rows) == 0){
    echo "
    <p>No events to show.</p>
    ";
  }else {
    $counter = 1;   
    while($row = $result -> fetch_array()){
      $counter2 = $counter++;

      echo "
        <li id='".$row['id']."' onclick='changeEvent(this.id)'><a>".$counter2 .'. ' .$row['client_name']."'s Event</a></li>
      ";
    }
  }

  $conn -> close();
?>