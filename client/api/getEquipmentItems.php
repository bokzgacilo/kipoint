<?php
  include('connection.php');

  $sql = "SELECT * FROM inventory";
  $result = $conn -> query($sql);

  if($result -> num_rows == 0){
    echo "<h4>No Available Item</h4>";
  }else {
    while($row = $result -> fetch_array()){
      if($row['available'] != 0){
        echo "
        <div class='equipment'>
          <p class='col-3'>".$row['serial_code']."</p>
          <p class='col'>".$row['name']."</p>
          <p class='col-2'>".$row['available']."</p>
          <div class='col-2'>
            <input type='number' class='is-small input w-100' onchange='handleChangeEquipment(this.id)' value='0' id='".$row['serial_code']."'>
          </div>
        </div>
      ";
      }      
    }
  }

  $conn -> close();
?>