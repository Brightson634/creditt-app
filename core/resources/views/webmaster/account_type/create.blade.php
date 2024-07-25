
  <div id="create_account_type_modal" class="modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            {!! Form::open([
                'url' => action([\App\Http\Controllers\Webmaster\AccountTypeController::class, 'store']),
                'method' => 'post',
                'id' => 'create_account_type_form',
            ]) !!}
            {!! Form::hidden('account_type', null, ['id' => 'account_type']) !!}
          <div class="modal-header">
            <h6 class="modal-title">Add Account Sub Type</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name','Name' . ':*') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' =>'Name']) !!}
                        </div>
                    </div>
                </div>

                <div class="row" id="account_type_div">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('parent_id','Account Type' . ':*') !!}
                            <select class="form-control" style="width: 100%;" name="account_primary_type"
                                id="account_primary_type">
                                <option value="">Please Select</option>
                                @foreach ($account_types as $k => $v)
                                    <option value="{{ $k }}">{{ $v['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" id="parent_id_div">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('parent_id', 'Parent Type' . ':*') !!}
                            <select class="form-control" style="width: 100%;" name="parent_id" id="parent_id">
                                <option value="">Please Select</option>
                                @foreach ($account_sub_types as $account_type)
                                    <option value="{{ $account_type->id }}">
                                        {{ $account_type->account_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="description_div">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('description','Description' . ':') !!}
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control',
                                'placeholder' =>'Description',
                                'rows' => 3,
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-indigo">Save</button>
            <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
