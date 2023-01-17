<?php
  include('../connection.php');

  $sql = "SELECT * FROM inventory";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
    <div class='row'>
      <p class='col-4'>".$row['name']."</p>
      <p class='col-3'>".$row['available']."</p>
      <input id='input-".$row['serial_code']."' name='item[".$row['serial_code']."][]' type='number' class='col input is-small' value='0' max='".$row['available']." min='0'>
    </div>";
  }

  $conn -> close();
?>