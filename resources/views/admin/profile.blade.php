@extends('layouts.admin_app')
@section('content')
@include('admin.breadcrumb')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <label id="profile_img">
                <div id="preview_div">
                  <img id="image_preview" class="image_preview profile-user-img img-fluid img-circle admin_profile" height=150 width=150 src="{{$user->image}}">
                </div>
              </label>
            </div>
            <h3 class="profile-username text-center">{{$user->email??'-'}}</h3>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Followers</b> <a class="float-right">-</a>
              </li>
              <li class="list-group-item">
                <b>Following</b> <a class="float-right">-</a>
              </li>
              <li class="list-group-item">
                <b>Friends</b> <a class="float-right">-</a>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="profile">
                <form id="profile_frm" form_name="profile_frm" method="post" action="{{ route('admin.update_profile') }}">
                  <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Firstname <span class="red">*</span></label>
                          <input type="text" class="form-control" placeholder="Please enter firstname" id="first_name" name="first_name" value="{{$user->first_name}}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Lastname <span class="red">*</span></label>
                          <input type="text" class="form-control" placeholder="Please enter lastname" id="last_name" name="last_name" value="{{$user->last_name}}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Username <span class="red">*</span></label>
                          <input type="text" class="form-control" onkeypress="return Validateusername(event)" placeholder="Please enter username" id="username" name="name" value="{{$user->name}}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Email <span class="red">*</span></label>
                          <input type="read" class="form-control" placeholder="Please enter email" value="{{$user->email}}" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Image</label>
                          <input type="file" name="image" id="image" class="form-control" style="padding: 0.200rem 0.75rem;" placeholder="Enter Select Image" onchange="load_preview_image(this);" accept="image/x-png,image/jpg,image/jpeg">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-indigo btn-flat float-right" id="profile_frm_btn">Update Profile <span style="display: none" id="profile_frm_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="password">
                <form id="password_frm" form_name="password_frm" method="post" action="{{ route('admin.update_password') }}">
                  <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Old Password</label>
                          <input type="password" class="form-control" placeholder="Please enter old password" id="old_password" name="old_password">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control" placeholder="Please enter password" id="password" name="password">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Confirm Password</label>
                          <input type="password" class="form-control" placeholder="Please enter confirm password" id="password_confirmation" name="password_confirmation">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-indigo btn-flat float-right" id="password_frm_btn">Update Password <span style="display: none" id="password_frm_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="settings">
                <form  class="form-horizontal" id="setting_frm" form_name="setting_frm" method="post" action="{{ route('admin.save_setting') }}">
                  <div class="">
                    <div class="form-group row">
                      <label for="support_email" class="col-sm-3 col-form-label">Support Email <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="email" name="support_email" class="form-control" id="support_email" value="{{$settings['support_email']}}" placeholder="Support Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="contact" class="col-sm-3 col-form-label">Contact <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="number" name="contact" class="form-control" id="contact" value="{{$settings['contact']}}" placeholder="Contact">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label">Address <span class="text-danger">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" name="address" class="form-control" value="{{$settings['address']}}" id="address" placeholder="Address">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-6">
                        <label><b>Logo image</b></label>
                        <div class="custom-file">
                          <input name="logo_image" type="file" class="form-control custom-file-input" onchange="load_preview_image(this,'preview_image_logo_div','preview_image_logo');" id="customFile1">
                          <label class="custom-file-label" for="customFile1">Choose file</label>
                        </div>
                      </div>
                      <div class="col-md-6 pt-2" id="preview_image_logo_div">
                        <img id="preview_image_logo" class="preview_image ml-2" width="70" height="70" src="{{$settings['logo_image_url']}}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-12">
                        <b>Social Handles</b>
                      </div>
                      <div class="col-12">
                        <div class="row m-2 p-3">
                          <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                              <label>Facebook</label>
                              <input type="text" name="facebook" type="text" value="{{$settings['facebook']}}" placeholder="Facebook" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                              <label>Twitter</label>
                              <input type="text" name="twitter" type="text" value="{{$settings['twitter']}}" placeholder="Twitter" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                              <label>LinkedIN</label>
                              <input type="text" name="linkedin" type="text" value="{{$settings['linkedin']}}" placeholder="LinkedIN" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                              <label>Instagram</label>
                              <input type="text" name="instagram" type="text" value="{{$settings['instagram']}}" placeholder="Instagram" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-right">
                  <button type="submit" class="btn bg-indigo btn-flat float-right" id="setting_frm_btn">Submit <span style="display: none" id="setting_frm_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection
@push('script')
<script src="{{asset('assets/js/custom/profile.js')}}"></script>
@endpush