<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="../" class="navbar-brand"><i class="fa fa-home" aria-hidden="true"></i></a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Main pages <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="themes">
                        <li><a href="/">Home</a></li>
                        <li class="divider"></li>
                        <li><a href="/posts">Posts</a></li>
                        <li><a href="/videos">Videos</a></li>
                        <li><a href="/bands">Bands</a></li>
                        <li><a href="/categories/new-reviews">New reviews</a></li>
                        <li><a href="/categories/old-reviews">Old reviews</a></li>
                        <li><a href="/categories/short-reviews">Short reviews</a></li>
                        <li><a href="/monthlyreviews">Monthly reviews</a></li>
                    </ul>
                </li>
            </ul>

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
                @endif
            </ul>
        </div>
    </div>
</div>
