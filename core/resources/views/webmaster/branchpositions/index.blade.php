@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="page-heading">
        {{-- <div class="page-heading__title">
            <h3>{{ $page_title }}</h3>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active">
                                <div class="card card-dashboard-table-six">
                                    <h6 class="card-title">Branch Positions<div class="float-right">
                                        @can('add_branch')
                                        <button type="button" class="btn btn-dark btn-sm btn-theme" data-toggle="modal"
                                            data-target="#positionModel">
                                            <i class="fa fa-plus"></i> Add Position
                                        </button>
                                        @endcan
                                        <div class="modal fade" id="positionModel" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <h4 class="card-title mb-4"> Add Branch Position </h4>
                                                        <form action="#" method="POST" id="branchposition_form">
                                                            @csrf

                                                            <div class="form-group">
                                                                <label for="name">Title</label>
                                                                <input type="text" name="name" id="name"
                                                                    class="form-control">
                                                                <span class="invalid-feedback"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Details</label>
                                                                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                                                <span class="invalid-feedback"></span>
                                                            </div>


                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary btn-sm btn-theme"
                                                                    id="btn_branchposition">Add Branch Position</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div></h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Position Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 0; @endphp
                                                @foreach ($branchpositions as $row)
                                                    @php $i++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i }}</th>
                                                        <td>{{ $row->name }}</td>
                                                        <td>
                                                            @can('edit_branch')
                                                            <a href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#editModel{{ $row->id }}"
                                                                class="btn btn-xs btn-dark"> <i class="far fa-edit"></i>Edit</a>
                                                                @endcan
                                                            <div class="modal fade" id="editModel{{ $row->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <h4 class="card-title mb-4"> Edit Branch Position
                                                                            </h4>
                                                                            <form action="#" method="POST"
                                                                                class="edit_form">
                                                                                @csrf
                                                                                <input type="hidden" name="id"
                                                                                    class="form-control"
                                                                                    value="{{ $row->id }}">
                                                                                <div class="form-group">
                                                                                    <label for="name">Position Name</label>
                                                                                    <input type="text" name="name"
                                                                                        id="name" class="form-control"
                                                                                        value="{{ $row->name }}">
                                                                                    <span class="invalid-feedback"></span>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="description">Details</label>
                                                                                    <textarea name="description" class="form-control" id="description" rows="3">{{ $row->description }}</textarea>
                                                                                    <span class="invalid-feedback"></span>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-danger"
                                                                                        data-dismiss="modal">Cancel</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-sm btn-primary btn-theme btn_edit">Update
                                                                                        Branch Position </button>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @can('delete_branch')
                                                            <form action="{{ route('webmaster.branchposition.destroy', $row->id) }}" method="POST"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-xs btn-dark">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                            @endcan
                                                        </td>

                                                    <tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#branchposition_form").submit(function(e) {
            e.preventDefault();
            $("#btn_branchposition").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Adding'
                );
            $("#btn_branchposition").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.branchposition.store') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $("#btn_branchposition").html('Add Branch Position');
                        $("#btn_branchposition").prop("disabled", false);
                    } else if (response.status == 200) {
                        $("#branchposition_form")[0].reset();
                        removeErrors("#branchposition_form");
                        $("#btn_branchposition").html('Add Branch Position');
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });

        $(".edit_form").submit(function(e) {
            e.preventDefault();
            $(".btn_edit").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Updating'
                );
            $(".btn_edit").prop("disabled", true);
            $.ajax({
                url: '{{ route('webmaster.branchposition.update') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.message, function(key, value) {
                            showError(key, value);
                        });
                        $(".btn_edit").html('Update Branch Position');
                        $(".btn_edit").prop("disabled", false);
                    } else if (response.status == 200) {
                        $(".edit_form")[0].reset();
                        removeErrors(".edit_form");
                        $(".btn_edit").html('Update Branch Position');
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);

                    }
                }
            });
        });
    </script>
@endsection
