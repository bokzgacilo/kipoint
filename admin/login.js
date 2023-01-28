// Whitespace Checker
function containsWhitespace(str) {
  var specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=";
  return /\s/.test(str);
}

function bothTrue(user, pass){
  console.log(user + ':' + pass);

  if(user == true && pass == true){
    $('#register-button').removeAttr('disabled');
  }else {
    $('#register-button').attr('disabled');
  }
}

$(document).ready(function(){
  var reg_password, reg_username;
  var reg_password_bool = false;
  var reg_username_bool = false;

  $('.close-modal').click(function(){
    $(this).parent().parent().parent().css('display', 'none');
  })

  $('#password-register').keyup(function(){
    var password = $(this).val();

    if(containsWhitespace(password) || /^[a-zA-Z0-9- ]*$/.test(password) == false){
      reg_password_bool = false;
      
      var invalid_element = "<div>"+
        "<i class='fa-solid fa-circle-exclamation me-2'></i>" +
        "Invalid. Password has whitespace or special characters. " +
      "</div>";

      $('#passwordFeedback').css({
        'display':'flex',
        'color':'red'
      })

      $('#passwordFeedback').html(invalid_element);
    }else {
      reg_password_bool = true;
      bothTrue(reg_username_bool, reg_password_bool);
      reg_password = password;

      var valid_element = "<div>"+
        "<i class='fa-solid fa-check me-2'></i>" +
        "Valid " +
      "</div>";

      $('#passwordFeedback').css({
        'display':'flex',
        'color':'green'
      }) 

      $('#password-register').css({
        'border': '2px green solid'
      })

      $('#passwordFeedback').html(valid_element);
    }

    if(password == '' || password == ' '){
      reg_password_bool = false;

      $('#passwordFeedback').css({
        'display':'none',
      })

      $('#password-register').css({
        'border': '1px solid #ced4da'
      })
    }
  })

  $('#username-register').keyup(function(){
    var username = $(this).val();

    if(containsWhitespace(username) || /^[a-zA-Z0-9- ]*$/.test(username) == false){
      reg_username_bool = false;
      
      var invalid_element = "<div>"+
        "<i class='fa-solid fa-circle-exclamation me-2'></i>" +
        "Invalid. Username has whitespace or special characters. " +
      "</div>";

      $('#usernameFeedback').css({
        'display':'flex',
        'color':'red'
      })

      $('#usernameFeedback').html(invalid_element);
    }else {
      reg_username_bool = true;
      bothTrue(reg_username_bool, reg_password_bool);
      reg_username = username;

      var valid_element = "<div>"+
        "<i class='fa-solid fa-check me-2'></i>" +
        "Valid " +
      "</div>";

      $('#usernameFeedback').css({
        'display':'flex',
        'color':'green'
      }) 

      $('#username-register').css({
        'border': '2px green solid'
      })

      $('#usernameFeedback').html(valid_element);
    }

    if(username == '' || username == ' '){
      reg_username_bool = false;

      $('#usernameFeedback').css({
        'display':'none',
      })

      $('#username-register').css({
        'border': '1px solid #ced4da'
      })
    }
  })

  $('#register-form').submit(function(e){
    e.preventDefault();
    $('.backdrop').css('display', 'flex');
    var fullname = $('#fullname-register').val();
    $.ajax({
      type: 'post',
      url: 'api/register.php',
      data: {
        username: reg_username,
        password: reg_password,
        fullname: fullname
      },
      success: function(response){
        setTimeout(function(){
          $('.backdrop').css('display', 'none');
          Swal.fire({
            title: 'Success!',
            text: 'Account has been successfully registered.',
            icon: 'success',
            confirmButtonText: 'Close'
          })
          $('#register-form')[0].reset();
        }, 2500)   
      }
    })
  })

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
        const resp = JSON.parse(response);
        setTimeout(function(){
          $('.backdrop').css('display', 'none');
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
        }, 2500)
      }
    })
  })
})

