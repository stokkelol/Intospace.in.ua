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

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <!--<li><a href="{{ url('/home') }}">Home</a></li>-->
                @if (Request::path() == 'login')
                @elseif (Request::path() == 'register')
                @else
                    <li class="dropdown cl-effect-1">
                        <a href="/posts">Последние обзоры<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($navbarposts as $post)
                                <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown cl-effect-1">
                        <a href="/videos">Последние видео<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($navbarvideos as $video)
                                <li><a href="{{ route('videos', ['slug' => $video->slug])}}">{{ $video->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                <li class="hidden-sm hidden-xs"><a href="/pages/top-2015">Топ 2015</a></li>
                <!--<li class="hidden-sm hidden-xs"><a href="#tagscloud">Облако тегов</a></li>-->
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown cl-effect-1">
                    <a href="/posts">Теги<span class="caret cl-effect-1"></span></a>
                    <ul class="dropdown-menu">
                        @foreach ($counttags as $tag)
                            @if (($tag->cnt) > 5)
                                <li><a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%3 == 0) ? 'tag-even' : 'tag-odd' }}" style="font-size:14px"><span>{{ $tag->tag }}</span></a></li>
                            @elseif (($tag->cnt) > 3)
                                <li><a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%3 == 1) ? 'tag-even' : 'tag-odd' }}" style="font-size:12px"><span>{{ $tag->tag }}</span></a></li>
                            @else
                                <li><a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%3 == 2) ? 'tag-even' : 'tag-odd' }}" style="font-size:10px">{{ $tag->tag }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li>
                    <form method="GET" action="/" accept-charset="UTF-8" role="search" class="main-search form-inline">
                        <input class="" name="search" type="text">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </form>
                </li>
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
