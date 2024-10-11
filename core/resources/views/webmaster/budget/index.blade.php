@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <style>
        .table-sticky thead,
        .table-sticky tfoot {
            position: sticky;
        }

        .table-sticky thead {
            inset-block-start: 0;
            /* "top" */
        }

        .table-sticky tfoot {
            inset-block-end: 0;
            /* "bottom" */
        }

        .collapsed .collapse-tr {
            display: none;
        }
    </style>
@endsection

@section('content')

    @include('webmaster.partials.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Budget</h1>
    </section>
    <section class="content">
        @can('add_accounting_budgets')
            @component('webmaster.components.widget', ['class' => 'box-solid'])
                @slot('tool')
                    <div class="box-tools">
                        <button type="button"
                            class="btn btn-primary tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full btn-modal"
                            data-toggle="modal" data-target="#add_budget_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>Add
                        </button>
                    </div>
                @endslot
                <div class="card-body">
                    <div class="row mb-10">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fiscal_year_picker">Financial Year For the Budget</label>
                                <input type="text" class="form-control" id="fiscal_year_picker" value="{{ $fy_year }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    @if (count($budget) != 0)
                        @include('webmaster.budget.budget_table')
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4>Select Financial Year</h4>
                            </div>
                        </div>
                    @endif
                </div>
            @endcomponent
        @endcan
    </section>
    <div id="add_budget_modal" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                {!! Form::open([
                    'url' => action([\App\Http\Controllers\Webmaster\BudgetController::class, 'create']),
                    'method' => 'get',
                    'id' => 'add_budget_form',
                ]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Financial Year for the budget</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::number('financial_year', null, [
                                    'class' => 'form-control',
                                    'required',
                                    'placeholder' => 'financial year for the budget',
                                    'id' => 'financial_year',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Continue</button>
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@stop
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#fiscal_year_picker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            }).on('changeDate', function(e) {
                window.location.href =
                    "{{ action([\App\Http\Controllers\Webmaster\BudgetController::class, 'index']) }}?financial_year=" +
                    $('#fiscal_year_picker').val();
            });

            $('#financial_year').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            })
        });
        $(document).on('click', '.toggle-tr', function() {
            $(this).closest('tbody').toggleClass('collapsed');
            var html = $(this).closest('tbody').hasClass('collapsed') ?
                '<i class="fas fa-arrow-circle-right"></i>' : '<i class="fas fa-arrow-circle-down"></i>';
            $(this).find('.collapse-icon').html(html);
        })
    </script>
@endsection
