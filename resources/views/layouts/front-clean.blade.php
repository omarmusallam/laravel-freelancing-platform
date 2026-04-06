<!doctype html>
<html lang="{{ App::currentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <title>{{ trim(($title ? $title . ' | ' : '') . ($siteSettings->meta_title ?: $siteSettings->site_name)) }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{ $siteSettings->meta_description }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">
    @if ($siteSettings->faviconUrl())
        <link rel="icon" type="image/png" href="{{ $siteSettings->faviconUrl() }}">
    @endif

    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/front/css/style.rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/front/css/colors/blue.css') }}">
    <style>
        :root {
            --front-ink: #0f172a;
            --front-muted: #64748b;
            --front-line: rgba(148, 163, 184, 0.18);
            --front-soft: #f8fafc;
            --front-accent: #f97316;
            --front-accent-2: #2563eb;
            --front-dark: #0f172a;
            --front-radius-xl: 28px;
        }

        html,
        body.front-shell {
            margin: 0;
            padding: 0;
        }

        body.front-shell {
            background: #ffffff;
            color: var(--front-ink);
        }

        body.front-shell #wrapper {
            background: transparent;
            margin: 0;
            padding-top: 0 !important;
        }

        body.front-shell .clearfix {
            display: none;
        }

        body.front-shell .container {
            width: min(1240px, calc(100% - 32px));
        }

        body.front-shell .button {
            border-radius: 14px;
            font-weight: 700;
        }

        .front-footer {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #111827 0%, #0f172a 100%);
            color: #fff;
        }

        .front-footer::before {
            content: '';
            position: absolute;
            inset: -30% auto auto -6%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(249, 115, 22, 0.08);
            filter: blur(24px);
        }

        .front-footer .footer-top-section,
        .front-footer .footer-middle-section,
        .front-footer .footer-bottom-section {
            position: relative;
            border-color: rgba(255, 255, 255, 0.08);
        }

        .front-footer .footer-top-section {
            padding-top: 18px;
        }

        .front-footer .footer-logo-wrap {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .front-footer .footer-logo-wrap img {
            max-height: 40px;
            width: auto;
        }

        .front-footer .footer-brand-copy strong {
            display: block;
            margin-bottom: 4px;
            font-size: 1.05rem;
        }

        .front-footer .footer-brand-copy span,
        .front-footer .footer-links ul li a,
        .front-footer .footer-contact-item,
        .front-footer .footer-note {
            color: rgba(255, 255, 255, 0.72);
        }

        .front-footer .footer-links h3,
        .front-footer .footer-news-title {
            color: #ffffff;
        }

        .front-footer .footer-contact-list {
            display: grid;
            gap: 10px;
            margin-top: 18px;
        }

        .front-footer .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .front-footer .newsletter input {
            border-radius: 14px 0 0 14px;
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .front-footer .newsletter button {
            border-radius: 0 14px 14px 0;
            background: linear-gradient(135deg, var(--front-accent), var(--front-accent-2));
        }

        @media (max-width: 767px) {
            body.front-shell .container {
                width: min(100% - 24px, 1240px);
            }
        }
    </style>
</head>

<body class="front-shell">
    @php
        $currentUser = auth()->user();
        $userRoles = ($currentUser && method_exists($currentUser, 'roles')) ? $currentUser->roles : collect();
        $isFreelancer = $userRoles->contains('name', 'freelancer');
        $isClient = $userRoles->contains('name', 'client');
    @endphp
    <div id="wrapper">
        <x-front-header />
        <div class="clearfix"></div>

        {{ $slot }}

        <div id="footer" class="front-footer">
            <div class="footer-top-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="footer-rows-container">
                                <div class="footer-rows-left">
                                    <div class="footer-row">
                                        <div class="footer-row-inner footer-logo">
                                            <div class="footer-logo-wrap">
                                                <img src="{{ $siteSettings->footerLogoUrl() }}" alt="{{ $siteSettings->site_name }}">
                                                <div class="footer-brand-copy">
                                                    <strong>{{ $siteSettings->site_name }}</strong>
                                                    <span>{{ $siteSettings->site_tagline }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="footer-rows-right">
                                    <div class="footer-row">
                                        <div class="footer-row-inner">
                                            <ul class="footer-social-links">
                                                <li><a href="{{ $siteSettings->facebook_url ?: route('home') }}" title="Facebook" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-facebook-f"></i></a></li>
                                                <li><a href="{{ $siteSettings->twitter_url ?: route('projects.browse') }}" title="Twitter" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-twitter"></i></a></li>
                                                <li><a href="{{ $siteSettings->instagram_url ?: (auth()->check() ? route('client.projects.create') : route('register')) }}" title="Instagram" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-google-plus-g"></i></a></li>
                                                <li><a href="{{ $siteSettings->linkedin_url ?: (auth()->check() ? route('messages') : route('login')) }}" title="LinkedIn" data-tippy-placement="bottom" data-tippy-theme="light"><i class="icon-brand-linkedin-in"></i></a></li>
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
                                    <li><a href="{{ $isFreelancer ? route('freelancer.profile.edit') : route('register') }}"><span>Freelancer Profile</span></a></li>
                                    <li><a href="{{ $isFreelancer ? route('freelancer.proposals.index') : route('login') }}"><span>My Proposals</span></a></li>
                                    <li><a href="{{ auth()->check() ? route('messages') : route('login') }}"><span>Messages</span></a></li>
                                </ul>
                            </div>
                        </div>

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
                                    <li><a href="{{ $isFreelancer ? route('freelancer.profile.edit') : ($isClient ? route('client.projects.index') : route('register')) }}"><span>My Account</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <h3 class="footer-news-title"><i class="icon-feather-mail"></i> Platform Contact & Updates</h3>
                            <p class="footer-note">{{ $siteSettings->meta_description ?: ($siteSettings->site_tagline ?: 'Create an account and explore the platform as a polished portfolio demo.') }}</p>
                            <form action="{{ route('register') }}" method="get" class="newsletter">
                                <input type="text" name="fname" placeholder="Create your account to explore more" readonly>
                                <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                            </form>
                            <div class="footer-contact-list">
                                <div class="footer-contact-item">
                                    <i class="icon-feather-mail"></i>
                                    <span>{{ $siteSettings->contact_email }}</span>
                                </div>
                                <div class="footer-contact-item">
                                    <i class="icon-feather-phone"></i>
                                    <span>{{ $siteSettings->contact_phone }}</span>
                                </div>
                                @if ($siteSettings->contact_whatsapp)
                                    <div class="footer-contact-item">
                                        <i class="icon-brand-whatsapp"></i>
                                        <span>{{ $siteSettings->contact_whatsapp }}</span>
                                    </div>
                                @endif
                                @if ($siteSettings->contact_address)
                                    <div class="footer-contact-item">
                                        <i class="icon-material-outline-location-on"></i>
                                        <span>{{ $siteSettings->contact_address }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-section">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            &copy; {{ now()->year }} <strong>{{ $siteSettings->site_name }}</strong>. {{ $siteSettings->copyright_text ?: 'All Rights Reserved.' }}
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
