@extends('member.partials.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')

   <div class="row">
      <div class="col-md-8 mx-auto">
         
         <div class="row mb-1">
            <input type="hidden" name="id" id="webmaster_id" value="{{ member()->id }}">
            <div class="text-center">
               <div class="image-upload">
                  <div class="thumb">
                     @if (member()->photo)
                     <img alt="image" id="image_preview" src="{{ asset('assets/uploads/members/'. member()->photo )}}" class="rounded-circle" width="70">
                     @else
                     <img alt="image" id="image_preview" src="{{ asset('assets/uploads/defaults/member.png' )}}" class="rounded-circle" width="70">
                     @endif
                     <div class="upload-file">
                        <input type="file" name="photo" class="form-control file-upload" id="photo">
                        <label for="photo" class="btn btn-info">Change Photo</label>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
        

        <div class=" mb-5">
            <div class="listview-title mt-1">Account Information</div>
            <ul class="listview image-listview text inset">
               <li>
                  <a href="{{ route('member.profile') }}" class="item">
                     <div class="in">
                        <div><i class="fas fa-user mr-1"></i> Update Information</div>
                     </div>
                  </a>
               </li>
               <li>
                  <a href="{{ route('member.password') }}" class="item">
                     <div class="in">
                        <div><i class="fas fa-lock mr-1"></i> Change Password</div>
                     </div>
                  </a>
               </li>

               <li>
                  <a href=" " class="item">
                     <div class="in">
                        <div> <i class="fas fa-donate mr-1"></i> KYC / Biodata</div>
                     </div>
                  </a>
               </li>
               
               <li>
                  <a href="{{ route('member.notifications') }}" class="item">
                     <div class="in">
                        <div><i class="fas fa-comment-alt mr-1"></i> Notifications</div>
                     </div>
                  </a>
               </li>
               <li>
                  <div class="item">
                     <div class="in">
                        <div><i class="fas fa-lock mr-1"></i> Dark Mode </div>
                           <div class="form-check form-switch ms-2">
                              <input class="form-check-input" type="checkbox" id="SwitchCheckDefault2">
                              <label class="form-check-label" for="SwitchCheckDefault2"></label>
                           </div>
                        </div>
                     </div>
               </li>
            </ul>
        </div>   
      </div>
      </div>
   </div>
@endsection

@section('scripts')
<script type="text/javascript">

  $("#photo").change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#image_preview").attr('src', url);
      let form_data = new FormData();
      form_data.append('photo', file);
      form_data.append('id', $("#admin_id").val());
      form_data.append('_token', '{{ csrf_token() }}');
      $.ajax({
         url: '{{ route('member.profile.photo') }}',
         method: 'post',
         data: form_data,
         cache: false,
         processData: false,
         contentType: false, 
         dataType: 'json',
         success: function(response) {
          $("#photo").val('');
          window.location.reload();
         }
      });
  });

  </script>
@endsection