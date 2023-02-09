<?php
  include('connection.php');

  $sql = "SELECT * FROM useraccounts WHERE username='".$_POST['username']."'";
  $result = $conn -> query($sql);
  
  if(($result -> num_rows) == 0){
    echo 0;
  }else {
    $sql = "SELECT * FROM useraccounts WHERE temporary_password='".$_POST['password']."' OR password='".$_POST['password']."'";
    $result = $conn -> query($sql);
    if(($result -> num_rows) == 0){
      echo 2;
    }else {
      echo 1;
    }
  }

  $conn -> close();
?>