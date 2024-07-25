
  <div id="exchange_update" class="modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Update</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{action([\App\Http\Controllers\Webmaster\SettingController::class, 'updateExchangeRate'])}}" method ="POST" id="exchangerateUpdateForm">
                @csrf
          <div class="modal-body">
             <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Currency:</label>
                            <input type='number' hidden value='' id='exchangeRateId'>
                            <select class="form-control" name="froCurrency" id="froCurrencyUpdate" required>
                                <option value="">Please Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->country }} - {{ $currency->currency }}
                                    </option>
                                @endforeach
                            </select>
                              <span class="error text-danger" id="froCurrencyErrorUpdate"></span>
                        </div>
                        <div class="form-group">
                            <label>Rate:</label>
                            <input class='form-control' name='exchangeRate' type='number' id="exchangeRateUpdate" placeholder="Enter Rate Amount">
                            <span class="error text-danger" id="exchangeRateErrorUpdate"></span>
                        </div>
                    </div>
                </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-indigo" id='rateUpdateBtn'>Update</button>
            <button type="button" data-dismiss="modal" class="btn btn-outline-light">Close</button>
          </div>
           </form>
        </div>
      </div><!-- modal-dialog -->
</div><!-- modal -->
