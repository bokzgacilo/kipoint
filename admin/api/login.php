<?php
  session_start();
  include('../connection.php');

  $username = $_POST['username'];
  $password = $_POST['password']; 

  $check = "SELECT * FROM accounts WHERE username='$username' AND password='$password'";
  $result = $conn -> query($check);

  if(($result -> num_rows) > 0){
    $fullname = '';
    while($row = $result -> fetch_array()){
      $fullname = $row['name'];
    }

    $resp = array(
      'status' => 1,
      'fullname' => $fullname
    );

    echo json_encode($resp);
  }else {
    echo 0;
  }

  $conn -> close();
?>