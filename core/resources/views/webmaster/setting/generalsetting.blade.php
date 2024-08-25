@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
<style>
    /* Custom card styling */
.custom-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px; 
    background-color: #f9f9f9; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}

/* Custom form group styling */
.custom-form-group {
    margin-bottom: 1rem;
}

.custom-form-control {
    border-radius: 4px; 
    border: 1px solid #ced4da;
}

/* Custom button styling */
.custom-btn {
    background-color: #007bff; 
    color: #fff; 
    border: none; 
    border-radius: 4px; 
    padding: 0.375rem 0.75rem;
    font-size: 1rem; 
}

.custom-btn:hover {
    background-color: #0056b3;
}

</style>
@endsection
@section('content')
    <div class="page-heading ">
        <div class="az-dashboard-nav">
            <nav class="nav">
              <a class="nav-link active"  href="{{route('webmaster.generalsetting')}}">Information Settings</a>
              <a class="nav-link" href="{{route('webmaster.emailsetting')}}">Emailing Settings</a>
              <a class="nav-link active"  href="{{ route('webmaster.logosetting') }}">Log Settings</a>
              <a class="nav-link" href="{{route('webmaster.prefixsetting')}}">Prefix Settings</a>
              <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav>
          </div>
        {{-- <div class="page-heading__title">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('webmaster.generalsetting') }}"><i class="fas fa-chart-line"></i>
                        General Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('webmaster.emailsetting') }}"><i class="far fa-user"></i> Email
                        Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('webmaster.smssetting') }}"><i class="far fa-user"></i> SMS
                        Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('webmaster.logosetting') }}"> <i class="far fa-user"></i> Logo
                        Settings</a>
                </li>
            </ul>
        </div> --}}
    </div>

    <div class="row">
        <!-- System Information Card -->
        <div class="col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h4 class="card-title mb-4">System Information</h4>
                    <form action="#" method="POST" id="setting_form">
                        @csrf
                        <div class="row">
                            <!-- System Name and Company Name -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group custom-form-group">
                                    <label for="system_name">System Name</label>
                                    <input type="text" name="system_name" class="form-control custom-form-control" id="system_name" value="{{ $setting->system_name }}">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group custom-form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" name="company_name" class="form-control custom-form-control" id="company_name" value="{{ $setting->company_name }}">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Currency Symbol and Address -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group custom-form-group">
                                    <label for="currency_symbol">Currency Symbol</label>
                                    <input type="text" name="currency_symbol" class="form-control custom-form-control" id="currency_symbol" value="{{ $setting->currency_symbol }}">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group custom-form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control custom-form-control" id="address" rows="5">{{ $setting->address }}</textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn custom-btn" id="btn_setting">Update Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection

@section('scripts')
    <script type="text/javascript">
        "use strict";
        $('.nav-pills a').on('shown.bs.tab', function(event) {
            var tab = $(event.target).attr("href");
            var url = "{{ route('webmaster.generalsetting') }}";
            history.pushState({}, null, url + "?tab=" + tab.substring(1));
        });

        @if (isset($_GET['tab']))
            $('.nav-pills a[href="#{{ $_GET['tab'] }}"]').tab('show');
        @endif


        $("#setting_form").submit(function(e) {
            e.preventDefault();
            $("#btn_setting").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
            $("#btn_setting").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.generalsetting.update') }}',
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
                }
            });
        });
    </script>
@endsection
