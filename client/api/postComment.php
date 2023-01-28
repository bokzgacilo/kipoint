<?php 
  include('connection.php');

  $eventID = $_POST['id'];
  $username = $_POST['username'];
  $comment = $_POST['message'];

  $sql = "SELECT * FROM dibe WHERE id='$eventID'";
  $result = $conn -> query($sql);
  $array_of_comment = '';

  while($row = $result -> fetch_array()){
    if($row['comments'] == 'None'){
      $array_of_comment = [];
    }else {
      $array_of_comment = json_decode($row['comments']);
    }
  }

  array_push($array_of_comment, (object)[
    'name' => $username,
    'message' => $comment,
    'likes' => 0,
    'date' => date("h:i a F j, Y")
  ]);

  $process_array = json_encode($array_of_comment);
  
  $updateComment = $conn -> query("UPDATE done SET comments='$process_array' WHERE id='$eventID'");
  
  if($updateComment){
    echo 1;
  }else {
    echo 0;
  }

  $conn -> close();
?>