<?php
  include('connection.php');

  $fullname = $_POST['fullname'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "INSERT INTO useraccounts(fullname, username, password) VALUES('$fullname', '$username', '$password')";
  $result = $conn -> query($sql);

  if($result){
    echo 1;
  }else{
    echo 0;
  }
  
  $conn -> close();
?>