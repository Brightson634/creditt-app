<form id='accountFormUpdate'>
    @csrf 
    <!-- Account Name Field -->
    <div class="form-group">
        <input type='hidden' id='accTypeId' value="{{$accountType->id}}"/>
        <label for="account_name">Account Name</label>
        <input type="text" value="{{$accountType->name}}" class="form-control" id="account_name" name="account_name" placeholder="Enter account name">
    </div>
    <!-- Minimum Amount Field -->
    <div class="form-group">
        <label for="minimum_amount">Minimum Amount</label>
        <input type="number" value="{{$accountType->min_amount}}" class="form-control" id="minimum_amount" name="minimum_amount" placeholder="Enter minimum amount">
    </div>

    <!-- Description Field -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description">{{$accountType->description}}</textarea>
    </div>
    <!-- Status Field -->
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status">
            <option valu="">Select Status</option>
            <option value="1" {{ $accountType->status == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ $accountType->status == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="button" class="btn btn-success" id='updatedType'>Update</button>
    </div>
</form>