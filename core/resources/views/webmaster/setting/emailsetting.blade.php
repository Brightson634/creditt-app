@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
        .custom-card {
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            background-color: #f9f9f9;
            /* Light background color to blend with page */
            border: none;
            /* Remove sharp borders */
        }

        .custom-card .card-body {
            padding: 20px;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            border-radius: 5px;
        }

        .form-control {
            border-radius: 5px;
            border-color: #ced4da;
        }

        .invalid-feedback {
            color: #dc3545;
        }

        h4.card-title {
            font-weight: 600;
        }

        body {
            background-color: #f0f2f5;
        }
    </style>
@endsection
@section('content')
    <div class="page-heading ">
        @include('webmaster.setting.commonheader')
    </div>

    <div class="row">
        <!-- Left Column: Email Settings -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Email Settings</h4>
                    <form action="#" method="POST" id="setting_form">
                        @csrf
                        <div class="form-group">
                            <label for="smtp_host">SMTP Host</label>
                            <input type="text" name="smtp_host" class="form-control" id="smtp_host"
                                value="{{ $setting->smtp_host }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="mail_type">Mail Type</label>
                            <input type="text" name="mail_type" class="form-control" id="mail_type"
                                value="{{ $setting->mail_type }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="smtp_port">SMTP Port</label>
                            <input type="text" name="smtp_port" class="form-control" id="smtp_port"
                                value="{{ $setting->smtp_port }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="smtp_password">SMTP Password</label>
                            <input type="text" name="smtp_password" class="form-control" id="smtp_password"
                                value="{{ $setting->smtp_password }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="mail_encryption">Mail Encryption</label>
                            <input type="text" name="mail_encryption" class="form-control" id="mail_encryption"
                                value="{{ $setting->mail_encryption }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="from_email">Sender Email</label>
                            <input type="email" name="from_email" class="form-control" id="from_email"
                                value="{{ $setting->from_email }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="from_name">Sender Name</label>
                            <input type="text" name="from_name" class="form-control" id="from_name"
                                value="{{ $setting->from_name }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        @can('update_email_settings')
                        <div class="form-group">
                            <button type="submit" class="btn btn-info" id="btn_setting">Update Settings</button>
                        </div>
                        @endcan
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Test Email -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Send Test Email</h4>
                    <form action="#" method="POST" id="test_form">
                        @csrf
                        <div class="form-group">
                            <label for="email">Test Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                value="{{ $setting->email }}">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info" id="btn_test">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#setting_form").submit(function(e) {
            e.preventDefault();
            $("#btn_setting").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
            $("#btn_setting").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.emailsetting.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_setting").html('Update Settings');
                        $("#btn_setting").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#setting_form");
                        $("#btn_setting").html('Update Settings');
                        setTimeout(function() {
                            $("#btn_setting").prop("disabled", false);
                            window.location.reload();
                        }, 500);

                    }
                },
                error: function(xhr) {
                    $("#btn_setting").html('Update Settings');
                    if (xhr.status === 403) {
                        return toastr.error(xhr.responseJSON.message)
                    }
                }
            });
        });

        $("#test_form").submit(function(e) {
            e.preventDefault();
            $("#btn_test").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Sending'
                );
            $("#btn_test").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.send.testemail') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_test").html('Send Email');
                        $("#btn_test").prop("disabled", false);
                    } else if (response.status == 200) {
                        removeErrors("#test_form");
                        $("#btn_test").html('Send Email');
                        setTimeout(function() {
                            $("#btn_test").prop("disabled", false);
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });
    </script>
@endsection
