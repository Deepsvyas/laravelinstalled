<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{ url('/') }}">
                    <img class="logoM" src="{{ Theme::img('logo.jpg') }}">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/') }}"> HOME </a></li>
                    <li><a href="{{ url('/pages/community-rules') }}">COMMUNITY RULES </a></li>
                    <li><a href="{{ url('/pages/about-us') }}"> ABOUT US</a></li>
                    <li><a href="{{ url('/pages/faqs') }}">FAQs</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">@if(Auth::check()) PROFILE @else  ACCOUNT @endif <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @if(Auth::check())
                            <li style="text-transform: capitalize;"><a href="{{ Auth::user()->getUserProfileUrl() }}">{{ Auth::user()->full_name() }}</a></li>
                            <li><a href="{{ url('logout') }}">Logout</a></li>                           
                            @else
                            <li><a href="{{ url('login') }}">LOGIN</a></li>
                            <li><a href="{{ url('new-signup') }}">SIGNUP</a></li>
                            @endif
                        </ul>
                    </li>

                    <form action="{{ url('t/search') }}" class="navbar-form navbar-left">
                        <div class="form-group search">
                            <input type="text"   name="gbl" id="gbl" value="{{ $input['gbl'] or '' }}" class="form-control searchTerm" placeholder="Search...">
                        </div>
                        <button type="submit" class="btn btn-default pull-right searchButton"><i class="fa fa-search"></i></button>
                    </form>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>