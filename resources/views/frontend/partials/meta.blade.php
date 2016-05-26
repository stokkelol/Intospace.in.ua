@if (Request::path() == '/')
    <title>Intospace</title>
    <meta name="description" content="Intospace.in.ua">
    <meta property="og:url" content="http://intospace.in.ua/" />
    <meta property="og:description" content="intospace.in.ua - блог о странной музыке" />
    <meta property="og:title" content="Intospace" />
    <meta property="og:img" content="Intospace" />
@else
    <title>{{ isset($title) ? $title : 'Intospace' }}</title>
    <meta property="og:url" content="http://intospace.in.ua/{{ isset($post->title) ? 'post/'.$post->title : '' }}" />
    <meta property="og:description" content="{{ isset($post->excerpt) ? $post->excerpt : 'intospace.in.ua - блог о странной музыке' }}" />
    <meta property="og:title" content="{{ isset($post->title) ? 'post/'.$post->title : '' }}" />
    <meta property="og:img" content="{{ isset($post->img) ? 'localhost:8000/upload/'.$post->img : '' }}" />
@endif
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Intospace" />
