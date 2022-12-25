@extends('layouts.admin_app')
@section('content')
@include('admin.breadcrumb')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">{{$title}}</h3>
            </div>
             <form method="post" id="static-page-form" name="static_page_form">
              @csrf
                <input type="hidden" name="slug" value="{{$slug}}" id="page_slug">
                <div class="card-body">
                  <textarea name="static_page_form_editor">{{$content}}</textarea>
                  <div class="card-footer text-center">
                    <button type="button" class="btn bg-indigo btn-flat" id="static_page_form_btn" onclick="saveStaticPage(`{{route('static_page_update')}}`)">Save<span style="display: none" id="static_page_form_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@push('script')
<script src="{{asset('plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/js/custom/staticpage.js')}}"></script>
@endpush