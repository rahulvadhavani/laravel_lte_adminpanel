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
              <button class="btn btn-dark float-right" onclick="addModel()"><i class="fa fa-plus" aria-hidden="true"></i> Add User</button>
            </div>
          </div>
          <form id="frm-example" method="post">
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped w-100">
                <thead>
                  <tr>
                    <th>#</th>
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
    var table = $('#example1').DataTable({
      processing: true,
      serverSide: true,
      // dom: 'Bfrtip',
      buttons: [],
      ajax: "{{ route('users.index') }}",
      "order": [],
      columnDefs: [{
        orderable: false,
        targets: [0, 5]
      }],
      select: {
        style: 'multi'
      },
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false },
        { data: 'first_name', name: 'first_name' },
        { data: 'last_name',  name: 'last_name'  },
        { data: 'email', name: 'email' },
        { data: 'image', name: 'image', searchable: false },
        { data: 'actions', name: 'actions', searchable: false }
      ],
    });
  });
</script>
@endpush