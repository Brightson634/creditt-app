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
            padding: 1.5rem;
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
                            <h3 class="card-title">Staff Information Update</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.staffs') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-eye"></i> View Staffs</a>
                        </div>
                    </div>
                    <form action="#" method="POST" id="staff_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="staff_no" class="form-label">Staff No</label>
                                    <input type="text" name="staff_no" id="staff_no" class="form-control"
                                        value="{{ $staffMember->staff_no }}" readonly>
                                </div>

                                <input type="hidden" name="staff_id" id="staff_id" class="form-control"
                                    value="{{ $staffMember->staff_id }}" readonly>

                            </div>
                            <div class="col-md-2">
                                @php
                                    $titles = ['Mr', 'Mrs', 'Miss', 'Dr', 'Eng', 'Rev', 'Hon'];
                                @endphp
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <select class="form-control" name="title" id="title">
                                        <option value="">select title</option>
                                        @foreach ($titles as $title)
                                            <option value="{{ $title }}"
                                                @if ($staffMember->title == $title) selected @endif>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" name="fname" id="fname" value="{{ $staffMember->fname }}"
                                        class="form-control" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" name="lname" id="lname" value="{{ $staffMember->lname }}"
                                        class="form-control" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telephone" class="form-label">Telephone</label>
                                    <input type="text" value="{{ $staffMember->telephone }}" name="telephone"
                                        id="telephone" class="form-control" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $staffMember->email }}" id="email"
                                        class="form-control" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" value="{{ $staffMember->password }}"
                                        id="password" class="form-control" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_id" class="form-label">Branch Name</label>
                                    <select class="form-control" name="branch_id" id="branch_id">
                                        <option value="">select branch</option>
                                        @foreach ($branches as $data)
                                            <option value="{{ $data->id }}"
                                                @if ($staffMember->branch_id = $data->id) selected @endif>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branchposition_id" class="form-label">Designation</label>
                                    <select class="form-control" name="branchposition_id" id="branchposition_id">
                                        <option value="">select branch position</option>
                                        @foreach ($positions as $data)
                                            <option value="{{ $data->id }}"
                                                @if ($staffMember->branchposition_id = $data->id) selected @endif>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branchposition_id" class="form-label">Role</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="">Accord Role</option>
                                        @foreach ($roles as $data)
                                            <option value="{{ $data->id }}"
                                                @if ($staffMember->branchposition_id = $data->id) selected @endif>{{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_staff">Update
                                    Staff</button>
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
        $(document).on('click', '#btn_staff', function(e) {
            e.preventDefault();
            $("#btn_staff").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
            );
            $("#btn_staff").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.staff.update') }}',
                method: 'post',
                data: $("#staff_form").serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_staff").html('Update Staff');
                        $("#btn_staff").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#staff_form");
                        $("#btn_staff").html('Update Staff');
                        $("#btn_staff").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);

                    }
                }
            });
        });
    </script>
@endsection