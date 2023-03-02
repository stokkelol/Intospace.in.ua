@if (count($posts) == 0)
<!-- Nothing has been found -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
        <p>Что-то тут такого нет...</p>
    </div>
@endif
@if (!empty($posts))
    @foreach ($posts as $post)
        @if (isset($post->content))
        <!-- Post -->
            @if ($post->status == 'active'  && $post->is_pinned == '0')
                @include('frontend.partials.regular_post_post', ['post' => $post])
            @endif
        @else
        <!-- Video -->
            @include('frontend.partials.regular_post_video', ['video' => $post])
        @endif
    @endforeach
@endif
@if (Request::path() == '/' || Request::path() == 'posts' || starts_with(Request::path(), 'categories'))
    <!-- Main page paginator -->
    @if (!empty($links))
        <div class="paginate text-center">
            {!! $links->links() !!}
        </div>
    @endif
@endif
