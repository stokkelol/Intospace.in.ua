@extends ('layouts.backend')

@section('content')
<div class="col-lg-12">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <div class="panel panel-success">
            <div class="panel-heading">Info:</div>
            <div class="panel-body">
                <p>Logged in as: {{ auth()->user()->name }}</p>
                <p>Registered at: {{ auth()->user()->created_at }}</p>
                <p>IP: {{ Request::ip() }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <div class="panel panel-success">
            <div class="panel-heading">Posts:</div>
            <div class="panel-body">
                <p>Total posts: {{ $posts_total }}</p>
                <p>Active posts: {{ $posts_active }}</p>
                <p>Draft: {{ $posts_draft }}</p>
                <p>Total videos: {{ $videos_total }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <div class="panel panel-success">
            <div class="panel-heading">Users:</div>
            <div class="panel-body">
                <p>Users: {{ $users_total }}</p>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <div class="panel panel-success">
            <div class="panel-heading">
            Latest posts
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                @foreach ($recent_posts as $recent_post)
                    <li><a href="/posts/{{ $recent_post->slug }}">{{ $recent_post->title }}</a></li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <div class="panel panel-success">
            <div class="panel-heading">
            Popular posts
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                @foreach ($popular_posts as $popular_post)
                    <a href="/posts/{{ $popular_post->slug }}"><li>{{ $popular_post->title }}</li></a>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <div class="panel panel-success">
            <div class="panel-heading">
            Latest posts
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                @foreach ($recent_posts as $recent_post)
                    <a href="/posts/{{ $recent_post->slug }}"><li>{{ $recent_post->title }}</li></a>
                @endforeach
                </ul>
            </div>
            </div>
        </div>
</div>

<!--<div class="panel panel-primary">
    <div class="panel-heading">Analytics</div>
    <div class="panel-body"></div>
</div>-->
@endsection

@include('backend.partials.footer')
