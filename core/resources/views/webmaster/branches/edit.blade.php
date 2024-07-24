<div id="update_account_modal" class="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Update Branch</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST" id="branch_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-11 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <div class="clearfix mb-3">
                                        <div class="float-left">
                                            <h3 class="card-title">Branch Information Update</h3>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="branch_no" class="form-label">Branch No:</label>
                                                <input type="text" name="branch_no" id="branch_no"
                                                    class="form-control" value="" readonly>
                                                    <input type='hidden' name='branch_id' id='branch_id'>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name:</label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control">
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
                                                <input type="radio" id="no" name="is_main"
                                                    class="custom-control-input" value="0" checked>
                                                <label class="custom-control-label" for="no">NO</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="yes" name="is_main"
                                                    class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="yes">YES</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo" id='update_btn'>Update</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
