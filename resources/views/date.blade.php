
@extends('layouts.app')
@section('title', 'Today')

@section('content')
<div class="heading">
    <h1>Welcome</h1>
    <p class="text-muted">Carbon intensity for Great Britain</p>
</div>

<div class="stats">
    <table class="table">
        <thead>
            <th>From</th>
            <th>To</th>
            <th>Forecast</th>
            <th>Actual</th>
            <th>Index</th>
        </thead>
        <tbody>
        @foreach($data->data as $value)
            <tr>
                <td>{{ Carbon\Carbon::create($value->from)->format('Y-m-d H:i') }}</td>
                <td>{{ Carbon\Carbon::create($value->to)->format('Y-m-d H:i') }}</td>
                <td>{{ $value->intensity->forecast }}</td>
                <td>{{ $value->intensity->actual}}</td>
                <td>{{ $value->intensity->index }}</td>
            </tr>
        @endforeach
        </tbody>
</div>
@endsection
