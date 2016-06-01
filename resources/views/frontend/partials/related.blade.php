@inject('relatedposts', 'App\Services\BlogService')

<?php $posts = $relatedposts->getRelatedPosts($post->tags);?>
<div class="related-posts">
    @foreach ($posts as $post)
        <div class="col-lg-4 col-sm-12 col-sx-12 related-post-item">
            <img src="upload/{{ $post->img_thumbnail }}" alt="" class="related-post-img img-thumbnail img-responsive">
            <br>
            <p class="text-center"><a href="{{ $post->slug }}" class="related-post-title">{{ $post->title }}</a></p>
        </div>
    @endforeach
</div>

