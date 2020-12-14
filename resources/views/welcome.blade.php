@extends('layouts.app')
@section('title', 'Home')

@section('content')
<div class="heading">
    <h1>Welcome</h1>
    <p class="text-muted">Carbon intensity for Great Britain</p>
</div>
<div class="stats">
    <div class="stat"><div class="stat-inner card"><a href="{{route('intensity')}}">Get Carbon Intensity data for current half hour</a></div></div>
    <div class="stat"><div class="stat-inner card"><a href="{{route('today')}}">Get Carbon Intensity data for today</a></div></div>
    <div class="stat"><div class="stat-inner card"><a href="{{route('date')}}">Get Carbon Intensity data for random date</a></div></div>
    <div class="stat"><div class="stat-inner card"><a href="{{route('factors')}}">Get Carbon Intensity factors for each fuel type</a></div></div>
</div>
<div class="more">
    <a href="{{ route('more') }}" class="btn btn-secondary mb-4">more <i class="fa fa-chevron-right" style="font-size:smaller;"></i></a>
</div>
@endsection
