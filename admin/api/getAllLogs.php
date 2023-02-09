<?php
  include('../connection.php');

  $sql = "SELECT * FROM logs";
  $result = $conn -> query($sql);

  if($result -> num_rows == 0){
    echo "
      <div class='logs'>
        <h4 class='is-size-6'>No Logs</h4>
      </div>
    ";
  }else {
    while($row = $result -> fetch_array()){
      echo "
      <div class='logs'>
        <p class='col-2'>".$row['id']."</p>
        <p class='col'>".$row['event']."</p>
        <p class='col-3'>".$row['date']."</p>
      </div>
    ";
    }
  }

  $conn -> close();
?>