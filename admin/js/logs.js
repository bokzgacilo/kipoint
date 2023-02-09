function getAllLogs(){
  $.ajax({
    type: 'get',
    url: 'api/getAllLogs.php',
    success: (response) => {
      $('.logs-container').html(response)
    }
  })
}

$(document).ready(function(){
  getAllLogs();
})