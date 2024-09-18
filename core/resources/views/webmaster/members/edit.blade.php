@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading ">
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
                            <h3 class="card-title">Member Information</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.members') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-eye"></i> View Members</a>
                        </div>
                    </div>
                    <form action="#" method="POST" id="member_form">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $member->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="member_no" class="form-label">Member No</label>
                                    <input type="text" name="member_no" id="member_no" class="form-control"
                                        value="{{ $member->member_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="member_type" class="form-label">Individual / Group </label>
                                    <select class="form-control" name="member_type" id="member_type">
                                        <option value="">select member type</option>
                                        <option value="individual" @if ($member->member_type == 'individual') ? selected @endif>
                                            Individual Member</option>
                                        <option value="group" @if ($member->member_type == 'group') ? selected @endif>Group
                                            Member</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        @if ($member->member_type == 'individual')
                            <div id="individualDiv">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            @php
                                                $titles = ['Mr', 'Mrs', 'Miss', 'Dr', 'Eng', 'Rev', 'Hon'];
                                            @endphp
                                            <label for="title" class="form-label">Title</label>
                                            <select class="form-control" name="title" id="title">
                                                <option value="">Select title</option>
                                                @foreach ($titles as $title)
                                                    <option value="{{ $title }}"
                                                        @if ($member->title == $title) selected @endif>
                                                        {{ $title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fname" class="form-label">First Name:</label>
                                            <input type="text" value="{{ $member->fname }}" name="fname" id="fname"
                                                class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" name="lname" value={{ $member->lname }} id="lname"
                                                class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="oname" class="form-label">Other Name</label>
                                            <input type="text" value="{{ $member->oname }}" name="oname" id="oname"
                                                class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($member->member_type == 'individual')
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                @php
                                                    $genders = ['Male', 'Female', 'Other'];
                                                @endphp

                                                <label for="gender" class="form-label">Gender</label>
                                                <select class="form-control" name="gender" id="gender">
                                                    <option value="">Select gender</option>
                                                    @foreach ($genders as $gender)
                                                        <option value="{{ $gender }}"
                                                            @if ($member->gender == $gender) selected @endif>
                                                            {{ $gender }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="marital_status" class="form-label">Marital Status</label>
                                                @php
                                                    $maritalStatus = ['NA', 'Single', 'Married', 'Divorced'];
                                                @endphp
                                                <select class="form-control" name="marital_status" id="marital_status">
                                                    <option value="">select status</option>
                                                    @foreach ($maritalStatus as $marital)
                                                        <option value="{{ $marital }}"
                                                            @if ($member->marital_status == $marital) selected @endif>
                                                            {{ $marital }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="text" name="dob" class="form-control"
                                                    data-provide="datepicker" data-date-autoclose="true"
                                                    value={{ $member->dob }} data-date-format="yyyy-mm-dd"
                                                    id="dob" autocomplete="off">
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="disability" class="form-label">Disability</label>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="dno" name="disability"
                                                        class="custom-control-input" value="No"
                                                        @if ($member->disability == 'No') ? checked @endif>
                                                    <label class="custom-control-label" for="dno">NO</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="dyes" name="disability"
                                                        class="custom-control-input" value="Yes"
                                                        @if ($member->disability == 'Yes') ? checked @endif>
                                                    <label class="custom-control-label" for="dyes">YES</label>
                                                </div>
                                            </div>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else:
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="fname" class="form-label">Group Name:</label>
                                        <input type="text" value="{{ $member->fname }}" name="fname"
                                            id="fname" class="form-control">
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($member->member_type == 'group')
                            <div id="groupDiv" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="group_name" class="form-label">Group Name</label>
                                            <input type="text" value="{{ $member->name }}" name="group_name"
                                                id="group_name" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <input type="text" value="{{ $member->description }}" name="description"
                                                id="description" class="form-control">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephone" class="form-label">Telephone</label>
                                    <input type="text" value="{{ $member->telephone }}" name="telephone"
                                        id="telephone" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"value="{{ $member->email }}" name="email" id="email"
                                        class="form-control">
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
                                    <select class="form-control" name="subscriptionplan_id" id="subscriptionplan_id">
                                        <option value="">select branch</option>
                                        @foreach ($branches as $data)
                                            <option value="{{ $data->id }}"
                                                @if ($member->subscriptionplan_id == $data->id) ? selected @endif>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-primary btn-theme" id="btn_member">Update
                                    Member</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).on('click', '#btn_member', function(e) {
            e.preventDefault();
            $("#btn_member").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $("#btn_member").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.member.update') }}',
                method: 'post',
                data: $("#member_form").serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_member").html('Update Member');
                        $("#btn_member").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#member_form");
                        $("#btn_member").html('Update Member');
                        $("#btn_member").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);

                    }
                }
            });
        });
    </script>
@endsection
