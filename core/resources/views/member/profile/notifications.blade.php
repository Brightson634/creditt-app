@extends('member.partials.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
<div class="row">
   <div class="col-md-8 mx-auto">
      <div class="page-heading">
         <div class="page-heading__title">      
            <h3>
               <a href="javascript:void(0);" onclick="goBack()" class="btn btn-sm btn-dark mr-2"> <i class="fa fas fa-reply"></i> Back</a> 
                {{ $page_title }}
            </h3>
         </div>
         
      </div>
   </div>
</div>


   <div class="row">
      <div class="col-md-8 mx-auto">
            @if($notifications->count() > 0)
            <div>
               <ul class="listview image-listview flush  mb-4">
                  @foreach($notifications as $notification)
                  <li>
                     <a href="#" class="item">
                        <div class="icon-box bg-warning">
                           <i class="fas fa-angle-right text-white"></i>
                        </div>
                        <div class="in">
                           <div>
                              <div class="mb-1"><strong>{{ $notification->title }}</strong></div>
                              <div class="text-small mb-1">{!! $notification->detail !!}</div>
                              <div class="text-xsmall">{{ showDateTime($notification->created_at) }}</div>
                           </div>
                        </div>
                     </a>
                  </li>
                  @endforeach
               </ul>
            </div>
            @else
            <div class="d-flex flex-column align-items-center mt-5">
               <img src="{{ asset('assets/uploads/defaults/nodata.png') }}" width="200">
               <span class="mt-3">No Notifications</span>
            </div>
         @endif
      </div>
   </div>
@endsection