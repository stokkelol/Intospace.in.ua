@extends ('layouts.backend')

@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">Posts with <a href="/tags/{{ $tag->slug }}">{{ $tag->tag }}</a> tag</div>
            <ul>
                @foreach ($posts as $post)
                    <li>{{ $post->title }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
