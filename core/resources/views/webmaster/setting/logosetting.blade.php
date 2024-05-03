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
            <a class="nav-link" href="{{ route('webmaster.generalsetting') }}"><i class="fas fa-chart-line"></i> General Settings</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="{{ route('webmaster.emailsetting') }}"><i class="far fa-user"></i> Email Settings</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link active" href="{{ route('webmaster.logosetting') }}"> <i class="far fa-user"></i> Logo Settings</a>
         </li>
      </ul>
      <div class="tab-content">
         <div class="tab-pane show active" id="dashboard">

         </div>
         <div class="tab-pane" id="statement">

         </div>
         <div class="tab-pane" id="information">

         </div>
         <div class="tab-pane" id="group">

         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="text-center">
               <h4 class="card-title mb-3">Main Logo</h4>
               <div class="image-upload">
                  <div class="thumb">
                     @if ($setting->logo != NULL)
                     <img alt="logo" id="logo_preview" src="{{ asset('assets/uploads/generals/'. $setting->logo )}}" width="228">
                     @else
                     <img alt="logo" id="logo_preview" src="{{ asset('assets/uploads/defaults/logo.png' )}}"  width="228">
                     @endif
                     <div class="upload-file mt-3">
                        <input type="file" name="logo" class="file-upload" id="logo">
                        <label for="logo" class="btn bg-info">Upload Main Logo </label>
                     </div>
                  </div> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="text-center">
               <h4 class="card-title mb-3">Footer Logo</h4>
               <div class="image-upload">
                  <div class="thumb">
                     @if ($setting->footerlogo != NULL)
                     <img alt="footer logo" id="footerlogo_preview" src="{{ asset('assets/uploads/generals/'. $setting->footerlogo )}}" width="228">
                     @else
                     <img alt="footer logo" id="footerlogo_preview" src="{{ asset('assets/uploads/defaults/logo.png' )}}"  width="228">
                     @endif
                     <div class="upload-file mt-3">
                        <input type="file" name="footerlogo" class="file-upload" id="footerlogo">
                        <label for="footerlogo" class="btn bg-info">upload footer logo </label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="text-center">
               <h4 class="card-title mb-3">Favicon</h4>
               <div class="image-upload">
                  <div class="thumb">
                     @if ($setting->favicon != NULL)
                     <img alt="favicon" id="favicon_preview" src="{{ asset('assets/uploads/generals/'. $setting->favicon )}}" width="100">
                     @else
                     <img alt="favicon" id="favicon_preview" src="{{ asset('assets/uploads/defaults/favicon.png' )}}"  width="40">
                     @endif
                     <div class="upload-file mt-3">
                        <input type="file" name="favicon" class="file-upload" id="favicon">
                        <label for="favicon" class="btn bg-info">upload footer logo </label>
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
   $("#logo").change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#logo_preview").attr('src', url);
      let form_data = new FormData();
      form_data.append('logo', file);
      form_data.append('_token', '{{ csrf_token() }}');
      $.ajax({
         url: '{{ route('webmaster.logo.update') }}',
         method: 'post',
         data: form_data,
         cache: false,
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function(response) {
          window.location.reload();
          $("#logo").val('');
         }
      });
   });

  $("#footerlogo").change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#footerlogo_preview").attr('src', url);
      let form_data = new FormData();
      form_data.append('footerlogo', file);
      form_data.append('_token', '{{ csrf_token() }}');
      $.ajax({
         url: '{{ route('webmaster.footerlogo.update') }}',
         method: 'post',
         data: form_data,
         cache: false,
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function(response) {
          window.location.reload();
          $("#footerlogo").val('');
         }
      });
  });

  $("#favicon").change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#favicon_preview").attr('src', url);
      let form_data = new FormData();
      form_data.append('favicon', file);
      form_data.append('_token', '{{ csrf_token() }}');
      $.ajax({
         url: '{{ route('webmaster.favicon.update') }}',
         method: 'post',
         data: form_data,
         cache: false,
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function(response) {
          window.location.reload();
          $("#favicon").val('');
         }
      });
  });
</script>
@endsection