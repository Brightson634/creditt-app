@extends('webmaster.partials.auth')
@section('content')
    <style>
        .logo-img {
            max-width: 200px;
            /* Adjust as needed */
            height: auto;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="w-100 d-block bg-white rounded my-5">
                    <div class="p-5">
                        <div class="text-center mb-3">
                            <img src="{{ asset('assets/uploads/generals/' . $gs->logo) }}" class="logo-img">
                        </div>
                        <p class="mb-4">Enter your email and password to access admin panel.</p>
                        <form action="#" method="POST" id="login_form">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email">
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-lg btn-theme btn-block" id="btn_login">Login</button>
                            </div>
                        </form>
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <p class="mb-2"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(function() {
            $("#login_form").submit(function(e) {
                e.preventDefault();
                $("#btn_login").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>'
                );
                $("#btn_login").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.login.submit') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_login").html('Login');
                            $("#btn_login").prop("disabled", false);
                        } else if (response.status == 200) {
                            //   $("#login_form")[0].reset();
                            removeErrors("#login_form");
                            $("#btn_login").html('Login');
                            setTimeout(function() {
                                $("#btn_login").prop("disabled", false);
                                window.location.href = response.url;
                            }, 300);

                        }
                    }
                });
            });
        });
    </script>
@endsection
