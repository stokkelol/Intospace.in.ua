@extends('layouts.app')

@section('content')
    <div class="bands-container">
        <ul class="list-unstyled">
            @foreach ($bands as $band)
                <li>{{ $band }}</li>
            @endforeach
        </ul>
    </div>
@endsection
