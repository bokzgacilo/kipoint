<?php
  include('../connection.php');

  $selectAllResidents = $conn -> query("SELECT * FROM accounts ORDER BY name ASC");
  while($row = $selectAllResidents -> fetch_array()){
    echo "
      <div class='resident mb-2'>
        <div class='resident-action col-2'>
          <a title='Delete Resident'>
            <i class='fa-solid fa-trash'></i>
          </a>
          <a title='Edit Resident'>
            <i class='fa-solid fa-user-pen'></i>
          </a>
          <a title='Change Password'>
            <i class='fa-solid fa-key'></i>
          </a>
          <a title='Change Address'>
            <i class='fa-solid fa-map-location-dot'></i>
          </a>
        </div>
        <div class='col-1 res-avatar'>
          <img src='".$row['profile_picture']."'>
        </div>
        <p class='col-3'>".$row['name']."</p>
        <p class='col-2'>".$row['username']."</p>
        <p class='col-2'>".$row['password']."</p>
        <p class='col-2'>".$row['address']."</p>
      </div>
    ";
  }

  $conn -> close();
?>