<div class="modal-content modal-content-demo" id='editModalContent'>
    {!! Form::open([
        'url' => action([\App\Http\Controllers\Webmaster\CoaController::class, 'update'], $account->id),
        'method' => 'put',
        'id' => 'create_client_form',
    ]) !!}

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Account</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('account_primary_type','Account Type' . ':*') !!}
                    <select class="form-control" name="account_primary_type" id="account_primary_type" required>
                        <option value="">Please Select</option>
                        @foreach ($account_types as $account_type => $account_details)
                            <option value="{{ $account_type }}" @if ($account->account_primary_type == $account_type) selected @endif>
                                {{ $account_type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('account_sub_type','Acount Sub Type'. ':*') !!}
                    <select class="form-control" name="account_sub_type_id" id="account_sub_type">
                        <option value="">Please Select</option>
                        @foreach ($account_sub_types as $account_type)
                            <option value="{{ $account_type->id }}"
                                data-show_balance="{{ $account_type->show_balance }}"
                                @if ($account->account_sub_type_id == $account_type->id) selected @endif>
                                {{ $account_type->account_type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('account_currency', 'Currency' . ':*') !!}
                    <select class="form-control" name="account_currency" id="account_currency" required>
                        <option value="">Please Select</option>
                        @foreach ($currencies as $currency)
                            @if ($currency->id == $account->account_currency)
                                <option value="{{ $currency->id }}" selected>{{ $currency->country }} -
                                    {{ $currency->code }}</option>
                            @else
                                <option value="{{ $currency->id }}">{{ $currency->country }} - {{ $currency->code }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('detail_type','Detail Type' . ':*') !!}

                    <select class="form-control" name="detail_type_id" id="detail_type">
                        <option value="">Please Select</option>
                        @foreach ($account_detail_types as $detail_type)
                            <option value="{{ $detail_type->id }}" @if ($account->detail_type_id == $detail_type->id) selected @endif>
                                {{ $detail_type->account_type_name }}</option>
                        @endforeach
                    </select>
                    <p class="help-block" id="detail_type_desc">
                        {{ $account->detail_type->account_type_description ?? '' }}</p>
                </div>
                <div class="form-group">
                    {!! Form::label('name', 'Name' . ':*') !!}
                    {!! Form::text('name', $account->name, [
                        'class' => 'form-control',
                        'required',
                        'placeholder' => 'Name',
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('gl_code','GLC' . ':') !!}
                    {!! Form::text('gl_code', $account->gl_code, [
                        'class' => 'form-control',
                        'placeholder' =>'General Ledger Code',
                    ]) !!}
                    <p class="help-block">All General Ledger accounts have a 6-digit number. 1xxxxxx = Assets, 2xxxxx = Liabilities, 3xxxxx = Net Assets, 4xxxxx = Revenue, 5xxxxx = Revenue, 8xxxxx = Allocations</p>
                </div>
                <div class="form-group">
                    {!! Form::label('parent_account','Parent Account' . ':') !!}
                    <select class="form-control" name="parent_account_id" id="parent_account">
                        <option value="">Please Select</option>
                        @foreach ($parent_accounts as $parent_account)
                            <option value="{{ $parent_account->id }}"
                                @if ($account->parent_account_id == $parent_account->id) selected @endif>
                                {{ $parent_account->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('description','Description' . ':') !!}
                    {!! Form::textarea('description', $account->description, [
                        'class' => 'form-control',
                        'placeholder' =>'Description',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class=" btn btn-primary tw-dw-btn tw-dw-btn-primary tw-text-white">Save</button>
        <button type="button" class="btn btn-danger tw-dw-btn tw-dw-btn-neutral tw-text-white"
            data-dismiss="modal">Close</button>
    </div>

    {!! Form::close() !!}
</div>
