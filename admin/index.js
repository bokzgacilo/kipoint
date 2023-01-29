var route;
var hashed_url = window.location.hash;
var lastURL = hashed_url.split("#");

$(document).ready(function(){
  if(sessionStorage.getItem("name") == null || sessionStorage.getItem("name") == ""){
    window.location.replace("login.html#error=No Signed In Account");
  }

  if(lastURL[1] == undefined){
    changeRoute('reservation');
  }else {
    changeRoute(lastURL[1]);
    $("[name='"+lastURL[1]+"']").addClass('active');
  }

  $('.modal-opener').click(function(){
    openModal($(this).attr('name'));
  })
  
  $('.avatar').click(function(){
    $("#account-sidebar").css({
      'display' : 'flex',
    });

    $("#account-sidebar").animate({
      'opacity' : '1'
    }, 250, () => {
      $("#account-sidebar .sidebar-content").animate({
          "right" : "0" 
      }, 250)
    });
  })

  $('.close-sidebar').click(function() {
    $("#account-sidebar .sidebar-content").animate({
      "right" : "-100%"
    }, 500, () => {
      $("#account-sidebar").animate({
          'opacity' : '0'
      }, 150, () => {
        $("#account-sidebar").css({
          'display' : 'none',
        });
      })
    });
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

// FUNCTIONS

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

function validateInput(name){
  if(
    $('#input-' + name + 'a').val() != '' &&
    $('#input-' + name + 'b').val() != ''
  ){
    return true;
  }
}
