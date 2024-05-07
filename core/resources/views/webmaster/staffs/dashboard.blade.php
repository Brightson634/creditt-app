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
            <a class="nav-link active" href="#information" data-toggle="tab" aria-expanded="false"><i class="fas fa-chart-line"></i> Information</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#biodata" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Biodata</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#emails" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Emails</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#contacts" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Contacts</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#documents" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Documents</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#loginlogs" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Login Logs</a>
         </li>
      </ul>
   </div>
</div>
<div class="tab-content">
   <div class="tab-pane show active" id="information">
   <div class="row">
      <div class="col-md-3">      
         <div class="row">
            <div class="col-md-12">
               <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Profile Photo</h4>
               <div class="text-center">
            @if ($staff->photo != NULL)
            <img alt="image" id="image_preview" src="{{ asset('assets/uploads/staffs/'. $staff->photo )}}" class="avatar img-thumbnail" alt="photo" />
            @else
            <img alt="image" id="image_preview" src="{{ asset('assets/uploads/defaults/author.png') }}" width="140" class="avatar img-thumbnail" alt="avatar">
            @endif
         </div>
            </div>
         </div>
            </div>
            <div class="col-md-12">
               <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Signature</h4>
               <div class="text-center">
            @if ($staff->signature != NULL)
            <img alt="image" id="signature_preview" src="{{ asset('assets/uploads/staffs/'. $staff->signature )}}" width="150" alt="signature" />
            @else
            <img alt="image" id="image_preview" src="{{ asset('assets/uploads/defaults/author.png') }}" width="100" class="avatar img-thumbnail" alt="avatar">
            @endif
         </div>
            </div>
         </div>
            </div>
         </div>
      </div>
      <div class="col-md-9">
         <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Information</h4>
               <form action="#" method="POST" id="information_form">
                   @csrf
                   <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                           <label for="title" class="form-label">Title</label>
                           <select class="form-control" name="title" id="title">
                              <option {{ $staff->title == 'Mr' ? 'selected' : '' }}  value="Mr">Mr</option>
                              <option {{ $staff->title == 'Mrs' ? 'selected' : '' }}  value="Mrs">Mrs</option>
                              <option {{ $staff->title == 'Hon' ? 'selected' : '' }}  value="Hon">Hon</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-6">
                     <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" value="{{ $staff->fname }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                   </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control" value="{{ $staff->lname }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="oname">Other Name</label>
                        <input type="text" name="oname" id="oname" class="form-control" value="{{ $staff->oname }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                           <label for="gender" class="form-label">Gender</label>
                           <select class="form-control" name="gender" id="gender">
                              <option {{ $staff->gender == 'Male' ? 'selected' : '' }}  value="Male">Male</option>
                              <option {{ $staff->gender == 'Female' ? 'selected' : '' }}  value="Female">Female</option>
                              <option {{ $staff->gender == 'Other' ? 'selected' : '' }}  value="Other">Others</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                           <label for="marital_status" class="form-label">Marital Status</label>
                           <select class="form-control" name="marital_status" id="marital_status">
                              <option {{ $staff->marital_status == 'N/A' ? 'selected' : '' }}  value="N/A">N/A</option>
                              <option {{ $staff->marital_status == 'Single' ? 'selected' : '' }}  value="Single">Single</option>
                              <option {{ $staff->marital_status == 'Married' ? 'selected' : '' }}  value="Married">Married</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="text" name="dob" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="dob" autocomplete="off" value="{{ $staff->dob }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label for="disability" class="form-label">Disability</label>
                     <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="dno" name="disability" class="custom-control-input" value="No" @php echo $staff->disability == 'No' ? 'checked' : '' @endphp>
                           <label class="custom-control-label" for="dno">NO</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="dyes" name="disability" class="custom-control-input" value="Yes" @php echo $staff->disability == 'Yes' ? 'checked' : '' @endphp>
                           <label class="custom-control-label" for="dyes">YES</label>
                           </div>
                        </div>
                        <span class="invalid-feedback"></span>
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   </div>

   <div class="tab-pane" id="biodata">
      <div class="row">
         <div class="col-md-10 mx-auto">
            <div class="card">
      <div class="card-body">
         <div class="clearfix mb-3">
            <div class="float-left">
               <h3 class="card-title">Staff Details</h3>
            </div>
         </div>
         <form action="#" method="POST" id="biodata_form">
             @csrf
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="nin" class="form-label">NIN Number</label>
                     <input type="text" name="nin" id="nin" class="form-control"  value="{{ $staff->nin }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="no_of_children" class="form-label">Number of children</label>
                     <input type="text" name="no_of_children" id="no_of_children" class="form-control"  value="{{ $staff->no_of_children }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="no_of_dependant" class="form-label">Number of dependants</label>
                     <input type="text" name="no_of_dependant" id="no_of_dependant" class="form-control" value="{{ $staff->no_of_dependant }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="crbcard_no" class="form-label">CRB Card No</label>
                     <input type="text" name="crbcard_no" id="crbcard_no" class="form-control"  value="{{ $staff->crbcard_no }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="col-md-4">
                     <div class="form-group">
                        <label for="branch_id" class="form-label">Branch</label>
                        <select class="form-control" name="branch_id" id="branch_id">
                           @foreach($branches as $data)
                           <option  {{ $data->id == $staff->branch_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="branchposition_id" class="form-label">Designation</label>
                        <select class="form-control" name="branchposition_id" id="branchposition_id">
                           @foreach($positions as $data)
                           <option  {{ $data->id == $staff->branchposition_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
            </div>
         </form>
      </div>
   </div> 
         </div>
      </div>
   </div>

   <div class="tab-pane" id="emails">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
      <div class="card-body">
         <div class="clearfix mb-3">
               <h3 class="card-title">Emails</h3>
         </div>
         @if($emails->count() > 0)
         <div class="table-responsive">
            <table class="table table-sm mb-0">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Telephone</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @php $i = 0; @endphp
                  @foreach($emails as $row)
                  @php $i++; @endphp
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td>{{ $row->email }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Emails</span>
            </div>
         @endif
      </div>
   </div> 
         </div>
      </div>
   </div>

   <div class="tab-pane" id="contacts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
      <div class="card-body">
         <div class="clearfix mb-3">
            <h3 class="card-title">Contacts</h3>
         </div>
         @if($contacts->count() > 0)
         <div class="table-responsive">
            <table class="table table-sm mb-0">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Telephone</th>
                  </tr>
               </thead>
               <tbody>
                  @php $i = 0; @endphp
                  @foreach($contacts as $contact)
                  @php $i++; @endphp
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td>{{ $contact->telephone }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Contacts</span>
            </div>
         @endif
      </div>
   </div> 
         </div>
      </div>
   </div>

   <div class="tab-pane" id="documents">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
      <div class="card-body">
         <div class="clearfix mb-3">
            <h3 class="card-title">Document</h3>
         </div>
         @if($documents->count() > 0)
         <div class="table-responsive">
            <table class="table table-sm mb-0">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>File Name</th>
                     <th>File Type</th>
                  </tr>
               </thead>
               <tbody>
                  @php $i = 0; @endphp
                  @foreach($documents as $row)
                  @php $i++; @endphp
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td><a href="{{ asset('assets/uploads/staffs/'. $row->file ) }}" target="_blank">{{ $row->file_name }}</a></td>
                     <td>{{ $row->file_type }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Documents</span>
            </div>
         @endif
      </div>
   </div>
         </div>
      </div>
   </div>

      <div class="tab-pane" id="loginlogs">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
      <div class="card-body">
         <div class="clearfix mb-3">
            <h3 class="card-title">Login Logs</h3>
         </div>
         @if($documents->count() > 0)
         <div class="table-responsive">
            <table class="table table-sm mb-0">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>File Name</th>
                     <th>File Type</th>
                  </tr>
               </thead>
               <tbody>
                  @php $i = 0; @endphp
                  @foreach($documents as $row)
                  @php $i++; @endphp
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td><a href="{{ asset('assets/uploads/staffs/'. $row->file ) }}" target="_blank">{{ $row->file_name }}</a></td>
                     <td>{{ $row->file_type }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Documents</span>
            </div>
         @endif
      </div>
   </div>
         </div>
      </div>
   </div>

</div>
@endsection

@section('scripts')
<script type="text/javascript">
   $('.nav-tabs a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.staff.dashboard', $staff->staff_no) }}";
         history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif   
</script>
@endsection
