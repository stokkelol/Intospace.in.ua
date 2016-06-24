@extends ('layouts.backend')

@section('content')

     <h1>{{ $post->title }}</h1>


    <article>
        {{ $post->body }}
    </article>

     @unless ($post->tags->isEmpty())
        <h5>Tags:</h5>
        <ul>
            @foreach ($post->tags as $tag)
               <li>{{ $tag->tag }}</li>
            @endforeach
        </ul>
    @endunless

@endsection