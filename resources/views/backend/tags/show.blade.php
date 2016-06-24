@extends ('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-2">

            </div>
            <div class="col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                        {{$tag->tag}}
                        @foreach ($posts as $post)
                            {{ $post->title }}
                        @endforeach
                    <div class="panel-body">
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection