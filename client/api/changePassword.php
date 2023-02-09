<?php
  include('connection.php');

  $oldpassword = $_POST['oldpassword'];
  $newpassword = $_POST['newpassword'];
  $username = $_POST['username'];

  $sql = "SELECT * FROM useraccounts WHERE username='$username'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    if($row['password'] == $oldpassword || $row['temporary_password'] == $oldpassword){
      $changePassword = $conn -> query("UPDATE useraccounts SET password='$newpassword', temporary_password='$newpassword' WHERE username='$username'");

      if($changePassword){
        echo 1;
      }
    }
  }

  $conn -> close()
?>