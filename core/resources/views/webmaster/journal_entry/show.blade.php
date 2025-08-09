@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')

    @include('webmaster.partials.nav')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header with-border text-center">
                        <h2 class="box-title">Journal Entry-{{ $journal->ref_no }}</h2>
                        {{-- <p>{{@format_date($start_date)}} ~ {{@format_date($end_date)}}</p> --}}
                        <p><strong>Operation Date:</strong> {{ $journal->operation_date }}</p>
                    </div>

                    <div class="box-body">
                        <table class="table table-stripped w-100">
                            <thead>
                                <tr>
                                    <th>Account Name</th>
                                    <th>Account Type</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts_transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction['account']['name'] }}</td>
                                        <td>{{ $transaction['account']['account_primary_type'] }}</td>
                                        <td>
                                            @if ($transaction['type'] == 'debit')
                                                {{ number_format($transaction['amount'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction['type'] == 'credit')
                                                {{ number_format($transaction['amount'], 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfooter>
                                <tr>
                                    <th><strong>Note:</strong></th>
                                    <th>
                                        <p> {{ $journal->note ? $journal->note : 'N/A' }}</p>
                                    </th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable();
        });
    </script>
@endsection
