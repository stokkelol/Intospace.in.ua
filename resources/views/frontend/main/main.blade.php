@extends('layouts.app')

@section('content')
    <div class="" style="padding-top: 60px">
        @foreach($objects as $object)
            {{ $object->title }}
            <br>
        @endforeach
    </div>
@endsection
