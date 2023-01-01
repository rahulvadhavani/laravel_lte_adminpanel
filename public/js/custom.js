var csrf_token = $('meta[name=csrf-token]').attr('content');
$(".backdrop_static").modal({
  show: false,
  backdrop: 'static'
});

function load_preview_image(input, div = "preview_div", imgDiv = 'image_preview') {
  let imgParentDiv = `#${div}`;
  let imgPreiwDiv = `#${imgDiv}`;
  console.log(imgParentDiv, imgPreiwDiv);
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
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
function reload_data() {
  $('#data_table_main').DataTable().ajax.reload();
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
            $('#data_table_main').DataTable().ajax.reload();
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
  });
}

$(function () {
  // Handle click on "Select all" control
  $('#delete-select-checkbox').on('click', function () {
    if (!this.checked) {
      $("#delete_selected").prop('disabled', true);
    } else {
      $("#delete_selected").prop('disabled', false);
    }
    $('.dt_checkbox').prop('checked', this.checked);
  });

  // Handle click on checkbox to set state of "Select all" control
  $('#data_table_main tbody').on('change', 'input[type="checkbox"]', function () {
    if (!this.checked) {
      var checked = $("#data_table_main tbody input[type='checkbox']:checked").length;
      if (checked == 0) {
        $("#delete_selected").prop('disabled', false);
      }
      var el = $('#delete-select-checkbox').get(0);
      if (el && el.checked && ('indeterminate' in el)) {
        el.indeterminate = true;
      }
    } else {
      $("#delete_selected").prop('disabled', false);
    }
  });

  // Handle form submission event
  $('#delete_selected').on('click', function (e) {
    // 
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
        var form = $("#form_delete_selected");
        let delete_selected_url = $('#delete_selected_url').val();
        $.ajax({
          type: "post",
          url: delete_selected_url,
          data: form.serialize(),
          dataType: "json",
          success: function (response) {
            console.log(response);
            if (response.status) {
              toastr.success(response.message);
              $('#data_table_main').DataTable().ajax.reload();
              $("#delete_selected").prop('disabled', true);
              $('#delete-select-checkbox').prop('checked',false);
            } else {
              toastr.error(response.message);
            }
          },
          error: function () {
            toastr.error('Please Reload Page.');
          }
        });
      }
    })
  });
});