@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection
@section('css')
@endsection
@section('content')
    @include('webmaster.partials.generalheader')
    <div class="row row-sm">
        <iframe src="{{route('webmaster.dashboard.calendar')}}" width="100%" height="600px" style="border:none;"></iframe>
    </div>
@endsection