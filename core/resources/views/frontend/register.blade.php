@php
    $titles = getTitles();
@endphp
@extends('frontend.partials.azia-main')
@section('title', 'Register')
@section('css')
    <!-- Ladda CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" />
@endsection
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">New Business Registration Form</h2>
        <form method="POST" action="{{ route('tenant.store') }}" id="bregForm">
            @csrf
            <div class="card bd-0">
                <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
                    <nav class="nav nav-tabs">
                        <a class="nav-link active" data-toggle="tab" href="#tenant_info">Entity Information</a>
                        <a class="nav-link" data-toggle="tab" href="#owner_info">Owner Information</a>
                    </nav>
                </div><!-- card-header -->
                <div class="card-body bd bd-t-0 tab-content">
                    <div id="tenant_info" class="tab-pane active">
                        <div class="row row-sm">
                            <!-- Business Name -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="biz_name">
                                            <i class="fas fa-building"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="business_name"
                                        placeholder="Business Name" aria-label="Business Name" aria-describedby="biz_name"
                                        value="{{ old('business_name') }}">
                                </div>
                            </div>
                            <!-- Industry -->
                            {{-- <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="industry">
                                            <i class="fas fa-industry"></i>
                                        </span>
                                    </div>
                                    <select name="industry" class="form-control" aria-describedby="industry">
                                        <option value="">Select Industry</option>
                                        @foreach ($industries as $industry)
                                            <option value="{{ $industry }}"
                                                {{ old('industry') == $industry ? 'selected' : '' }}>
                                                {{ $industry }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <!-- Country -->
                            {{-- <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="country">
                                            <i class="fas fa-globe-africa"></i>
                                        </span>
                                    </div>
                                    <select name="country" class="form-control" aria-describedby="country">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $code => $name)
                                            <option value="{{ $code }}"
                                                {{ old('country') == $code ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <!-- City -->
                            {{-- <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="city">
                                            <i class="fas fa-city"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="city" placeholder="City"
                                        aria-label="City" aria-describedby="city" value="{{ old('city') }}">
                                </div>
                            </div> --}}

                            <!-- Address -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="address">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="address" placeholder="Business Address"
                                        aria-label="Business Address" aria-describedby="address"
                                        value="{{ old('address') }}">
                                </div>
                            </div>

                            <!-- Business Contact -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="business_contact">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="business_contact"
                                        placeholder="Business Contact Number" aria-label="Business Contact"
                                        aria-describedby="business_contact" value="{{ old('business_contact') }}">
                                </div>
                            </div>

                            <!-- Alternate Contact -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="alt_contact">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="alternate_contact"
                                        placeholder="Alternate Contact" aria-label="Alternate Contact"
                                        aria-describedby="alt_contact" value="{{ old('alternate_contact') }}">
                                </div>
                            </div>
                            <!-- Entity Email -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="entity_email">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="entity_email"
                                        placeholder="Business Email" aria-label="Entity Email"
                                        aria-describedby="entity_email" value="{{ old('entity_email') }}">
                                </div>
                            </div>

                            <!-- Alternate Email -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="alt_email">
                                            <i class="fas fa-envelope-open"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="alternate_email"
                                        placeholder="Alternate Email" aria-label="Alternate Email"
                                        aria-describedby="alt_email" value="{{ old('alternate_email') }}">
                                </div>
                            </div>


                        </div>
                    </div>

                    <div id="owner_info" class="tab-pane">
                        <div class="row row-sm">
                            <!-- Title -->
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="ttl">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                    </div>
                                    <select name="title" class="form-control select2" style='width:80%'
                                        aria-describedby="ttl">
                                        <option label="Choose Title"></option>
                                        @foreach ($titles as $title)
                                            <option value="{{ $title }}"
                                                {{ old('title') == $title ? 'selected' : '' }}>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="first_name">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="fname" placeholder="First Name"
                                        aria-label="First Name" aria-describedby="first_name"
                                        value="{{ old('fname') }}">
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="last_name">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="lname" placeholder="Last Name"
                                        aria-label="Last Name" aria-describedby="last_name" value="{{ old('lname') }}">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="email">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Email Address" aria-label="Email" aria-describedby="email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="phone">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" placeholder="Phone Number"
                                        aria-label="Phone" aria-describedby="phone" value="{{ old('phone') }}">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="password">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        aria-label="Password" aria-describedby="password">
                                </div>
                                <small id="password-feedback" class="form-text"></small>
                            </div>
                            <!-- Confirm Password -->
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="password_confirmation">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm Password" aria-label="Confirm Password"
                                        aria-describedby="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
            <!-- Submit Button -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary ladda-button btn-sm bregBtn" data-style="expand-right"
                    style='width:50%'>
                    <span class="ladda-label">Register</span>
                </button>
            </div>
        </form>
    </div>
@endsection()
@section('scripts')
    <!-- Ladda JS + Spinner -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Choose Title',
                searchInputPlaceholder: 'Search'
            });
            const $password = $('input[name="password"]');
            const $confirm = $('input[name="password_confirmation"]');
            const $feedback = $('#password-feedback');

            function updatePasswordFeedback() {
                const password = $password.val();
                const confirm = $confirm.val();
                let strengthMsg = '';
                let matchMsg = '';
                let color = 'red';

                // Password strength logic
                if (password.length >= 8 && /[A-Z]/.test(password) &&
                    /[a-z]/.test(password) && /[0-9]/.test(password) &&
                    /[\W]/.test(password)) {
                    strengthMsg = 'Strength: Strong';
                    color = 'green';
                } else if (password.length >= 6) {
                    strengthMsg = 'Strength: Moderate';
                    color = 'orange';
                } else if (password.length > 0) {
                    strengthMsg = 'Strength: Weak';
                    color = 'red';
                }

                // Match check
                if (confirm.length > 0) {
                    if (password === confirm) {
                        matchMsg = '<br>Passwords match';
                        if (color !== 'red') color = 'green';
                    } else {
                        matchMsg = '<br>Passwords do not match';
                        color = 'red';
                    }
                }

                $feedback.html(`${strengthMsg}${matchMsg}`).css('color', color);
            }

            $password.on('input', updatePasswordFeedback);
            $confirm.on('input', updatePasswordFeedback);

            // AJAX submission with frontend match validation
            $('#bregForm').submit(function(e) {
                e.preventDefault();

                const password = $password.val();
                const confirm = $confirm.val();

                if (password !== confirm) {
                    $feedback.html('Passwords do not match').css('color', 'red');

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Password and confirmation do not match!',
                    });
                    return;
                }

                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                const laddaBtn = Ladda.create(document.querySelector('.ladda-button'));
                laddaBtn.start();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Registration successful.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                              $('#bregForm')[0].reset();
                            window.location.href = "{{ route('login') }}";
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorList = '';

                        if (errors) {
                            Object.keys(errors).forEach(key => {
                                errorList += `<li>${errors[key][0]}</li>`;
                            });
                        } else {
                            errorList = '<li>Something went wrong. Please try again.</li>';
                        }

                        Swal.fire({
                            title: 'Validation Errors',
                            html: `<ul style="text-align: left">${errorList}</ul>`,
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
@endsection
