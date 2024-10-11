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
               @if($assetgroups->count() > 0)
               <div class="card card-dashboard-table-six">
                  <h6 class="card-title">{{ $page_title }} <div class="float-right">
                     @can('add_assets_group')
                     <a href="{{ route('webmaster.assetgroup.create') }}" class="btn btn-sm btn-dark btn-theme"> <i class="fa fa-plus"></i> New Asset Group</a>
                     @endcan
                  </div></h6>
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Description</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php $i = 0; @endphp
                           @foreach($assetgroups as $row)
                           @php $i++; @endphp
                           <tr>
                              <th scope="row">{{ $i }}</th>
                              <td>{{ $row->name }}</td>
                              <td>{{ $row->description }}</td>
                              <td>
                                 @can('add_assets_group')
                              <a href="{{ route('webmaster.assetgroup.edit', $row->id) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i></a>
                              @endcan
                              @can('delete_assets_group')
                              <form action="{{ route('webmaster.assetgroup.destroy', $row->id) }}" method="POST"
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
