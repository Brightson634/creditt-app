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
   <div class="col-md-4">
      <div class="card">
         <div class="card-body">
            <h3 class="card-title"> Loan Preview Information</h3>
            
         </div>
      </div>
      
   </div>
   <div class="col-md-8">
      <iframe class="pdf" src="{{ route('webmaster.loan.reviewpdf', $loan->loan_no) }}" width="100%" height="600"></iframe>
   </div>
 
</div>
@endsection
