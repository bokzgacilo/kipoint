<?php
  include('../connection.php');
  $getIncomingEvent = $conn -> query("SELECT * FROM done ORDER BY starting_date ASC LIMIT 1");
  $incoming = '';
  
  while($inc = $getIncomingEvent -> fetch_array()){
    $incoming =  strtotime($inc['starting_date']);
  }

  $today = date("M j, Y");
  $date1 = strtotime(date('Y-m-d'));
  $interval = ($incoming - $date1)/60/60/24;

  echo "
  <div style='text-align: center;' class='today'>
    <h4 class='mb-2'>Today's Date: $today</h4>
    <span>Next appointment is ($interval) days from now.</span>
  </div>
  ";

  $conn -> close();
?>