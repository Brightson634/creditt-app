<div id="exchange_modal" class="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Exchange Rate</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Currency:</label>
                            <select class="form-control" name="froCurrency" id="froCurrency" required>
                                <option value="">Please Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->country }} - {{ $currency->currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Rate:</label>
                            <input class='form-control' name='exchangeRate' type='number' id="exchangeRate" placeholder="Enter Rate Amount">
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Save</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>
