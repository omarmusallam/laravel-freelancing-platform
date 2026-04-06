<!doctype html>
<html lang="{{ App::currentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>

    <!-- Basic Page Needs
================================================== -->
    <title>{{ trim(($title ? $title . ' | ' : '') . ($siteSettings->meta_title ?: $siteSettings->site_name)) }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{ $siteSettings->meta_description }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">
    <meta property="og:title" content="{{ trim(($title ? $title . ' | ' : '') . ($siteSettings->meta_title ?: $siteSettings->site_name)) }}">
    <meta property="og:description" content="{{ $siteSettings->meta_description }}">
    @if ($siteSettings->ogImageUrl())
        <meta property="og:image" content="{{ $siteSettings->ogImageUrl() }}">
    @endif
    @if ($siteSettings->faviconUrl())
        <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    @endif

    <!-- CSS
================================================== -->

    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/front/css/style.rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/front/css/colors/blue.css') }}">

</head>

<body>

    @php
        $currentUser = auth()->user();
        $userRoles = ($currentUser && method_exists($currentUser, 'roles')) ? $currentUser->roles : collect();
        $isFreelancer = $userRoles->contains('name', 'freelancer');
        $isClient = $userRoles->contains('name', 'client');
    @endphp

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Header Container
================================================== -->
        <x-front-header />

        <div class="clearfix"></div>
        <!-- Header Container / End -->

        {{ $slot }}

        <!-- Footer
================================================== -->
        <div id="footer">

            <!-- Footer Top Section -->
            <div class="footer-top-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">

                            <!-- Footer Rows Container -->
                            <div class="footer-rows-container">

                                <!-- Left Side -->
                                <div class="footer-rows-left">
                                    <div class="footer-row">
                                        <div class="footer-row-inner footer-logo">
                                            <img src="{{ $siteSettings->footerLogoUrl() }}" alt="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side -->
                                <div class="footer-rows-right">

                                    <!-- Social Icons -->
                                    <div class="footer-row">
                                        <div class="footer-row-inner">
                                            <ul class="footer-social-links">
                                                <li>
                                                    <a href="{{ $siteSettings->facebook_url ?: route('home') }}" title="Facebook" data-tippy-placement="bottom"
                                                        data-tippy-theme="light">
                                                        <i class="icon-brand-facebook-f"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ $siteSettings->twitter_url ?: route('projects.browse') }}" title="Twitter" data-tippy-placement="bottom"
                                                        data-tippy-theme="light">
                                                        <i class="icon-brand-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ $siteSettings->instagram_url ?: (auth()->check() ? route('client.projects.create') : route('register')) }}" title="Instagram" data-tippy-placement="bottom"
                                                        data-tippy-theme="light">
                                                        <i class="icon-brand-google-plus-g"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ $siteSettings->linkedin_url ?: (auth()->check() ? route('messages') : route('login')) }}" title="LinkedIn" data-tippy-placement="bottom"
                                                        data-tippy-theme="light">
                                                        <i class="icon-brand-linkedin-in"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Footer Rows Container / End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Top Section / End -->

            <!-- Footer Middle Section -->
            <div class="footer-middle-section">
                <div class="container">
                    <div class="row">

                        <!-- Links -->
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>For Candidates</h3>
                                <ul>
                                    <li><a href="{{ route('projects.browse') }}"><span>Browse Jobs</span></a></li>
                                    <li><a href="{{ $isFreelancer ? route('freelancer.profile.edit') : route('register') }}"><span>Freelancer Profile</span></a></li>
                                    <li><a href="{{ $isFreelancer ? route('freelancer.proposals.index') : route('login') }}"><span>My Proposals</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('messages') : route('login') }}"><span>Messages</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Links -->
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>For Employers</h3>
                                <ul>
                                    <li><a href="{{ route('projects.browse') }}"><span>Browse Projects</span></a></li>
                                    <li><a href="{{ $isClient ? route('client.projects.create') : route('login') }}"><span>Post a Job</span></a></li>
                                    <li><a href="{{ $isClient ? route('client.projects.index') : route('login') }}"><span>Manage Jobs</span></a></li>
                                    <li><a href="{{ route('register') }}"><span>Create Account</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Links -->
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>Helpful Links</h3>
                                <ul>
                                    <li><a href="{{ route('home') }}"><span>Home</span></a></li>
                                    <li><a href="{{ route('projects.browse') }}"><span>Browse Projects</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('messages') : route('login') }}"><span>Messages</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Links -->
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>Account</h3>
                                <ul>
                                    <li><a href="{{ route('login') }}"><span>Log In</span></a></li>
                                    <li><a href="{{ $isFreelancer ? route('freelancer.profile.edit') : ($isClient ? route('client.projects.index') : route('register')) }}"><span>My Account</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Newsletter -->
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                            <p>{{ $siteSettings->site_tagline ?: 'Weekly breaking news, analysis and cutting edge advices on job searching.' }}</p>
                            <form action="{{ route('register') }}" method="get" class="newsletter">
                                <input type="text" name="fname" placeholder="Create your account to explore more" readonly>
                                <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                            </form>
                            <div class="mt-3 text-muted">
                                <div>{{ $siteSettings->contact_email }}</div>
                                <div>{{ $siteSettings->contact_phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Middle Section / End -->

            <!-- Footer Copyrights -->
            <div class="footer-bottom-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            &copy; {{ now()->year }} <strong>{{ $siteSettings->site_name }}</strong>. {{ $siteSettings->copyright_text ?: 'All Rights Reserved.' }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Copyrights / End -->

        </div>
        <!-- Footer / End -->

    </div>
    <!-- Wrapper / End -->

    <!-- Scripts
================================================== -->
    <script src="{{ asset('assets/front/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/mmenu.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/tippy.all.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/snackbar.js') }}"></script>
    <script src="{{ asset('assets/front/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>

    <script>
        const userId = "{{ Auth::id() }}";
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
    <script>
        // Snackbar for user status switcher
        $('#snackbar-user-status label').click(function() {
            Snackbar.show({
                text: 'Your status has been changed!',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        });
    </script>

</body>

</html>
