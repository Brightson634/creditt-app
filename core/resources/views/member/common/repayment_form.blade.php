  <!-- LARGE MODAL -->
  <div id="repaymentModal" class="modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Loan Repayment Form</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="repaymentForm" enctype="multipart/form-data" method="POST"
                          action="{{ route('member.loan.repayment') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="date_due" class="form-label">Due Date</label>
                            <input type="date" readonly class="form-control" name="date_due" id="date_due" required>
                            @error('date_due')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount to Pay</label>
                            <input type="number" class="form-control" name="amount" id="amount"
                                   placeholder="Enter amount" required>
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="paymentType" class="form-label">Payment Type</label>
                            <select class="form-control" name="payment_type" id="paymentType">
                                <option value="">Select Payment</option>
                                <option value="paid">Full Payment</option>
                                <option value="partial">Partial Payment</option>
                            </select>
                            @error('payment_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="paymentMode" class="form-label">Mode of Payment</label>
                            <select class="form-control" name="payment_mode" id="paymentMode" required>
                                <option value="">Select</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="mobile_money">Mobile Money</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="cash">Cash</option>
                            </select>
                            @error('payment_mode')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proofOfPayment" class="form-label">Upload Proof of Payment (optional)</label>
                            <input type="file" class="form-control" name="proof_of_payment" id="proofOfPayment"
                                   accept="image/*,application/pdf">
                            @error('proof_of_payment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo submitPayment">Submit Payment</button>
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- modal-dialog -->