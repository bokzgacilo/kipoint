<?php 
  session_start();

  if(!isset($_SESSION['name'])){
    header('location: ./login.php');
  }else {
    include('connection.php');

    $name = $_SESSION['name'];    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Kipoint</title>
  <link rel="icon" type="image/x-icon" href="asset/seal.png">

  <!-- STYLES -->
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="css/header.css">
  <!-- SCRIPTS -->
  <script src="jquery.js"></script>
  <script src="index.js"></script>
  <script src="plugins/formToJson.js"></script>
  <script src="plugins/sweetalert2@11.js"></script>
  <script src="asset/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="backdrop">
    <div class="spinner-border text-light" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>


  <script>
    var route;
      
    var hashed_url = window.location.hash;
    var lastURL = hashed_url.split("#");

    function openModal(name){
      $('#' + name +"").css('display', 'flex');
    }

    function changeRoute(route){
      if(route == 'default'){
        $('.root').hide().load('views/default.html').fadeIn('250');
      }else {
        $('.root').hide().load(`views/${route}.html`).fadeIn('250');
      }
    }

    function getAllAvailableEquipment() {
      $.ajax({
        type: 'get',
        url: 'api/getAllAvailableEquipment.php',
        success: (response) => {
          $('.need-equipment').html(response)
        }
      })
    }

    function validateInput(name){
      if(
        $('#input-' + name + 'a').val() != '' &&
        $('#input-' + name + 'b').val() != ''
      ){
        return true;
      }
    }

    function renderStepBubbleCompleted(name){
      $("#stepper-" + name).removeClass('step-active')
      $("#stepper-" + name + " i").removeClass('fa-x fa-circle')
      $("#stepper-" + name + " i").addClass('fa-check')
      $("#stepper-" + name).css({
        'background-color' : 'green',
        'color' : 'white'
      })
    }

    function renderStepBubblePrevious(name){
      $("#stepper-" + name).removeClass('step-active')
      $("#stepper-" + name + " i").removeClass('fa-circle')
      $("#stepper-" + name + " i").addClass('fa-x')
      $("#stepper-" + name).css({
        'background-color' : '#fff',
        'color' : '#000'
      })
    }

    function renderStepBubbleNext(name){
      $("#stepper-" + name).addClass('step-active')
      $("#stepper-" + name + " i").removeClass('fa-x')
      $("#stepper-" + name + " i").addClass('fa-circle')
    }


    function nextStep(name){
      if(validateInput(name)){
        renderStepBubbleCompleted(name)
        $('.step-' + name).css('display', 'none')
        var next = parseInt(name) + 1;
        renderStepBubbleNext(next);
        $('.step-' + next).css('display', 'flex')
      }
    }

    function prevStep(name){
      renderStepBubbleNext(name);
      renderStepBubblePrevious(name);

      $("#stepper-" + name).removeClass('step-active')

      $('.step-' + name).css('display', 'none')
      var prev = parseInt(name) - 1;

      renderStepBubbleNext(prev);
      $('.step-' + prev).css('display', 'flex')
    }

    $(document).ready(function(){
      getAllAvailableEquipment();

      
      if(lastURL[1] == undefined){
        changeRoute('default');
      }else {
        changeRoute(lastURL[1]);
        $("[name='"+lastURL[1]+"']").addClass('active');
      }

      $('.modal-opener').click(function(){
        openModal($(this).attr('name'));
      })
      
      $('#finalizeReservation').click(function(event){
            Swal.fire({
              title: 'Confirm Reservation',
              text: "This action is irreversible.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, confirm reservation'
            }).then((result) => {
              if (result.isConfirmed) {
                event.preventDefault();

                var form = $('#reservationForm')[0];
                var data = new FormData(form);

                $.ajax({
                  type: 'post',
                  url: 'api/postReservation.php',
                  enctype: 'multipart/form-data',
                  data: data,
                  processData: false,
                  contentType: false,
                  cache: false,
                  timeout: 800000,
                  beforeSend: () => {

                  },
                  success: (response) => {

                    Swal.fire(
                      'Success',
                      'Your reservation is posted in Kipoint Reservations',
                      'success'
                    )

                    $('#makeReservation').css('display', 'none');
                    $('#reservationForm')[0].reset();
                    $("a[name='"+lastURL[1]+"']").click();
                  },
                  complete: () => {
                  }
                })
              }
            })
          })

      $('#changePasswordForm').submit(function(event){
        event.preventDefault();
        $('.backdrop').css('display', 'flex');  
        var formdata = $(this).formToJson();

        if(formdata['password'] == null || formdata['password'].trim() === ''){
          $('#changePasswordForm')[0].reset();  
          $('.backdrop').css('display', 'none');
          $('.bok-modal').css('display', 'none');
        }else {
          $.ajax({
            type: 'post',
            url: 'api/changePassword.php',
            data: {
              newPassword: formdata['password']
            },
            success: function(response){
              if(response == 1){
                setTimeout(function(){
                  Swal.fire({
                    title: 'Password changed.',
                    text: 'You can use your new password now.',
                    icon: 'success',
                    allowOutsideClick: false,
                    confirmButtonText: 'Ok'
                  }).then((result) => {
                    if(result.isConfirmed){
                      $('#changePasswordForm')[0].reset();  
                      $('.backdrop').css('display', 'none');
                      $('.bok-modal').css('display', 'none');
                    }
                  }) 
                }, 750)
              }else {
                Swal.fire({
                    title: 'Password not changed.',
                    text: 'Please try again after a few minutes.',
                    icon: 'Error',
                    allowOutsideClick: false,
                    confirmButtonText: 'Close'
                  }).then((result) => {
                    if(result.isConfirmed){
                      $('#changePasswordForm')[0].reset();  
                      $('.backdrop').css('display', 'none');
                      $('.bok-modal').css('display', 'none');
                    }
                  }) 
              }
            }
          })
        }
      })

      $('.navigate').click(function(){
        newRoute = $(this).attr('name');
        $('.backdrop').css('display', 'flex');

        setTimeout(function(){
          $('.backdrop').css('display', 'none');      
          changeRoute(newRoute);
        }, 1000)

        $('.navigate').removeClass('active');
        $(this).addClass('active'); 
      })

      $('.close-modal').click(function(){
        $(this).parent().parent().parent().css('display', 'none');
      })
    })
  </script>
  <style>
    #reservationForm > div {
      flex-direction: column;
    }

    .stepper {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .stepper-bubble {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 12px;
      border: 1px #fff solid;
    }

    .step-active {
      border: 1px #d7d7d7 solid;
      transition: 0.5s;
    }
  </style>
  <div id='makeReservation' class='bok-modal'>
    <div class="bok w-50">
      <div class="bok-modal-header">
        <h4 class="mt-2 mb-2">
          Make Reservation
        </h4>
        <i class="close-modal fa-solid fa-x"></i>
      </div>
      <div class="stepper">
        <div id="stepper-1" class="stepper-bubble step-active">
          <i class="fa-regular fa-circle"></i>
          <p>Event Details</p>
        </div>
        <div id="stepper-2" class="stepper-bubble">
          <i class="fa-regular fa-x"></i>
          <p>Event Date</p>
        </div>
        <div id="stepper-3" class="stepper-bubble">
          <i class="fa-regular fa-x"></i>
          <p>Event Equipments</p>
        </div>
      </div>
      <form id="reservationForm" method="post" enctype="multipart/form-data">
        <div class="step-1">
          <p class="bok-form-text">Client Name</p>
          <input id='input-1a' name='client_name' required class="input" type="text" placeholder="Dela Cruz, Juan">
          <p class="bok-form-text">Venue</p>
          <div class="select w-100 mb-3">
            <select id='input-1' name='venue' required class="w-100">
              <option>Basketball Court</option>
              <option>Barangay Hall</option>
              <option>Elementary School</option>
              <option>Health Clinic</option>
            </select>
          </div>
          <p class="bok-form-text">Event Description</p>
          <textarea id='input-1b' name='event_description' required class="textarea mt-3" placeholder="Textarea"></textarea>
          <div class="form-action">
            <a class="mt-4 button is-primary" name='1' onclick="nextStep(this.name)">Next</a>
          </div>
        </div>
        <div style='display:none;' class="step-2">
          <p class="bok-form-text">Starting Date</p>
          <input id='input-2a' name='starting_date' required class="input" type="datetime-local">
          <p class="bok-form-text">Ending Start</p>
          <input id='input-2b' name='ending_date' required class="input" type="datetime-local">
          <div class="form-action">
            <a class="mt-4 button is-secondary" name='2' onclick="prevStep(this.name)">Back</a>
            <a class="mt-4 button is-primary" name='2' onclick="nextStep(this.name)">Next</a>
          </div>
        </div>
        <div style='display:none;' class="step-3">
          <p class="bok-form-text">Need Equipment</p>
          <div class="need-equipment">

          </div>
          <div class="form-action">
            <a class="mt-4 button is-secondary" name='3' onclick="prevStep(this.name)">Back</a>
            <a class="mt-4 button is-primary" id='finalizeReservation'>Reserve</a>
          </div>
        </div>
      </form>
      <script>
        
      </script>
    </div>
  </div>

  <div id='changePassword' name='changePassword' class="bok-modal">
    <div class="bok">
      <h4 class="mt-2">Change Password</h4>
      <form id="changePasswordForm" class="mb-4">
        <div class="form-floating mt-4 mb-3">
          <input id="changePassword_Input" type="password" name="password" class="form-control" placeholder="Password">
          <label for="floatingInput">New Password</label>
        </div>
        <p class="error-message"></p>
        <button id='changePassword_Button' class="btn btn-primary btn-lg w-100" type="submit">Close</button>
      </form>
    </div>
  </div>

  <header>
    <a href="#default" name='default' id="brand">KIPOINT</a>
    <div class="navigators"> 
      <button name='makeReservation' class='modal-opener make-reservation'>
        <i class="fa-solid fa-plus me-1"></i>
        <p>Make Reservation</p>
      </button>
      <a href="#reservation" class='navigate' name='reservation'>
        <i class="fa-solid fa-clock"></i>
        <p>Reservation</p>
      </a>
      <a href="#inventory" class='navigate' name='inventory'>
        <i class="fa-solid fa-warehouse"></i>
        <p>Inventory</p>
      </a>
      <a href="#resident" class='navigate' name='resident'>
        <i class="fa-solid fa-users"></i>
        <p>Residents</p>
      </a>
      <a href='#complaints' class='navigate' name='complaints'>
        <i class="fa-solid fa-solid fa-file-exclamation"></i>
        <p>Complaints</p>
      </a>
      <div class="other-drop">
        <p>
          Others 
          <i class="ms-2 fa-solid fa-chevron-down"></i>
        </p>
        <div class="other-drop-content">
          <a>
            <i class="fa-solid fa-sitemap me-2"></i>  
            Barangay Organizational Chart
          </a>
          <a>
            <i class="fa-solid fa-list me-2"></i>  
            Logs
          </a>
          <a>
            <i class="fa-solid fa-file-export me-2"></i>
            Export Data
          </a>
          <a>
            <i class="fa-solid fa-database me-2"></i>  
            Access Database
          </a>
        </div>
      </div>
      <div class="account-drop">
        <div class="avatar" title="<?php echo $name; ?>">
          <a class="me-2"><?php echo $name; ?></a>
          <img src="asset/default.png">
        </div>
        <div class="account-drop-content">
          <a>
            <i class="fa-solid fa-gear me-2"></i>  
            Account Setting
          </a>
          <a name='changePassword' class="modal-opener">
            <i class="fa-solid fa-key me-2"></i>  
            Change Password
          </a>
          <a href="api/logout.php">
            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>  
            Logout
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="root">

  </div>
</body>
</html>
<?php
    $conn -> close();
  }
?>