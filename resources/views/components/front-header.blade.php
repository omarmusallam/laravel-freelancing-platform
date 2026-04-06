@php
    $currentUser = auth()->user();
    $userRoles = ($currentUser && method_exists($currentUser, 'roles')) ? $currentUser->roles : collect();
    $isFreelancer = $userRoles->contains('name', 'freelancer');
    $isClient = $userRoles->contains('name', 'client');

    $primaryLinks = [
        ['label' => __('Home'), 'url' => route('home')],
        ['label' => __('Find Work'), 'url' => route('projects.browse')],
        ['label' => __('For Employers'), 'url' => $isClient ? route('client.projects.index') : route('login')],
    ];

    if (auth()->check()) {
        $primaryLinks[] = [
            'label' => __('Dashboard'),
            'url' => $isFreelancer ? route('freelancer.profile.edit') : ($isClient ? route('client.projects.index') : route('home')),
        ];
    }
@endphp

<style>
    .frontsite-header {
        position: sticky;
        top: 0;
        z-index: 1100;
        margin-top: 0 !important;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(18px);
        border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.05);
    }

    .frontsite-header__wrap {
        width: min(1240px, calc(100% - 32px));
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        min-height: 84px;
    }

    .frontsite-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .frontsite-brand img {
        max-height: 42px;
        width: auto;
        flex-shrink: 0;
    }

    .frontsite-brand__text {
        min-width: 0;
    }

    .frontsite-brand__text strong {
        display: block;
        color: #0f172a;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.1;
    }

    .frontsite-brand__text span {
        display: block;
        margin-top: 3px;
        color: #64748b;
        font-size: 0.82rem;
        line-height: 1.35;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 360px;
    }

    .frontsite-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        justify-content: center;
    }

    .frontsite-nav a,
    .frontsite-nav details summary {
        list-style: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 16px;
        border-radius: 12px;
        color: #334155;
        font-weight: 700;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .frontsite-nav a:hover,
    .frontsite-nav details summary:hover,
    .frontsite-nav a[aria-current="page"] {
        background: rgba(37, 99, 235, 0.08);
        color: #1d4ed8;
    }

    .frontsite-nav details {
        position: relative;
    }

    .frontsite-nav details summary::-webkit-details-marker {
        display: none;
    }

    .frontsite-nav details[open] .frontsite-language {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .frontsite-language {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 180px;
        padding: 10px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
        opacity: 0;
        visibility: hidden;
        transform: translateY(6px);
        transition: all 0.2s ease;
    }

    .frontsite-language a {
        display: flex;
        justify-content: flex-start;
        width: 100%;
        min-height: 40px;
        border-radius: 10px;
    }

    .frontsite-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .frontsite-contact {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 48px;
        padding: 0 16px;
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.14);
        background: rgba(248, 250, 252, 0.9);
    }

    .frontsite-contact i {
        color: #f97316;
        font-size: 1.1rem;
    }

    .frontsite-contact span {
        display: block;
        color: #94a3b8;
        font-size: 0.72rem;
        line-height: 1.1;
    }

    .frontsite-contact strong {
        display: block;
        color: #0f172a;
        font-size: 0.92rem;
        line-height: 1.1;
        font-weight: 800;
    }

    .frontsite-auth {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 18px;
        border-radius: 14px;
        font-weight: 800;
        color: #fff !important;
        background: linear-gradient(135deg, #f97316, #2563eb);
        box-shadow: 0 16px 28px rgba(37, 99, 235, 0.2);
    }

    .frontsite-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 8px 6px 6px;
        border-radius: 16px;
        border: 1px solid rgba(148, 163, 184, 0.14);
        background: #fff;
    }

    .frontsite-user img {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        object-fit: cover;
    }

    .frontsite-user strong {
        display: block;
        color: #0f172a;
        font-size: 0.9rem;
        line-height: 1.15;
    }

    .frontsite-user span {
        display: block;
        color: #64748b;
        font-size: 0.78rem;
    }

    .frontsite-mobile-toggle {
        display: none;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: #fff;
        color: #0f172a;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .frontsite-mobile-menu {
        display: none;
        width: min(1240px, calc(100% - 32px));
        margin: 0 auto;
        padding: 0 0 16px;
    }

    .frontsite-mobile-menu nav {
        display: grid;
        gap: 8px;
        padding: 14px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
    }

    .frontsite-mobile-menu a {
        display: flex;
        min-height: 44px;
        align-items: center;
        padding: 0 12px;
        border-radius: 12px;
        color: #334155;
        font-weight: 700;
    }

    @media (max-width: 1100px) {
        .frontsite-nav,
        .frontsite-contact {
            display: none;
        }

        .frontsite-mobile-toggle {
            display: inline-flex;
        }
    }

    @media (max-width: 767px) {
        .frontsite-header__wrap,
        .frontsite-mobile-menu {
            width: min(100% - 24px, 1240px);
        }

        .frontsite-brand__text span {
            max-width: 180px;
        }
    }
</style>

<header class="frontsite-header">
    <div class="frontsite-header__wrap">
        <a href="{{ route('home') }}" class="frontsite-brand">
            <img src="{{ $siteSettings->logoUrl() }}" alt="{{ $siteSettings->site_name }}">
            <div class="frontsite-brand__text">
                <strong>{{ $siteSettings->site_name }}</strong>
                <span>{{ $siteSettings->site_tagline }}</span>
            </div>
        </a>

        <nav class="frontsite-nav" aria-label="Primary">
            @foreach ($primaryLinks as $link)
                <a href="{{ $link['url'] }}" @if (url()->current() === $link['url']) aria-current="page" @endif>
                    {{ $link['label'] }}
                </a>
            @endforeach

            <details>
                <summary>{{ __('Language') }}</summary>
                <div class="frontsite-language">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </details>
        </nav>

        <div class="frontsite-actions">
            <div class="frontsite-contact">
                <i class="icon-feather-phone-call"></i>
                <div>
                    <span>Direct contact</span>
                    <strong>{{ $siteSettings->contact_phone }}</strong>
                </div>
            </div>

            @auth
                <a href="{{ $isFreelancer ? route('freelancer.profile.edit') : ($isClient ? route('client.projects.index') : route('home')) }}"
                    class="frontsite-user">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>{{ $isFreelancer ? __('Freelancer') : __('Client') }}</span>
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}" class="frontsite-auth">{{ __('Login') }}</a>
            @endauth

            <button type="button" class="frontsite-mobile-toggle" data-frontsite-toggle aria-label="Open menu">
                <i class="icon-feather-menu"></i>
            </button>
        </div>
    </div>

    <div class="frontsite-mobile-menu" data-frontsite-menu hidden>
        <nav>
            @foreach ($primaryLinks as $link)
                <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
            @endforeach

            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ __('Language') }}: {{ $properties['native'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('[data-frontsite-toggle]');
        const menu = document.querySelector('[data-frontsite-menu]');

        if (!toggle || !menu) {
            return;
        }

        toggle.addEventListener('click', function() {
            const isHidden = menu.hasAttribute('hidden');
            if (isHidden) {
                menu.removeAttribute('hidden');
            } else {
                menu.setAttribute('hidden', 'hidden');
            }
        });
    });
</script>
