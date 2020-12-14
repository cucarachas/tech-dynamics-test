@extends('layouts.app')
@section('title', 'Factors')

@section('content')
<div class="heading">
    <h1>Welcome</h1>
    <p class="text-muted">Carbon intensity for Great Britain</p>
</div>
<div class="stats">
    <table class="table">
        <thead>
            <th>Type</th>
            <th>Measurement</th>
        </thead>
        <tbody>
        @foreach($data->data[0] as $type => $measurement)
            <tr>
                <td>{{ $type }}</td>
                <td>{{ $measurement }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
