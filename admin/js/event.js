var date = new Date()
var d = date.getDate(), m = date.getMonth(), y = date.getFullYear();
var calendar;
var Calendar = FullCalendar.Calendar;

function getAllDoneEvents(){
  $.ajax({
    type: 'get',
    url: 'api/getAllDoneEvents.php',
    success: function(response){
      $('#done-events').html(response)
    }
  })
}

function getAllRequestedEvents(){
  $.ajax({
    type: 'get',
    url: 'api/getAllRequestedEvents.php',
    success: function(response){
      $('#requested-events').html(response)
    }
  })
}
function getAllCancelledEvents(){
  $.ajax({
    type: 'get',
    url: 'api/getAllCancelledEvents.php',
    success: function(response){
      $('#cancelled-events').html(response)
    }
  })
}

function getIncomingEvent(){
  $.ajax({
    type: 'get',
    url: 'api/getIncomingEvent.php',
    success: function(response){
      $('.incoming-event').html(response)
    }
  })
}

function acceptEvent(id){
  $.ajax({
    type: 'post',
    url: 'api/acceptEvent.php',
    data: {requestID: id},
    beforeSend: () => {
      $('.backdrop').css({'display' : 'flex'})
    },
    success: (response) => {
      Swal.fire(
        'Event Accepted!',
        'Requested event was moved to accepted and can be shown to the Calendar.',
        'success'
      )
      closeModal();
    },
    complete: () => {
      $('.backdrop').css({'display' : 'none'})
      getAllEvents();
      renderCalendar();
    }
  })
}


function openDoneEvent(id){
  $.ajax({
    type: 'get',
    url: 'api/getDoneEventDetails.php',
    data: {
      requestID: id
    },
    beforeSend: () => {

    },
    success: (response) => {
      $('#event-detail-body').html(response)
    },
    complete: () => {
      openModal('eventDetails')
    }
  })
}

function postReschedule(formID){
  var form = '#' + formID + 'form';
  $(form).submit(function(event){
    event.preventDefault();

    var setRescheduleDate = $('#reschedRange').val();

    $.ajax({
      type: 'post',
      url: 'api/rescheduleEvent.php',
      data: {
        requestID: formID,
        days: setRescheduleDate
      },
      beforeSend: () => {
        $('.backdrop').css({'display':'flex'})
      },
      success: (response) => {
        if(response == 1){
          Swal.fire(
            'Event Rescheduled!',
            'Event ' + formID + ' has new starting and ending dates.',
            'success'
          )
    
          closeModal();
          $('.backdrop').css({'display':'none'})
        }

        getAllEvents();
        renderCalendar();
        getServingEvent();
      }
    })
  })
}

function reviewFirstEvent(id){
  $.ajax({
    type: 'get',
    url: 'api/getFirstEvent.php',
    data: {
      requestID: id
    },
    beforeSend: () => {

    },
    success: (response) => {
      $('#request-body').html(response)
    },
    complete: () => {
      $('#requestDetails').css({
        'display' : 'flex'
      })
    }
  })
}

function getServingEvent(){
  $.ajax({
    type: 'get',
    url: 'api/getCurrentServingEvent.php',
    success: (response) => {
      $('#now-serving-event').html(response)
    }
  })
}

function reviewEvent(id){
  $.ajax({
    type: 'get',
    url: 'api/getRequestDetails.php',
    data: {
      requestID: id
    },
    beforeSend: () => {

    },
    success: (response) => {
      $('#request-body').html(response)
    },
    complete: () => {
      $('#requestDetails').css({
        'display' : 'flex'
      })
    }
  })
}

function viewCancelled(id){
  $.ajax({
    type: 'get',
    url: 'api/getCancelledEvents.php',
    data: {
      requestID: id
    },
    beforeSend: () => {

    },
    success: (response) => {
      $('#cancelled-body').html(response)
    },
    complete: () => {
      $('#cancelledDetails').css({
        'display' : 'flex'
      })
    }
  })
}

function genereteReceipt(id){
  alert()
}

function cancelEvent(id){
  $.ajax({
    type: 'post',
    url: 'api/cancelEvent.php',
    data: {requestID: id},
    beforeSend: () => {
      $('.backdrop').css({'display' : 'flex'})
    },
    success: (response) => {
      Swal.fire(
        'Event Cancelled!',
        'Event was moved to cancelled',
        'success'
      )

      closeModal();
    },
    complete: () => {
      $('.backdrop').css({'display' : 'none'})
      getAllEvents();
      renderCalendar();
      getServingEvent();
    }
  })
}

function getCalendarItem(item){
  var schedules = JSON.parse(item);
  var events = [];
  for(var key in schedules) {
    if (schedules.hasOwnProperty(key)) {
      events.push({ 
        id: schedules[key].requestID,
        title: schedules[key].client_name, 
        start: schedules[key].sdate, 
        end: schedules[key].edate
      });
    }
  }

  calendar = new Calendar(document.getElementById('calendar'), {
  headerToolbar: {
    left: 'prev,next today',
    right: 'dayGridMonth,dayGridWeek,list',
    center: 'title',
  },
  selectable: true,
  themeSystem: 'default',
  events: events,
  eventClick: function(info) {
    var id = info.event.id
    generateDetails(id)
  },
  eventDidMount: function(info) {
  },
  editable: false
  });
  calendar.render();
}

function renderCalendar(){
  $.ajax({
    type: 'get',
    url: 'api/getCalendar.php',
    success: function(response){
      getCalendarItem(response);
    }
  })
}

function getAllEvents(){
  getAllDoneEvents();
  getAllRequestedEvents();
  getAllCancelledEvents();
}

function rescheduleEvent(id){
  $('.event-title').text('Reschedule Event: ' + id);
  $('#rescheduleEvent').css({'display':'flex', 'z-index': '102'})

  $.ajax({
    type: 'get',
    url: 'api/getRescheduleDetails.php',
    data: {requestID:id},
    beforeSend: () => {
      $('.backdrop').css({'display':'flex'})
    },
    success: (response) => {
      $('.rescheduleForm').html(response)

      $('.backdrop').css({'display':'none'})
    }
  })
}

function processDone(){
  $.ajax({
    type: 'get',
    url: 'api/processDone.php',
    success: (response) => {
      console.log(response)
    }
  })
}

$(document).ready(function(){
  $('.close-modal').click(function(){
    $(this).parent().parent().parent().css('display', 'none');
  })

  getServingEvent();
  processDone();
  getAllEvents();
  getIncomingEvent();
  renderCalendar();
})