// Whitespace Checker
function containsWhitespace(str) {
  var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=";
  return /\s/.test(str);
}

$(document).ready(function(){
  $('.close-modal').click(function(){
    $(this).parent().parent().parent().css('display', 'none');
  })

  $("#loginForm").submit(function(event){
    event.preventDefault();

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
      type: 'post',
      url: 'api/login.php',
      data: {
        username: username,
        password: password,
      },
      beforeSend: () => {
        $('.backdrop').css('display', 'flex');
      },
      success: function(response){
        const resp = JSON.parse(response);

        setTimeout(function(){
          if(resp['status'] == 1){
            sessionStorage.setItem("name", resp['fullname']);
            window.location.href = 'index.html#reservation';
          }else {
            Swal.fire({
              title: 'Error!',
              text: 'Username and password not matched',
              icon: 'error',
              confirmButtonText: 'Retry'
            })
          }

          $('.backdrop').css('display', 'none');
        }, 2500)
      }
    })
  })
})

