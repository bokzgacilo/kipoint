<?php
include('emailer.php');
include('connection.php');

$user_email = $_POST['email'];

$checkVerification = $conn -> query("SELECT * FROM useraccounts WHERE email='$user_email'");

if($checkVerification -> num_rows == 0){
  echo 2;
}else {
  while($row = $checkVerification -> fetch_array()){
    if($row['verification_number'] == 0 || $row['status'] == 'Not Registered'){
      sendRegistrationEmail($user_email);
      echo 1;
    }else {
      echo 0;
    }
  }
}

$conn -> close();
?>