<ul class="list-unstyled list-inline cl-effect-1 tagline">
    @foreach($tags as $tag)
        <li><a href="/tags/{{ $tag->slug }}">{{ $tag->tag }}</a></li>
    @endforeach
</ul>
