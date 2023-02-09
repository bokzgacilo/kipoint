<?php
  include('../connection.php');
  $selectAllResidents = $conn -> query("SELECT * FROM officials ORDER BY fullname ASC");
  
  while($row = $selectAllResidents -> fetch_array()){
    echo "
    <div class='official'>
      <div class='official-action col-2'>
        <i onclick='deleteOfficial(".$row['id'].")' class='fa-solid fa-trash'></i>
      </div>
      <div class='col-1 official-image'>
        <img src='".$row['photoURL']."'>
      </div>
      <p class='col-3'>".$row['fullname']."</p>
      <p class='col-2'>".$row['position']."</p>
      <p class='col'>".$row['contact']."</p>
    </div>
    ";
  }

  $conn -> close();
?>