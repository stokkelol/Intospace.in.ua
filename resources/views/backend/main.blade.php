@extends ('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Info:</div>
                            <div class="panel-body">
                                <p>Logged in as: {{ auth()->user()->name }}</p>
                                <p>Registered at: {{ auth()->user()->created_at }}</p>
                                <p>IP: {{ Request::ip() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">Posts:</div>
                            <div class="panel-body">
                                <p>Total posts: {{ $posts_total }}</p>
                                <p>Active posts: {{ $posts_active }}</p>
                                <p>Draft: {{ $posts_draft }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">Users:</div>
                            <div class="panel-body">
                                <p>Users: {{ $users_total }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Analytics</div>
                <div class="panel-body"></div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">Posts</div>
                <div class="panel-body">
                  <div class="col-lg-4">
                    <div class="panel panel-info">
                      <div class="panel-heading">
                        Latest posts
                      </div>
                      <div class="panel-body">
                        <ul>
                          @foreach ($recent_posts as $recent_post)
                            <li>{{ $recent_post->title }}</li>
                            @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="panel panel-info">
                      <div class="panel-heading">
                        Popular posts
                      </div>
                      <div class="panel-body">
                        <ul>
                          @foreach ($popular_posts as $popular_post)
                                <li>{{ $popular_post->title }}</li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="panel panel-info">
                      <div class="panel-heading">
                        Latest posts
                      </div>
                      <div class="panel-body">
                        <ul>
                          @foreach ($recent_posts as $recent_post)
                            <li>{{ $recent_post->title }}</li>
                            @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('backend.partials.footer')
