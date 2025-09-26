@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
@section('css')
    <style>
        .custom-card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-table thead th {
            background-color: #f8f9fa;
        }

        .custom-table tbody tr {
            transition: background-color 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
@endsection

<div class="d-flex justify-content-end align-items-center p-2">
    @can('add_fee_settings')
        <a class="btn btn-primary btn-sm" href="{{ route('webmaster.fee.create') }}">
            <i class="fas fa-plus-circle"></i> Add New Fee
        </a>
    @endcan
</div>

<div class="row rounded-lg bg-white p-2">
    @if ($fees->count() > 0)
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover data-table">
                <thead class='thead-light'>
                    <tr>
                        <th>#</th>
                        <th>Fee Name</th>
                        <th>Fee Type</th>
                        <th>Rate Type</th>
                        <th>Amount</th>
                        <th>Rate</th>
                        <th>Period</th>
                        <th>Ledger Account</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach ($fees as $row)
                        @php $i++; @endphp
                        <tr>
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->type }}</td>
                            <td>
                                @if ($row->rate_type == 'percent')
                                    Percentage
                                @endif
                                @if ($row->rate_type == 'fixed')
                                    Fixed Amount
                                @endif
                                @if ($row->rate_type == 'range')
                                    Range
                                @endif
                            </td>
                            <td>
                                @if ($row->rate_type == 'percent')
                                    -
                                @endif
                                @if ($row->rate_type == 'fixed')
                                    {!! showAmount($row->amount) !!}
                                @endif
                                @if ($row->rate_type == 'range')
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($row->rate_type == 'percent')
                                    {{ $row->rate }}
                                @endif
                                @if ($row->rate_type == 'fixed')
                                    -
                                @endif
                                @if ($row->rate_type == 'range')
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($row->period == 'day')
                                    DAILY
                                @endif
                                @if ($row->period == 'week')
                                    WEEKLY
                                @endif
                                @if ($row->period == 'month')
                                    MONTHLY
                                @endif
                                @if ($row->period == 'year')
                                    YEARLY
                                @endif
                                 @if ($row->period == 'other')
                                    OTHER
                                @endif
                            </td>
                            <td>{{ $row->account->name ?? 'none' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                        data-toggle="dropdown">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu shadow animated--fade-in">
                                        @can('edit_fee_settings')
                                            <a class="dropdown-item" href="{{ route('webmaster.fee.edit', $row->id) }}">
                                                <i class="far fa-edit text-primary"></i> Edit
                                            </a>
                                        @endcan

                                        @can('delete_fee_settings')
                                            <form action="{{ route('webmaster.fee.destroy', $row->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="d-flex flex-column align-items-center mt-5">
            <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200" alt="No Data">
            <span class="mt-3 text-muted">No Data Available</span>
        </div>
    @endif
</div>
@endsection
