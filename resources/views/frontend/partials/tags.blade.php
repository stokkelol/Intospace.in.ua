@unless ($post->tags->isEmpty())
    <ul class="list-inline">
        @foreach ($post->tags as $tag)
            <em class="top-post-tags"><a href="{{ route('tag', ['slug' => $tag->slug]) }}" class="tag-element">{{ $tag->tag }}</a></em>
        @endforeach
    </ul>
@endunless
