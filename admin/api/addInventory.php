<?php 
  include('../connection.php');

  $itemName = $_POST['itemName'];
  $itemSerialCode = $_POST['itemSerialCode'];
  $itemBrand = $_POST['itemBrand'];
  $quantity = $_POST['quantity'];

  $sql = "INSERT INTO inventory (name, serial_code, brand, quantity, available) VALUES(
    '$itemName', '$itemSerialCode', '$itemBrand', $quantity, $quantity
  )";

  $result = $conn -> query($sql);

  if($result){
    echo 1;
  }else {
    echo 0;
  }

  $conn -> close();
?>