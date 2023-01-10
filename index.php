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
  <style>
    main {
      height: 93vh;
      max-height: 93vh;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 1rem;
    }

    .backdrop {
      background-color: var(--backdrop);
      width: 100vw;
      height: 100vh;
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 2;
      position: fixed; 
    }
  </style>

  <div class="bok-modal-makeReservation">
    <div class="bok w-50">
      <div class="bok-modal-header">
        <h4 class="mt-2 mb-2">
          Make Reservation
        </h4>
        <i class="close-modal fa-solid fa-x"></i>
      </div>
      <form id="reservationForm"  enctype="multipart/form-data" method='post' action="api/makeAppoinment.php" class="mt-4">
        <div class="step-container mb-4">
          <div class="step" id="step-1">
            Reservation Details
            <i class="fa-solid fa-check"></i>
          </div>
          <div class="step" id="step-2">
            Equipments
            <i class="fa-solid fa-check"></i>
          </div>
          <div class="step" id="step-3">
            Venue
            <i class="fa-solid fa-check"></i>
          </div>
        </div>

      <div class="tab mt-4" id = "tab-1">
        <div class="form-floating mt-4 mb-3">
          <input required id="client_name" type="text" name="client_name" class="form-control form-control-sm" placeholder="Starting Date">
          <label for="floatingInput">Client Name</label>
        </div>
        <div class="form-floating mt-4 mb-3">
          <input required id="starting_date" type="date" name="start_date" class="form-control form-control-sm" placeholder="Starting Date">
          <label for="floatingInput">Starting Date</label>
        </div>
        <div class="form-floating mt-4 mb-3">
          <input required id="ending_date" type="date" name="end_date" class="form-control" placeholder="Ending Date">
          <label for="floatingInput">Ending Date</label>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Description</label>
          <textarea required name='description' class="form-control" id="reservation_descriptions" rows="3"></textarea>
        </div>
        <label class="btn btn-primary w-100" onclick="run(1, 2);">Next</label>
      </div>

      <div class="tab" id = "tab-2">
        <h5 class="modal-content-title">Add Equipment: </h5>
        <div class="equipment-table">
          <?php
            $getAllEquipment = $conn -> query("SELECT * FROM inventory");

            while($equipment = $getAllEquipment -> fetch_array()){
              echo "
                <div class='equipment' id='".$equipment['serial_code']."'>
                  <p class='col'>".$equipment['name']."</p>
                  <p class='col'>Available: ".$equipment['available']."</p>
                  <div class='col order'>
                    <p>Order: </p>
                    <input name='item_quantity[".$equipment['serial_code']."][]' type='number' class='form form-control form-control-sm' min='0' value='0' max='".$equipment['available']."'>
                  </div>
                </div>
              ";
            }
          ?>
        </div>

        <div class="index-btn-wrapper">
          <!-- <label class="btn btn-secondary" onclick="run(2, 1);">Previous</label> -->
          <label class="btn btn-primary" onclick="run(2, 3);">Next</label>
        </div>
      </div>
      <div class="tab" id = "tab-3">
        <select required name='venue' class="form form-control mb-3">
          <option value="Covered Court">Covered Court</option>
          <option value="Barangay Hall">Barangay Hall</option>
        </select>
        <div class="index-btn-wrapper">
          <!-- <label class="btn btn-secondary" onclick="run(2, 1);">Previous</label> -->
          <button type="submit" class="btn btn-primary" onclick="run(2, 3);">Complete</button>
        </div>
      </div>
    </form>
    </div>
  </div>

  <div class="bok-modal">
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

  <div class="backdrop">
    <div class="spinner-border text-light" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <header>
    <a href="#default" name='default' id="brand">KIPOINT</a>
    <div class="navigators"> 
      <button class='make-reservation'>
        <i class="fa-solid fa-plus me-1"></i>
        <p>Make Reservation</p>
      </button>
      <a href="#appointment" class='navigate' name='appointment'>
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
          <a class="changePasswordButton">
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

  <script>
    function changeRoute(route){

      if(route == 'default'){
        $('.root').hide().load('views/default.php').fadeIn('250');
      }else {
        $('.root').hide().load(`views/${route}.php`).fadeIn('250');
      }
    }

    $(document).ready(function(){
      var route;
      
      var hashed_url = window.location.hash;
      var lastURL = hashed_url.split("#");
      
      if(lastURL[1] == undefined){
        changeRoute('default');
      }else {
        changeRoute(lastURL[1]);
      }

      // $('#reservationForm').submit(function(event){
      //   event.preventDefault();
      //   var formdata = $(this).formToJson();

      //   console.table(formdata);
      // })


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

      $('.make-reservation').click(function(){
        $('.bok-modal-makeReservation').css('display', 'flex');
      })

      $('.changePasswordButton').click(function(){
        $('.bok-modal').css('display', 'flex');
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
    })
  </script>
  <script>
      // Default tab
      $(".tab").css("display", "none");
      $("#tab-1").css("display", "block");

      function run(hideTab, showTab){
        if(hideTab < showTab){ // If not press previous button
          // Validation if press next button
          var currentTab = 0;
          x = $('#tab-' + hideTab);
          y = $(x).find("input")
          for (i = 0; i < y.length; i++){
            if (y[i].value == ""){
              $(y[i]).css("background", "#ffdddd");
              return false;
            }
          }
        }

        // Progress bar
        for (i = 1; i < showTab; i++){
          $("#step-" + i).css("opacity", "1");
          $("#step-" + i).css("color", "#fff");
          $("#step-" + i).css("background-color", "green");
          $("#step-" + (i + 1)).css({
            'background-color': '#fff',
            'border': '1px rgb(202, 202, 202) solid',
            'color': 'rgb(157, 157, 157)',
            'opacity': '1'
          });
        }

        // Switch tab
        $("#tab-" + hideTab).css("display", "none");
        $("#tab-" + showTab).css("display", "block");
        $("input").css("background", "#fff");
      }
    </script>
</body>
</html>
<?php
  $conn -> close();
  }
?>