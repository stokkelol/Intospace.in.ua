@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel-heading">
                <h2>Reviews</h2>
                <p><a href="{{ route('backend.reviews.create') }}">
                    <button type="button" class="btn btn-primary">Create review</button></a>
                </p>
            </div>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    Reviews
                </div>
                <div class="panel-body">
                    @foreach($reviews as $review)
                        {{ $review->title }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
