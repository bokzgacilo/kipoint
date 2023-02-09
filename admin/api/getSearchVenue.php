<?php
  include('../connection.php');

  $param = $_GET['param'];

  $sql = "SELECT * FROM venue WHERE name LIKE '%$param%' OR address LIKE '%$param%' ORDER BY name ASC";
  $result = $conn -> query($sql);

  if($result -> num_rows != 0){
    while($row = $result -> fetch_array()){
      echo "
        <div class='venue'>
          <div class='venue-action col-1'>
          <i id='".$row['id']."' onclick='removeVenue(this.id)' class='fa-solid fa-trash'></i>";
  
          if($row['requestID'] != 0){
            echo "<i id='".$row['id']."' style='color: red;' onclick='editVenue(this.id)' class='fa-solid fa-ban'></i>";
          }  
  
          echo "
          </div>
          <p class='col-3'>
            ".$row['name']."
          </p>
          <p class='col-4'>
            ".$row['address']."
          </p>
          <p class='col-1'>
            ".$row['status']."
          </p>
          <p class='col'>
            ".$row['client_name']."
          </p>
          <p class='col'>";
            if($row['requestID'] != 0){
              echo "
                <button class='button is-small' onclick='generateDetails(".$row['requestID'].")'>".$row['requestID']."</button>
              ";
            }else {
              echo $row['requestID'];
            }
          echo "</p>
        </div>
      ";
    }
  }else {
    echo "
      <div class='venue'>
        <h4 class='is-size-6 me-4'>Venue didn't exist. </h4>
        <button class='button is-small is-ghost' onclick='openAddNewVenueModal()'>Add Venue</button>
      </div>
    ";
  }

  $conn -> close();
?>