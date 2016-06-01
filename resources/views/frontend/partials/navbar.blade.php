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
            <ul class="nav navbar-nav cl-effect-1">
                <!--<li><a href="{{ url('/home') }}">Home</a></li>-->
                @if (Request::path() == 'login')
                @elseif (Request::path() == 'register')
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Последние обзоры<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach ($navbarposts as $post)
                                <li><a href="{{ route('posts', ['slug' => $post->slug]) }}">{{ $post->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="/videos">Последние видео<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach ($navbarvideos as $video)
                                <li><a href="{{ route('videos', ['slug' => $video->slug])}}">{{ $video->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
                <li class="hidden-sm hidden-xs"><a href="/pages/top-2015">Топ 2015</a></li>
                <li class="hidden-sm hidden-xs"><a href="#tagscloud">Облако тегов</a></li>
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
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
