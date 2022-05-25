<!-- View user details -->
<div class="modal fade" id="view_user_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">View User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body align-items-center justify-content-center loader" id="modal_loader1" style="display: none;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
        <div class="card-body" id="modal_body_part">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img id="info_image" class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                  </div>
                  <h3 class="profile-username text-center" id="info_name">Nina Mcintire</h3>
                  <div class="row">
                    <div class="col-md-6">
                      <label class="col-form-label"><b>First Name</b></label><br>
                      <p id="info_first_name"></p>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label"><b>Last Name</b></label><br>
                      <p id="info_last_name"></p>
                    </div>
                    <div class="col-md-6">
                      <label class="col-form-label"><b>Email</b></label><br>
                      <p id="info_email"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary float-right">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- add update modal -->
<div class="modal fade" id="modal-add-update" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Large Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="users_form" action="{{route('users.store')}}" name="users_form" novalidate="novalidate">
        <div class="modal-body">
          <div class="card-body">
            <input type="hidden" name="id" id="id" value="">
            <div class="row">
              <div class="form-group col-md-12" id="password_note">
                <div class="callout callout-info">
                  <h5><i class="icon fas fa-info"></i> Note :</h5>
                  <p>Leave <b>Password</b> and <b>Confirm Password</b> empty, if you are not going to change the password.</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Firstname <span class="red">*</span></label>
                  <input type="text" class="form-control" placeholder="Please enter firstname" id="first_name" name="first_name" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Lastname <span class="red">*</span></label>
                  <input type="text" class="form-control" placeholder="Please enter lastname" id="last_name" name="last_name" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Name <span class="red">*</span></label>
                  <input type="text" class="form-control" placeholder="Please enter name" id="name" name="name" value="">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Email <span class="red">*</span></label>
                  <input type="text" class="form-control" placeholder="Please enter email" id="email" name="email" value="">
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
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" name="image" id="image" class="form-control" style="padding: 0.200rem 0.75rem;" placeholder="Enter Select Image" onchange="load_preview_image(this);" accept="image/x-png,image/jpg,image/jpeg">
                </div>
              </div>
              <div class="col-sm-2">
                <div id="preview_div">
                  <img id="image_preview" class="profile-user-img img-fluid img-circle admin_profile" src="">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="users_form_btn">Save<span style="display: none" id="users_form_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
        </div>
      </form>
    </div>
  </div>
</div>