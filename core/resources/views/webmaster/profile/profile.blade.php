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
            <a class="nav-link" href="#password" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Password</a>
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
      </ul>
   </div>
</div>
<div class="tab-content">
   <div class="tab-pane show active" id="information">
   <div class="row">
      <input type="hidden" name="staffid" id="staffid" class="form-control" value="{{ $webmaster->id }}">
      <div class="col-md-3">      
         <div class="row">
            <div class="col-md-12">
               <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Profile Photo</h4>
               <div class="text-center">
            @if ($webmaster->photo != NULL)
            <img alt="image" id="image_preview" src="{{ asset('assets/uploads/staffs/'. $webmaster->photo )}}" class="avatar img-thumbnail" alt="photo" />
            @else
            <img alt="image" id="image_preview" src="{{ asset('assets/uploads/defaults/author.png') }}" width="140" class="avatar img-thumbnail" alt="avatar">
            @endif
            <div class="image-upload">
               <div class="thumb">
                  <div class="upload-file">
                     <input type="file" name="photo" class="form-control file-upload" id="photo">
                     <label for="photo" class="btn btn-xs btn-theme">Change Photo</label>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
            </div>
         </div>
            </div>
         </div>
            </div>
            <div class="col-md-12">
               <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Signature</h4>
               <div class="text-center">
            @if ($webmaster->signature != NULL)
            <img alt="image" id="signature_preview" src="{{ asset('assets/uploads/staffs/'. $webmaster->signature )}}" width="100" alt="signature" />
            @else
            <img alt="image" id="image_preview" src="{{ asset('assets/uploads/defaults/author.png') }}" width="100" class="avatar img-thumbnail" alt="avatar">
            @endif
            <div class="image-upload">
               <div class="thumb">
                  <div class="upload-file">
                     <input type="file" name="signature" class="form-control file-upload" id="signature">
                     <label for="signature" class="btn btn-xs btn-theme">Change Signature</label>
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
            </div>
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
                              <option {{ $webmaster->title == 'Mr' ? 'selected' : '' }}  value="Mr">Mr</option>
                              <option {{ $webmaster->title == 'Mrs' ? 'selected' : '' }}  value="Mrs">Mrs</option>
                              <option {{ $webmaster->title == 'Hon' ? 'selected' : '' }}  value="Hon">Hon</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                     </div>
                     <div class="col-md-6">
                     <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" value="{{ $webmaster->fname }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                   </div>

               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control" value="{{ $webmaster->lname }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="oname">Other Name</label>
                        <input type="text" name="oname" id="oname" class="form-control" value="{{ $webmaster->oname }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                           <label for="gender" class="form-label">Gender</label>
                           <select class="form-control" name="gender" id="gender">
                              <option {{ $webmaster->gender == 'Male' ? 'selected' : '' }}  value="Male">Male</option>
                              <option {{ $webmaster->gender == 'Female' ? 'selected' : '' }}  value="Female">Female</option>
                              <option {{ $webmaster->gender == 'Other' ? 'selected' : '' }}  value="Other">Others</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                           <label for="marital_status" class="form-label">Marital Status</label>
                           <select class="form-control" name="marital_status" id="marital_status">
                              <option {{ $webmaster->marital_status == 'N/A' ? 'selected' : '' }}  value="N/A">N/A</option>
                              <option {{ $webmaster->marital_status == 'Single' ? 'selected' : '' }}  value="Single">Single</option>
                              <option {{ $webmaster->marital_status == 'Married' ? 'selected' : '' }}  value="Married">Married</option>
                           </select>
                           <span class="invalid-feedback"></span>
                        </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="text" name="dob" class="form-control" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="dob" autocomplete="off" value="{{ $webmaster->dob }}">
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label for="disability" class="form-label">Disability</label>
                     <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="dno" name="disability" class="custom-control-input" value="No" @php echo $webmaster->disability == 'No' ? 'checked' : '' @endphp>
                           <label class="custom-control-label" for="dno">NO</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="dyes" name="disability" class="custom-control-input" value="Yes" @php echo $webmaster->disability == 'Yes' ? 'checked' : '' @endphp>
                           <label class="custom-control-label" for="dyes">YES</label>
                           </div>
                        </div>
                        <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="row mt-2">
                  <div class="col-md-12">
                     <button type="submit" class="btn btn-theme" id="btn_information">Update Information</button>
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
               <h3 class="card-title">Staff Biodata</h3>
            </div>
         </div>
         <form action="#" method="POST" id="biodata_form">
             @csrf
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="nin" class="form-label">NIN Number</label>
                     <input type="text" name="nin" id="nin" class="form-control"  value="{{ $webmaster->nin }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="no_of_children" class="form-label">Number of children</label>
                     <input type="text" name="no_of_children" id="no_of_children" class="form-control"  value="{{ $webmaster->no_of_children }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="no_of_dependant" class="form-label">Number of dependants</label>
                     <input type="text" name="no_of_dependant" id="no_of_dependant" class="form-control" value="{{ $webmaster->no_of_dependant }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="crbcard_no" class="form-label">CRB Card No</label>
                     <input type="text" name="crbcard_no" id="crbcard_no" class="form-control"  value="{{ $webmaster->crbcard_no }}" autocomplete="off">
                     <span class="invalid-feedback"></span>
                  </div>
               </div>
               <div class="col-md-4">
                     <div class="form-group">
                        <label for="branch_id" class="form-label">Branch</label>
                        <select class="form-control" name="branch_id" id="branch_id">
                           @foreach($branches as $data)
                           <option  {{ $data->id == $webmaster->branch_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
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
                           <option  {{ $data->id == $webmaster->branchposition_id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->name }}</option>
                           @endforeach
                        </select>
                        <span class="invalid-feedback"></span>
                     </div>
                  </div>
            </div>
            <div class="row mt-2">
               <div class="col-md-12">
                  <button type="submit" class="btn btn-theme" id="btn_biodata">Update Data</button>
               </div>
            </div>
         </form>
      </div>
   </div> 
         </div>
      </div>
   </div>

   <div class="tab-pane" id="password">
      <div class="row">
         <div class="col-md-6 mx-auto">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title mb-4">Change Profile Password</h4>
               <form action="#" method="POST" id="password_form"> 
                  @csrf
                  <input type="hidden" name="id" value="{{ $webmaster->id }}">
                  <div class="form-group">
                     <label for="old_password">Old Password</label>
                     <input type="password" name="old_password" class="form-control" id="old_password">
                     <span class="invalid-feedback"></span>
                  </div>

                  <div class="form-group">
                     <label for="new_password">Password</label>
                     <input type="password" name="new_password" class="form-control" id="new_password">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <label for="confirm_password">Re Password</label>
                     <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                     <span class="invalid-feedback"></span>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-info" id="btn_password">Update Password</button>
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
            <div class="float-left">
               <h3 class="card-title">Emails</h3>
            </div>
            <div class="float-right">
               <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#emailModel"> <i class="fa fa-plus"></i> Add Email
               </button>
               <div class="modal fade" id="emailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">                                                
                        <div class="modal-body">
                           <h4 class="card-title mb-4">New Email Form</h4>
                           <form action="#" method="POST" id="staffemail_form"> 
                              @csrf       
                              <div class="form-group">
                                 <label for="email">Email</label>
                                 <input type="text" name="email" id="email" class="form-control" autocomplete="off">
                                 <span class="invalid-feedback"></span>
                              </div>
                              <div class="form-group">
                                 <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                 <button type="submit" class="btn btn-sm btn-theme" id="btn_staffemail">Add Email</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
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
                     <td>
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteEmailModel{{ $row->id }}"> <i class="fa fa-trash"></i></button>
                         <div class="modal fade" id="deleteEmailModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <div class="alert alert-fwarning" role="alert">
                                            <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                            <h3 class="text-center">Delete Email {{ $row->email }}?</h3>
                                            <form action="#" method="POST" class="delete_staffemail_form">
                                              @csrf
                                               <input type="hidden" name="id"  value="{{ $row->id }}">
                                               <div class="form-group text-center mt-3">
                                                   <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cancel</button>
                                                   <button type="submit" class="btn btn-danger delete_staffemail">Yes, Delete</button>
                                               </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </td>
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
            <div class="float-left">
               <h3 class="card-title">Contacts</h3>
            </div>
            <div class="float-right">
               <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#contactModel"> <i class="fa fa-plus"></i> Add Contact
               </button>
               <div class="modal fade" id="contactModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">                                                
                        <div class="modal-body">
                           <h4 class="card-title mb-4">New Contact Form</h4>
                           <form action="#" method="POST" id="contact_form"> 
                              @csrf       
                              <div class="form-group">
                                 <label for="telephone">Telephone</label>
                                 <input type="text" name="telephone" id="telephone" class="form-control" autocomplete="off">
                                 <span class="invalid-feedback"></span>
                              </div>
                              <div class="form-group">
                                 <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                 <button type="submit" class="btn btn-sm btn-theme" id="btn_contact">Add Contact</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @if($contacts->count() > 0)
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
                  @foreach($contacts as $contact)
                  @php $i++; @endphp
                  <tr>
                     <th scope="row">{{ $i }}</th>
                     <td>{{ $contact->telephone }}</td>
                     <td>
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteContactModel{{ $contact->id }}"> <i class="fa fa-trash"></i></button>
                         <div class="modal fade" id="deleteContactModel{{ $contact->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <div class="alert alert-fwarning" role="alert">
                                            <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                            <h3 class="text-center">Delete Contact {{ $contact->telephone }}?</h3>
                                            <form action="#" method="POST" class="delete_contact_form">
                                              @csrf
                                               <input type="hidden" name="id"  value="{{ $contact->id }}">
                                               <div class="form-group text-center mt-3">
                                                   <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cancel</button>
                                                   <button type="submit" class="btn btn-danger delete_contact">Yes, Delete</button>
                                               </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </td>
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
            <div class="float-left">
               <h3 class="card-title">Document</h3>
            </div>
            <div class="float-right">
               <button type="button" class="btn btn-sm btn-theme" data-toggle="modal" data-target="#documentModel"> <i class="fa fa-plus"></i> Add Document
               </button>
               <div class="modal fade" id="documentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">                                                
                        <div class="modal-body">
                           <h4 class="card-title mb-4">Add Document</h4>
                           <form action="#" method="POST" id="staffdocument_form"> 
                              @csrf   
                              <div class="form-group">
                                <label for="file_name">Document Name</label>
                                 <input type="text" name="file_name" id="file_name" class="form-control" autocomplete="off">
                                 <span class="invalid-feedback"></span>
                              </div>
                              <div class="form-group">
                                 <label for="file">Upload file</label>
                                 <input type="file" name="file" id="file" class="form-control">
                                 <span class="invalid-feedback"></span>
                              </div>
                              <div class="form-group mt-3">
                                 <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                 <button type="submit" class="btn btn-sm btn-theme" id="btn_staffdocument">Upload Document</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @if($documents->count() > 0)
         <div class="table-responsive">
            <table class="table table-sm mb-0">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>File Name</th>
                     <th>File Type</th>
                     <th>Action</th>
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
                     <td>
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteDocumentModel{{ $row->id }}"> <i class="fa fa-trash"></i></button>
                         <div class="modal fade" id="deleteDocumentModel{{ $row->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content border-0">
                                    <div class="modal-body">
                                        <div class="alert alert-fwarning" role="alert">
                                            <i class="fa fa-exclamation-triangle d-block display-4 mt-2 mb-3 text-warning text-center"></i>
                                            <h3 class="text-center">Delete Document {{ $row->file_name }}?</h3>
                                            <form action="#" method="POST" class="delete_staffdocument_form">
                                              @csrf
                                               <input type="hidden" name="id"  value="{{ $row->id }}">
                                               <div class="form-group text-center mt-3">
                                                   <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cancel</button>
                                                   <button type="submit" class="btn btn-danger delete_staffdocument">Yes, Delete</button>
                                               </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </td>
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
         var url = "{{ route('webmaster.profile') }}";
         history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif

  $("#photo").change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#image_preview").attr('src', url);
      let form_data = new FormData();
      form_data.append('photo', file);
      form_data.append('id', $("#staffid").val());
      form_data.append('_token', '{{ csrf_token() }}');
      $.ajax({
          url: '{{ route('webmaster.staffphoto.update') }}',
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

   $("#signature").change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#signature_preview").attr('src', url);
      let form_data = new FormData();
      form_data.append('signature', file);
      form_data.append('id', $("#staffid").val());
      form_data.append('_token', '{{ csrf_token() }}');
      $.ajax({
          url: '{{ route('webmaster.staffsignature.update') }}',
         method: 'post',
         data: form_data,
         cache: false,
         processData: false,
         contentType: false, 
         dataType: 'json',
         success: function(response) {
          $("#signature").val('');
          window.location.reload();
         }
      });
  });

      $("#information_form").submit(function(e) {
        e.preventDefault();
        $("#btn_information").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_information").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.staffinformation.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_information").html('Update Information');
              $("#btn_information").prop("disabled", false);
            } else if(response.status == 200){
               //$("#information_form")[0].reset();
              removeErrors("#information_form");
              $("#btn_information").html('Update Information');
              $("#btn_information").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });

      $("#biodata_form").submit(function(e) {
        e.preventDefault();
        $("#btn_biodata").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_biodata").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.staffbiodata.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_biodata").html('Update Data');
              $("#btn_biodata").prop("disabled", false);
            } else if(response.status == 200){
               //$("#biodata_form")[0].reset();
              removeErrors("#biodata_form");
              $("#btn_biodata").html('Update Data');
              $("#btn_biodata").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });


      $("#password_form").submit(function(e) {
        e.preventDefault();
        $("#btn_password").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating');
        $("#btn_password").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.password.update') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_password").html('Update Password');
              $("#btn_password").prop("disabled", false);
            } else if(response.status == 200){
              $("#password_form")[0].reset();
              removeErrors("#password_form");
              $("#btn_password").html('Update Password');
              $("#btn_password").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 1000);

            }
          }
        });
      });


      $("#contact_form").submit(function(e) {
      e.preventDefault();
      $("#btn_contact").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_contact").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.staffcontact.store') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $("#btn_contact").html('Add Contact');
              $("#btn_contact").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors("#contact_form");
               $("#contact_form")[0].reset();
               $("#btn_contact").html('Add Contact');
                  setTimeout(function(){
                  $("#btn_contact").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });

      $(".delete_contact_form").submit(function(e) {
        e.preventDefault();
        $(".delete_contact").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_contact").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.staffcontact.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_contact").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_contact").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });

      $("#staffemail_form").submit(function(e) {
      e.preventDefault();
      $("#btn_staffemail").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_staffemail").prop("disabled", true);
      $.ajax({
         url:'{{ route('webmaster.staffemail.store') }}',
         method: 'post',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(response){
            if(response.status == 400){
               $.each(response.message, function (key, value) {
                  showError(key, value);
               });
              $("#btn_staffemail").html('Add Email');
              $("#btn_staffemail").prop("disabled", false);
            } else if(response.status == 200){
               removeErrors("#staffemail_form");
               $("#staffemail_form")[0].reset();
               $("#btn_staffemail").html('Add Email');
                  setTimeout(function(){
                  $("#btn_staffemail").prop("disabled", false);
                  window.location.reload();
              }, 500);
            }
          }
        });
      });

      $(".delete_staffemail_form").submit(function(e) {
        e.preventDefault();
        $(".delete_staffemail").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_staffemail").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.staffemail.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_staffemail").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_staffemail").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });

       $("#staffdocument_form").submit(function(e) {
      e.preventDefault();
      $("#btn_staffdocument").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
      $("#btn_staffdocument").prop("disabled", true);
        var formData = new FormData(this);
      $.ajax({
            url:'{{ route('webmaster.staffdocument.store') }}',
            method: 'post',
            data: formData, 
            processData: false,
            contentType: false,
            dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_staffdocument").html('Add Document');
              $("#btn_staffdocument").prop("disabled", false);
            } else if(response.status == 200){
               $("#staffdocument_form")[0].reset();
              removeErrors("#staffdocument_form");
              $("#btn_staffdocument").html('Add Document');
              $("#btn_staffdocument").prop("disabled", false);
              setTimeout(function(){
                window.location.reload();
              }, 500);

            }
          }
        });
      });

      $(".delete_staffdocument_form").submit(function(e) {
        e.preventDefault();
        $(".delete_staffdocument").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Deleting..');
        $(".delete_staffdocument").prop("disabled", true);
        $.ajax({
          url:'{{ route('webmaster.staffdocument.delete') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response) {
            $(".delete_staffdocument").html('Yes, Delete');
            setTimeout(function(){
               $(".delete_staffdocument").prop("disabled", false);
               window.location.reload();
            }, 500);
          }
        });
      });
</script>
@endsection
