<?php
  include('connection.php');

  $sql = "SELECT * FROM venue";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo "
      <option>".$row['name']."</option>
    ";
  }
  $conn -> close();
?>