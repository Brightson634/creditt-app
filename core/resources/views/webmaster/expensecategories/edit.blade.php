<div class="modal-body">
    <h4 class="card-title mb-4"> Expense Category Update Form</h4>
    <form action="#" method="POST" id="category_form_update">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type='number' name='id' hidden value='<?=$expense->id?>'>
            <input type="text" name="name" id="name" value="<?= $expense->name ?>" class="form-control">
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" name="code" id="code" value="<?= $expense->code ?>" class="form-control">
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <label for="expenseAccount">Expense Account</label>
            <select class='form-control' name='expenseAccount' id='expenseAccount' style="width:100%">
                <option value="">Select Account</option>
                @foreach ($accounts_array as $account)
                <option value="{{$account['id']}}" data-currency="{{$account['currency']}}">{{$account['name']}}
                   -{{$account['primaryType']}}-{{$account['subType']}}
                </option>
                @endforeach
            </select>
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="is_subcat" class="custom-control-input" id="is_subcat">
                <label class="custom-control-label" for="is_subcat">Add as Sub-Category</label>
            </div>
        </div>
        <div id="subCatDiv" style="display: {{ $expense->is_subcat ? 'block' : 'none' }}">
            <div class="form-group">
                <label for="parent_id">Select Parent Category</label>
                <select class="form-control" name="parent_id" id="parent_id">
                    <option value="">select parent category</option>
                    @foreach ($categories as $data)
                        <option value="{{ $data->id }}"  {{ $data->id == $expense->parent_id ? 'selected' : '' }}>{{ $data->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3"><?= $expense->description ?></textarea>
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary btn-sm btn-theme" id="btn_update_category">Update Category</button>
        </div>
    </form>
</div>

