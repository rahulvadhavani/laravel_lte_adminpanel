@extends('layouts.admin_app')
@push('style')
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
@endpush
@section('content')
@include('admin.breadcrumb')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All user lists</h3>
            <div class="text-right">
              <button class="btn btn-sm btn-dark float-right  ml-2" onclick="addModel()"><i class="fa fa-plus" aria-hidden="true"></i> Add User</button>
              <button id="delete_selected" class="btn btn-sm btn-danger float-right" disabled>Delete Selected</button>
            </div>
          </div>
          <form id="form_delete_selected" method="post">
            @csrf
            <div class="card-body">
              <table id="data_table_main" class="table table-bordered table-striped w-100">
                <thead>
                  <tr>
                    <th class="text-center"><input type="checkbox" name="select_all" value="1" id="delete-select-checkbox"></th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </form>
          <input type="hidden" id="delete_selected_url" value="{{route('users.delete-selected')}}">
        </div>
      </div>
    </div>
  </div>
</section>
@include('users.modal')
@endsection
@push('script')
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/custom/users.js')}}"></script>
<script>
  $(document).ready(function() {
    // Get user data
    var table = $('#data_table_main').DataTable({
      processing: true,
      serverSide: true,
      // dom: 'Bfrtip',
      buttons: [],
      ajax: "{{ route('users.index') }}",
      "order": [],
      columnDefs: [{
        'targets': [0],
        'searchable': false,
        'orderable': false,
        'className': 'dt-body-center',
        'render': function(data, type, full, meta) {
          return '<input type="checkbox" class="dt_checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
        }
      }],
      select: {
        style: 'multi'
      },
      columns: [{
          data: 'id',
          name: 'id',
          searchable: false
        },
        {
          data: 'first_name',
          name: 'first_name'
        },
        {
          data: 'last_name',
          name: 'last_name'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'image',
          name: 'image',
          searchable: false
        },
        {
          data: 'actions',
          name: 'actions',
          searchable: false,
          orderable: false,
        }
      ],
    });
  });
</script>
@endpush