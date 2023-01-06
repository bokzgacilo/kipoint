<main>
  <h4 style='text-align: center;' class="mt-4 mb-4">Reservations</h4>
  <?php 
      include('../connection.php');
      $getIncomingEvent = $conn -> query("SELECT * FROM appointment ORDER BY starting_date ASC LIMIT 1");
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
    ?>
  </div>
  <div id='appointmentList'>
</main>

<script>
  function getAllAppointments(){
    $.ajax({
      type: 'get',
      url: 'api/getAllAppointments.php',
      success: function(response){
        $('#appointmentList').html(response)
      }
    })
  }

  $(document).ready(function(){
    getAllAppointments();
  })

</script>

<style>
  #appointmentList {
    display: flex;
    flex-direction: column;
    width: 100%;
    align-items: center;
    /* background-color: red; */
    max-height: 75vh;
    overflow: auto;
    padding: 10px;
  }

  .appointment {
    width: 50%;
    max-height: 15vh;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    background-color: #fff;
    display: flex;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
    flex-direction: row;
    /* gap: 10px; */
    align-items: center;
    justify-content: space-between;
  }

  .appointment > div > p {
    font-family: Inter-SemiBold;
  }

  h4 {
    font-family: Inter-Bold;
  }
</style>