<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <title>{{ $siteSettings->site_name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{ $siteSettings->meta_description }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">
    @if ($siteSettings->faviconUrl())
        <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    @endif

    <!-- CSS
================================================== -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/colors/blue.css') }}">

</head>

<body class="gray">

    @php
        $currentUser = auth()->user();
        $userRoles = ($currentUser && method_exists($currentUser, 'roles')) ? $currentUser->roles : collect();
        $isFreelancer = $userRoles->contains('name', 'freelancer');
        $isClient = $userRoles->contains('name', 'client');
        $dashboardRoute = $isFreelancer ? route('freelancer.profile.edit') : route('client.projects.index');
    @endphp

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Header Container
================================================== -->
        <x-front-header />

        <div class="clearfix"></div>
        <!-- Header Container / End -->


        <!-- Dashboard Container -->
        <div class="dashboard-container">

            <!-- Dashboard Sidebar
 ================================================== -->
            <div class="dashboard-sidebar">
                <div class="dashboard-sidebar-inner" data-simplebar>
                    <div class="dashboard-nav-container">

                        <!-- Responsive Navigation Trigger -->
                        <a href="#" class="dashboard-responsive-nav-trigger">
                            <span class="hamburger hamburger--collapse">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </span>
                            <span class="trigger-title">Dashboard Navigation</span>
                        </a>

                        <!-- Navigation -->
                        <div class="dashboard-nav">
                            <div class="dashboard-nav-inner">

                                <ul data-submenu-title="Start">
                                    <li><a href="{{ $dashboardRoute }}"><i class="icon-material-outline-dashboard"></i>
                                            Dashboard</a></li>
                                    <li><a href="{{ route('messages') }}"><i
                                                class="icon-material-outline-question-answer"></i> Messages <span
                                                class="nav-tag">Live</span></a></li>
                                    <li><a href="{{ route('projects.browse') }}"><i class="icon-material-outline-star-border"></i>
                                            Browse Projects</a></li>
                                    @if ($isFreelancer)
                                        <li><a href="{{ route('freelancer.proposals.index') }}"><i class="icon-material-outline-rate-review"></i> My Proposals</a>
                                        </li>
                                    @endif
                                </ul>

                                <ul data-submenu-title="Organize and Manage">
                                    @if ($isClient)
                                        <li><a href="{{ route('client.projects.index') }}"><i class="icon-material-outline-business-center"></i>
                                                Jobs</a>
                                            <ul>
                                                <li><a href="{{ route('client.projects.index') }}">Manage Jobs</a></li>
                                                <li><a href="{{ route('projects.browse') }}">Browse Public Jobs</a></li>
                                                <li><a href="{{ route('client.projects.create') }}">Post a Job</a></li>
                                            </ul>
                                        </li>
                                    @endif
                                    @if ($isFreelancer)
                                        <li><a href="{{ route('freelancer.proposals.index') }}"><i class="icon-material-outline-assignment"></i> Freelancer</a>
                                            <ul>
                                                <li><a href="{{ route('freelancer.proposals.index') }}">My Active Bids</a></li>
                                                <li><a href="{{ route('freelancer.profile.edit') }}">Profile Settings</a></li>
                                                <li><a href="{{ route('messages') }}">Conversations</a></li>
                                            </ul>
                                        </li>
                                    @endif
                                </ul>

                                <ul data-submenu-title="Account">
                                    @if ($isFreelancer)
                                        <li class="active"><a href="{{ route('freelancer.profile.edit') }}"><i class="icon-material-outline-settings"></i>
                                                Settings</a></li>
                                    @endif
                                    <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout').submit();"><i
                                                class="icon-material-outline-power-settings-new"></i> Logout</a>
                                    </li>
                                </ul>
                                <form action="{{ route('logout') }}" method="post" style="display: none;"
                                    id="logout">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- Navigation / End -->

                    </div>
                </div>
            </div>
            <!-- Dashboard Sidebar / End -->


            <!-- Dashboard Content
 ================================================== -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner">

                    <!-- Dashboard Headline -->
                    <div class="dashboard-headline">
                        <h3>{{ $title ?? 'Dashboard' }}</h3>

                        <!-- Breadcrumbs -->
                        <nav id="breadcrumbs" class="dark">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ $dashboardRoute }}">Dashboard</a></li>
                                <li>{{ $title ?? 'Dashboard' }}</li>
                            </ul>
                        </nav>
                    </div>

                    {{ $slot }}

                    <!-- Footer -->
                    <div class="dashboard-footer-spacer"></div>
                    <div class="small-footer margin-top-15">
                        <div class="small-footer-copyrights">
                            &copy; {{ now()->year }} <strong>{{ $siteSettings->site_name }}</strong>. {{ $siteSettings->copyright_text ?: 'All Rights Reserved.' }}
                        </div>
                        <div class="dashboard-surface-muted" style="margin-top: 8px;">
                            {{ $siteSettings->contact_email }} @if($siteSettings->contact_phone) | {{ $siteSettings->contact_phone }} @endif
                        </div>
                        <ul class="footer-social-links">
                            <li>
                                <a href="#" title="Facebook" data-tippy-placement="top">
                                    <i class="icon-brand-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Twitter" data-tippy-placement="top">
                                    <i class="icon-brand-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Google Plus" data-tippy-placement="top">
                                    <i class="icon-brand-google-plus-g"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="LinkedIn" data-tippy-placement="top">
                                    <i class="icon-brand-linkedin-in"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Footer / End -->

                </div>
            </div>
            <!-- Dashboard Content / End -->

        </div>
        <!-- Dashboard Container / End -->

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

    <!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
    <script src="{{ asset('assets/front/js/chart.min.js') }}"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        var ctx = document.getElementById('chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: ["January", "February", "March", "April", "May", "June"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: 'rgba(42,65,232,0.08)',
                    borderColor: '#2a41e8',
                    borderWidth: "3",
                    data: [196, 132, 215, 362, 210, 252],
                    pointRadius: 5,
                    pointHoverRadius: 5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {

                layout: {
                    padding: 10,
                },

                legend: {
                    display: false
                },
                title: {
                    display: false
                },

                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            borderDash: [6, 10],
                            color: "#d8d8d8",
                            lineWidth: 1,
                        },
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            display: false
                        },
                    }],
                },

                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },


        });
    </script>


    <!-- Google Autocomplete -->
    <script>
        function initAutocomplete() {
            var options = {
                types: ['(cities)'],
                // componentRestrictions: {country: "us"}
            };

            var input = document.getElementById('autocomplete-input');
            var autocomplete = new google.maps.places.Autocomplete(input, options);

            if ($('.submit-field')[0]) {
                setTimeout(function() {
                    $(".pac-container").prependTo("#autocomplete-container");
                }, 300);
            }
        }
    </script>

    <!-- Google API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initAutocomplete"></script>


</body>

</html>
