<!-- Tags associated with given post -->
@unless ($post->tags->isEmpty())
    <ul class="list-inline">
        <em class="top-post-tags"><i class="fa fa-tags" aria-hidden="true"></i></em>
        @foreach ($post->tags as $tag)
            <em class="top-post-tags"> <a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="tag-element">{{ $tag->tag }} </a></em>
        @endforeach
    </ul>
@endunless
