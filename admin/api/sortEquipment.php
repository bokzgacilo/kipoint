<?php
  include('../connection.php');

  $parameter = $_GET['param'];

  $sql = "SELECT * FROM inventory WHERE category='$parameter'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
    <div class='equipment'>
      <div class='equipment-action col-2'>
        <i id='".$row['serial_code']."' onclick='removeItem(this.id)' class='fa-solid fa-trash'></i>
      </div>
      <p class='col-2'>".$row['serial_code']."</p>
      <p class='col-3'>".$row['name']."</p>
      <p class='col-2'>".$row['brand']."</p>
      <p class='col-1'>".$row['quantity']."</p>
      <p class='col-1'>".$row['in_reserve']."</p>
      <p class='col-1'>".$row['available']."</p>
    </div>
    ";
  }

  $conn -> close();
?>