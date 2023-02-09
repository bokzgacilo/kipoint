$(document).ready(function(){
  $('#userFormLogin').submit((event) => {
    event.preventDefault();

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
      type: 'post',
      url: 'api/login.php',
      data: {
        username: username,
        password: password
      },
      beforeSend: () => {

      },
      success: (response) => {
        if(response == 0){
          Swal.fire(
            'Error',
            'Username is not registered',
            'error'
          )
        }

        if(response == 1){
          Swal.fire({
            title: 'Successfully Logged In',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Open Dashboard'
          }).then((result) => {
            if (result.isConfirmed) {
              sessionStorage.setItem('username', $("#username").val());
              window.location.replace("dashboard.html");
            }
          })
        }

        if(response == 2){
          Swal.fire(
            'Incorrect Password',
            'Please make sure caps lock is off.',
            'error'
          )
        }
      }
    })
  })
})