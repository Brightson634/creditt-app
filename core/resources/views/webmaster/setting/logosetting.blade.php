@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
        .custom-card {
            border-radius: 10px;
            /* Smooth rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            background-color: #f9f9f9;
            /* Light background for a blended look */
            border: none;
            /* Remove sharp border */
        }

        .custom-card .card-body {
            padding: 20px;
            /* Adequate padding */
        }

        .img-fluid {
            border-radius: 8px;
            /* Rounded image corners */
            max-width: 100%;
            height: auto;
        }

        .btn {
            border-radius: 5px;
            /* Soft buttons */
        }

        .upload-file {
            margin-top: 20px;
        }

        body {
            background-color: #f0f2f5;
            /* Light background for page */
        }
    </style>
@endsection
@section('content')
    <div class="page-heading ">
        <div class="az-dashboard-nav">
            <nav class="nav">
                <a class="nav-link" href="{{ route('webmaster.generalsetting') }}">General Settings</a>
                <a class="nav-link" href="{{ route('webmaster.emailsetting') }}">Emailing Settings</a>
                <a class="nav-link active" href="{{ route('webmaster.logosetting') }}">Log Settings</a>
                <a class="nav-link" href="{{ route('webmaster.prefixsetting') }}">Prefix Settings</a>
                <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav>
        </div>
    </div>
    <div class="row">
        <!-- Main Logo Upload -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="text-center">
                        <h4 class="card-title mb-3">Main Logo</h4>
                        <div class="image-upload">
                            <div class="thumb">
                                @if ($setting->logo != null)
                                    <img alt="logo" id="logo_preview"
                                        src="{{ asset('assets/uploads/generals/' . $setting->logo) }}" width="228"
                                        class="img-fluid rounded">
                                @else
                                    <img alt="logo" id="logo_preview"
                                        src="{{ asset('assets/uploads/defaults/logo.png') }}" width="228"
                                        class="img-fluid rounded">
                                @endif
                                <div class="upload-file mt-3">
                                    <input type="file" name="logo" class="file-upload" id="logo">
                                    <label for="logo" class="btn bg-info">Upload Main Logo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Logo Upload -->
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="text-center">
                        <h4 class="card-title mb-3">Footer Logo</h4>
                        <div class="image-upload">
                            <div class="thumb">
                                @if ($setting->footerlogo != null)
                                    <img alt="footer logo" id="footerlogo_preview"
                                        src="{{ asset('assets/uploads/generals/' . $setting->footerlogo) }}" width="228"
                                        class="img-fluid rounded">
                                @else
                                    <img alt="footer logo" id="footerlogo_preview"
                                        src="{{ asset('assets/uploads/defaults/logo.png') }}" width="228"
                                        class="img-fluid rounded">
                                @endif
                                <div class="upload-file mt-3">
                                    <input type="file" name="footerlogo" class="file-upload" id="footerlogo">
                                    <label for="footerlogo" class="btn bg-info">Upload Footer Logo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favicon Upload -->
        <div class="col-md-6 mt-2">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="text-center">
                        <h4 class="card-title mb-3">Favicon</h4>
                        <div class="image-upload">
                            <div class="thumb">
                                @if ($setting->favicon != null)
                                    <img alt="favicon" id="favicon_preview"
                                        src="{{ asset('assets/uploads/generals/' . $setting->favicon) }}" width="100"
                                        class="img-fluid rounded">
                                @else
                                    <img alt="favicon" id="favicon_preview"
                                        src="{{ asset('assets/uploads/defaults/favicon.png') }}" width="40"
                                        class="img-fluid rounded">
                                @endif
                                <div class="upload-file mt-3">
                                    <input type="file" name="favicon" class="file-upload" id="favicon">
                                    <label for="favicon" class="btn bg-info">Upload Favicon</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#logo").change(function(e) {
            const file = e.target.files[0];
            let url = window.URL.createObjectURL(file);
            $("#logo_preview").attr('src', url);
            let form_data = new FormData();
            form_data.append('logo', file);
            form_data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('webmaster.logo.update') }}',
                method: 'post',
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    window.location.reload();
                    $("#logo").val('');
                }
            });
        });

        $("#footerlogo").change(function(e) {
            const file = e.target.files[0];
            let url = window.URL.createObjectURL(file);
            $("#footerlogo_preview").attr('src', url);
            let form_data = new FormData();
            form_data.append('footerlogo', file);
            form_data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('webmaster.footerlogo.update') }}',
                method: 'post',
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    window.location.reload();
                    $("#footerlogo").val('');
                }
            });
        });

        $("#favicon").change(function(e) {
            const file = e.target.files[0];
            let url = window.URL.createObjectURL(file);
            $("#favicon_preview").attr('src', url);
            let form_data = new FormData();
            form_data.append('favicon', file);
            form_data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('webmaster.favicon.update') }}',
                method: 'post',
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    window.location.reload();
                    $("#favicon").val('');
                }
            });
        });
    </script>
@endsection
