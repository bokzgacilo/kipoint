<?php
  include('connection.php');

  $username = $_GET['username'];

  $sql = "SELECT * FROM useraccounts WHERE username='$username'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    echo $row['photoURL'];
  }

  $conn -> close();
?>