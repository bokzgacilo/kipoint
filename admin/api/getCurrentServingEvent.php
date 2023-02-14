<?php
  include('../connection.php');
  include('emailer.php');
  
  $sql = "SELECT * FROM requests ORDER BY starting_date ASC LIMIT 1";
  $result = $conn -> query($sql);

  echo "<h4 class='is-size-4 mb-4'>Now Serving</h4>";

  if($result -> num_rows == 0){
    echo "<h5 class='is-size-6'>No event to show. Kipoint is for client's requests.</h5>";
  }else {
    

    while($row = $result -> fetch_array()){
      $start = strtotime($row['starting_date']);
      $end = strtotime($row['ending_date']);
      
      $findEmail = $conn -> query("SELECT * FROM useraccounts WHERE fullname='".$row['client_name']."'");
      $email = '';
      $receipt = '';
      
      if($findEmail){
        while($row2 = $findEmail -> fetch_array()){
          $email = $row2['email'];
          $receipt = $row2['receipt'];
        }
      }
      if($receipt == 'None'){
        sendEmailReceipt($row['requestID'], $email, $row['client_name']);
        $conn -> query("UPDATE useraccounts SET receipt='Sent' WHERE fullname='".$row['client_name']."'");
      }
      echo "
      <div class='row'>
        <h4 class='col-3 is-size-6'>Request ID:</h4>
        <p class='col-9'>".$row['requestID']."</p>
      </div>
      <div class='row'>
        <h4 class='col-3 is-size-6'>Client Name:</h4>
        <p class='col-9'>".$row['client_name']."</p>
      </div>
      <div class='row'>
        <h4 class='col-3 is-size-6'>Venue:</h4>
        <p class='col-9'>".$row['venue']."</p>
      </div>
      <div class='row'>
        <h4 class='col-3 is-size-6'>Description:</h4>
        <p class='col-9'>".$row['description']."</p>
      </div>
      <div class='row'>
        <h4 class='col-3 is-size-6'>Starting Date:</h4>
        <p class='col-9'>".date('d F, Y (l), h:i A', $start)."</p>
      </div>
      <div class='row'>
        <h4 class='col-3 is-size-6'>Ending Date:</h4>
        <p class='col-9'>".date('d F, Y (l), h:i A', $end)."</p>
      </div>
      <div class='row'>
        <h4 class='col-3 is-size-6'>Status:</h4>
        <p class='col-9'>On-going</p>
      </div>
      <div class='row'>
      <h4 class='col-3 is-size-6'>Equipments:</h4>
      <div class='equipments-used col-9'>";
      
      if($row['equipments'] == 'None'){
        echo "<h4 class='col-9'>This event has no reserved equipments.</h4>";
      }else {
        $item = json_decode($row['equipments'], true);
  
        for ($i=0; $i < count($item); $i++) { 
          echo "
            <div class='item'>
              <p>Serial Code: ".$item[$i]['serial_code']."</p>
              <p>Quantity: ".$item[$i]['item_count']."</p>
            </div>
          ";
        }
      }
      echo "
      </div>
      </div>
      <div class='bok-modal-footer'>
        <button id='".$row['requestID']."' onclick='cancelEvent(this.id)' class='button is-danger'>Cancel Event</button>
        </div>
      ";
    }
  }
  

  $conn -> close();
?>