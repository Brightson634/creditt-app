@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')

    <div class="page-heading">
        <div class="az-dashboard-nav">
            <nav class="nav">
                <a class="nav-link {{ $activeTab == 'tab1' ? 'active' : '' }}" data-toggle="tab" href="#new_member">New
                    Member</a>
                <a class="nav-link {{ $activeTab == 'tab2' ? 'active' : '' }}" data-toggle="tab" href="#manage_members"
                    role="tab" aria-controls="guarantors" aria-selected="false">Members</a>
                <a class="nav-link {{ $activeTab == 'tab3' ? 'active' : '' }}" data-toggle="tab" href="#create_account"
                    role="tab" aria-controls="collaterals" aria-selected="false">New Account</a>
                <a class="nav-link {{ $activeTab == 'tab4' ? 'active' : '' }}" data-toggle="tab" href="#member_accounts"
                    role="tab" aria-controls="collaterals" aria-selected="false">Accounts</a>
                <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav>
        </div>
    </div>
    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ $activeTab == 'tab1' ? 'show active' : '' }}" id="new_member" role="tabpanel"
            aria-labelledby="new_member-tab">
            <div class="row">
               <div class="col-xl-12 mx-auto">
                   <div class="card">
                       <div class="card-body">
                           <div class="clearfix mb-3">
                               <div class="float-left">
                                   <h3 class="card-title">Member Information</h3>
                               </div>
                               <div class="float-right">
                                   <a href="{{ route('webmaster.members') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                           class="fa fa-eye"></i> View Members</a>
                               </div>
                           </div>
                           <form action="#" method="POST" id="member_form">
                               @csrf
                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="member_no" class="form-label">Member No</label>
                                           <input type="text" name="member_no" id="member_no" class="form-control"
                                               value="{{ $member_no }}" readonly>
                                       </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="member_type" class="form-label">Individual / Group </label>
                                           <select class="form-control" name="member_type" id="member_type">
                                               <option value="">select member type</option>
                                               <option value="individual">Individual Member</option>
                                               <option value="group">Group Member</option>
                                           </select>
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                               </div>
                               <div id="individualDiv">
                                   <div class="row">
                                       <div class="col-md-2">
                                           <div class="form-group">
                                               <label for="title" class="form-label">Title</label>
                                               <select class="form-control" name="title" id="title">
                                                   <option value="">select title</option>
                                                   <option value="Mr">Mr</option>
                                                   <option value="Mrs">Mrs</option>
                                                   <option value="Hon">Hon</option>
                                               </select>
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-4">
                                           <div class="form-group">
                                               <label for="fname" class="form-label">First Name:</label>
                                               <input type="text" name="fname" id="fname"
                                                   class="form-control">
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-3">
                                           <div class="form-group">
                                               <label for="lname" class="form-label">Last Name</label>
                                               <input type="text" name="lname" id="lname"
                                                   class="form-control">
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-3">
                                           <div class="form-group">
                                               <label for="oname" class="form-label">Other Name</label>
                                               <input type="text" name="oname" id="oname"
                                                   class="form-control">
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="col-md-3">
                                           <div class="form-group">
                                               <label for="gender" class="form-label">Gender</label>
                                               <select class="form-control" name="gender" id="gender">
                                                   <option value="">select gender</option>
                                                   <option value="Male">Male</option>
                                                   <option value="Female">Female</option>
                                                   <option value="Other">Others</option>
                                               </select>
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-3">
                                           <div class="form-group">
                                               <label for="marital_status" class="form-label">Marital Status</label>
                                               <select class="form-control" name="marital_status" id="marital_status">
                                                   <option value="">select status</option>
                                                   <option value="NA">N/A</option>
                                                   <option value="Single">Single</option>
                                                   <option value="Married">Married</option>
                                               </select>
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-3">
                                           <div class="form-group">
                                               <label for="dob" class="form-label">Date of Birth</label>
                                               <input type="text" name="dob" class="form-control"
                                                   data-provide="datepicker" data-date-autoclose="true"
                                                   data-date-format="yyyy-mm-dd" id="dob" autocomplete="off">
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-3">
                                           <label for="disability" class="form-label">Disability</label>
                                           <div class="form-group">
                                               <div class="custom-control custom-radio custom-control-inline">
                                                   <input type="radio" id="dno" name="disability"
                                                       class="custom-control-input" value="No" checked>
                                                   <label class="custom-control-label" for="dno">NO</label>
                                               </div>
                                               <div class="custom-control custom-radio custom-control-inline">
                                                   <input type="radio" id="dyes" name="disability"
                                                       class="custom-control-input" value="Yes">
                                                   <label class="custom-control-label" for="dyes">YES</label>
                                               </div>
                                           </div>
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                               </div>
                               <div id="groupDiv" style="display: none;">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="group_name" class="form-label">Group Name</label>
                                               <input type="text" name="group_name" id="group_name"
                                                   class="form-control">
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="description" class="form-label">Description</label>
                                               <input type="text" name="description" id="description"
                                                   class="form-control">
                                               <span class="invalid-feedback"></span>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="telephone" class="form-label">Telephone</label>
                                           <input type="text" name="telephone" id="telephone" class="form-control">
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="email" class="form-label">Email</label>
                                           <input type="email" name="email" id="email" class="form-control">
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                               </div>

                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="password" class="form-label">Member Password</label>
                                           <input type="password" name="password" id="password" class="form-control"
                                               value="12345678" readonly>
                                           <small class="form-text text-muted">The default password is
                                               <strong>12345678</strong></small>
                                       </div>
                                   </div>
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="subscriptionplan_id" class="form-label">Subscription Plan</label>
                                           <select class="form-control" name="subscriptionplan_id"
                                               id="subscriptionplan_id">
                                               <option value="">select branch</option>
                                               @foreach ($branches as $data)
                                                   <option value="{{ $data->id }}">{{ $data->name }}</option>
                                               @endforeach
                                           </select>
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                               </div>

                               <div class="row mt-2">
                                   <div class="col-sm-9">
                                       <button type="submit" class="btn btn-primary btn-theme" id="btn_member">Add
                                           Member</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
        </div>
        <div class="tab-pane fade {{ $activeTab == 'tab2' ? 'show active' : '' }}" id="manage_members" role="tabpanel"
            aria-labelledby="manage_member-tab">
            <div class="row">
               <div class="col-xl-12 mx-auto">
                   <div class="card">
                       <div class="card-body">
                           @if ($members->count() > 0)
                               <div class="card card-dashboard-table-six">
                                   <h6 class="card-title">Registered Members <div class="float-right">
                                           <a href="{{ route('webmaster.member.create') }}"
                                               class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New
                                               Member</a>
                                       </div>
                                   </h6>
                                   <div class="table-responsive">
                                       <table class="table table-striped">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>Member No</th>
                                                   <th>Member Names</th>
                                                   <th>Gender</th>
                                                   <th>Telephone</th>
                                                   <th>Email</th>
                                                   <th>Action</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               @php $i = 0; @endphp
                                               @foreach ($members as $row)
                                                   @php $i++; @endphp
                                                   <tr>
                                                       <th scope="row">{{ $i }}</th>
                                                       <td><a
                                                               href="{{ route('webmaster.member.dashboard', $row->member_no) }}">{{ $row->member_no }}</a>
                                                       </td>
                                                       <td>
                                                           @if ($row->member_type == 'individual')
                                                               {{ $row->title }} {{ $row->fname }}
                                                               {{ $row->lname }}
                                                           @endif
                                                           @if ($row->member_type == 'group')
                                                               {{ $row->fname }}
                                                           @endif
                                                       </td>
                                                       <td>
                                                           @if ($row->member_type == 'individual')
                                                               MEMBER
                                                           @endif
                                                           @if ($row->member_type == 'group')
                                                               GROUP
                                                           @endif
                                                       </td>
                                                       <td>{{ $row->telephone }}</td>
                                                       <td>{{ $row->email }}</td>
                                                       <td>
                                                           <a href="{{ route('webmaster.member.edit', $row->member_no) }}"
                                                               class="btn btn-xs btn-dark"> <i class="far fa-edit"></i>
                                                               Edit</a>
                                                       </td>
                                                   <tr>
                                               @endforeach
                                           </tbody>
                                       </table>
                                   </div>
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
        </div>
        <div class="tab-pane fade {{ $activeTab == 'tab3' ? 'show active' : '' }}" id="create_account" role="tabpanel"
            aria-labelledby="create_account-tab">
            <div class="row">
               <div class="col-xl-12 mx-auto">
                   <div class="card">
                       <div class="card-body">
                           <div class="clearfix mb-3">
                               <div class="float-left">
                                   <h3 class="card-title">Account Information</h3>
                               </div>
                               <div class="float-right">
                                   <a href="{{ route('webmaster.memberaccounts') }}"
                                       class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-eye"></i> View Accounts</a>
                               </div>
                           </div>
                           <form action="#" method="POST" id="account_form">
                               @csrf
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="member_id" class="form-label">Member</label>
                                           <select class="form-control" name="member_id" id="member_id">
                                               <option value="">select member</option>
                                               @foreach ($members as $data)
                                                   <option value="{{ $data->id }}">{{ $data->fname }}
                                                       {{ $data->lname }}</option>
                                               @endforeach
                                           </select>
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="accounttype_id" class="form-label">Account Type</label>
                                           <select class="form-control" name="accounttype_id" id="accounttype_id">
                                               <option value="">select account type </option>
                                               @foreach ($accounttypes as $data)
                                                   <option value="{{ $data->id }}">{{ $data->name }}</option>
                                               @endforeach
                                           </select>
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="account_no" class="form-label">Account No:</label>
                                           <input type="text" name="account_no" id="account_no" class="form-control"
                                               value="{{ $account_no }}" readonly>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="opening_balance" class="form-label">Opening Balance</label>
                                           <input type="text" name="opening_balance" id="opening_balance"
                                               class="form-control">
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="fees_id" class="form-label">Applicable Fees</label>
                                           <select class="form-control select2" data-toggle="select2" name="fees_id[]"
                                               id="fees_id">
                                               <option value="">select fees </option>
                                               @foreach ($fees as $data)
                                                   <option value="{{ $data->id }}">{{ $data->name }}</option>
                                               @endforeach
                                           </select>
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="account_purpose" class="form-label">Account Purpose</label>
                                           <input type="text" name="account_purpose" id="account_purpose"
                                               class="form-control">
                                           <span class="invalid-feedback"></span>
                                       </div>
                                   </div>
                               </div>
                               <div class="row">

                               </div>
                               <div class="row mt-2">
                                   <div class="col-sm-9">
                                       <button type="submit" class="btn btn-primary btn-theme" id="btn_account">Add
                                           Account</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
        </div>
        <div class="tab-pane fade {{ $activeTab == 'tab4' ? 'show active' : '' }}" id="member_accounts" role="tabpanel"
            aria-labelledby="member_accounts-tab">
            <div class="row">
               <div class="col-xl-12 mx-auto">
                   <div class="card">
                       <div class="card-body">
                           {{-- <div class="clearfix mb-3">
                    <div class="float-left">
                       <h3 class="card-title">{{ $page_title }}</h3>
                    </div>
                    <div class="float-right">
                       <a href="{{ route('webmaster.memberaccount.create') }}" class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New Account</a>
                    </div>
                 </div> --}}

                           @if ($accounts->count() > 0)
                               {{-- <div class="table-responsive">
                       <table class="table table-sm mb-0">
                          <thead>
                             <tr>
                                <th>#</th>
                                <th>Account No</th>
                                <th>Account Type</th>
                                <th>Member</th>
                                <th>Opening Balance</th>
                                <th>Current Balance</th>
                                <th>Available balance</th>
                                <th>Status</th>
                                <th>Action</th>
                             </tr>
                          </thead>
                          <tbody>
                             @php $i = 0; @endphp
                             @foreach ($accounts as $row)
                             @php $i++; @endphp
                             <tr>
                                <th scope="row">{{ $i }}</th>
                                <td>{{ $row->account_no }}</td>
                                <td>{{ $row->accounttype->name }}</td>
                                <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
                                <td>{!! showAmount($row->opening_balance) !!}</td>
                                <td>{!! showAmount($row->current_balance) !!}</td>
                                <td>{!! showAmount($row->available_balance) !!}</td>
                                <td>
                                   @if ($row->account_status == 1)
                                      <div class="badge badge-success">ACTIVE</div>
                                   @endif
                                   @if ($row->account_status == 0)
                                      <div class="badge badge-warning">INACTIVE</div>
                                   @endif
                                </td>
                                <td>
                                <a href="#{{ route('webmaster.memberaccount.edit', $row->account_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                                </td>
                             <tr>
                             @endforeach
                          </tbody>
                       </table>
                    </div> --}}
                               <div class="card card-dashboard-table-six">
                                   <h6 class="card-title">Member Accounts<div class="float-right">
                                           <a href="{{ route('webmaster.memberaccount.create') }}"
                                               class="btn btn-dark btn-sm btn-theme"> <i class="fa fa-plus"></i> New
                                               Account</a>
                                       </div>
                                   </h6>
                                   <div class="table-responsive">
                                       <table class="table table-striped">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>Account No</th>
                                                   <th>Account Type</th>
                                                   <th>Member</th>
                                                   <th>Opening Balance</th>
                                                   <th>Current Balance</th>
                                                   <th>Available balance</th>
                                                   <th>Status</th>
                                                   <th>Action</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               @php $i = 0; @endphp
                                               @foreach ($accounts as $row)
                                                   @php $i++; @endphp
                                                   <tr>
                                                       <th scope="row">{{ $i }}</th>
                                                       <td>{{ $row->account_no }}</td>
                                                       <td>{{ $row->accounttype->name }}</td>
                                                       <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
                                                       <td>{!! showAmount($row->opening_balance) !!}</td>
                                                       <td>{!! showAmount($row->current_balance) !!}</td>
                                                       <td>{!! showAmount($row->available_balance) !!}</td>
                                                       <td>
                                                           @if ($row->account_status == 1)
                                                               <div class="badge badge-success">ACTIVE</div>
                                                           @endif
                                                           @if ($row->account_status == 0)
                                                               <div class="badge badge-warning">INACTIVE</div>
                                                           @endif
                                                       </td>
                                                       <td>
                                                           <a href="#{{ route('webmaster.memberaccount.edit', $row->account_no) }}"
                                                               class="btn btn-xs btn-dark"> <i
                                                                   class="far fa-edit"></i></a>
                                                       </td>
                                                   <tr>
                                               @endforeach
                                           </tbody>
                                       </table>
                                   </div><!-- table-responsive -->
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
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        "use strict";

        $('#member_type').change(function() {
            let member_type = $(this).val();
            if (member_type == 'individual') {
                $('#individualDiv').show();
                $('#groupDiv').hide();
            } else if (member_type == 'group') {
                $('#individualDiv').hide();
                $('#groupDiv').show();
            } else {
                $('#individualDiv').show();
                $('#groupDiv').hide();
            }
        });

        $("#member_form").submit(function(e) {
            e.preventDefault();
            $("#btn_member").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
            $("#btn_member").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.member.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_member").html('Add Member');
                        $("#btn_member").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#member_form")[0].reset();
                        removeErrors("#member_form");
                        $("#btn_member").html('Add Member');
                        $("#btn_member").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);

                    }
                }
            });
        });
    </script>
    <!--account creation script-->
    <script type="text/javascript">
        $('[data-toggle="select2"]').select2();

        $("#account_form").submit(function(e) {
            e.preventDefault();
            $("#btn_account").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
            $("#btn_account").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.memberaccount.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_account").html('Add Account');
                        $("#btn_account").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#account_form")[0].reset();
                        removeErrors("#account_form");
                        $("#btn_account").html('Add Account');
                        $("#btn_account").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);

                    }
                }
            });
        });
    </script>
@endsection
