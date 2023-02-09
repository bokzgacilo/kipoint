<?php
  include('../connection.php');

  $sql = "SELECT * FROM venue ORDER BY name ASC";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
      <div class='venue'>
        <div class='venue-action col-1'>
        <i id='".$row['id']."' onclick='removeVenue(this.id)' class='fa-solid fa-trash'></i>
        </div>
        <p class='col'>
          ".$row['name']."
        </p>
        <p class='col'>
          ".$row['address']."
        </p>
      </div>
    ";
  }

  $conn -> close();
?>