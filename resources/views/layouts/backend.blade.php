<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Intospace.in.ua</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir("css/all.css") }}">
    <link rel="stylesheet" href="{{ elixir("css/backend.css") }}">
    <link rel="stylesheet" href="{{ elixir('css/styles.css') }}">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container-fluid navbar-container">
        <div class="navbar-header page-scroll">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Intospace
            </a>
        </div>

        <ul class="nav navbar-nav navbar-flex-container">
            <li class="navbar-flex-container"><a href="{{ url('/backend') }}">
                    <i class="fa fa-code" aria-hidden="true"></i>
                    <span>Backend</span>
                </a></li>
            <li><a href="{{ url('/backend/posts') }}"><i class="fa fa-list" aria-hidden="true"></i><span>Posts</span></a></li>
            <li><a href="{{ url('/backend/videos') }}"><i class="fa fa-video-camera" aria-hidden="true"></i><span>Videos</span></a></li>
            <li><a href="{{ url('/backend/categories') }}"><i class="fa fa-columns" aria-hidden="true"></i><span>Categories</span></a></li>
            <li><a href="{{ url('/backend/tags') }}"><i class="fa fa-tags" aria-hidden="true"></i><span>Tags</span></a></li>
            <li><a href="{{ url('/backend/users') }}"><i class="fa fa-users" aria-hidden="true"></i><span>Users</span></a></li>
            <li><a href="{{ url('/backend/bands') }}"><i class="fa fa-music" aria-hidden="true"></i><span>Bands</span></a></li>
            <li><a href="{{ url('/backend/blogs') }}"><i class="fa fa-th-large" aria-hidden="true"></i><span>Blog posts</span></a></li>
            <li><a href="{{ url('/backend/monthlyreviews') }}"><i class="fa fa-file-text" aria-hidden="true"></i><span>Monthly reviews</span></a></li>
            <li><a href="{{ url('/backend/files') }}"><i class="fa fa-file-image-o" aria-hidden="true"></i><span>Files</span></a></li>
        </ul>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">



            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">

                <li><a href="/feed" class="feed-icon"><i class="fa fa-rss-square" aria-hidden="true"></i></a></li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Привет, {{ Auth::user()->name }} ! <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>



<div class="container" style="height:50px;">
    @include('flash::message')
</div>
@yield('content')
@yield('partials.footer')


        <!-- JavaScripts -->
<script src="{{ elixir("js/all.js") }}"></script>
<script>
    $('#tagsselect').select2({
        placeholder: 'Choose a tag',
        tags: true,
        tokenSeparators: [",", " "],
        createTag: function (newTag) {
            return {
                id: 'new:' + newTag.term,
                text: newTag.term + ' (new)'
            };
        }
    });
</script>
<script>
    $('.alert-info').delay(3000).fadeOut("slow");
</script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'ckeditor', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });
    for (var i in CKEDITOR.instances) {

        CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });

    }
</script>
<script>
    new Vue({
        el: '#post-form-preview',
        data: {

        }
    });
</script>
</body>
</html>
