<?php
  include('connection.php');

  $id = $_GET['id'];

  $sql = "SELECT * FROM done WHERE requestID='$id'";
  $result = $conn -> query($sql);
  while($row = $result -> fetch_array()){
    echo "
      <button onclick='openDescription(this.name)' name='".$row['requestID']."' class='button is-link is-small mb-4'>Description</button>
      <div style='
        display: flex;
        flex-direction: column;'
      >
        <h4 class='is-size-5 mb-3'>Comments</h4>
        <div class='comment-holder'>";
        if($row['comments'] == 'None'){
                echo "<p>No comments available.</p>";
              }else {
                $comments = json_decode($row['comments'], true);
                for($i = 0; $i < sizeof($comments); $i++){
                  $photoURL = '';
                  if($comments[$i]['name'] == 'Anonymous User'){
                    $photoURL = '../asset/default.png';
                  }else {
                    $username = $comments[$i]['name'];
                    $getPicture = $conn -> query("SELECT * FROM useraccounts WHERE username='$username'");
                    while($getPic = $getPicture -> fetch_array()){
                      $photoURL = $getPic['photoURL'];
                    }
                  }
                  echo "
                  <div class='comment mb-4'>
                    <img class='col-3' src='".$photoURL."' />
                    <div class='col comment-body'>
                      <div class='comment-body-header'>
                        <p class='commenter'>".$comments[$i]['name']."</p>
                        <p class='comment-date'>".$comments[$i]['date']."</p>
                      </div>
                      <p>".$comments[$i]['message']."</p>
                    </div>
                  </div>  
                  ";
                }
              }
              echo "
              </div>
              <form id='commentForm-mobile' name='formmobile".$row['requestID']."'>
                <input id='commentInput-mobile' required class='input is-small' type='text' placeholder='Post something..'>
                <button class='button is-primary is-small' name=".$row['requestID']." onclick='postCommentMobile(this.name)' type='submit'>Post</button>
              </form>
        </div>
      </div>
    ";
  }
  $conn -> close();
?>