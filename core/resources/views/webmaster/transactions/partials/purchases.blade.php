<div class="pos-tab-content">
    <div class="row">
        {{-- @component('components.filters', ['title' => __('report.filters')]) --}}
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_location_id','Location' . ':') !!}
                    {!! Form::select('purchase_list_filter_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' =>'All']); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_supplier_id', 'Supplier'. ':') !!}
                    {!! Form::select('purchase_list_filter_supplier_id', $suppliers, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' =>'All']); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_status', 'Status' . ':') !!}
                    {!! Form::select('purchase_list_filter_status', $orderStatuses, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' =>'All'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_payment_status','Status' . ':') !!}
                    {!! Form::select('purchase_list_filter_payment_status', ['paid' =>'Paid', 'due' =>'Due', 'partial' => "Partial", 'overdue' =>"Overdue"], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' =>'All'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('purchase_list_filter_date_range','Date Range' . ':') !!}
                    {!! Form::text('purchase_list_filter_date_range', null, ['placeholder' =>'Select Date Range', 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
        {{-- @endcomponent --}}
    </div>

    <div class="row">
        <div class="col-md-12">


        <table class="table table-bordered table-striped" id="purchase_table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Date</th>
                    <th>Ref No</th>
                    <th>Location</th>
                    <th>Supplier</th>
                    <th>Purchase Status</th>
                    <th>Payment Status</th>
                    <th>Grand Total</th>
                    <th>Payment Due &nbsp;&nbsp;<i class="fa fa-info-circle text-info no-print" data-toggle="tooltip" data-placement="bottom" data-html="true" data-original-title="Purchase Due" aria-hidden="true"></i></th>
                    <th>Added By</th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
</div>
