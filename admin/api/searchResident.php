<?php
  include('../connection.php');

  $keyword = $_GET['keyword'];
  
  $sql = "SELECT * FROM accounts WHERE name LIKE '%$keyword%' OR username LIKE '%$keyword%' ORDER BY name ASC";
  $result = $conn -> query($sql);

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){
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
  }else{
    echo "<h6>No found result for $keyword.</h6>";
  }

  $conn -> close();
?>