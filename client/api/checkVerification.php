<?php
  include('connection.php');

  $verification_number = $_POST['ver_number'];
  $email = $_POST['email'];

  $checkIfMatched = $conn -> query("SELECT * FROM useraccounts WHERE email='$email'");

  while($row = $checkIfMatched -> fetch_array()){
    if($row['verification_number'] == $verification_number){
      echo 1;

      $conn -> query("UPDATE useraccounts SET username='kipoint$verification_number' WHERE email='$email'");
      $conn -> query("UPDATE useraccounts SET password='$verification_number' WHERE email='$email'");
    }else {
      echo 0;
    }
  }

  $conn -> close();
?>