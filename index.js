

$(document).ready(function(){


  $("#login-form").submit(function(e){
    $('.backdrop').css('display', 'flex');
    e.preventDefault();
    var loginformdata = $(this).formToJson();
    $.ajax({
      type: 'post',
      url: 'api/login.php',
      data: {
        username: loginformdata['username'],
        password: loginformdata['password'],
      },
      success: function(response){
        setTimeout(function(){
          $('.backdrop').css('display', 'none');
          if(response == 'success'){
            window.location.href = 'index.php';
          }else {
            Swal.fire({
              title: 'Error!',
              text: 'Username and password not matched',
              icon: 'error',
              confirmButtonText: 'Retry'
            })
          }
          console.log(response)
        }, 2500)
      }
    })
  })
})