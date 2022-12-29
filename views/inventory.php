<div class="bok-modal-addItem">
  <div class="bok w-50">
    <div class="bok-modal-header">
      <h4 class="mt-2">
        Add Item
      </h4>
      <i class="close-modal fa-solid fa-x"></i>
    </div>
    <form id="addItemForm" class="mb-4">
      <div class="form-floating mt-4 mb-3">
        <input type="text" name="item_Name" class="form-control" placeholder="Item Name">
        <label for="floatingInput">Item Name</label>
      </div>
      <div class="form-floating mt-2 mb-3">
        <input type="text" name="item_SerialCode" class="form-control" placeholder="Serial Code">
        <label for="floatingInput">Serial Code</label>
      </div>
      <div class="form-floating mt-2 mb-3">
        <input type="text" name="item_Brand" class="form-control" placeholder="Item Brand">
        <label for="floatingInput">Item Brand</label>
      </div>
      <div class="form-floating mt-2 mb-3">
        <input type="number" name="quantity" class="form-control" placeholder="Quantity">
        <label for="floatingInput">Quantity</label>
      </div>
      <button id='addItem_Button' class="btn btn-primary btn-lg w-100" type="submit">Add Item</button>
    </form>
  </div>
</div>

<main>
  <h3 class="mb-3" style='font-family: Inter-Bold;'> Inventory</h3>
  <div>
    <button type="button" class="btn btn-primary addItemModalButton">
      Add Item
    </button>

    <div id="InventoryList" class="inventory-tab" style="display: block;">
      <table id='inventory' class="align-middle table table-striped table-sm">
        <!-- API GET INVENTORY ITEM -->
      </table>
    </div>
  </div>
</main>

<style>
  .active {
    color: #fff;
  }

  tr {
    font-size: 14px;
    align-items: center;
  }

  th {
    font-family: Inter-SemiBold;
  }
</style>

<script>
  $('.close-modal').click(function(){
    $(this).parent().parent().parent().css('display', 'none');
  })

  function getInventory(){
    $.ajax({
      type: 'get',
      url: 'api/getInventory.php',
      success: function(response){
        $('#inventory').html(response);
      }
    })
  }

  $(document).ready(function(){

    getInventory();

    $('#addItemForm').submit(function(event){
      event.preventDefault();
      $('.backdrop').css('display', 'flex');
      var formdata = $(this).formToJson();
      // console.log(formdata)
      $.ajax({
        type: 'post',
        url: 'api/AddInventory.php',
        data: {
          itemName : formdata['item_Name'],
          itemSerialCode : formdata['item_SerialCode'],
          itemBrand : formdata['item_Brand'],
          quantity : formdata['quantity']
        },
        success: function(response){
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
          }else {

          }
          
          $('.backdrop').css('display', 'none');  
          getInventory();
        }
      })
    })

  })

  $('.addItemModalButton').click(function(){
    $('.bok-modal-addItem').css('display', 'flex');
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
</script>