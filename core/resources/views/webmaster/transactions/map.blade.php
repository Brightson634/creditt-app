  <div class="modal-dialog" role="document">
      <form action="{{ action([\App\Http\Controllers\Webmaster\TransactionController::class, 'saveMap']) }}"
          method="POST" id="save_accounting_map">
          @csrf
          <input type="hidden" name="type" value="{{ $type }}" id="transaction_type">
          @if (!empty($tran_id))
              <input type="hidden" name="id" value="{{ $tran_id }}">
              <input type="hidden" name="payment_date" value="{{ $payment_date }}">
          @elseif(in_array($type, ['sell_payment', 'purchase_payment']))
              <input type="hidden" name="id" value="{{ $transaction_payment->id }}">
          @endif
          <div class="modal-content">
              <div class="modal-header">
                  <h6 class="modal-title">
                      @if ($type == 'loan_payment')
                          Loan Payment
                      @elseif(in_array($type, ['sell_payment', 'purchase_payment']))
                          {{ $transaction_payment->payment_ref_no }}
                      @elseif($type == 'expense')
                          Expense 
                      @endif
                  </h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>

              </div>
              <div class="modal-body">
                  <div class="row">
                      <!-- Payment Account -->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="payment_account">@lang('Payment Account'):</label>
                              <select name="payment_account" id="payment_account" class="form-control accounts-dropdown"
                                  required>
                                  @if (!is_null($default_payment_account))
                                      <option value="{{ $default_payment_account->id }}" selected>
                                          {{ $default_payment_account->name }}
                                      </option>
                                  @else
                                      <option value="">@lang('Payment Account')</option>
                                  @endif
                              </select>
                          </div>
                      </div>

                      <!-- Deposit To -->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="deposit_to">@lang('Deposit To'):</label>
                              <select name="deposit_to" id="deposit_to" class="form-control accounts-dropdown" required>
                                  @if (!is_null($default_deposit_to))
                                      <option value="{{ $default_deposit_to->id }}" selected>
                                          {{ $default_deposit_to->name }}
                                      </option>
                                  @else
                                      <option value="">@lang('Deposit To')</option>
                                  @endif
                              </select>
                          </div>
                      </div>

                      <!-- Description -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="description">@lang('Description'):</label>
                              <textarea name="description" id="description" class="form-control" placeholder="@lang('Description')" rows="3">{{ $note }}</textarea>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-indigo">Update</button>
                  <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
              </div>
          </div><!-- /.modal-content -->
      </form>
  </div><!-- /.modal-dialog -->
