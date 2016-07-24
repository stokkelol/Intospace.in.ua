@extends ('layouts.app')

@section('tagline')
    <div class="container">
        <div class="row">
            @include('frontend.partials.tagline')
        </div>
    </div>
@endsection

@section('random')
    @if(Request::path() == '/')
        <div class="container">
            <div class="row">
                @include('frontend.partials.random')
            </div>
        </div>
    @endif
@endsection

@section('toppost')
    @if(Request::path() == '/' || Request::path() == 'posts' || Request::path() == 'bands/'.$toppost->band->slug)
        @include('frontend.partials.top_post', ['post' => $toppost])
    @endif
@endsection


@section('content')
    <div class="container">
        <hr>
        <div class="row main-body">
            @if(Request::path() != '/')
                <div class="regular-post-padding"></div>
            @endif
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                @include('frontend.partials.regular_post', ['posts'  =>  $posts])
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sidebar" id="sidebar">
                @include('frontend.sidebar.sidebar')
            </div>
        </div>
    </div>
@endsection
