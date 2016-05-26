@inject('relatedposts', 'App\Services\BlogService')

<?php $posts = $relatedposts->getRelatedPosts($post->tags);?>

@foreach ($posts as $post)
    {{ $post->title }}
@endforeach
