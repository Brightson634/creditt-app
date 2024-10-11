@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
@section('css')
@endsection
@include('webmaster.partials.nav')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Journal Entry</h1>
</section>
<section class="content no-print">
    <div class="row">
        <div class="col-md-12">
            @component('webmaster.components.filters', ['title' => 'Filters'])
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('journal_entry_date_range_filter', 'Date Range' . ':') !!}
                        {!! Form::text('journal_entry_date_range_filter', null, [
                            'placeholder' => 'Select Date Range',
                            'class' => 'form-control',
                            'readonly',
                        ]) !!}
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    @component('webmaster.components.widget', ['class' => 'box-solid'])
        @can('add_accounting_journal')
        @slot('tool')
            <div class="box-tools">
                <a class="btn btn-primary tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right"
                    href="{{ action([App\Http\Controllers\Webmaster\JournalEntryController::class, 'create']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>Add
                </a>
            </div>
        @endslot
        @endcan

        <table class="table table-bordered table-striped" id="journal_table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Journal Date</th>
                    <th>Reference No</th>
                    <th>Added By</th>
                    <th>Additional Notes</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @endcomponent
</section>

@stop

@section('scripts')
@if (session('status'))
    <script>
        $(document).ready(function() {
            @if (session('status')['success'])
                toastr.success("{{ session('status')['msg'] }}");
            @else
                toastr.error("{{ session('status')['msg'] }}");
            @endif
        });
    </script>
@endif
<script type="text/javascript">
    $(document).ready(function() {

        //Journal table
        journal_table = $('#journal_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url('/') }}/webmaster/accounting/journal-entry',
                data: function(d) {
                    var start = '';
                    var end = '';
                    if ($('#journal_entry_date_range_filter').val()) {
                        start = $('input#journal_entry_date_range_filter')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        end = $('input#journal_entry_date_range_filter')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                    d.start_date = start;
                    d.end_date = end;
                },
            },
            aaSorting: [
                [1, 'desc']
            ],
            columns: [{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'operation_date',
                    name: 'operation_date'
                },
                {
                    data: 'ref_no',
                    name: 'ref_no'
                },
                {
                    data: 'added_by',
                    name: 'added_by'
                },
                {
                    data: 'note',
                    name: 'note'
                }
            ]
        });

        $('#journal_entry_date_range_filter').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#journal_entry_date_range_filter').val(start.format('MM/DD/YYYY') + ' ~ ' + end
                    .format('MM/DD/YYYY'));
                journal_table.ajax.reload();
            }
        );
        $('#journal_entry_date_range_filter').on('cancel.daterangepicker', function(ev, picker) {
            $('#journal_entry_date_range_filter').val('');
            journal_table.ajax.reload();
        });

        //Delete Sale
        $(document).on('click', '.delete_journal_button', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'confirm!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                journal_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 403) {
                                return toastr.error(xhr.responseJSON.message);
                            }

                            toastr.error('Unexpected error occured!')
                        }
                    });
                }
            });
        });


    });
</script>
@endsection
