var date = new Date()
var d = date.getDate(), m = date.getMonth(), y = date.getFullYear();
var calendar;
var Calendar = FullCalendar.Calendar;

function getAllAcceptedEvents(){
  $.ajax({
    type: 'get',
    url: 'api/getAllAcceptedEvents.php',
    success: function(response){
      $('#accepted-events').html(response)
    }
  })
}

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

function generateDetails(id){
  $.ajax({
    type: 'get',
    url: 'api/getEventDetails.php',
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

function closeModal(){

}

function cancelEvent(id){
  alert(id)
}

function getCalendarItem(item){
  var schedules = $.parseJSON(item)
  var events = [];
  for(var key in schedules) {
    if (schedules.hasOwnProperty(key)) {
      events.push({ 
        id: schedules[key].requestID,
        title: schedules[key].client_name, 
        start: schedules[key].starting_date, 
        end: schedules[key].ending_date
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
  getAllAcceptedEvents();
  getAllDoneEvents();
  getAllRequestedEvents();
  getAllCancelledEvents();
}

$(document).ready(function(){
  $('.close-modal').click(function(){
    $(this).parent().parent().parent().css('display', 'none');
  })

  getAllEvents();
  getIncomingEvent();
  renderCalendar();
})