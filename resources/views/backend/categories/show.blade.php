@extends ('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $title }}</div>
                    @foreach($posts as $post)
                        <div>{{ $post->id }}</div>
                        <div>{{ $post->title }}</div>
                        <br>
                    @endforeach
                    <div class="panel-body">
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection