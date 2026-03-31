<!doctype html>
<html lang="{{ App::currentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <title>{{ config('app.name') }} | {{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/front/css/style.rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/front/css/colors/blue.css') }}">
</head>

<body>
    <div id="wrapper">
        <x-front-header />
        <div class="clearfix"></div>

        {{ $slot }}

        <div id="footer">
            <div class="footer-top-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="footer-rows-container">
                                <div class="footer-rows-left">
                                    <div class="footer-row">
                                        <div class="footer-row-inner footer-logo">
                                            <img src="{{ asset('assets/front/images/logo2.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="footer-rows-right">
                                    <div class="footer-row">
                                        <div class="footer-row-inner">
                                            <ul class="footer-social-links">
                                                <li><a href="{{ route('home') }}" title="Home" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-facebook-f"></i></a></li>
                                                <li><a href="{{ route('projects.browse') }}" title="Projects" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-twitter"></i></a></li>
                                                <li><a href="{{ auth()->check() ? route('client.projects.create') : route('register') }}" title="Post a Job" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-google-plus-g"></i></a></li>
                                                <li><a href="{{ auth()->check() ? route('messages') : route('login') }}" title="Messages" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-linkedin-in"></i></a></li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-middle-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>For Candidates</h3>
                                <ul>
                                    <li><a href="{{ route('projects.browse') }}"><span>Browse Jobs</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('freelancer.profile.edit') : route('register') }}"><span>Freelancer Profile</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('freelancer.proposals.index') : route('login') }}"><span>My Proposals</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('messages') : route('login') }}"><span>Messages</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>For Employers</h3>
                                <ul>
                                    <li><a href="{{ route('projects.browse') }}"><span>Browse Projects</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('client.projects.create') : route('login') }}"><span>Post a Job</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('client.projects.index') : route('login') }}"><span>Manage Jobs</span></a></li>
                                    <li><a href="{{ route('register') }}"><span>Create Account</span></a></li>
                                </ul>
                            </div>
                        </div>

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

                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-links">
                                <h3>Account</h3>
                                <ul>
                                    <li><a href="{{ route('login') }}"><span>Log In</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('freelancer.profile.edit') : route('register') }}"><span>My Account</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                            <p>Create an account and explore the platform as a polished portfolio demo.</p>
                            <form action="{{ route('register') }}" method="get" class="newsletter">
                                <input type="text" name="fname" placeholder="Create your account to explore more" readonly>
                                <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            &copy; {{ now()->year }} <strong>{{ config('app.name') }}</strong>. All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
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
