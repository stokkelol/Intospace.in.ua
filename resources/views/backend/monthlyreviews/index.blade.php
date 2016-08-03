@extends('layouts.backend')

@section('content')
            <div class="panel panel-success">
                <div class="panel-heading">
                    Reviews
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled list-inline">
                          <li><a href="{{ route('backend.monthlyreviews.create') }}"><button type="button" class="btn btn-primary">Create new review</button></a></li>
                    </ul>
                    <hr>
                    @foreach ($reviews as $review)
                        <div class="backend-item">
                            <div class="col-lg-2">
                                {{ $review->id }}
                            </div>
                            <div class="col-lg-6">
                                {{ $review->title }}
                                <span class="label label-default"><a href="{{ route('backend.monthlyreviews.edit', ['review_id' => $review->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></span>
                                <span class="label label-default"><a href="{{ route('backend.monthlyreviews.to-draft', ['review_id' => $review->id]) }}">
                                        <i class="fa fa-outdent" aria-hidden="true"></i>To draft</a></span>
                                <span class="label label-default"><a href="{{ route('backend.monthlyreviews.to-active', ['review_id' => $review->id]) }}">
                                        <i class="fa fa-indent" aria-hidden="true"></i>To active</a></span>

                            </div>
                            <div class="col-lg-4">
                                {{ $review->published_at }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
@endsection
