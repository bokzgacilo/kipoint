var eventHashID, eventID;
var equipmentArray = [];
var equipmentArrayWithValue = [];

function getEventDetails(id){
  $.ajax({
    type: 'get',
    url: 'api/getEventDetails.php',
    data: {
      id: id
    },
    success: (response) => {
      $('#event-article').html(response);
    }
  })
} 

function handleChangeEquipment(serial_code){
  var newObject;
  var item_value = $('#' + serial_code).val();

  equipmentArray.push(serial_code);
}

function removeDuplicates(array){
  return array.filter((el, index) => array.indexOf(el) === index);
}

function populateEquipmentTable(){
  $.ajax({
    type: 'get',
    url: 'api/getEquipmentItems.php',
    success: (response) => {
      $('.equipment-body').html(response)
    }
  })
}

function makeReservation(){
  $('#makeReservation').css({
    'display' : 'flex'
  })

  populateEquipmentTable();
}

function openMyReservation(id){
  $.ajax({
    type: 'get',
    url: 'api/getMyReservationDetails.php',
    data: {
      id: id
    },
    beforeSend: () => {
      $('.backdrop').css({
        'display' : 'flex'
      })
    },
    success: (response) => {
      $('.backdrop').css({
        'display' : 'none'
      })
      $('#myReservation').css({'display' : 'flex'});
      $('.my-reservation-detail').html(response)
    }
  })
}

function getMyReservation(){
  $.ajax({
    type: 'get',
    url: 'api/getMyReservation.php',
    data: {
      username: sessionStorage.getItem('username')
    },
    success: (response) => {
      $('.my-reservation').html(response);
    }
  })
}

function getFirstEvent(){
  $.ajax({
    type: 'get',
    url: 'api/getFirstEvent.php',
    success: (response) => {
      $('#event-article').html(response);
    }
  })
}

function changeEvent(id){
  window.location.hash = "eventID=" + id;
  getEventDetails(id);
}

function getEvent(){
  $.ajax({
    type: 'get',
    url: 'api/getEvents.php',
    success: (response) => {
      $('.menu-list').html(response);
    }
  })
} 

function postComment(id){
  $("form[name='"+id+"']").submit(function(event){
    event.preventDefault();

    var comment = $("form[name='"+id+"'] input").val();
    var username = '';

    if($('#anonymousSwitch').is(":checked")){
      username = 'Anonymous User';
    }else {
      username = sessionStorage.getItem('username');
    }

    $.ajax({
      type: 'post',
      url: 'api/postComment.php',
      data: {
        id: id,
        username: username,
        message: comment
      },
      beforeSend: () => {
        $('.backdrop').css({
          'display' : 'flex'
        })
      },
      success: (response) => {
        console.log(response)

        Swal.fire({
          title: 'Comment Posted',
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Continue'
        }).then((result) => {
          if (result.isConfirmed) {
            if(eventHashID != undefined){
              changeEvent(eventID);
            }else {
              getFirstEvent();
            }
            $('.backdrop').css({
              'display' : 'none'
            })
          }
        })
      }
    })
  })
}

$(document).ready(function(){
  if(sessionStorage.getItem("username") == null ||sessionStorage.getItem("username") == ""){
    window.location.replace('index.html#error=No Signed In Account');
  }

  if(window.location.href != 'http://localhost/kipoint/client/dashboard.html'){
    eventHashID = window.location.href.split('#')[1];
    eventID = eventHashID.split('=')[1];
    changeEvent(eventID);
  }else {
    getFirstEvent();
  }

  getMyReservation();
  getEvent();

  $('#reservationForm').submit(function(event){
    event.preventDefault();
    let i = 0;

    var desc = $('#event_description').val();
    var venue = $('#venue_dropdown').val();
    var starting_date = $("#starting_date").val();
    var ending_date = $("#ending_date").val();
    
    while (i < removeDuplicates(equipmentArray).length) {
      var element = $("#" + removeDuplicates(equipmentArray)[i]).val();
      var itemOBJ = {
        "serial_code" : removeDuplicates(equipmentArray)[i],
        "item_count" : element
      };

      equipmentArrayWithValue.unshift(itemOBJ)
      i++;
    }

    $.ajax({
      type: 'post',
      url: 'api/postRequestReservation.php',
      data: {
        desc: desc,
        venue: venue,
        starting_date: starting_date,
        ending_date: ending_date,
        client_name: sessionStorage.getItem("username"),
        equipmentArray: JSON.stringify(equipmentArrayWithValue)
      },
      beforeSend: () => {
        $('.backdrop').css({'display' : 'flex'})
      },
      success: (response) => {
        console.log(response)
        Swal.fire({
          title: 'Requested Successfully',
          text: "Your reservation was successfully requested.",
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ok'
        }).then((result) => {
          getMyReservation();
          getEvent();
          
          $('#reservationForm')[0].reset();
          $('.backdrop').css({'display' : 'none'})
          $('.close-modal').click();
        })
      }
    })
  })

  $('.close-modal').click(function(){
    $(this).parent().parent().parent().css({
      'display' : 'none'
    })
  })

  $('.account img').click(function(){
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
})