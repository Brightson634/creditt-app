<form  id="collateralFormUpdate">
    @csrf
    <!-- Collateral Name Field -->
    <div class="form-group">
        <input type='text' value="{{$collateral->id}}" id='collateralId'>
        <label for="collateral_name">Collateral Name</label>
        <input type="text" class="form-control" id="collateral_name" name="collateral_name"
            placeholder="Enter collateral name" value='{{$collateral->name}}'>
    </div>

    <!-- Status Field -->
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status" >
            <option value="">Select Status</option>
            <option value="1" {{ $collateral->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ $collateral->status == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="button" class="btn btn-success" id='updateCollateral'>Save</button>
    </div>
</form>