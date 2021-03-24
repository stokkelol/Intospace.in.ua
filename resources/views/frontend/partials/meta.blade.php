<!-- Some meta tags. Determine on wich page we are -->
@if (Request::path() == '/')
    <title>Intospace</title>
    <meta name="description" content="intospace.rocks">
    <meta property="og:url" content="https://intospace.rocks" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="intospace.rocks - мрак и блог, вот это вот." />
    <meta property="og:title" content="Intospace" />
    <meta property="og:image" content="https://intospace.rocks/upload/images/intospace.jpg" />
@else
    <title>{{ isset($title) ? $title : 'Intospace' }}</title>
    <meta name="description" content="{{ isset($post->excerpt) ? strip_tags($post->excerpt) : '' }}">
    <meta property="og:url" content="https://www.intospace.rocks/{{ isset($post->slug) ? $post->slug : ''}}"/>
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ isset($post->excerpt) ? strip_tags($post->excerpt) : 'intospace.rocks - мрак и блог, вот это вот' }}" />
    <meta property="og:title" content="{{ isset($post->title) ? $post->title : 'intospace.rocks' }}" />
    <meta property="og:image" content="{{ isset($post->img) ? 'https://intospace.rocks/upload/covers/'.$post->img : '' }}" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@intospace.rocks">
    <meta name="twitter:creator" content="@redwhite">
    <meta name="twitter:title" content="{{ isset($post->title) ? $post->title : 'Intospace' }}">
    <meta name="twitter:description" content="{{ isset($post->excerpt) ? strip_tags($post->excerpt) : 'intospace.rocks - мрак и блог, вот это вот' }}">
    <meta name="twitter:image" content="https://intospace.rocks/upload/covers/{{ isset($post->img) ? $post->img : '' }}">
@endif
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="Intospace" />
