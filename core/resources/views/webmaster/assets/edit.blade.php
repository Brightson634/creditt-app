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
                            <h3 class="card-title">Edit Asset Information</h3>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('webmaster.assets') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-eye"></i> View Assets</a>
                        </div>
                    </div>
                    <form action="#" method="POST" id="asset_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="asset_no" class="form-label">Asset No:</label>
                                    <input type="text" name="asset_no" id="asset_no" class="form-control"
                                        value="{{ $asset->asset_no }}" readonly>
                                </div>
                            </div>
                            <input type='hidden' name='id' value="{{$asset->id}}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Asset Name:</label>
                                    <input type="text" name="name" id="name" value="{{ $asset->asset_no }}" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="assetgroup_id" class="col-label">Asset Group</label>
                                    <select class="form-control" name="assetgroup_id" id="assetgroup_id">
                                        <option value="">select asset group</option>
                                        @foreach ($assetgroups as $data)
                                            <option value="{{ $data->id }}" @if($asset->assetgroup_id == $data->id) selected @endif>{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="serial_no" class="form-label">Asset Serial/Model</label>
                                    <input type="text" value="{{ $asset->serial_no }}" name="serial_no" id="serial_no" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost_price" class="form-label">Asset Cost Price:</label>
                                    <input type="text" value="{{ $asset->cost_price }}" name="cost_price" id="cost_price" class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_date" class="form-label">Asset Purchase Date</label>
                                    <input type="text" name="purchase_date" value="{{ $asset->purchase_date }}" class="form-control"
                                        data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd"
                                        id="purchase_date" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="staff_id" class="form-label">Asset Managed By</label>
                                    <select class="form-control" name="staff_id" id="staff_id">
                                        <option value="">select staff member</option>
                                        @foreach ($staffs as $data)
                                            <option value="{{ $data->id }}" @if($asset->staff_id == $data->id) selected @endif>{{ $data->salutation }} {{ $data->fname }}
                                                {{ $data->lname }} - {{ $data->staff_no }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location" class="form-label">Asset Location</label>
                                    <input type="text" value="{{$asset->location}}" name="location" class="form-control" id="location"
                                        autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="warrant_period" class="form-label">Warrant Period (in months)</label>
                                    <input type="text" value="{{$asset->warrant_period}}" name="warrant_period" class="form-control" id="warrant_period"
                                        autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="depreciation_period" class="form-label">Depreciation Period (in
                                        months)</label>
                                    <input type="text" value="{{$asset->depreciation_period}}" name="depreciation_period" id="depreciation_period"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="depreciation_amount" class="form-label">Depreciation Amount</label>
                                    <input type="text" value="{{$asset->depreciation_amount}}" name="depreciation_amount" id="depreciation_amount"
                                        class="form-control">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select class="form-control" name="supplier_id" id="supplier_id">
                                        <option value="">select supplier</option>
                                        @foreach ($suppliers as $data)
                                            <option value="{{ $data->id }}"
                                                 @if($asset->supplier_id == $data->id) selected @endif>{{ $data->name }} -
                                                {{ $data->supplier_no }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account_id" class="form-label">Account</label>
                                    <select name="account_id" class="form-control accounts-dropdown account_id"
                                        style="width: 100%;">
                                        <option value=''>Select Account</option>
                                        @foreach ($accounts_array as $account)
                                            <option value="{{ $account['id'] }}"
                                                data-currency="{{ $account['currency'] }}" @if($asset->account_type == $account['id'] ) selected @endif>{{ $account['name'] }}
                                                -{{ $account['primaryType'] }}-{{ $account['subType'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Date</label>
                                    <input type="text" name="date" class="form-control" data-provide="datepicker"
                                        data-date-autoclose="true" data-date-format="yyyy-mm-dd" id="date"
                                        value="{{ now()->format('Y-m-d') }}" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-theme" id="btn_asset">Update
                                    Asset</button>
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
            $('select.account_id').select2();
            $("#asset_form").submit(function(e) {
                e.preventDefault();
                $("#btn_asset").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
                $("#btn_asset").prop("disabled", true);
                $.ajax({
                    url: '{{ route('webmaster.asset.update') }}',
                    method: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.message, function(key, value) {
                                showError(key, value);
                            });
                            $("#btn_asset").html('Update Asset');
                            $("#btn_asset").prop("disabled", false);
                        } else if (response.status == 200) {
                            $("#asset_form")[0].reset();
                            removeErrors("#asset_form");
                            $("#btn_asset").html('Update Asset');
                            $("#btn_asset").prop("disabled", false);
                            setTimeout(function() {
                                window.location.href = response.url;
                            }, 1000);

                        }
                    }
                });
            });
        });
    </script>
@endsection
