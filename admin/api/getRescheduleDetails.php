<?php
  include('../connection.php');

  $requestID = $_GET['requestID'];

  $sql = "SELECT * FROM requests WHERE requestID='$requestID'";
  $result = $conn -> query($sql);

  while($row = $result -> fetch_array()){
    
    echo "
      <form id='".$row['requestID']."form'>
        <h4 class='mb-1'>Current Starting Date</h4>
        <input type='text' disabled class='input mb-3' value='".$row['starting_date']."'>
        <h4 class='mb-1'>How many Days </h4>
        <div class='select w-100 mb-4'>
          <select required id='reschedRange' class='w-100'>
            <option value='7'>7 Days</option>
            <option value='10'>10 Days</option>
            <option value='13'>13 Days</option>
            <option value='15'>15 Days</option>
          </select>
        </div>
        <div>
          <button class='button is-primary' id='".$row['requestID']."' onclick='postReschedule(this.id)'>Confirm</button>
        </div>
      </form>
    ";
  }

  $conn -> close();
?>