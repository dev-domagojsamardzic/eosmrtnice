{{-- Top bar --}}
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="#" class="text-black mr-3">
                        {{ __('guest.funerals') }}
                    </a>
                    <a href="#" class="text-black mr-3">
                        {{ __('guest.masonries') }}
                    </a>
                    <a href="#" class="text-black mr-3">
                        {{ __('guest.florists') }}
                    </a>
                </div>

                <!--class="float-right"-->
                <div>
                    <a class="btn btn-primary btn-user btn-block text-white" role="button" href="#">
                        {{ __('guest.submit_post') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Top bar --}}

{{-- Mobile navbar --}}
<header class="mobile-site-navbar shadow d-none">
    <div class="container">
        <div class="d-flex justify-between align-items-center">
            {{-- Logo --}}
            <div class="site-logo">
                <a href="{{ route('homepage') }}">
                    <img style="height: 40px; width: auto;" src="{{ asset('graphics/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                </a>
            </div>

            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
                <span class="fas fa-bars"></span>
            </button>
        </div>

        <div class="navbar-collapse offcanvas-collapse">
            <nav class="site-navigation" role="navigation">

                <a class="btn btn-secondary btn-user text-black ml-3" role="button" href="#">
                    {{ __('guest.submit_post') }}
                </a>
                <div class="px-3">
                    <hr class="bg-white" style="opacity: .3">
                </div>
                <ul>
                    <li><a href="#" class="nav-link">{{ __('guest.funerals') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.masonries') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.florists') }}</a></li>
                </ul>
                <div class="px-3">
                    <hr class="bg-white" style="opacity: .3">
                </div>
                <ul>
                    <li><a href="#" class="nav-link">{{ __('guest.death_notices') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.last_goodbyes') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.memories') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.thank_yous') }}</a></li>
                </ul>
                <div class="px-3">
                    <hr class="bg-white" style="opacity: .3">
                </div>
                @if(Auth::check())
                    <ul>
                        <li class="d-flex align-items-center justify-content-start flex-row px-3">
                            <i class="fas fa-user-circle text-white"></i>
                            <span class="text-sm font-bold text-white ml-2">{{ auth()->user()->full_name }}</span>
                        </li>

                        <li>
                            <a href="{{ route(auth_user_type().'.dashboard') }}" class="nav-link">{{ __('guest.dashboard') }}</a>
                        </li>

                        <form id="logout_form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li><a class="nav-link" onclick="document.querySelector('#logout_form').submit()">{{ __('auth.log_out') }}</a></li>
                        </form>
                    </ul>
                @else
                    <ul>
                        <li>
                            <a class="nav-link" href="{{ route('login') }}" title="{{ __('auth.log_in') }}">
                                {{ __('auth.log_in') }}
                            </a>
                        </li>
                    </ul>
                @endif
            </nav>
        </div>

    </div>
</header>
{{-- Mobile navbar --}}

{{-- Desktop navbar --}}
<header class="site-navbar js-sticky-header site-navbar-target shadow" role="banner">
    <div class="container">
        <div class="d-flex justify-between align-items-center">

            {{-- Logo --}}
            <div class="site-logo">
                <a href="{{ route('homepage') }}">
                    <img style="height: 40px; width: auto;" src="{{ asset('graphics/logo/logo-dark.svg') }}" alt="{{ config('app.name') }}">
                </a>
            </div>

            {{-- Main navigation --}}
            <nav class="site-navigation navbar-collapse" role="navigation">
                <ul class="site-menu js-clone-nav">
                    <li><a href="#" class="nav-link">{{ __('guest.death_notices') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.last_goodbyes') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.memories') }}</a></li>
                    <li><a href="#" class="nav-link">{{ __('guest.thank_yous') }}</a></li>
                    {{-- nav link with children --}}
                    {{--<li class="has-children">
                        <a href="#" class="nav-link">
                            About Us<i class="fas fa-chevron-down ml-2"></i>
                        </a>
                        <ul class="dropdown arrow-top">
                            <li><a href="#team-section" class="nav-link">Team</a></li>
                            <li><a href="#pricing-section" class="nav-link">Pricing</a></li>
                            <li><a href="#faq-section" class="nav-link">FAQ</a></li>
                            <li class="has-children">
                                <a href="#">More Links</a>
                                <ul class="dropdown">
                                    <li><a href="#">Menu One</a></li>
                                    <li><a href="#">Menu Two</a></li>
                                    <li><a href="#">Menu Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>--}}
                </ul>
            </nav>

            <div class="d-flex align-items-end justify-content-center">
                @if(Auth::check())
                    <div class="has-children">
                        <a class="nav-link" href="{{ route(auth_user_type().'.dashboard') }}" title="{{ auth()->user()->full_name }}">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <i class="fas fa-user-circle"></i>
                                <span class="text-xs font-bold">{{ auth()->user()->first_name }}</span>
                            </div>
                        </a>
                        <ul class="dropdown arrow-top">
                            <li>
                                <a href="{{ route(auth_user_type().'.dashboard') }}" class="nav-link">{{ __('guest.dashboard') }}</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link">{{ __('auth.log_out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('login') }}" title="{{ __('auth.log_in') }}">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    </a>
                @endif
            </div>

            <div class="toggle-button d-inline-block d-lg-none">
                <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black" data-toggle="offcanvas">
                    <i class="fas fa-bars h-3"></i>
                </a>
            </div>
        </div>
    </div>
</header>
{{-- Desktop navbar --}}
