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
            @if ($assets->count() > 0)
                <div class="card card-dashboard-table-six">
                    <h6 class="card-title">{{ $page_title }}<div class="float-right">
                            @can('add_assets')
                                <a href="{{ route('webmaster.asset.create') }}" class="btn btn-dark btn-sm btn-theme"> <i
                                        class="fa fa-plus"></i> New Asset</a>
                            </div>
                        @endcan
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Asset No</th>
                                    <th>Name</th>
                                    <th>Serial No.</th>
                                    <th>Depreciation Amount</th>
                                    <th>Depreciation Period</th>
                                    <th>Accumulated Depreciation</th>
                                    <th>Cost Price</th>
                                    <th>Net Book Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @foreach ($assets as $row)
                                    @php $i++; @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $row->asset_no }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->serial_no }}</td>
                                        <td>{!! showAmount($row->depreciation_amount) !!}</td>
                                        <td>{{ $row->depreciation_period }}</td>
                                        <td></td>
                                        <td>{!! showAmount($row->cost_price) !!}</td>
                                        <td></td>
                                        <td>
                                            @can('edit_assets')
                                                <a href="{{ route('webmaster.asset.edit', $row->id) }}"
                                                    class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                                            @endcan
                                            @can('delete_assets')
                                                <form action="{{ route('webmaster.asset.destroy', $row->id) }}" method="POST"
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
