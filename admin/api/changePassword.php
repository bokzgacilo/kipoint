<?php
  include('../connection.php');
  session_start();
  
  $newPassword = $_POST['newPassword'];
  $target = $_SESSION['name'];

  $sql = "UPDATE accounts SET password='$newPassword' WHERE name='$target'";
  $result = $conn -> query($sql);

  if($result){
    echo 1;
  }else {
    echo 0;
  }
  
  $conn -> close();
?>