@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
@include('webmaster.partials.nav')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Transfer</h1>
</section>
<section class="content no-print">
    <div class="row">
        <div class="col-md-12">
            @component('webmaster.components.filters', ['title' =>'Filter'])
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('transfer_from_filter','Transfer From' . ':') !!}
                        {!! Form::select('transfer_from_filter', [], null,
                            ['class' => 'form-control accounts-dropdown', 'style' => 'width:100%',
                            'id' => 'transfer_from_filter', 'placeholder' =>'All']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('transfer_to_filter','Transfer To' . ':') !!}
                        {!! Form::select('transfer_to_filter', [], null,
                            ['class' => 'form-control accounts-dropdown', 'style' => 'width:100%',
                            'id' => 'transfer_to_filter', 'placeholder' =>'All']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('transfer_date_range_filter','Date Range' . ':') !!}
                        {!! Form::text('transfer_date_range_filter', null,
                            ['placeholder' =>'Select Date Range',
                            'class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('webmaster.components.widget', ['class' => 'box-solid'])
                {{-- @can('accounting.add_transfer') --}}
                    @slot('tool')
                        <div class="box-tools">
                            <button type="button" class="btn btn-primary tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right btn-modal"
                                data-href="{{action([\App\Http\Controllers\Webmaster\TransferController::class, 'create'])}}"
                                data-container="#create_transfer_modal" style="" id="create_transfer" title="Add Transfer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>Add
                            </button>
                        </div>
                    @endslot
                {{-- @endcan --}}
                <table class="table table-bordered table-striped" id="transfer_table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Date</th>
                            <th>Reference No.</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Amount</th>
                            <th>Added By</th>
                            <th>Additional Notes</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            @endcomponent
        </div>
    </div>
</section>
<div id="create_transfer_modal" class="modal">

</div><!-- modal -->
@stop

@section('scripts')
@include('webmaster.accounting.common_js')
<script type="text/javascript">
    $(document).ready( function(){
        // $(document).on('shown.bs.modal', '#create_transfer_modal', function(){
        //     $('#operation_date').datetimepicker({
        //         format: moment_date_format + ' ' + moment_time_format,
        //         ignoreReadonly: true,
        //     });
        //     $('#transfer_form').submit(function(e) {
        //         e.preventDefault();
        //     }).validate({
        //         submitHandler: function(form) {
        //             var data = $(form).serialize();

        //             $.ajax({
        //                 method: 'POST',
        //                 url: $(form).attr('action'),
        //                 dataType: 'json',
        //                 data: data,
        //                 beforeSend: function(xhr) {
        //                     __disable_submit_button($(form).find('button[type="submit"]'));
        //                 },
        //                 success: function(result) {
        //                     if (result.success == true) {
        //                         $('div#create_transfer_modal').modal('hide');
        //                         toastr.success(result.msg);
        //                         transfer_table.ajax.reload();
        //                     } else {
        //                         toastr.error(result.msg);
        //                     }
        //                 },
        //             });
        //         },
        //     })
        // });


        $(document).on("click","#create_transfer" ,function () {
            const url = $(this).data('href');
            $.ajax({
                type: "get",
                url:url,
                success: function (response) {
                    // console.log(response)

                    $('#operation_date_picker').datepicker({
                        format: 'mm/dd/yyyy',
                        autoclose: true,
                        todayHighlight: true
                    });
                    $("#create_transfer_modal").html(response.html)
                    $("#create_transfer_modal").modal('show')
                },
                error:function(xhr)
                {
                    console.log(xhr)
                    toastr.error('Something went wrong')
                }
            });
        });

        //Transfer table
        transfer_table = $('#transfer_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{action([\App\Http\Controllers\Webmaster\TransferController::class, 'index'])}}",
                data: function(d) {
                    var start = '';
                    var end = '';
                    if ($('#transfer_date_range_filter').val()) {
                        start = $('input#transfer_date_range_filter')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        end = $('input#transfer_date_range_filter')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                    d.start_date = start;
                    d.end_date = end;
                    d.transfer_from = $('#transfer_from_filter').val();
                    d.transfer_to = $('#transfer_to_filter').val();
                },
            },
            aaSorting: [[1, 'desc']],
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'operation_date', name: 'operation_date' },
                { data: 'ref_no', name: 'ref_no' },
                { data: 'from_account_name', name: 'from_account.name' },
                { data: 'to_account_name', name: 'to_account.name' },
                { data: 'amount', name: 'from_transaction.amount' },
                { data: 'added_by', name: 'added_by' },
                { data: 'note', name: 'accounting_acc_trans_mappings.note' }
            ]
        });
        $(document).on('change', '#transfer_from_filter, #transfer_to_filter', function(){
            transfer_table.ajax.reload();
        })
        $('#transfer_date_range_filter').daterangepicker(
            // dateRangeSettings,
            function (start, end) {
                $('#transfer_date_range_filter').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                transfer_table.ajax.reload();
            }
        );
        $('#transfer_date_range_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#transfer_date_range_filter').val('');
            transfer_table.ajax.reload();
        });

        //Delete Sale
        $(document).on('click', '.delete_transfer_button', function(e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(willDelete => {
                if (willDelete) {
                    var href = $(this).attr('data-href');
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                transfer_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });

	});

</script>
@endsection
