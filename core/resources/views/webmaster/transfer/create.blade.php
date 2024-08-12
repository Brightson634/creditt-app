<div class="modal-dialog" role="document">
    <div class="modal-content modal-content-demo">

        <form action="{{ action([\App\Http\Controllers\Webmaster\TransferController::class, 'store']) }}"
              method="post" id="transfer_form">
            @csrf

            <div class="modal-header">
                <h6 class="modal-title">Add Transfer</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="ref_no">Reference No:</label>
                    <small class="form-text text-muted">Leave empty to autogenerate</small>
                    <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Reference No">
                </div>

                <div class="form-group">
                    <label for="from_account">Transfer From:*</label>
                    <select name="from_account" id="from_account" class="form-control accounts-dropdown" required>
                        <option value="">Please Select</option>
                        <!-- Options will be added dynamically -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="to_account">Transfer To:*</label>
                    <select name="to_account" id="to_account" class="form-control accounts-dropdown" required>
                        <option value="">Please Select</option>
                        <!-- Options will be added dynamically -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount">Amount:*</label>
                    <input type="text" name="amount" id="amount" class="form-control input_number" required placeholder="Amount">
                </div>

                <div class="form-group">
                    <label for="operation_date">Date:*</label>
                    <div class="input-group">
                        <input type="text" name="operation_date" id="operation_date" class="form-control"
                            placeholder=" Date" required >
                        <span class="input-group-addon">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" class="form-control" placeholder="Note" rows="4"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $(document).ready(function () {
        $('#operation_date').datetimepicker({
            format: 'mm/dd/yyyy hh:ii',
            language: 'en',
            autoclose: true,
        });

        $('#transfer_form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Gather form data
            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function (response) {
                    toastr.success(response.msg);
                    location.reload()
                    $('#transfer_form')[0].reset(); 
                    $('.modal').modal('hide');
                },
                error: function (xhr) {
                    var response = xhr.responseJSON;
                    var errorMessage = 'An unexpected error occurred. Please try again.';
                    if (response && response.msg) {
                        errorMessage = response.msg;
                    }
                    toastr.error(errorMessage);
                }
            });
        });
    });
</script>
