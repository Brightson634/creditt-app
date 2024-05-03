@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div>
   <div class="page-heading__title">
      <ul class="nav nav-tabs">
         <li class="nav-item"> 
            <a class="nav-link active" href="{{ route('webmaster.generalsetting') }}"><i class="fas fa-chart-line"></i> General Settings</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="{{ route('webmaster.emailsetting') }}"><i class="far fa-user"></i> Email Settings</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="{{ route('webmaster.smssetting') }}"><i class="far fa-user"></i> SMS Settings</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="{{ route('webmaster.logosetting') }}"> <i class="far fa-user"></i> Logo Settings</a>
         </li>
      </ul>
   </div>
</div>

<div class="row">
   <div class="col-md-12">
      <div class="tab-content">
         <div class="tab-pane show active">
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-3 mb-2 mb-sm-0">
                        <ul class="nav flex-column nav-pills">
                           <li class="nav-item"> 
                           <a class="nav-link active show mb-2" data-toggle="tab" href="#biodata" aria-expanded="false"> <i class="far fa-user"></i> Information
                           </a>
                        </li>
                        <li class="nav-item"> 
                           <a class="nav-link mb-2" data-toggle="tab" href="#prefixs" aria-expanded="false">  <i class="far fa-user"></i> Prefixs
                           </a>
                        </li>
                        <li class="nav-item"> 
                           <a class="nav-link mb-2" data-toggle="tab" href="#emails">  <i class="far fa-user"></i> Emails
                            </a>
                         </li>
                         <li class="nav-item"> 
                            <a class="nav-link mb-2" data-toggle="tab" href="#documents">  <i class="far fa-user"></i> Documents
                           </a>
                        </li>
                        </ul>
                     </div>
                     <div class="col-sm-9">
                        <div class="tab-content">

                           <div class="tab-pane show active" id="biodata">
                              <h4 class="card-title mb-4">Information</h4>
                              <div class="card">
      <div class="card-body">
            <h4 class="card-title mb-4">System Information</h4>
               <form action="#" method="POST" id="setting_form"> 
                  @csrf
                  <div class="form-group">
                     <label for="system_name">System Name</label>
                     <input type="text" name="system_name" class="form-control" id="system_name" value="{{ $setting->system_name }}">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="company_name">Company Name</label>
                     <input type="text" name="company_name" class="form-control" id="company_name" value="{{ $setting->company_name }}">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="currency_symbol">Currency Symbol</label>
                     <input type="text" name="currency_symbol" class="form-control" id="currency_symbol" value="{{ $setting->currency_symbol }}">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="address">Address</label>
                     <textarea name="address" class="form-control" id="address" rows="5">{{ $setting->address }}</textarea>
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-theme" id="btn_setting">Update Settings</button>
                  </div>
               </form>
         
      </div>
     </div>
                           </div>

                           <div class="tab-pane" id="prefixs">
                              <h4 class="card-title mb-4">Prefixs</h4>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    "use strict";
      $('.nav-pills a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.generalsetting') }}";
          history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-pills a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif


      $("#setting_form").submit(function(e) {
        e.preventDefault();
        $("#btn_setting").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_setting").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.generalsetting.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_setting").html('Update Settings');
              $("#btn_setting").prop("disabled", false);
            } else if(response.status == 200){
              removeErrors("#setting_form");
              $("#btn_setting").html('Update Settings');
              setTimeout(function(){
                $("#btn_setting").prop("disabled", false);
                 window.location.reload();
              }, 500);

            }
          }
        });
      });
</script>
@endsection