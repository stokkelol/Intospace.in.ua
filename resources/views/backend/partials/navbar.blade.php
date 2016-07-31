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
