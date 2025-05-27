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
    <div class='shadow-base rounded-2 bg-white p-3'>
        <div class="row">
            <!-- Left Column: Email Settings -->
            <div class="col-md-6">
                <form action="#" method="POST" id="setting_form">
                    @csrf
                    {{-- Mail Host --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-server"></i></span>
                            </div>
                            <input type="text" name="smtp_host" class="form-control @error('_host') is-invalid @enderror"
                                placeholder="SMTP Host (e.g. smtp.mailgun.org)"
                                value="{{ old('smtp_host', $setting->smtp_host ?? '') }}">
                            @error('smtp_host')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Mail Type --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                            </div>
                            <input type="text" name="mail_type"
                                class="form-control @error('mail_type') is-invalid @enderror"
                                placeholder="Mail Type (e.g. smtp)"
                                value="{{ old('mail_type', $setting->mail_type ?? '') }}">
                            @error('mail_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- Mail Port --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-plug"></i></span>
                            </div>
                            <input type="number" name="smtp_port"
                                class="form-control @error('smtp_port') is-invalid @enderror"
                                placeholder="SMTP Port (e.g. 587)"
                                value="{{ old('smtp_port', $setting->smtp_port ?? '') }}">
                            @error('smtp_port')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Mail Username --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="email_user_name"
                                class="form-control @error('email_user_name') is-invalid @enderror"
                                placeholder="Email Username"
                                value="{{ old('email_user_name', $setting->email_user_name ?? '') }}">
                            @error('email_user_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Mail Password --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="text" name="smtp_password"
                                class="form-control @error('smtp_password') is-invalid @enderror"
                                placeholder="Email Password" value="{{ $setting->smtp_password }}">
                            @error('smtp_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Mail Encryption --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <select name="mail_encryption"
                                class="form-control @error('mail_encryption') is-invalid @enderror">
                                <option value="">-- Encryption --</option>
                                <option value="tls"
                                    {{ old('mail_encryption', $setting->mail_encryption ?? '') == 'tls' ? 'selected' : '' }}>
                                    TLS
                                </option>
                                <option value="ssl"
                                    {{ old('mail_encryption', $setting->mail_encryption ?? '') == 'ssl' ? 'selected' : '' }}>
                                    SSL
                                </option>
                                <option value="null"
                                    {{ old('mail_encryption', $setting->mail_encryption ?? '') == 'null' ? 'selected' : '' }}>
                                    None
                                </option>
                            </select>
                            @error('mail_encryption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- From Address --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="from_email"
                                class="form-control @error('mail_from_address') is-invalid @enderror"
                                placeholder="From Address (e.g. no-reply@yourdomain.com)"
                                value="{{ old('from_email', $setting->from_email ?? '') }}">
                            @error('from_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- From Name --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            </div>
                            <input type="text" name="from_name"
                                class="form-control @error('from_name') is-invalid @enderror"
                                placeholder="From Name (e.g. CreditApp Notifications)"
                                value="{{ old('from_name', $setting->from_name ?? '') }}">
                            @error('from_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @can('update_email_settings')
                        <div class="form-group">
                            <button type="submit" class="btn btn-info" id="btn_setting">Update Settings</button>
                        </div>
                    @endcan
                </form>
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
                    $("#btn_setting").prop("disabled", false);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(i, msg) {
                                toastr.error(msg);
                            });
                        });
                    } else {
                        toastr.error("An unexpected error occurred.");
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
