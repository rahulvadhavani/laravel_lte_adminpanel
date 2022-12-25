var csrf_token = $('meta[name=csrf-token]').attr('content');
$(document).ready( function () {
    $("#add_edit_user_modal,#view_user_modal,#add_edit_category_modal,#import_excel").modal({
      show:false,
      backdrop:'static'
    });

    // Multiple delete checkbox click event
    $('#example1').on('change', 'tbody,thead input.dt-checkboxes', function () {
        var rows_selected = $('#example1').DataTable().column(0).checkboxes.selected();
        if(rows_selected.length){
          $("#multiple_delete_btn").prop('disabled', false);
        } else {
          $("#multiple_delete_btn").prop('disabled', true);
        } 
    });
});

function load_preview_image(input,div="preview_div",imgDiv='image_preview') {
  let imgParentDiv = `#${div}`;
  let imgPreiwDiv = `#${imgDiv}`;
  console.log(imgParentDiv,imgPreiwDiv);
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $(imgParentDiv).show();
          $(imgPreiwDiv).attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
  } else {
    $(imgParentDiv).hide();
  }
}

function Validateusername(evt) {
  var keyCode = (evt.which) ? evt.which : evt.keyCode
  if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && (keyCode < 48 || keyCode > 58) && keyCode != 46 && keyCode != 95 && keyCode != 13)
      return false;
  else
      return true;
}

// reload datatables
function reload_data(){
    $('#example1').DataTable().ajax.reload();
}

// delete modal
function deleteRecordModule(id, url) {
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
              type: 'DELETE',
              data: {
                  _method: 'DELETE'
              },
              url: url,
              headers: {
                  'X-CSRF-TOKEN': csrf_token
              },
              success: function (response) {
                  if (response.status) {
                      $('#example1').DataTable().ajax.reload();
                      Swal.fire(
                          'Deleted!',
                          response.message,
                          'success'
                      )
                  } else {
                      Swal.fire(
                          'error!',
                          response.message,
                          'error'
                      )
                  }
              },
              error: function () {
                  toastr.error('Please Reload Page.');
              }
          });
      }
  })
}

  function deleteRecordModule(id, url) {
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
          type: 'DELETE',
          data: {
            _method: 'DELETE'
          },
          url: url,
          headers: {
            'X-CSRF-TOKEN': csrf_token
          },
          success: function(response) {
            if (response.status) {
              $('#example1').DataTable().ajax.reload();
              Swal.fire(
                'Deleted!',
                response.message,
                'success'
              )
            } else {
              Swal.fire(
                'error!',
                response.message,
                'error'
              )
            }
          },
          error: function() {
            toastr.error('Please Reload Page.');
          }
        });
      }
    })
  }