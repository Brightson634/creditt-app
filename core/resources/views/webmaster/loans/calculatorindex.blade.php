@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Loan Calculator</h4>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf

                    <!-- Loan Product -->
                    <div class="form-group">
                        <label for="loan_product">Loan Product</label>
                        <select class="form-control @error('loan_product') is-invalid @enderror" id="loan_product" name="loan_product" required>
                            <option value="">Choose loan product</option>
                            @if(isset($loanProducts))
                                @foreach($loanProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('loan_product')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Loan Amount and Release Date -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="loan_amount">Loan Principal Amount ($)</label>
                            <input type="number" class="form-control @error('loan_amount') is-invalid @enderror" id="loan_amount" name="loan_amount" placeholder="Enter loan amount" required>
                            @error('loan_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="release_date">Release Date</label>
                            <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" required>
                            @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Interest Rate -->
                    <div class="form-group">
                        <label for="interest_rate">Interest Rate (%)</label>
                        <input type="number" class="form-control @error('interest_rate') is-invalid @enderror" id="interest_rate" name="interest_rate" step="0.01" placeholder="Enter interest rate" required>
                        @error('interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Loan Term -->
                    <div class="form-group">
                        <label for="loan_term">Loan Term</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('loan_term_value') is-invalid @enderror" id="loan_term_value" name="loan_term_value" placeholder="Enter loan term" required>
                            <div class="input-group-append">
                                <select class="form-control @error('loan_term_unit') is-invalid @enderror" id="loan_term_unit" name="loan_term_unit" required>
                                    <option value="years">Years</option>
                                    <option value="months">Months</option>
                                    <option value="weeks">Weeks</option>
                                    <option value="days">Days</option>
                                </select>
                            </div>
                        </div>
                        @error('loan_term_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('loan_term_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Interest Method -->
                    <div class="form-group">
                        <label for="interest_method">Interest Method</label>
                        <select class="form-control @error('interest_method') is-invalid @enderror" id="interest_method" name="interest_method" required>
                            <option value="">Choose interest method</option>
                            <option value="flat_rate">Flat Rate</option>
                            <option value="reducing_balance_equal_principal">Reducing Balance (Equal Principal)</option>
                            <option value="reducing_balance_equal_installment">Reducing Balance (Equal Installment)</option>
                            <option value="interest_only">Interest Only</option>
                            <option value="compound_interest">Compound Interest</option>
                        </select>
                        @error('interest_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Repayment Period -->
                    <div class="form-group">
                        <label for="repayment_period">Repayment Period</label>
                        <select class="form-control @error('repayment_period') is-invalid @enderror" id="repayment_period" name="repayment_period" required>
                            <option value="">Choose repayment period</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="semi_annually">Semi-Annually</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        @error('repayment_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block">Calculate Loan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection