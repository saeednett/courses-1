<header class="header">

    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12 col-12" style="background: lightcoral;">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12 col-12 text-right">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('logo.png') }}" alt="" height="70">
                    </a>
                </div>
                <div class="col-md-4 col-sm-12 col-12 text-center">
                    wufybino
                </div>
            </div>
        </div>
    </div>

    <div class="menu-section" style="background: #4e555b;">
        <div class="row justify-content-center">
            <div class="col-md-8 pr-0" style="background: #c51f1a;">

                <nav class="navbar navbar-expand-lg navbar-light pr-0">

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse pr-0" id="navbarSupportedContent" style="background: teal;">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-lg-0">
                            <li class="nav-item col-md-2">
                                <a class="nav-link" href="{{ route('account.index') }}">الرئسية</a>
                            </li>

                            <li class="nav-item col-md-2">
                                <a class="nav-link" href="{{ route('login') }}">من نحن</a>
                            </li>

                            <li class="nav-item col-md-2">
                                <a class="nav-link" href="{{ route('login') }}">اتصل بنا</a>
                            </li>

                            <li class="nav-item col-md-2">
                                <a class="nav-link" href="{{ route('account.ticket') }}">تذاكري</a>
                            </li>

                        </ul>

                        <ul class="navbar-nav ml-lg-1 col-lg-3 ml-md-1 col-md-3">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item dropdown mr-lg-4 mr-md-4">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        دخول
                                        <span class="fa fa-user"></span>
                                        <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right text-right"
                                         aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
                                        <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل جديد</a>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->username }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                                        <a href="{{ route('account.edit') }}" class="dropdown-item">
                                            بياناتي
                                        </a>
                                        <a href="{{ route('account.ticket') }}" class="dropdown-item">
                                            تذاكري
                                            <span class="rounded-circle count-booking-tickets">1</span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            تسجيل الخروج
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>








<header class="header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12 col-12" style="background: lightcoral;">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-12">

                    </div>
                    <div class="col-md-4 col-sm-12 col-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-section" style="background: #4e555b;">
        <div class="row justify-content-center">
            <div class="col-md-8" style="background: #c51f1a;">

                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('img/logo2.png') }}" alt="" height="50">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-lg-4 mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account.index') }}">الرئسية</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">من نحن</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">اتصل بنا</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-lg-1 col-lg-3 ml-md-1 col-md-3">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item dropdown mr-lg-4 mr-md-4">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        دخول
                                        <span class="fa fa-user"></span>
                                        <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right text-right"
                                         aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
                                        <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل جديد</a>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->username }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                                        <a href="{{ route('account.edit') }}" class="dropdown-item">
                                            بياناتي
                                        </a>
                                        <a href="{{ route('account.ticket') }}" class="dropdown-item">
                                            تذاكري
                                            <span class="rounded-circle count-booking-tickets">1</span>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            تسجيل الخروج
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>