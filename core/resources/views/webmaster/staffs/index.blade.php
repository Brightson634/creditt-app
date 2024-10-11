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
        <div class="col-xl-12 mx-auto">
            @if ($staffs->count() > 0)
                <div class="card card-dashboard-table-six">
                    <h6 class="card-title">{{ $page_title }}<div class="float-right">
                        @can('add_staff')
                            <a href="{{ route('webmaster.staff.create') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                    class="fa fa-plus"></i> New Staff</a>
                        </div>
                        @endcan
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Branch</th>
                                    <th>Telephone</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($staffs as $row)
                                    @php $i++; @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td><a
                                                href="{{ route('webmaster.staff.dashboard', $row->staff_no) }}">{{ $row->staff_no }}</a>
                                        </td>
                                        <td>{{ optional($row)->fname }} - {{ optional($row)->lname }}</td>
                                        <td>{{ optional($row->branchposition)->name }}</td>
                                        <td>{{ optional($row->branch)->name }}</td>
                                        <td>{{ optional($row)->telephone }}</td>
                                        <td>{{ optional($row)->email }}</td>
                                        <td>
                                            @can('edit_staff')
                                            <a href="{{ route('webmaster.staff.edit', $row->id) }}"
                                                class="btn btn-xs btn-dark me-2">
                                                <i class="far fa-edit"></i> Edit
                                            </a>
                                            @endcan
                                            @can('delete_staff')
                                            <form action="{{ route('webmaster.staff.destroy', $row->id) }}" method="POST"
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
            @else
                <div class="d-flex flex-column align-items-center mt-5">
                    <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                    <span class="mt-3">No Data</span>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script>
   $(document).ready(function () {
       //delete
       $(document).on('click', '#deleStaff', function(e) {
                e.preventDefault();
                alert('Hi');
                var url = "{{ route('webmaster.staff.delete') }}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content'),
                                id: $(this).attr('data_id'),
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Satff deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload(true);
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                    console.log(response)
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while trying to delete the account type.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
   });
</script> --}}
@endsection
