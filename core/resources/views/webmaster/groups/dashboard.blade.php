@extends('webmaster.partials.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
<div class="page-heading ">
   <div class="page-heading__title">
      <h3>{{ $page_title }}</h3>
      <div>
         <a href="{{ route('webmaster.group.create') }}" class="btn btn-sm btn-theme"> <i class="fa fa-plus"></i> New Group</a>
      </div>
   </div>


   <div class="page-heading__title">
      <ul class="nav nav-tabs">
         <li class="nav-item"> 
            <a class="nav-link active" href="#dashboard" data-toggle="tab" aria-expanded="false"><i class="fas fa-chart-line"></i> Dashboard</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#savings" data-toggle="tab" aria-expanded="false"><i class="far fa-user"></i> Savings</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#loans" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Loans</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#repayments" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Repayments</a>
         </li>
         <li class="nav-item"> 
            <a class="nav-link" href="#information" data-toggle="tab" aria-expanded="false"> <i class="far fa-user"></i> Information</a>
         </li>
      </ul>
   </div>
</div>

<div class="tab-content">
   <div class="tab-pane show active" id="dashboard">
      <div class="row">

      </div>
   </div>

   <div class="tab-pane" id="savings">
      <div class="row">

      </div>
   </div>

   <div class="tab-pane" id="loans">
      <div class="row">

      </div>
   </div>

   <div class="tab-pane" id="repayments">
      <div class="row">

      </div>
   </div>

   <div class="tab-pane" id="information">
      <div class="row">

      </div>
   </div>


</div>





@endsection

@section('scripts')
   <script type="text/javascript">
      "use strict";
      $('.nav-tabs a').on('shown.bs.tab', function(event){
         var tab = $(event.target).attr("href");
         var url = "{{ route('webmaster.group.dashboard', $group->group_no) }}";
          history.pushState({}, null, url + "?tab=" + tab.substring(1));
      });

      @if(isset($_GET['tab']))
         $('.nav-tabs a[href="#{{ $_GET['tab'] }}"]').tab('show');
      @endif



   </script>
@endsection