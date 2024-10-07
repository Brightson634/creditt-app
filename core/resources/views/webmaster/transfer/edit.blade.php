<style>
    .input-group-text {
        border-left: none;
    }

    .datetimepicker-input {
        border-right: none;
    }

    .input-group-append .input-group-text {
        cursor: pointer;
    }
</style>
<div class="modal-content modal-content-demo">
    <form
        action="{{ action([\App\Http\Controllers\Webmaster\TransferController::class, 'update'], $mapping_transaction->id) }}"
        method="post" id="transferupdate_form">
        @method('PUT')
        @csrf
        <div class="modal-header">
            <h6 class="modal-title">Edit Transfer</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="ref_no">Reference Number:</label>
                <small class="form-text text-muted">Leave empty to autogenerate</small>
                <input type="text" name="ref_no" id="ref_no" value="{{ $mapping_transaction->ref_no }}"
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="from_account">Transfer From:</label>
                <select name="from_account" id="from_account" class="form-control accounts-dropdown" required>
                    <option value="{{ $debit_tansaction->accounting_account_id }}">{{ $from_account }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="to_account">Transfer To:</label>
                <select name="to_account" id="to_account" class="form-control accounts-dropdown" required>
                    <option value="{{ $credit_tansaction->accounting_account_id }}">{{ $to_account }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" name="amount" id="amount" value="{{ abs($debit_tansaction->amount) }}"
                    class="form-control input_number" required placeholder="Amount">
            </div>

            <div class="form-group">
                <label for="operation_date">Operation Date:</label>
                <div class="input-group">
                    <input type="text" name="operation_date" id="operation_date"
                        value="{{ formattedDateWithoutSeconds($mapping_transaction->operation_date) }}" class="form-control"
                        placeholder="Operation Date" required>
                    <span class="input-group-addon">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="note">Note:</label>
                <textarea name="note" id="note" class="form-control" placeholder="Note" rows="4">{{ $mapping_transaction->note }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-indigo updateTransferBtn">Update Transfer</button>
            <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#operation_date').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            language: 'en',
            autoclose: true,
        });
        $('#transferupdate_form').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Serialize the form data
            let actionUrl = $(this).attr('action'); // Get the form action URL

            $.ajax({
                url: actionUrl,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.msg);
                        location.reload();
                        $('#updateTransfer').modal('hide');
                    } else {
                        toastr.error(response.msg);
                    }
                    $('#transferupdate_form')[0].reset();
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 500) {
                        toastr.error('An internal server error occurred.');
                        console.log(xhr)
                    } else {
                        console.log('An error occurred: ' + xhr.responseJSON.msg);
                    }
                }
            });
        });
    });
</script>
