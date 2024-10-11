@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
<style>
   /* General Card Styling */
.card {
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  overflow: hidden;
  transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px); 
}

/* Card Body Styling */
.card-body {
  padding: 1.5rem; /* Adjust padding as needed */
}

/* Form Control Styling */
.form-control {
  border-radius: 4px;
  border: 1px solid #ced4da;
  background-color: #fff;
  box-shadow: none;
}

/* Form Label Styling */
.form-label {
  margin-bottom: .5rem;
  font-weight: bold;
}

/* Button Styling */
.btn-theme {
  background-color: #007bff;
  border-color: #007bff;
  color: #fff;
  border-radius: 4px;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
}

.btn-theme:hover {
  background-color: #0056b3;
  border-color: #004085;
}

/* Button Styling for Small Sizes */
.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem; 
  border-radius: 3px;
}

/* Spacing and Alignment */
.clearfix {
  margin-bottom: 1rem;
}

.mt-3 {
  margin-top: 1rem;
}

.invalid-feedback {
  display: block;
  color: #dc3545;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 1rem;
  }

  .btn-theme {
    padding: 0.5rem;
  }
}

</style>
@endsection
@section('content')

<div class="page-heading">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>

   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
                  <div class="float-right">
                    @can('generate_system_backup')
                     <form action="#" method="POST" id="generate_form">
                        @csrf
                        <button type="submit" class="btn btn-theme" id="btn_generate">Generate BackUp</button>
                     </form>
                     @endcan
                  </div>
               </div>
               @if($dbbackups->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>File Name</th>
                           <th>File</th>
                           <th>File Size</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($dbbackups as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->file_name }}</td>
                           <td>{{ $row->file }}</td>
                           <td>{{ $row->file_size }}</td>
                           <td>
                            @can('generate_system_backup')
                             <a href="" class="btn btn-xs btn-dark"> <i class="fa fa-download"></i> Download</a>
                             @endcan
                           </td>
                        <tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Data</span>
                     </div>
                     @endif
            </div>
         </div>
      </div>
   </div>
@endsection

@section('scripts')
   <script type="text/javascript">
      "use strict";

      // $("#generate_form").submit(function(e) {
      //   e.preventDefault();
      //   $("#btn_generate").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Generating..');
      //   $("#btn_generate").prop("disabled", true);
      //   $.ajax({
      //     url:'{{ route('webmaster.dbbackup.generate') }}',
      //     method: 'post',
      //     data: $(this).serialize(),
      //     dataType: 'json',
      //     success: function(response) {
      //       $("#btn_generate").html('Generate Backup');
      //       setTimeout(function(){
      //          window.location.reload();
      //       }, 500);
      //     }
      //   });
      // });

      $("#generate_form").submit(function(e) {
        e.preventDefault();
        $("#btn_generate").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Generating');
        $("#btn_generate").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.dbbackup.generate') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_generate").html('Generate BackUp');
              $("#btn_generate").prop("disabled", false);
            } else if(response.status == 200){
              $("#btn_generate").html('Generate BackUp');
              $("#btn_generate").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });

   </script>
@endsection
