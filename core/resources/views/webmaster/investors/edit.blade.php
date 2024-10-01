@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
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
                            <h3 class="card-title">Update Investor Information</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.investors') }}" class="btn btn-sm btn-dark btn-theme"> <i
                                    class="fa fa-eye"></i> View Investors</a>
                        </div>
                    </div>
                    <form action="#" method="POST" id="investor_form">
                        @csrf
                       
                        <div class="row">
                            <input type='hidden' value="{{$investor->id}}" name="id">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Names</label>
                                    <input type="text" value="{{ $investor->name }}" name="name" id="name"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="designation">Designation</label>
                                    <input type="text" value="{{ $investor->designation }}" name="designation"
                                        id="designation" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephone">Telephone</label>
                                    <input type="text"value="{{ $investor->telephone }}" name="telephone" id="telephone"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" value="{{ $investor->email }}" name="email" id="email"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address" rows="2">{{ $investor->address }}</textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <div class="image-upload image-uploadx">
                                        <div class="thumb thumbx">
                                            <img alt="image" class="mr-3" id="preview"
                                                src="{{ asset('assets/uploads/defaults/author.png') }}" width="60">
                                            <div class="upload-file">
                                                <input type="file" name="photo" class="form-control file-upload"
                                                    id="photo">
                                                <label for="photo" class="btn btn-secondary">upload photo </label>
                                                <span class="invalid-feedback"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_investor">Update
                                    Investor</button>
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
        "use strict";

        previewImage("photo", "preview");
        $("#investor_form").submit(function(e) {
            e.preventDefault();
            $("#btn_investor").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
            $("#btn_investor").prop("disabled", true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('webmaster.investor.update') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_investor").html('update Investor');
                        $("#btn_investor").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#investor_form")[0].reset();
                        removeErrors("#investor_form");
                        $("#btn_investor").html('update Investor');
                        $("#btn_investor").prop("disabled", false);
                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 500);

                    }
                }
            });
        });
    </script>
@endsection
