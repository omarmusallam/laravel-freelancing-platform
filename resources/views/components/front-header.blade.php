<header id="header-container" class="fullwidth">

    <!-- Header -->
    <div id="header">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/front/images/logo.png') }}"
                            alt="logo"></a>
                </div>

                <!-- Main Navigation -->
                <nav id="navigation">
                    <ul id="responsive">

                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a>
                            {{-- {{ route('home') }} --}}
                            <ul class="dropdown-nav">
                                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            </ul>
                        </li>

                        <li><a href="{{ route('projects.browse') }}">{{ trans('Find Work') }}</a>
                            <ul class="dropdown-nav">
                                <li><a href="{{ route('projects.browse') }}">@lang('Browse Jobs')</a></li>
                                @auth
                                    <li><a href="{{ route('freelancer.proposals.index') }}">@lang('My Proposals')</a></li>
                                @endauth
                            </ul>
                        </li>

                        <li><a href="{{ auth()->check() ? route('client.projects.index') : route('login') }}">{{ __('For Employers') }}</a>
                            <ul class="dropdown-nav">
                                <li><a href="{{ route('projects.browse') }}">{{ __('Browse Projects') }}</a></li>
                                @auth
                                    <li><a href="{{ route('freelancer.profile.edit') }}">{{ __('Freelancer Profile') }}</a></li>
                                    <li><a href="{{ route('client.projects.create') }}">{{ __('Post a Job') }}</a></li>
                                @else
                                    <li><a href="{{ route('register') }}">{{ __('Create Account') }}</a></li>
                                    <li><a href="{{ route('login') }}">{{ __('Post a Job') }}</a></li>
                                @endauth
                            </ul>
                        </li>

                        <li><a href="{{ auth()->check() ? route('freelancer.profile.edit') : route('login') }}">{{ __('Dashboard') }}</a>
                            <ul class="dropdown-nav">
                                @auth
                                    <li><a href="{{ route('client.projects.index') }}">{{ __('My Jobs') }}</a></li>
                                    <li><a href="{{ route('messages') }}">{{ __('Messages') }}</a></li>
                                    <li><a href="{{ route('freelancer.profile.edit') }}">{{ __('Settings') }}</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                @endauth
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="current">{{ __('Language') }}</a>
                            <ul class="dropdown-nav">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->

            </div>
            <!-- Left Side Content / End -->


            <!-- Right Side Content / End -->
            <div class="right-side">

                @auth
                    <x-notification-menu />
                @endauth

                <!-- User Menu -->
                <div class="header-widget">

                    <!-- Messages -->
                    <div class="header-notifications user-menu">
                        @auth
                            <div class="header-notifications-trigger">
                                <a href="#">
                                    <div class=""><img src="{{ Auth::user()->profile_photo_url }}"
                                            alt=""
                                            style="border: 2px solid #2a41e8;
                                    padding: 2px;
                                    border-radius: 50%;
                                    border-top-color: #47bb67;
                                    border-left-color: #47bb67;
                                    width: 60px;
                                    height: 60px;">
                                    </div>
                                </a>
                            </div>
                        @else
                            <a class="header-notifications-trigger"
                                href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endauth

                        <!-- Dropdown -->
                        @auth
                            <div class="header-notifications-dropdown">

                                <!-- User Status -->
                                <div class="user-status">

                                    <!-- User Name / Avatar -->
                                    <div class="user-details">
                                        <div class=""><a href="{{ route('freelancer.profile.edit') }}"><img
                                                    src="{{ Auth::user()->profile_photo_url }}" alt=""
                                                    style="border: 2px solid #2a41e8;
                                            padding: 2px;
                                            border-radius: 50%;
                                            border-top-color: #47bb67;
                                            border-left-color: #47bb67;
                                            width: 60px;
                                            height: 60px;"></a>
                                        </div>
                                        <div class="user-name">
                                            <a
                                                href="{{ route('freelancer.profile.edit') }}">{{ Auth::user()->name }}</a><span>{{ __('Freelancer') }}</span>
                                        </div>
                                    </div>

                                    <!-- User Status Switcher -->
                                    <div class="status-switch" id="snackbar-user-status">
                                        <label class="user-online current-status">{{ __('Online') }}</label>
                                        <label class="user-invisible">{{ __('Invisible') }}</label>
                                        <!-- Status Indicator -->
                                        <span class="status-indicator" aria-hidden="true"></span>
                                    </div>
                                </div>

                                <ul class="user-menu-small-nav">
                                    <li><a href="{{ route('client.projects.index') }}"><i class="icon-material-outline-dashboard"></i>
                                            {{ __('My Jobs') }}</a></li>
                                    <li><a href="{{ route('freelancer.profile.edit') }}"><i class="icon-material-outline-settings"></i>
                                            {{ __('Settings') }}</a></li>
                                    <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout').submit();"><i
                                                class="icon-material-outline-power-settings-new"></i>
                                            {{ __('Logout') }}</a>
                                    </li>
                                </ul>
                                <form action="{{ route('logout') }}" method="post" style="display: none;"
                                    id="logout">
                                    @csrf
                                </form>

                            </div>
                        @endauth
                    </div>

                </div>
                <!-- User Menu / End -->

                <!-- Mobile Navigation Button -->
                <span class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </span>

            </div>
            <!-- Right Side Content / End -->

        </div>
    </div>
    <!-- Header / End -->

</header>
