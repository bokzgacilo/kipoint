<?php
  include('connection.php');

  $email = $_POST['email'];
  $password = $_POST['password'];
  $username = $_POST['username'];

  $update = $conn -> query("UPDATE useraccounts SET username='$username', password='$password', status='Registered' WHERE email='$email'");

  if($update){
    echo 1;
  }else {
    echo 0;
  }

  $conn -> close();
?>