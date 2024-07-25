@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
   {{-- <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div> --}}
</div>
<!--update Modal-->
@include('webmaster.branches.edit')
   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.branch.create') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New Branch</a>
                  </div>
               </div>
               @if($branches->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead style="background-color:#3b4863;">
                        <tr style="color:white;">
                           <th>#</th>
                           <th>Code</th>
                           <th>Name</th>
                           <th>Telephone</th>
                           <th>Email</th>
                           <th>Physical Address</th>
                           <th>Default Currency</th>
                           <th>Postal Address</th>
                           <th>Is Main</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($branches as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td>{{ $row->branch_no }}</td>
                           <td>{{ $row->name }}</td>
                           <td>{{ $row->telephone }}</td>
                           <td>{{ $row->email }}</td>
                           <td>{{ $row->physical_address }}</td>
                           <td>{{ $row->default_currency }}</td>
                           <td>{{ $row->postal_address }}</td>
                           <td>
                            @if($row->is_main == 1) Main Branch @else -  @endif
                           </td>
                           <td>
                             <a href="#" id="editBranch" data-toggle="tooltip-primary" title="Update Branch" data_branch="{{$row->id}}"class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
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
<script>
    $(document).ready(function () {
        $(document).on('click','#editBranch',function(){
            branchId = $(this).attr('data_branch')
            $.ajax({
                type: "GET",
                url: "{{ route('webmaster.branch.edit') }}",
                data:{'branchId':branchId},
                dataType: "json",
                success: function (response) {
                    if(response.status === 200) {
                        $('#branch_no').val(response.branch.branch_no);
                        $('#name').val(response.branch.name);
                        $('#branch_id').val(response.branch.id);
                        $('#default_curr').val(response.branch.default_currency);
                        $('#telephone').val(response.branch.telephone);
                        $('#email').val(response.branch.email);
                        $('#physical_address').val(response.branch.physical_address);
                        $('#postal_address').val(response.branch.postal_address);
                        $('input[name="is_main"][value="' + response.branch.is_main + '"]').prop('checked', true);
                        $("#update_account_modal").modal('show');
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error('An unexpected error.');
                }

            });
        })

        //update
           $("#branch_form").submit(function(e) {
                e.preventDefault();
                // $("#update_btn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
                $("#update_btn").prop("disabled", true);
                $.ajax({
                    url: "{{ route('webmaster.branch.update') }}",
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#update_btn").html('Add Branch');
                            $("#update_btn").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#branch_form")[0].reset();
                            removeErrors("#branch_form");
                            $("#update_btn").html('Add Branch');
                            $("#update_btn").prop("disabled", false);
                        }

                        if(response.message)
                        {
                            $('#update_account_modal').modal('hide')
                            toastr.success('Operation Successful')
                            location.reload()
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        toastr.error('Unexpected error has occured')
                        $("#update_btn").prop("disabled", false);
                    }
                });
        });
    });
</script>
@endsection
