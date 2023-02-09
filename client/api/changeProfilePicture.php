<?php 
  session_start();
  if(isset($_FILES['fileImg']['name'])){
    include('connection.php');

    global $conn;
  
    $imageName = $_FILES["fileImg"]["name"];
    $tmpName = $_FILES["fileImg"]["tmp_name"];
  
    // Image extension validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
  
    $name = $imageExtension[0];
    $imageExtension = strtolower(end($imageExtension));
  
    if (!in_array($imageExtension, $validImageExtension)){
      echo 0;
      exit;
    }
    else{
      $basename = $_POST['username'] . "." . $imageExtension;
      $picture_url = "profile-pictures/" . $basename;
  
      move_uploaded_file($tmpName, '../profile-pictures/' . $basename);

      $update = "UPDATE useraccounts SET photoURL='$picture_url' WHERE username='".$_POST['username']."'";
      $conn -> query($update);
      $conn -> close();
      echo 1;
    }
  }
  
?>