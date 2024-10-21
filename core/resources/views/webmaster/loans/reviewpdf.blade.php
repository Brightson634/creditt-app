<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loan Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <style media="all">
        body {
            font-size: 0.875rem;
            font-family: 'Helvetica', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            background: #f8f8f8;
            padding: 10px;
            text-align: center;
            font-size: 0.85rem;
        }

        .header img {
            max-width: 150px;
        }

        .main-content {
            padding: 20px;
            margin: 20px;
        }

        h2,
        h3 {
            color: #d00;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ececec;
            text-align: left;
        }

        table th {
            background: #f1f1f1;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .section-header {
            background: #eceff4;
            padding: 10px;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            font-size: 0.75rem;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signature-section {
            margin-top: 30px;
            text-align: left;
        }

        .signature-section img {
            width: 50px;
            height: auto;
            margin-top: 10px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    @php
        $systemInfo = getSystemInfo();
    @endphp
    <div class="header">
        <img src="{{ asset('assets/uploads/generals/' . $systemInfo->logo) }}" alt="Company Logo">
        <h2>{{ $systemInfo->company_name }}</h2>
        <p>Earn | Save | Invest | Earn</p>
        <p>{{ $systemInfo->post_office }} | {{ $systemInfo->physical_location }}</p>
        <p>{{ $systemInfo->phone_contact_one }} | {{ $systemInfo->phone_contact_two }}</p>
        <p>{{ $systemInfo->email_address_one }} | {{ $systemInfo->email_address_two }}</p>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
        <h2 align="center">{{ $title }}</h2>

        <!-- General Information Section -->
        <div class="section-header">
            <h3>General Information</h3>
        </div>
        <table>
            @if ($loan->loan_type == 'individual')
                <tr>
                    <td>Member: {{ $loan->member->title }} {{ $loan->member->fname }} {{ $loan->member->lname }}
                        {{ $loan->member->oname }}</td>
                </tr>
            @endif
            @if ($loan->loan_type == 'group')
                <tr>
                    <td>Group: {{ $loan->member->fname }}</td>
                </tr>
            @endif
            <tr>
                <td>Loan Product: {{ $loan->loanproduct->name }}</td>
            </tr>
            <tr>
                <td>Interest Rate: {{ $loan->loanproduct->interest_rate }}% /
                    {{ strtoupper($loan->loanproduct->duration) }}
                </td>
            </tr>
            <tr>
                <td>Loan Period: {{ $loan->loan_term }}
                    {{ strtolower($loan->loanproduct->duration . 's') }}
                </td>
            </tr>
            <tr>
                <td>Release Date: {{ dateFormat($loan->release_date) }}</td>
            </tr>
            <tr>
                <td>Repayment Date: {{ dateFormat($loan->repayment_date) }}</td>
            </tr>
            <tr>
                <td>Loan End Date: {{ dateFormat($loan->end_date) }}</td>
            </tr>
        </table>

        <!-- Loan Summary Section -->
        <div class="section-header">
            <h3>Loan Summary</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="text-right">Principal Amount</th>
                    <th class="text-right">Interest Amount</th>
                    <th class="text-right">Loan Amount</th>
                    <th class="text-right">Loan Charges</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-right">{!! showAmountPdf($loan->principal_amount) !!}</td>
                    <td class="text-right">{!! showAmountPdf($loan->interest_amount) !!}</td>
                    <td class="text-right">{!! showAmountPdf($loan->repayment_amount) !!}</td>
                    <td class="text-right">{!! showAmountPdf($loan->fees_total) !!}</td>
                </tr>
            </tbody>
        </table>

        <!-- Loan Officers Section -->
        <div class="section-header">
            <h3>Loan Officers</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)
                    ->where('comment',null)->get();
                @endphp
                @foreach ($officers as $officer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucwords($officer->staff->title . ' ' . $officer->staff->fname . ' ' . $officer->staff->lname) }}
                        </td>
                        <td>{{ $officer->staff->email }}</td>
                        <td>{{ $officer->staff->telephone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Loan Collaterals Section -->
        <div class="section-header">
            <h3>Loan Collaterals</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Collateral Name</th>
                    <th>Estimate Value</th>
                </tr>
            </thead>
            <tbody>
                @php $total_costs = 0; @endphp
                @foreach ($collaterals as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->item->name }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{!! showAmount($row->estimate_value) !!}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td><strong>{!! showAmount($total_costs) !!}</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Comments Section -->
        @php
            $officers = \App\Models\LoanOfficer::where('loan_id', $loan->id)
                ->whereNotNull('comment')
                ->get();
        @endphp
        <div class="signature-section">
            <h3>Loan Official Remarks</h3>
            @foreach ($officers as $row)
                <div>
                    <table>
                        <tr>
                            <td><strong>Comments:</strong> {{ $row->comment }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name:</strong> {{ $row->staff->fname . ' ' . $row->staff->lname }}</td>
                            <td><strong>Date:</strong> {{ dateFormat($row->date) }}</td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{ asset('assets/uploads/staffs/' . $row->staff->signature) }}"
                                    alt="Signature">
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>{{ $systemInfo->company_name }} | All rights reserved © {{ date('Y') }}</p>
    </div>
</body>

</html>
