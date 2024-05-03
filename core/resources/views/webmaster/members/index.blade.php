@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
<div class="page-heading">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
   </div>
</div>

   <div class="row">
      <div class="col-xl-12 mx-auto">
         <div class="card">
            <div class="card-body">
               <div class="clearfix mb-3">
                  <div class="float-left">
                     <h3 class="card-title">{{ $page_title }}</h3>
                  </div>
                  <div class="float-right">
                     <a href="{{ route('webmaster.member.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> New Member</a>
                  </div>
               </div>
               @if($members->count() > 0)
               <div class="table-responsive">
                  <table class="table table-sm mb-0">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Member No</th>
                           <th>Member Names</th>
                           <th>Gender</th>
                           <th>Telephone</th>
                           <th>Email</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i = 0; @endphp
                        @foreach($members as $row)
                        @php $i++; @endphp
                        <tr>
                           <th scope="row">{{ $i }}</th>
                           <td><a href="{{ route('webmaster.member.dashboard', $row->member_no) }}">{{ $row->member_no }}</a></td>
                           <td>
                              @if($row->member_type == 'individual') {{ $row->title }} {{ $row->fname }} {{ $row->lname }} @endif
                              @if($row->member_type == 'group') {{ $row->fname }} @endif
                           </td>
                           <td>
                              @if($row->member_type == 'individual') MEMBER @endif
                              @if($row->member_type == 'group') GROUP @endif
                           </td>
                           <td>{{ $row->telephone }}</td>
                           <td>{{ $row->email }}</td>
                           <td> 
                             <a href="{{ route('webmaster.member.edit', $row->member_no) }}" class="btn btn-xs btn-dark"> <i class="far fa-edit"></i> Edit</a>
                           </td>
                        <tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
                     <div class="d-flex flex-column align-items-center mt-5">
                        <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
                        <span class="mt-3">No Data</span>
                     </div>
                     @endif
            </div>
         </div>
      </div>
   </div>
@endsection