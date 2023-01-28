<?php
  include('connection.php');

  $id = $_GET['id'];
  
  $sql = "SELECT * FROM requests WHERE requestID='$id'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    $username = $row['client_name'];

    echo "
      <p>".$row['requestID']."</p>
      <p>".$row['client_name']."</p>
      <p>".$row['starting_date']."</p>
      <p>".$row['ending_date']."</p>
      <p>".$row['venue']."</p>
      <p>".$row['description']."</p>
      <p>".$row['status']."</p>
      <div class='requested-equipments'>";

      $equipment = json_decode($row['equipments'], true);

      for ($i = 0; $i < count($equipment); $i++) { 
        echo "<div class='req-item'>
          <p>".$equipment[$i]['serial_code']."</p>
          <p>Quantity: ".$equipment[$i]['item_count']."</p>
        </div>";
      }
      // print_r($$);

      echo "
      </div>
    ";
  }
  
  $conn -> close();
?>