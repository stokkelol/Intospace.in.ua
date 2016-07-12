@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel-heading">
                <h2>Blogs</h2>
                <p><a href="{{ route('backend.blogs.create') }}">
                    <button type="button" class="btn btn-primary">Create review</button></a>
                </p>
            </div>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    Blog posts
                </div>
                <div class="panel-body">
                    <div class="posts-paginate text-center">
                        {!! $blogs->render() !!}
                    </div>
                      <div class="posts-list">
                          <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-default">id</div>
                          <div class="col-lg-2 col-md-1 col-sm-1 col-xs-1 text-danger">author</div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-success">title</div>
                          <div class="col-lg-3 col-md-2 col-sm-2 col-xs-2 text-info">published at</div>
                      </div>
                      <hr>
                @foreach($blogs as $blog)
                    <div style="min-height:40px">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">{{ $blog->id}} </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>{{ $blog->user->name }}</span></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">{{ $blog->title }}</div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>{{ $blog->published_at }}</span></div>
                    </div>
                    <hr>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
