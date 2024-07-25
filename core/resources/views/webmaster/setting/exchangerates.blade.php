@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
 <div class="page-heading">
   <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active exchangeLink" data-toggle="tooltip-primary" href="#"
                    title='Add Exchange Rate'><i class="fas fa-money-bill-alt"></i>Exchange Rate</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-xl-11 mx-auto">
            <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Exchange Rates</h4>
                    </div>
                    <div class="card-body">
                        <div class='container'>
                            <h6> Default  Branch Currency <span class='text-muted'>@isset($default_branch_curr->currency){{$default_branch_curr->currency}}@endisset </span></h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Currency</th>
                                        <th>Code</th>
                                        <th>Exchange Rate</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($exchangeRates)
                                        @foreach($exchangeRates as $rate)
                                            <tr>
                                                <td>#</td>
                                                <td>{{$rate->foreign_currency}}</td>
                                                <td>{{$rate->code}}</td>
                                                <td>{{number_format($rate->exchange_rate,2)}}</td>
                                                <td>
                                                <div style='display:flex;'>
                                                    <a href="#" class="btn btn-xs btn-dark edit-rate" data.editrate='{{$rate->id}}' data-toggle="tooltip-primary" title='Edit Rate'> <i class="far fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-xs btn-danger del-rate" data.delrate="{{$rate->id}}" data-toggle="tooltip-primary" title='Delete Rate'> <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('webmaster.setting.updateexchangeratemodal')
    @include('webmaster.setting.exchangemodal')

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.exchangeLink', function() {
                $('#exchange_modal').modal('show');
            })

            //save rates
            $('#exchangerateForm').on('submit', function(event) {
                event.preventDefault();
                clearErrors()
                var formData = {
                    froCurrency: $('#froCurrency').val(),
                    exchangeRate: $('#exchangeRate').val(),
                    _token: '{{ csrf_token() }}'
                };
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#exchange_modal').modal('hide');
                        toastr.success('Exchange rate saved successfully!');
                        location.reload();
                    },
                    error: function(xhr,status,err) {
                         var errors = xhr.responseJSON.errors;
                        if (errors) {
                            if (errors.froCurrency) {
                                showError('froCurrencyError', errors.froCurrency[0]);
                            }
                            if (errors.exchangeRate) {
                                showError('exchangeRateError', errors.exchangeRate[0]);
                            }
                        } else {
                            toastr.error('An error occurred while saving the exchange rate.');
                        }
                    }
                });
            });

            //delete exchange rate
            $(document).on('click','.del-rate',function(){
                    const rateId=$(this).attr('data.delrate')
                    if (confirm('Are you sure you want to delete this exchange rate?')) {
                    // const rateId = $(this).data('rateid');
                    const url = `{{ route('webmaster.exchangerate.delete') }}`;
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            rateId: rateId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                           if (response.success) {
                                toastr.success(response.message);
                                location.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr, status, err) {
                            console.error('Error:', err);
                            toastr.error('An error occurred while deleting the exchange rate.');
                        }
                    });
                }
            })

            //update exchange rate
            $(document).on('click','.edit-rate',function(){
                const rateId =$(this).attr('data.editrate')
               $.ajax({
                    url: `{{ route('webmaster.exchangerate.get') }}`,
                    type: 'GET',
                    data: { rateId: rateId },
                    success: function(response) {
                        $('#froCurrencyUpdate').val(response.froCurrencyId);
                        $('#exchangeRateUpdate').val(response.exchangeRate);
                        $('#exchangeRateId').val(rateId)
                        // Open the modal
                         $('#exchange_update').modal('show');
                    },
                    error: function(xhr, status, err) {
                        console.log(err);
                        toastr.error('An error occurred while fetching the exchange rate details.');
                    }
                });
            })

          // Update exchange rate
            $(document).on('click', '#rateUpdateBtn', function() {
                    // Debugging: Log the action URL and form data
                    const url = $('#exchangerateUpdateForm').attr('action');
                    console.log('Action URL:', url);

                    var formData = {
                        froCurrency: $('#froCurrencyUpdate').val(),
                        exchangeRate: $('#exchangeRateUpdate').val(),
                        rateId: $('#exchangeRateId').val(), // Correctly get the value
                        _token: '{{ csrf_token() }}'
                    };

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            success: function(response) {

                                console.log(response)
                                $('#exchange_update').modal('hide');
                                toastr.success('Exchange rate saved successfully!');
                                location.reload(); // Reload the page
                            },
                            error: function(xhr, status, err) {
                                console.error('Error:', err); // Log the error for debugging
                                var errors = xhr.responseJSON.errors;
                                if (errors) {
                                    if (errors.froCurrency) {
                                        showError('froCurrencyErrorUpdate', errors.froCurrency[0]);
                                    }
                                    if (errors.exchangeRate) {
                                        showError('exchangeRateErrorUpdate', errors.exchangeRate[0]);
                                    }
                                } else {
                                    toastr.error('Server error');
                                }
                            }
                        });
                    });

            // Function to show error message
            function showError(elementId, message) {
                $('#' + elementId).text(message).show();
            }

            // Function to remove error message
            function removeError(elementId) {
                $('#' + elementId).hide().text('');
            }

            // Clear previous error messages
            function clearErrors() {
                removeError('froCurrencyError');
                removeError('exchangeRateError');
            }

        });
    </script>
@endsection

