<?php
  include('connection.php');

  $sql = "SELECT * FROM events LIMIT 1";
  $result = $conn -> query($sql);

  if(($result -> num_rows) == 0){
    echo "
    <h4>No events to show.</h4>
    ";
  }else {
    while($row = $result -> fetch_array()){
      echo "
      <h4 class='is-size-5' style='text-align: center; padding: 1rem;'>".$row['client_name']."'s Event</h4>
      <div class='dates'>
        <div class='date-card'>
          <p>Starting Date:</p>
          <i class='fa-regular fa-calendar'></i>
          <p>January 18, 2023</p>
          <i class='fa-regular fa-clock'></i>
          <p>9:24 AM</p>
        </div>
        <div class='date-card'>
          <p>Ending Date:</p>
          <i class='fa-regular fa-calendar'></i>
          <p>".$row['ending_date']."</p>
          <i class='fa-regular fa-clock'></i>
          <p>9:24 AM</p>
        </div>
        <div class='date-card'>
          <i class='fa-regular fa-map-location-dot'></i>
          <p>".$row['venue']."</p>
        </div>
      </div>
      <h4 class='is-size-6' style='padding: 1rem;'>Description</h4>
      <div class='event-detail'>
        <h4>".$row['description']."</h4>
      </div>
      <h4 class='is-size-6' style='padding: 1rem;'>Comments</h4>
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
          <div class='comment mb-2'>
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
      
      echo "</div>
      <form id='commentForm' name=".$row['id'].">
        <input id='commentInput' required class='input is-normal' type='text' placeholder='Post something..'>
        <button class='button is-primary' name=".$row['id']." onclick='postComment(this.name)' type='submit'>Post</button>
        <div class='form-check form-switch'>
          <input class='form-check-input' type='checkbox' role='switch' id='anonymousSwitch'>
          <label class='form-check-label'>Anonymous</label>
        </div>
      </form>
      ";
    }
  }

  $conn -> close();
?>