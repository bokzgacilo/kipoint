<?php
  include('connection.php');
  $selectAllResidents = $conn -> query("SELECT * FROM officials ORDER BY fullname ASC");
  
  while($row = $selectAllResidents -> fetch_array()){
    echo "
    <div class='official'>
      <div class='col-1 official-image'>
        <img src='../admin/".$row['photoURL']."'>
      </div>
      <h4 class='is-size-6 col'>".$row['fullname']."</h4>
      <p class='col-3'>".$row['position']."</p>
      <p class='col-2'>".$row['contact']."</p>
    </div>
    ";
  }

  $conn -> close();
?>