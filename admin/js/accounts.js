function deleteUser(id){
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'get',
        url: 'api/deleteUseraccount.php',
        data: {userID: id},
        beforeSend: () => {
          $('.backdrop').css({'display':'flex'})
        },
        success: (response) => {
          getAllResident();
          console.log(response)
          $('.backdrop').css({'display':'none'})
        }
      })
    }
  })
}

function changePasskey(id){
  $('#changePasskey').css({'display':'flex'});
}

function getAllResident(){
  $.ajax({
    type: 'get',
    url: 'api/getAllUseraccounts.php',
    success: function(response){
      $('.account-list').html(response)
    }
  })
}

$(document).ready(function(){
  getAllResident();

  $('#accountSearchButton').click(function(){
    var parameter = $('#accountSearchInput').val();

    $.ajax({
      type: 'get',
      url: 'api/getSearchAccount.php',
      data: {
        param : parameter
      },
      beforeSend: () => {
        $('.backdrop').css({'display' : 'flex'})
      },
      success: (response) => {
        $('.account-list').html(response)

        $('.backdrop').css({'display' : 'none'})
      }
    })
  })

  $('#importExcelFile').submit(function(event){
    event.preventDefault();

    var form = $('#importExcelFile')[0];
    var data = new FormData(form);

    $.ajax({
      type: 'post',
      url: 'api/postNewUserBatch.php',
      data: data,
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      beforeSend: () => {
        $('.backdrop').css({'display' : 'flex'})
      },
      success: (response) => {
        $('#uploadExcelAccount').css({'display' : 'none'});
        $('#importExcelFile')[0].reset();

        Swal.fire(
          'New Accounts Added!',
          'success'
        )

        $('.backdrop').css({'display' : 'none'});
        getAllResident();
      }
    })
  })

  $('.add-new-data').click(function(){
    $("#uploadExcelAccount").css({'display' : 'flex'})
  })

  $('#search-resident').keyup(function(){
    var searchword = $(this).val();

    if(searchword == ''){
      getAllResident();
    }else {
      $.ajax({
        type: 'get',
        url: 'api/searchResident.php',
        data: {
          keyword : searchword
        },
        success: function(response){
          $('.resident-list').html(response);
        }
      })
    }
  })
})