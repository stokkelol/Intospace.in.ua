@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel-heading">
                <p>Monthly reviews</p>
                <ul class="list-unstyled list-inline">
                      <li><a href="{{ route('backend.monthlyreviews.create') }}"><button type="button" class="btn btn-primary">Create new review</button></a></li>
                </ul>
            </div>
            <div class="panel panel-success">
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
