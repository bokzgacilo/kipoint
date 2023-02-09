<?php
  include('../connection.php');
  $selectAllResidents = $conn -> query("SELECT * FROM useraccounts ORDER BY fullname ASC");
  
  while($row = $selectAllResidents -> fetch_array()){
    if($row['username'] == ''){
      echo "
      <div class='account'>
        <div class='account-action col-2'>
          <i onclick='deleteUser(".$row['id'].")' class='fa-solid fa-trash'></i>
        </div>
        <div class='col-1 account-image'>
          <img src='../client/".$row['photoURL']."'>
        </div>
        <p class='col-3'>".$row['fullname']."</p>
        <p class='col-2'>".$row['username']."</p>
        <p class='col-2'>".$row['password']."</p>
        <p class='col-2'>".$row['status']."</p>
      </div>
      ";
    }else {
      echo "
      <div class='account'>
        <div class='account-action col-2'>
          <i onclick='deleteUser(".$row['id'].")' class='fa-solid fa-trash'></i>
          <i onclick='changePasskey(".$row['id'].")' class='fa-solid fa-key'></i>
        </div>
        <div class='col-1 account-image'>
          <img src='../client/".$row['photoURL']."'>
        </div>
        <p class='col-3'>".$row['fullname']."</p>
        <p class='col-2'>".$row['username']."</p>
        <p class='col-2'>".$row['password']."</p>
        <p class='col-2'>".$row['status']."</p>
      </div>
      ";
    }
  }
  


  $conn -> close();
?>