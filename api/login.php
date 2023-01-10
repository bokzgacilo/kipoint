<?php
  session_start();
  include('../connection.php');

  $username = $_POST['username'];
  $password = $_POST['password']; 

  $check = "SELECT * FROM accounts WHERE username='$username' AND password='$password'";
  $result = $conn -> query($check);

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){
      $_SESSION['name'] = $row['name'];
    }
    echo 'success';
  }else {
    echo 'failed';
  }

  $conn -> close();
?>