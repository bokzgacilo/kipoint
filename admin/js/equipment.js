$('.close-modal').click(function(){
  $(this).parent().parent().parent().css('display', 'none');
})

function getInventory(){
  $.ajax({
    type: 'get',
    url: 'api/getInventory.php',
    success: function(response){
      $('.equipment-container').html(response);
    }
  })
}

function removeItem(id){
  alert(id)
}

$(document).ready(function(){
  $('').addClass('selected');
  getInventory();

  $('#addItemForm').submit(function(event){
    event.preventDefault();
    var item_name = $('#item_name').val();
    var item_serialcode = $('#item_serialcode').val();
    var item_brand = $('#item_brand').val();
    var item_category = $('#item_category').val();
    var item_quantity = $('#item_quantity').val();

    $.ajax({
      type: 'post',
      url: 'api/postAddEquipmentItem.php',
      data: {
        itemName : item_name,
        itemSerialCode : item_serialcode,
        itemBrand : item_brand,
        category : item_category,
        quantity : item_quantity
      },
      beforeSend: () => {
        $('.backdrop').css('display', 'flex');
      },
      success: function(response){
        console.log(response)
        if(response == 1){
          Swal.fire({
            title: 'Item Added',
            text: 'Item was added to inventory.',
            icon: 'success',
            allowOutsideClick: false,
            confirmButtonText: 'Close'
          }).then((result) => {
            if(result.isConfirmed){
              $('.backdrop').css('display', 'none');  
              $('#addItemForm')[0].reset();
              $('.close-modal').click();
            }
          }) 
        }
        getInventory();
      },
      complete: () => {
        $('.backdrop').css('display', 'none');  
      }
    })
  })

})

$('#add-inventory-button').click(function(){
  $('#addInventory').css('display', 'flex');
})

$('.edit').click(function(){
  var target = $(this).parent().parent().attr('id');
  console.log(target)
})

$('.delete').click(function(){
  var target = $(this).parent().parent();
  $('.backdrop').css('display', 'flex');

  setTimeout(function(){
    $('.backdrop').css('display', 'none');
    target.fadeOut('slow');

  }, 400)
})