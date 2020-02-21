<div class="container-fluid bg-gray-dark">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @guest
                <header class="page-header">
                    <div class="rd-navbar-wrap bg-gray-dark">
                        <nav class="rd-navbar rd-navbar-original rd-navbar-static" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="1px" data-xl-stick-up-offset="1px" data-xxl-stick-up-offset="1px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                            <div class="rd-navbar-inner">
                                <div class="rd-navbar-panel">
                                    <button class="rd-navbar-toggle toggle-original" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                                    <div class="rd-navbar-brand"><a class="d-inline-block brand-name" href="{{url('/')}}">
                                            <img class="img-responsive center-block" src="{{ asset('/images/logo-white.png') }}" width="166" height="55" alt=""></a></div>
                                </div>
                                <div class="rd-navbar-nav-wrap toggle-original-elements">
                                    <ul class="rd-navbar-nav">
                                        <li><a href="{{url('login')}}">Login</a></li>
                                        <li><a href="{{url('register')}}">Register</a></li>
                                        <li><a href="{{url('contact')}}">Contacts</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </header>
                @endguest
                @auth
                @if (!Auth::guest() && Auth::user()->admin )
                <header class="page-header">
                    <div class="rd-navbar-wrap bg-gray-dark">
                        <nav class="rd-navbar rd-navbar-original rd-navbar-static" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="1px" data-xl-stick-up-offset="1px" data-xxl-stick-up-offset="1px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                            <div class="rd-navbar-inner">
                                <div class="rd-navbar-panel">
                                    <button class="rd-navbar-toggle toggle-original" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                                    <div class="rd-navbar-brand"><a class="d-inline-block brand-name" href="{{url('/')}}">
                                            <img class="img-responsive center-block" src="{{ asset('/images/logo-white.png') }}" width="166" height="55" alt=""></a></div>
                                </div>
                                <div class="rd-navbar-nav-wrap toggle-original-elements">
                                    <ul class="rd-navbar-nav">
                                        <li><a href="{{route('admin.user.dashboard')}}">@lang('navs.admin.dashboard')</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </header>
                @else
                <header class="page-header">
                    <div class="rd-navbar-wrap bg-gray-dark">
                        <nav class="rd-navbar rd-navbar-original rd-navbar-static" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="1px" data-xl-stick-up-offset="1px" data-xxl-stick-up-offset="1px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                            <div class="rd-navbar-inner">
                                <!-- RD Navbar Panel-->
                                <div class="rd-navbar-panel">
                                    <button class="rd-navbar-toggle toggle-original" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                                    <div class="rd-navbar-brand"><a class="d-inline-block brand-name" href="{{url('/')}}">
                                            <img class="img-responsive center-block" src="{{ asset('/images/logo-white.png') }}" width="166" height="55" alt=""></a></div>
                                </div>
                                <div class="rd-navbar-nav-wrap toggle-original-elements">
                                    <ul class="rd-navbar-nav">

                                        <li class="dropdown">
                                            <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="navbarDropdownMenuUser" data-toggle="dropdown"
                                               aria-haspopup="true">
                                                   <?php
                                                   if (Auth::user()->roles[0]->name == 'executive') {
                                                       ?>
                                                    <span> {{{ isset(Auth::user()->organization_name) ? Auth::user()->organization_name : Auth::user()->email }}} </span>
                                                <?php } else { ?>
                                                    <span> {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </span>
                                                <?php } ?>
                                            </a>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                                <li><a href="{{ url('account') }}">Account</a></li>
                                                <li><a href="{{ url('mytrip') }}">My Trip</a></li>
                                                <li><a href="{{ route('frontend.auth.logout') }}">Logout</a></li>
                                            </ul>
                                        </li> 
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </header>
                @endif
                @endauth        
            </div>
        </div>
    </div>
</div>