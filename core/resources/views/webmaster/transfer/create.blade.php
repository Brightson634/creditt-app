<div class="modal-dialog" role="document">
    <div class="modal-content modal-content-demo">

    {!! Form::open(['url' => action([\App\Http\Controllers\Webmaster\TransferController::class, 'store']),
        'method' => 'post', 'id' => 'transfer_form' ]) !!}

      <div class="modal-header">
            <h6 class="modal-title">Add Transfer</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <div class="modal-body">
        <div class="form-group">
            {!! Form::label('ref_no','Reference No'.':') !!}
            {{-- @show_tooltip(__('lang_v1.leave_empty_to_autogenerate')) --}}
            {!! Form::text('ref_no', null, ['class' => 'form-control'])!!}
        </div>
        <div class="form-group">
            {!! Form::label('from_account','Transfer From' .":*") !!}
            {!! Form::select('from_account', [], null, ['class' => 'form-control accounts-dropdown', 'required',
                'placeholder' =>"Please Select" ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('to_account',"Transfer To" .":*") !!}
            {!! Form::select('to_account', [], null, ['class' => 'form-control accounts-dropdown', 'required',
                'placeholder' =>"Please Select" ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('amount',"Amount" .":*") !!}
            {!! Form::text('amount', 0, ['class' => 'form-control input_number',
                'required','placeholder' =>"Amount" ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('operation_date',"Date" .":*") !!}
            <div class="input-group">
                @php
                use Carbon\Carbon;
                @endphp
                {!! Form::text('operation_date',  \Carbon\Carbon::now()->format('m/d/Y'), ['class' => 'form-control',
                    'required','placeholder' =>'Date', 'id' => 'operation_date' ]) !!}
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('note','Note') !!}
            {!! Form::textarea('note', null, ['class' => 'form-control',
                'placeholder' =>"Note", 'rows' => 4]) !!}
        </div>
    </div>

     <div class="modal-footer">
            <button type="submit" class="btn btn-indigo">Save </button>
            <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

