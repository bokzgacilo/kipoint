function getAllOfficials(){
  $.ajax({
    type: 'get',
    url: 'api/getAllOfficials.php',
    success: (response) => {
      $('.official-list').html(response);
    }
  })
}

function deleteOfficial(id){
  Swal.fire({
    title: 'Are you sure to remove this Barangay Official?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, I am sure!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'get',
        url: 'api/deleteOfficial.php',
        data: {officialID: id},
        beforeSend: () => {
          $('.backdrop').css({'display':'flex'})
        },
        success: (response) => {
          getAllOfficials();
          console.log(response)
          $('.backdrop').css({'display':'none'})
        }
      })
    }
  })
}

$(document).ready(function(){
  getAllOfficials();

  $('#newProfilePic').change(function(){
    const file = this.files[0];
      if (file){
        let reader = new FileReader();
        reader.onload = function(event){
          $('#imagePreview').attr('src', event.target.result);
        }
        reader.readAsDataURL(file);
      }
  })

  $('.addSingleOfficial').click(function(){
    $('#addSingleOfficial').css({'display':'flex'});
  })

  $('#addSingleOfficialForm').submit(function(event){
    var files = $('#newProfilePic')[0].files;
    var offfullname = $('#offFullname').val();
    var offposition = $('#offPosition').val();
    var offcontact = $('#offContact').val();

    var formData = new FormData();
    formData.append('officialPhoto', files[0]);
    formData.append('officialFullname', offfullname);
    formData.append('officialPosition', offposition);
    formData.append('officialContact', offcontact);

    $.ajax({
      url: 'api/postNewOfficial.php',
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: () => {
        $('.backdrop').css('display', 'flex');
      },
      success: function(response){
        $('.backdrop').css({'display' : 'none'})

        if(response == 1){
          Swal.fire(
            'New Barangay Official Added',
            offfullname + ' was added to Kipoint',
            'success'
          )

          $('.bok-modal').css({'display':'none'})
          getAllOfficials();
        }
      }
    })
  })
})