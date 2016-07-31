<!-- Some meta tags. Determine on wich page we are -->
@if (Request::path() == '/')
    <title>Intospace</title>
    <meta name="description" content="Intospace.in.ua">
    <meta property="og:url" content="http://www.intospace.in.ua" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="intospace.in.ua - мрак и блог, вот это вот." />
    <meta property="og:title" content="Intospace" />
    <meta property="og:image" content="http://www.intospace.in.ua/upload/images/intospace.jpg" />
@else
    <title>{{ isset($title) ? $title : 'Intospace' }}</title>
    <meta name="description" content="{{ isset($post->excerpt) ? $post->excerpt : '' }}">
    <meta property="og:url" content="http://www.intospace.in.ua/{{ isset($post->slug) ? $post->slug : ''}}"/>
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ isset($post->excerpt) ? $post->excerpt : 'intospace.in.ua - мрак и блог, вот это вот' }}" />
    <meta property="og:title" content="{{ isset($post->title) ? $post->title : 'Intospace.in.ua' }}" />
    <meta property="og:image" content="{{ isset($post->img) ? 'http://www.intospace.in.ua/upload/covers/'.$post->img : '' }}" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@intospace.in.ua">
    <meta name="twitter:creator" content="@redwhite">
    <meta name="twitter:title" content="{{ isset($post->title) ? $post->title : 'Intospace' }}">
    <meta name="twitter:description" content="{{ isset($post->excerpt) ? $post->excerpt : 'intospace.in.ua - мрак и блог, вот это вот' }}">
    <meta name="twitter:image" content="http://www.intospace.in.ua/upload/covers/{{ isset($post->img) ? $post->img : '' }}">
@endif
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="Intospace" />
