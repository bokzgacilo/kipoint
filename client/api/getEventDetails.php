<?php
  include('connection.php');

  $id = $_GET['id'];

  $sql = "SELECT * FROM done WHERE requestID='$id'";
  $result = $conn -> query($sql);
  
  if(($result -> num_rows) == 0){
    echo "
    <h4>No events to show.</h4>
    ";
  }else {
    while($row = $result -> fetch_array()){
      echo "
        <div style='display: flex; flex-direction: column; border-right: 1px #ededed solid;' class='col-6'>
          <div class='comment-holder'>
          <h4 class='is-size-5 mb-3'>Comments</h4>

        ";
          
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
          echo "
          </div>
          <form id='commentForm' name=".$row['requestID'].">
            <input id='commentInput' required class='input is-normal' type='text' placeholder='Post something..'>
            <button class='button is-primary' name=".$row['requestID']." onclick='postComment(this.name)' type='submit'>Post</button>
            <label class='cl-switch'>
              <input type='checkbox' id='anonymousSwitch'>
              <span class='switcher'></span>
            </label>
            <i class='fa-solid fa-user-secret fa-xl'></i>
          </form>
        </div>
        <div class='col-6' style='gap:1rem; display: flex; flex-direction: column; padding: 1rem;'>
          <h4 class='is-size-5'>".$row['client_name']."'s Event</h4>
          <div class='dates'>
            <div class='date-card'>
              <p>Starting Date:</p>
              <i class='fa-regular fa-calendar'></i>
              <p>".date('F j, Y', strtotime($row['starting_date']))."</p>
              <i class='fa-regular fa-clock'></i>
              <p>".date('h:i a', strtotime($row['starting_date']))."</p>
            </div>
            <div class='date-card'>
              <p>Ending Date:</p>
              <i class='fa-regular fa-calendar'></i>
              <p>".date('F j, Y', strtotime($row['ending_date']))."</p>
              <i class='fa-regular fa-clock'></i>
              <p>".date('h:i a', strtotime($row['ending_date']))."</p>
            </div>
            <div class='date-card'>
              <i class='fa-regular fa-map-location-dot'></i>
              <p>".$row['venue']."</p>
            </div>
          </div>
          <h4 class='is-size-6'>Description</h4>
          <p>".$row['description']."</p>
          <h4 class='is-size-6'>Equipment Requested</h4>
          <div class='equipment-req'>";

          if($row['equipments'] == 'None'){
            echo "<h4 class='is-size-6'>No requested equipment.</h4>";
          }else {
            $items = json_decode($row['equipments'], true);

            for ($i=0; $i < count($items); $i++) { 
              echo "
                <div class='item'>
                  <p>
                  Serial Code: ".$items[$i]['serial_code']."
                  </p>
                  <p>Quantity: ".$items[$i]['item_count']."</p>
                </div>
              ";
            }
          }
          echo "</div>
        </div>
      ";
    }
  }

  $conn -> close();
?>