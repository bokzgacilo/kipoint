<?php
  include('../connection.php');

  $sql = "SELECT * FROM inventory";
  $result = $conn -> query($sql);

  echo "
    <div class='inventory-list-header'>
      <p class='col-2'></p>
      <p class='col'>Serial Code</p>
      <p class='col-2'>Item Name</p>
      <p class='col'>Brand</p>
      <p class='col'>Quantity</p>
      <p class='col'>In Reservation</p>
      <p class='col'>Available</p>
    </div>
    <div class='inventory-list-content'>
  ";

  while($row = $result -> fetch_array()){
    echo "
      <div class='inventory-item'>
        <div class='inventory-item-action col-2'>
          <a class='delete btn btn-danger btn-sm'>Delete</a>
        </div>
        <p class='col'>".$row['serial_code']."</p>
        <p class='col-2'>".$row['name']."</p>
        <p class='col'>".$row['brand']."</p>
        <p class='col'>".$row['quantity']."</p>
        <p class='col'>".$row['in_reserve']."</p>
        <p class='col'>".$row['available']."</p>
      </div>
    ";
  }

  echo "</div>";

  $conn -> close();
?>