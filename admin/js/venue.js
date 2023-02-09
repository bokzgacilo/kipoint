function getAllVenue(){
  $.ajax({
    type: 'get',
    url: 'api/getAllVenue.php',
    success: (response) => {
      $('.venue-container').html(response)
    }
  })
}

function removeVenue(id){
  
}

function cancelEvent(id){
  
}

function openAddNewVenueModal(){
  $('#addNewVenue').css({'display' : 'flex'})
}


$(document).ready(function(){
  getAllVenue();

  $('#addNewVenueForm').submit(function(event){
    event.preventDefault();

    var venueName = $('#newVenueName').val();
    var venueAddress = $('#newVenueAddress').val();

    $.ajax({
      type: 'post',
      url: 'api/postNewVenue.php',
      data: {
        venueName: venueName,
        venueAddress: venueAddress
      },
      beforeSend: () => {
        $('.backdrop').css({'display':'flex'})
      },
      success: (response) => {
        if(response == 1){
          Swal.fire(
            'Venue Added',
            'Clients can now reserve to this venue',
            'success'
          )
  
          getAllVenue();
          closeModal();
  
          $('#addNewVenueForm')[0].reset();
          $('.backdrop').css({'display':'none'})
        }else {
          Swal.fire(
            'Something went wrong',
            'Kipoint is not responding',
            'error'
          )
        }
      }
    })

  })

  $('#venueSearchButton').click(function(){
    var parameter = $('#venueSearchInput').val();

    $.ajax({
      type: 'get',
      url: 'api/getSearchVenue.php',
      data: {
        param : parameter
      },
      beforeSend: () => {
        $('.backdrop').css({'display':'flex'});
      },
      success: (response) => {
        $('.venue-container').html(response)

        $('.backdrop').css({'display':'none'});
      }
    })
  })
})