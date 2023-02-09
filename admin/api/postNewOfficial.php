<?php 
  include('../connection.php');

  $fullname = $_POST['officialFullname'];
  $position = $_POST['officialPosition'];
  $contact = $_POST['officialContact'];

  $sql = "INSERT INTO officials(fullname, position, contact) VALUES('$fullname', '$position', '$contact')";
  $result = $conn -> query($sql);

  if($result){
    if(isset($_FILES['officialPhoto']['name'])){
  
      $imageName = $_FILES["officialPhoto"]["name"];
      $tmpName = $_FILES["officialPhoto"]["tmp_name"];
    
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
        $basename = "$contact-officials." . $imageExtension;
        $picture_url = "officials-pictures/" . $basename;
    
        move_uploaded_file($tmpName, '../officials-pictures/' . $basename);
  
        $update = "UPDATE officials SET photoURL='$picture_url' WHERE fullname='$fullname'";
        $conn -> query($update);
        $conn -> close();
        echo 1;
      }
    }
  }
?>