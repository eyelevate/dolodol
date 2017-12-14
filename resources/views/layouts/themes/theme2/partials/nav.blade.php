<nav class="navbar navbar-light sticky-top bg-primary bg-faded navbar-expand-lg d-none d-lg-block">
    <div class="container">    
        <a class="navbar-brand" href="{{ route('home') }}">dolodol</a>
        <div class="collapse navbar-collapse" style="">
            <ul class="navbar-nav mr-auto "></ul>

            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">contact</a>
                </li>
                @if (auth()->check())
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->email }}</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('home.logout') }}">Logout</a>
                    </div>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}">login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/register') }}">register</a>
                </li>
                @endif
                <li class="nav-item clearfix" style="">
                    <a class="nav-link" href="#" style="padding-right:25px;"><i class="icon-bag" style="font-size:25px; position:absolute; "><span class="cart-number">{{ count(session()->get('cart')) }}</span></i></a>
                </li>
                <li>&nbsp;</li>
            </ul>

        </div>
    </div>
</nav>
<nav class="navbar navbar-light navbar-toggleable-md sticky-top bg-primary bg-faded d-lg-none">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">dolodol</a>

    <div class="collapse navbar-collapse text-center" id="navbarSupportedContent" style="">
        <ul class="navbar-nav mr-auto "></ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">shop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">contact</a>
            </li>
            @if (auth()->check())
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->email }}</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('home.logout') }}">Logout</a>
                </div>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/login') }}">login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/register') }}">register</a>
            </li>
            @endif
            <li class="nav-item clearfix" style="">
                <a class="nav-link" href="#" style="padding-right:25px;"><i class="icon-bag" style="font-size:25px; position:absolute; "><span class="cart-number">{{ count(session()->get('cart')) }}</span></i></a>
            </li>
            <li>&nbsp;</li>
        </ul>

    </div>
</nav>
<nav class="navbar bg-transparent bg-faded"></nav>
