@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
    <style>
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            background-color: #fff;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .badge-info,
        .badge-warning,
        .badge-success,
        .badge-danger {
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }

        .btn-dark {
            border-radius: 0.375rem;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            @if ($loans->count() > 0)
                <div class="card card-dashboard-table-six">
                    <h6 class="card-title">{{ $page_title }}</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Loan No</th>
                                    <th>Member / Group</th>
                                    <th>Loan Product</th>
                                    <th>Principal Amount</th>
                                    <th>Repayment Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($loans as $row)
                                    @php $i++; @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $row->loan_no }}</td>
                                        <td>
                                            @if ($row->loan_type == 'individual')
                                                {{ $row->member->fname }} - {{ $row->member->lname }}
                                            @endif
                                            @if ($row->loan_type == 'group')
                                                {{ $row->member->fname }}
                                            @endif
                                        </td>
                                        <td>{{ optional(optional($row)->loanproduct)->name }}</td>
                                        <td>{!! showAmount($row->principal_amount) !!}</td>
                                        <td>{!! showAmount($row->repayment_amount) !!}</td>
                                        <td>
                                            @if ($row->status == 0)
                                                <div class="badge badge-info">SUBMITTED</div>
                                            @endif
                                            @if ($row->status == 12)
                                                <div class="badge badge-warning">UNDER REVIEW</div>
                                            @endif
                                            @if ($row->status == 2)
                                                <div class="badge badge-warning">REVIEWED</div>
                                            @endif
                                            @if ($row->status == 3)
                                                <div class="badge badge-success">APPROVED</div>
                                            @endif
                                            @if ($row->status == 13)
                                                <div class="badge badge-success">UNDER APPROVAL</div>
                                            @endif
                                            @if ($row->status == 4)
                                                <div class="badge badge-danger">REJECTED</div>
                                            @endif
                                            @if ($row->status == 9)
                                                <div class="badge badge-warning">WAITING REVIEW</div>
                                            @endif
                                            @if ($row->status == 5)
                                                <div class="badge badge-secondary">DISBURSED</div>
                                            @endif
                                            @if ($row->status == 6)
                                                <div class="badge badge-danger">CANCELLED</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->status == 3)
                                                <a href="{{ route('webmaster.loan.disburse', $row->loan_no) }}"
                                                    class="btn btn-xs btn-dark" title="Disburse Loan"> <i
                                                        class="far fa-edit"></i></a>
                                            @endif
                                            @if ($row->status == 0 || $row->status == 12)
                                                <a href="{{ route('webmaster.loan.review', $row->loan_no) }}"
                                                    class="btn btn-xs btn-dark" title="Review Loan"> <i
                                                        class="far fa-edit"></i></a>
                                            @endif
                                            @if($row->status == 9)
                                                <a href="{{ route('webmaster.loan.edit', $row->id) }}"
                                                    class="btn btn-xs btn-dark" title="Update Loan"> <i
                                                        class="far fa-edit"></i></a>
                                            @endif
                                            
                                            @if ($row->status == 2 || $row->status == 13)
                                                <a href="{{ route('webmaster.loan.approval', $row->loan_no) }}"
                                                    class="btn btn-xs btn-dark" title="Approve Loan"> <i
                                                        class="far fa-edit"></i></a>
                                            @endif
                                            <a href="{{ route('webmaster.loan.preview', $row->loan_no) }}"
                                                class="btn btn-xs btn-dark" title="Preview Loan"> <i
                                                    class="far fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="d-flex flex-column align-items-center mt-5 no-data">
                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200" alt="No Data">
                    <span class="mt-3">No Data</span>
                </div>
            @endif
        </div>
    </div>
@endsection
