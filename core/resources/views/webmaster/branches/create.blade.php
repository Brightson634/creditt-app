@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading">
    </div>
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <div class="float-left">
                            <h3 class="card-title">Branch Information</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.branches') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-eye"></i> View Branches</a>
                        </div>
                    </div>
                    <form action="#" method="POST" id="branch_form">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_no" class="form-label">Branch No:</label>
                                    <input type="text" name="branch_no" id="branch_no" class="form-control"
                                        value="{{ $branch_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Default Currency:</label>
                                    <select class="form-control" name='default_curr' id="default_curr">
                                        <option value="">Please Select</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->country }} -
                                                {{ $currency->currency }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Telephone:</label>
                                <input type="text" name="telephone" id="telephone" class="form-control">
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="physical_address" class="form-label">Physical Address:</label>
                                <textarea name="physical_address" class="form-control" id="physical_address" rows="3"></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="postal_address" class="form-label">Postal Address:</label>
                                <textarea name="postal_address" class="form-control" id="postal_address" rows="3"></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="is_main" class="col-sm-3 col-form-label">Is Main Branch</label>
                            <div class="col-sm-9 mt-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="no" name="is_main" class="custom-control-input"
                                        value="0" checked>
                                    <label class="custom-control-label" for="no">NO</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="yes" name="is_main" class="custom-control-input"
                                        value="1">
                                    <label class="custom-control-label" for="yes">YES</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_branch">Add
                                    Branch</button>
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
        $(document).ready(function() {
            $('#default_curr').select2({
                placeholder: "Please Select"
            });
            $("#branch_form").submit(function(e) {
                e.preventDefault();
                // $("#btn_branch").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding');
                $("#btn_branch").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.branch.store') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_branch").html('Add Branch');
                            $("#btn_branch").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#branch_form")[0].reset();
                            removeErrors("#branch_form");
                            $("#btn_branch").html('Add Branch');
                            $("#btn_branch").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                });
            });
        });
    </script>
@endsection
