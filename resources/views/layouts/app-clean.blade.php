<!doctype html>
<html lang="en">

<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/colors/blue.css') }}">
</head>

<body class="gray">
    <div id="wrapper">
        <x-front-header />
        <div class="clearfix"></div>

        <div class="dashboard-container">
            <div class="dashboard-sidebar">
                <div class="dashboard-sidebar-inner" data-simplebar>
                    <div class="dashboard-nav-container">
                        <a href="#" class="dashboard-responsive-nav-trigger">
                            <span class="hamburger hamburger--collapse">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </span>
                            <span class="trigger-title">Dashboard Navigation</span>
                        </a>

                        <div class="dashboard-nav">
                            <div class="dashboard-nav-inner">
                                <ul data-submenu-title="Start">
                                    <li><a href="{{ route('client.projects.index') }}"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
                                    <li><a href="{{ route('messages') }}"><i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag">Live</span></a></li>
                                    <li><a href="{{ route('projects.browse') }}"><i class="icon-material-outline-star-border"></i> Browse Projects</a></li>
                                    <li><a href="{{ route('freelancer.proposals.index') }}"><i class="icon-material-outline-rate-review"></i> My Proposals</a></li>
                                </ul>

                                <ul data-submenu-title="Organize and Manage">
                                    <li><a href="{{ route('client.projects.index') }}"><i class="icon-material-outline-business-center"></i> Jobs</a>
                                        <ul>
                                            <li><a href="{{ route('client.projects.index') }}">Manage Jobs</a></li>
                                            <li><a href="{{ route('projects.browse') }}">Browse Public Jobs</a></li>
                                            <li><a href="{{ route('client.projects.create') }}">Post a Job</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('freelancer.proposals.index') }}"><i class="icon-material-outline-assignment"></i> Freelancer</a>
                                        <ul>
                                            <li><a href="{{ route('freelancer.proposals.index') }}">My Active Bids</a></li>
                                            <li><a href="{{ route('freelancer.profile.edit') }}">Profile Settings</a></li>
                                            <li><a href="{{ route('messages') }}">Conversations</a></li>
                                        </ul>
                                    </li>
                                </ul>

                                <ul data-submenu-title="Account">
                                    <li class="active"><a href="{{ route('freelancer.profile.edit') }}"><i class="icon-material-outline-settings"></i> Settings</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                                </ul>
                                <form action="{{ route('logout') }}" method="post" style="display: none;" id="logout">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">
                    <div class="dashboard-headline">
                        <h3>{{ $title ?? 'Dashboard' }}</h3>
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('client.projects.index') }}">Dashboard</a></li>
                                <li>{{ $title ?? 'Dashboard' }}</li>
                            </ul>
                        </nav>
                    </div>

                    {{ $slot }}

                    <div class="dashboard-footer-spacer"></div>
                    <div class="small-footer margin-top-15">
                        <div class="small-footer-copyrights">
                            &copy; {{ now()->year }} <strong>{{ config('app.name') }}</strong>. All Rights Reserved.
                        </div>
                        <ul class="footer-social-links">
                            <li><a href="{{ route('home') }}" title="Home" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                            <li><a href="{{ route('projects.browse') }}" title="Projects" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                            <li><a href="{{ route('client.projects.create') }}" title="Post a Job" data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                            <li><a href="{{ route('messages') }}" title="Messages" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
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
