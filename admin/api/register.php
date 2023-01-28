<?php
  include('../connection.php');

  $username = $_POST['username'];
  $password = $_POST['password'];
  $fullname = $_POST['fullname'];

  $checkUsername = $conn -> query("SELECT * FROM accounts WHERE username LIKE '%$username%'");

  if(($checkUsername -> num_rows) > 0){
    echo 0;
  }else {
    $sql = "INSERT INTO accounts(name, username, password) VALUES('$fullname', '$username', '$password')";
    $result = $conn -> query($sql);

    if($result){
      echo 1;
      $event = $fullname . ", was created.";
      $conn -> query("INSERT INTO logs (event) VALUE('$event')");
    }
  }

  $conn -> close();
?>