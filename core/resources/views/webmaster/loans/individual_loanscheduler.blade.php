@php
    $lastDueDate = null;
    if (!empty($repaymentSchedule)) {
        $lastDueDate = end($repaymentSchedule)['due_date']; // Get the last due date
    }
@endphp

<style>
    .table-container {
        border-top: 5px solid #3b4863; /* Thick top border */
        padding-top: 20px; /* Space between border and content */
        margin-bottom: 30px; /* Space below the tables */
    }

    .table-title {
        text-align: center; /* Center the heading */
        font-size: 24px; /* Increase font size */
        font-weight: bold; /* Make the heading bold */
        color: #3b4863; /* Color for the heading */
        margin-bottom: 20px; /* Space below the heading */
    }

    .table thead th {
        color: #fff !important;
        background-color: #3b4863 !important;
        border-color: #49597b !important;
    }

    .totals {
        color: #fff !important;
        background-color: #3b4863 !important;
        border-color: #49597b !important;
    }
</style>

<div class="table-container">
    <div class="table-title">Loan Repayment Schedule Using {{$method}} Method</div>
    @include('common.loan_schedule_table')
    <div class="text-center mt-4">
        @if(!$pdfGen)
        <button id="downloadBtn" class="btn btn-primary">
            <i class="typcn typcn-download"></i> Download PDF
        </button>
        @endif
    </div>
</div>
