<div id="create_account_modal" class="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Account</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([
                'url' => action([\App\Http\Controllers\Webmaster\CoaController::class, 'store']),
                'method' => 'post',
                'id' => 'create_client_form',
            ]) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('account_primary_type', 'Account Type' . ':*') !!}
                            <select class="form-control" name="account_primary_type" id="account_primary_type" required>
                                <option value="">Please Select</option>
                                @foreach ($account_types as $account_type => $account_details)
                                    <option value="{{ $account_type }}">{{ @ucfirst($account_type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::label('account_sub_type', 'Account Sub Type' . ':*') !!}
                            <select class="form-control" name="account_sub_type_id" id="account_sub_type" required>
                                <option value="">Please Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::label('account_currency', 'Currency' . ':*') !!}
                            <select class="form-control" name="account_currency" id="account_currency" required>
                                <option value="">Please Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->country }} - {{ $currency->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::label('detail_type', 'Detail Type' . ':*') !!}
                            {!! Form::select('detail_type_id', [], null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => 'Please Select',
                                'id' => 'detail_type',
                            ]) !!}
                            <p class="help-block" id="detail_type_desc"></p>
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Name' . ':*') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Name']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('gl_code', 'GLC' . ':') !!}
                            {!! Form::text('gl_code', null, ['class' => 'form-control', 'placeholder' => 'General Ledger Code']) !!}
                            <p class="help-block">All General Ledger accounts have a 6-digit number. 1xxxxxx = Assets,
                                2xxxxx = Liabilities, 3xxxxx = Net Assets, 4xxxxx = Revenue, 5xxxxx = Revenue, 8xxxxx =
                                Allocations</p>
                        </div>
                        <div class="form-group">
                            {!! Form::label('parent_account', 'Parent Account' . ':') !!}
                            {!! Form::select('parent_account_id', [], null, [
                                'class' => 'form-control',
                                'placeholder' => 'Please Select',
                                'id' => 'parent_account',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row" id="bal_div">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('balance', 'Balance' . ':') !!}
                            {!! Form::text('balance', null, [
                                'class' => 'form-control input_number',
                                'placeholder' => 'Balance',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('as_of', 'As Of' . ':') !!}
                            <div class="input-group">
                                {!! Form::text('balance_as_of', null, ['class' => 'form-control', 'id' => 'as_of']) !!}
                                <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('description', 'Description' . ':') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'description']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Save</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

