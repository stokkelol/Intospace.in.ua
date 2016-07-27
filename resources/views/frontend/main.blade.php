@extends ('layouts.app')

@section('tagline')
    <div class="container">
        <div class="row">
            @include('frontend.partials.tagline')
        </div>
    </div>
@endsection

@section('random')
    @if(isset($randposts))
        @if(Request::path() == '/')
            <div class="container">
                <div class="row">
                    @include('frontend.partials.random')
                </div>
            </div>
        @endif
    @endif
@endsection

@section('review')

            @include('frontend.partials.review')

@endsection

@section('toppost')
    @if(!empty($toppost))
        @include('frontend.partials.top_post', ['post' => $toppost])
    @endif
@endsection

@section('content')
    @if(!empty($posts))
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
    @endif
@endsection
