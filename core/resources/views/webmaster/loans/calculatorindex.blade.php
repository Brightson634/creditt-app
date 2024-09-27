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
                <div class="card-header" style="background-color:#e3e7ed;">
                    <h4 class="mb-0">Loan Calculator</h4>
                </div>
                <div class="card-body">
                    <!-- Loan Form -->
                    <form action="#" method="POST" id='loancalculatorForm'>
                        @csrf

                        <!-- Loan Details Section -->
                        <h5 class="border-bottom pb-2 mb-4">Loan Details</h5>

                        <!-- Loan Product -->
                        <div class="form-group">
                            <label for="loan_product">Loan Product</label>
                            <select class="form-control @error('loan_product') is-invalid @enderror" id="loan_product"
                                name="loan_product" required>
                                <option value="">Choose loan product</option>
                                @if (isset($loanProducts))
                                    @foreach ($loanProducts as $product)
                                        <option value="{{ $product->id }}" interest_rate="{{ $product->interest_rate }}"
                                            duration="{{ $product->duration }}">
                                            {{ $product->name }}
                                        </option>
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
                                <label for="loan_amount">Loan Principal Amount</label>
                                <input type="number" class="form-control @error('loan_amount') is-invalid @enderror"
                                    id="loan_amount" name="loan_amount" placeholder="Enter loan amount" required>
                                @error('loan_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="release_date">Release Date</label>
                                <input type="date" class="form-control @error('release_date') is-invalid @enderror"
                                    id="release_date" name="release_date" required>
                                @error('release_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Interest Section -->
                        <h5 class="border-bottom pb-2 mb-4">Interest Details</h5>
                        <div class="form-group">
                            <label for="interest_rate">Interest Rate</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('interest_rate') is-invalid @enderror"
                                    id="interest_rate" name="interest_rate" step="0.01" placeholder="Enter interest rate"
                                    required>
                                <div class="input-group-append">
                                    <select class="form-control @error('interest_rate_period') is-invalid @enderror"
                                        id="interest_rate_period" name="interest_rate_period" required>
                                        <option value="years">Per Year</option>
                                        <option value="months">Per Month</option>
                                        <option value="weeks">Per Week</option>
                                        <option value="days">Per Day</option>
                                    </select>
                                </div>
                            </div>
                            @error('interest_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('interest_rate_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Loan Term -->
                        <div class="form-group">
                            <label for="loan_term">Loan Term</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('loan_term_value') is-invalid @enderror"
                                    id="loan_term_value" name="loan_term_value" placeholder="Enter loan term" required>
                                <div class="input-group-append">
                                    <select class="form-control @error('loan_term_unit') is-invalid @enderror"
                                        id="loan_term_unit" name="loan_term_unit" required>
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
                        <h5 class="border-bottom pb-2 mb-4">Repayment Details</h5>
                        <div class="form-group">
                            <label for="interest_method">Interest Method</label>
                            <select class="form-control @error('interest_method') is-invalid @enderror" id="interest_method"
                                name="interest_method" required>
                                <option value="">Choose interest method</option>
                                <option value="flat_rate">Flat Rate</option>
                                <option value="reducing_balance_equal_principal">Reducing Balance (Equal Principal)</option>
                                <option value="reducing_balance_equal_installment">Reducing Balance (Equal Installment)
                                </option>
                                <option value="interest_only">Interest Only</option>
                                <option value="compound_interest">Compound Interest</option>
                            </select>
                            @error('interest_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Repayment Period and Number of Installments -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="repayment_period">Repayment Period</label>
                                <select class="form-control @error('repayment_period') is-invalid @enderror"
                                    id="repayment_period" name="repayment_period" required>
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
                            <div class="form-group col-md-6">
                                <label for="numberofInstallments">Number of Repayments</label>
                                <input type="number"
                                    class="form-control @error('numberofInstallments') is-invalid @enderror"
                                    id="numberofInstallments" name="numberofInstallments"
                                    placeholder="Enter number of repayments" readonly>
                                @error('numberofInstallments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light" id="loanReset">Reset</button>
                            <button type="button" class="btn btn-primary" id="loanCalculate">Calculate Loan</button>
                        </div>
                    </form>

                    <!-- Show Form Again Button -->
                    <div id="showFormButton" class="d-none text-center mt-3">
                        <button type="button" class="btn btn-indigo" id="showForm">Show Loan Calculator</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-12 mx-auto scheduler"></div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#loanCalculate').on('click', function(event) {
                event.preventDefault();
                // Collapse form on calculate click
                $('#loancalculatorForm').addClass('d-none');
                $('#showFormButton').removeClass('d-none');
                var formData = new FormData($('#loancalculatorForm')[0]);
                $.ajax({
                    url: '{{ route('webmaster.loan.scheduler') }}',
                    method: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 200) {
                            $(".scheduler").html(response.html);
                        }
                    },
                    error: function(jqxhr) {
                        if (jqxhr.status === 422) {
                            // Validation error (Unprocessable Entity)
                            var errors = jqxhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[
                                    0]);
                            });
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });

            $('#showForm').on('click', function() {
                // Show form again on click
                $('#loancalculatorForm').removeClass('d-none');
                $('#showFormButton').addClass('d-none');
            });

            //attaching on change event listeners
            $(document).on('change', '#loan_term_unit, #repayment_period,#loan_term_value', function() {
                const loanPeriod = Number($("#loan_term_value").val());
                const loanPeriodUnit = $("#loan_term_unit").val();
                const repaymentPeriod = $("#repayment_period").val();
                const loanTermInYears = Number((getLoanTermInYears(loanPeriod, loanPeriodUnit).toFixed(0)))
                const numberofInstallments = getNumberOfInstallments(loanTermInYears, repaymentPeriod)
                if (numberofInstallments) {
                    $("#numberofInstallments").val(numberofInstallments);
                }

            });
            //calculate number of installements
            const getNumberOfInstallments = (loanTermInYears, repaymentPeriod) => {
                switch (repaymentPeriod) {
                    case 'daily':
                        return loanTermInYears * 365;
                    case 'weekly':
                        return loanTermInYears * 52;
                    case 'monthly':
                        return loanTermInYears * 12;
                    case 'quarterly':
                        return loanTermInYears * 4;
                    case 'semi_annually':
                        return loanTermInYears * 2;
                    case 'yearly':
                        return loanTermInYears;
                    default:
                        return loanTermInYears * 12;
                }
            }

            //calculate loan term in years 
            const getLoanTermInYears = (loanPeriod, loanPeriodUnit) => {
                switch (loanPeriodUnit) {
                    case 'days':
                        return loanPeriod / 365;
                    case 'weeks':
                        return loanPeriod / 52;
                    case 'months':
                        return loanPeriod / 12;
                    case 'years':
                        return loanPeriod;
                    default:
                        return 0;
                }
            }

            //reset form 
            $('#loanReset').on('click', function(event) {
                event.preventDefault();
                $('#loancalculatorForm')[0].reset();
            })

            //filling the necessary fields with data when loan product is chosen
            $('#loan_product').on('click', function(event) {
                var selectedOption = $(this).find('option:selected');
                var interestRate = selectedOption.attr('interest_rate');
                var duration = selectedOption.attr('duration');

                if (interestRate) {
                    $("#interest_rate").val(Number(interestRate));
                }

                // Set the selected option in the interest_rate_period dropdown
                var periodDropdown = $('#interest_rate_period');
                // Clear the current selection
                periodDropdown.val(''); // Optional: clear current selection

                // Set the corresponding option based on duration
                switch (duration) {
                    case 'year':
                        periodDropdown.val('years'); // Select 'Per Year'
                        break;
                    case 'month':
                        periodDropdown.val('months'); // Select 'Per Month'
                        break;
                    case 'week':
                        periodDropdown.val('weeks'); // Select 'Per Week'
                        break;
                    case 'day':
                        periodDropdown.val('days'); // Select 'Per Day'
                        break;
                    default:
                        periodDropdown.val(''); // No match, clear selection
                        break;
                }
            });
        });
    </script>
@endsection
