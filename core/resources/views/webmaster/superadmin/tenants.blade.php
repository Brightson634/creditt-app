@extends('webmaster.partials.dashboard.main')
@section('title', 'Superadmin Tenants')
@section('content')
    <div class="row">
        @include('webmaster.partials.superadmin_nav')
    </div>
    <div class="row">
        <div class="col-xl-12 mx-auto bg-white">
            <div class='wrapper'>
                <table class='table table-responsive' style='overflow:x;'>
                    <thead>
                        <tr>
                            <th>Date created</th>
                            <th>Business Name</th>
                            {{-- <th>Owner</th> --}}
                            <th>Business Email</th>
                            <th>Business Contact</th>
                            <th>Subscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tenants as $tenant)
                            <tr>
                                <td>{{ $tenant->created_at->toFormattedDateString() }}</td>
                                <td>{{ $tenant->company_name }}</td>
                                <td>{{ $tenant->phone_contact_one }}</td>
                                <td>{{ $tenant->email_address_one }}</td>
                                <td>{{$tenant->activePackage()->package->name ?? 'Default package' }}</td>
                                <td>
                                    <button data-tenant="{{ $tenant->id }}" class="btn btn-sm btn-info btn-sub">
                                        <i class="fas fa-plus"></i>Add Subscription
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--subscription-modal-->
    <div id="subscription" class="modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add Subscription</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="subscriptionForm" action="{{ route('webmaster.subscriptions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tenant_id" id="tenant_id"/>
                        <div class="form-group">
                            <label for="package_id">Package</label>
                            <select name="package_id" id="package_id" class="form-control" required>
                                <option value="" disabled selected>Select a package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="package_id_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date') }}" required>
                            <span class="text-danger" id="start_date_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date') }}" required>
                            <span class="text-danger" id="end_date_error"></span>
                        </div>
                        <div class="alert alert-success d-none" id="successMessage"></div>
                    </div><!-- modal-body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-indigo" id="submitBtn">Add</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-sub', function(event) {
                event.preventDefault()
                const tenantId = $(this).data('tenant')
                $('#tenant_id').val(tenantId)

                $("#subscription").modal('show');
            })

            $('#subscriptionForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous error messages
                $('#package_id_error, #start_date_error, #end_date_error').text('');
                $('#successMessage').addClass('d-none').text('');

                // Disable submit button to prevent multiple submissions
                $('#submitBtn').prop('disabled', true).text('Adding...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response)
                        $('#successMessage')
                            .removeClass('d-none')
                            .text('Subscription added successfully on ' + response.created_at);
                        $('#subscriptionForm')[0].reset();
                        setTimeout(() => {
                            $('#subscription').modal('hide');
                            window.location.reload(true);
                        }, 2000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $(`#${field}_error`).text(errors[field][0]);
                            }
                        } else {
                            $('#successMessage')
                                .removeClass('d-none')
                                .addClass('alert-danger')
                                .text(xhr.responseJSON.message ||
                                    'An error occurred. Please try again.');
                        }
                    },
                    complete: function() {
                        // Re-enable submit button
                        $('#submitBtn').prop('disabled', false).text('Add');
                    }
                });
            });
        });
    </script>
@endsection
