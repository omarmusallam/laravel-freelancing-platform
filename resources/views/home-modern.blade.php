<x-front-layout title="Home Page">
    @php
        $topCategories = $categories->take(8);
        $primaryCategories = $categories->whereNull('parent_id')->take(6);
    @endphp

    <style>
        .hero-shell {
            position: relative;
            overflow: hidden;
            padding: 5.5rem 0 4.5rem;
            background:
                radial-gradient(circle at top left, rgba(217, 119, 6, 0.22), transparent 34%),
                radial-gradient(circle at bottom right, rgba(15, 118, 110, 0.18), transparent 30%),
                linear-gradient(135deg, #fffdf6 0%, #fff7ed 42%, #f5f7ff 100%);
        }

        .hero-shell::after {
            content: '';
            position: absolute;
            inset: auto -6% -90px auto;
            width: 280px;
            height: 280px;
            border-radius: 36px;
            transform: rotate(18deg);
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.09), rgba(217, 119, 6, 0.12));
            filter: blur(2px);
        }

        .hero-shell .container {
            position: relative;
            z-index: 1;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.5rem 0.95rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.76);
            color: #9a3412;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .hero-card,
        .surface-card {
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.84);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.09);
        }

        .hero-card {
            padding: 1.5rem;
        }

        .surface-card {
            padding: 1.35rem;
            height: 100%;
        }

        .hero-metric {
            border-radius: 22px;
            padding: 1.1rem 1.15rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.94));
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.75);
        }

        .hero-metric strong {
            display: block;
            font-size: 1.9rem;
            line-height: 1;
            color: #0f172a;
            margin-bottom: 0.45rem;
        }

        .category-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.5rem 0.9rem;
            border: 1px solid rgba(249, 115, 22, 0.18);
            background: rgba(255, 247, 237, 0.96);
            color: #9a3412;
            font-weight: 600;
            margin: 0 0.5rem 0.5rem 0;
        }

        .category-card {
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            inset: -35% auto auto 60%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(249, 115, 22, 0.09);
        }

        .category-card h3,
        .expert-card h3 {
            color: #0f172a;
            font-weight: 700;
        }

        .featured-band {
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
        }

        .process-step {
            position: relative;
            padding-left: 4.4rem;
        }

        .step-badge {
            position: absolute;
            left: 0;
            top: 0;
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #ea580c, #0f766e);
            box-shadow: 0 18px 34px rgba(15, 118, 110, 0.18);
        }

        .section-note {
            max-width: 560px;
            color: #64748b;
        }

        .expert-avatar {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #0f766e, #f97316);
            box-shadow: 0 18px 34px rgba(15, 118, 110, 0.16);
        }
    </style>

    <section class="hero-shell">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="hero-kicker">
                        <i class="icon-material-outline-star-outline"></i>
                        Curated freelance marketplace
                    </span>

                    <h1 class="mt-4 mb-3" style="font-size: clamp(2.6rem, 6vw, 4.6rem); line-height: 1.02; color: #0f172a; letter-spacing: -0.04em; max-width: 820px;">
                        Move from project brief to trusted delivery with a marketplace that feels polished and credible.
                    </h1>

                    <p class="mb-4" style="max-width: 720px; font-size: 1.08rem; line-height: 1.9; color: #475569;">
                        {{ $siteSettings->site_tagline ?? 'A refined freelance platform for clients who want faster hiring, stronger project visibility, and professional execution from discovery to delivery.' }}
                    </p>

                    <div class="hero-card">
                        <form action="{{ route('projects.browse') }}" method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-6">
                                    <label class="form-label" for="home-search-query">What do you need done?</label>
                                    <input
                                        id="home-search-query"
                                        type="text"
                                        class="with-border"
                                        name="q"
                                        placeholder="Search projects, services, or specialist skills">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="home-search-category">Category</label>
                                    <select id="home-search-category" class="selectpicker with-border" data-size="7" title="All categories" name="category">
                                        <option value="">All categories</option>
                                        @foreach ($topCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <button class="button ripple-effect big-button" style="width: 100%; background: linear-gradient(135deg, #ea580c, #0f766e);" type="submit">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-4">
                            @foreach ($primaryCategories as $category)
                                <a class="category-chip" href="{{ route('projects.browse', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-sm-6 col-lg-3">
                            <div class="hero-metric">
                                <strong>{{ number_format($stats['projects']) }}</strong>
                                <span>Published projects</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="hero-metric">
                                <strong>{{ number_format($stats['open_projects']) }}</strong>
                                <span>Open opportunities</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="hero-metric">
                                <strong>{{ number_format($stats['freelancers']) }}</strong>
                                <span>Active freelancers</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="hero-metric">
                                <strong>{{ number_format($stats['completed_contracts']) }}</strong>
                                <span>Completed contracts</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="surface-card">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <span class="hero-kicker" style="background: rgba(249, 115, 22, 0.1); box-shadow: none;">Weekly momentum</span>
                                <h2 class="mt-3 mb-2" style="font-size: 1.8rem;">High-trust delivery starts with the right structure.</h2>
                            </div>
                        </div>

                        <div class="dashboard-box-list">
                            @foreach ($recent_projects->take(3) as $project)
                                <div class="notice small mb-3" style="background: #fff7ed; border-left: 4px solid #f97316;">
                                    <strong style="display: block; color: #0f172a;">{{ $project->title }}</strong>
                                    <span style="display: block; margin-top: 0.4rem;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($project->desc), 88) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-6">
                                <div class="hero-metric">
                                    <strong>{{ number_format($stats['clients']) }}</strong>
                                    <span>Clients building today</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="hero-metric">
                                    <strong>{{ number_format($stats['categories']) }}</strong>
                                    <span>Focused categories</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('projects.browse') }}" class="button ripple-effect margin-top-20" style="width: 100%; background: #0f172a;">
                            Browse Live Projects
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section gray padding-top-90 padding-bottom-70">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="hero-kicker">Explore sectors</span>
                    <h2 class="mt-3 mb-3">Explore High-Intent Categories</h2>
                    <p class="section-note">
                        Structured categories make the platform easier to browse, easier to trust, and faster to convert from discovery into real work.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('projects.browse') }}" class="button">View all project opportunities</a>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($topCategories as $category)
                    <div class="col-md-6 col-xl-3">
                        <a href="{{ route('projects.browse', ['category' => $category->id]) }}" class="surface-card category-card d-block">
                            <span class="icon-line-awesome-folder-open-o" style="font-size: 2rem; color: #ea580c;"></span>
                            <h3 class="mt-4 mb-2">{{ $category->name }}</h3>
                            <p class="mb-3" style="color: #64748b;">
                                {{ $category->parent ? 'Specialized subcategory inside ' . $category->parent->name : 'Primary category for high-value freelance work.' }}
                            </p>
                            <span style="font-weight: 700; color: #0f766e;">Browse projects</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section padding-top-90 padding-bottom-60 featured-band">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="hero-kicker">Recent demand</span>
                    <h2 class="mt-3 mb-3">Fresh Projects That Make The Marketplace Feel Alive</h2>
                    <p class="section-note">
                        A strong homepage should not just look good. It should immediately prove that real clients are posting work and specialists have meaningful opportunities to pursue.
                    </p>
                </div>
            </div>

            <div class="listings-container compact-list-layout margin-top-35">
                @foreach ($recent_projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="task-listing">
                        <div class="task-listing-details">
                            <div class="task-listing-description">
                                <h3 class="task-listing-title">{{ $project->title }}</h3>
                                <ul class="task-icons">
                                    <li><i class="icon-material-outline-account-circle"></i> {{ $project->user?->name ?? 'Platform Client' }}</li>
                                    @if ($project->category)
                                        <li><i class="icon-material-outline-business-center"></i> {{ $project->category->name }}</li>
                                    @endif
                                    <li><i class="icon-material-outline-date-range"></i> {{ optional($project->created_at)->diffForHumans() }}</li>
                                </ul>
                                <p class="mb-0" style="color: #64748b;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($project->desc), 160) }}
                                </p>
                            </div>
                        </div>
                        <div class="task-listing-bid">
                            <div class="task-listing-bid-inner">
                                <div class="task-offers">
                                    <strong>${{ number_format((float) $project->budget, 0) }}</strong>
                                    <span>{{ ucfirst($project->type) }}</span>
                                </div>
                                <span class="button button-sliding-icon ripple-effect">View Project <i class="icon-material-outline-arrow-right-alt"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section gray padding-top-90 padding-bottom-70">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="hero-kicker">Platform flow</span>
                    <h2 class="mt-3 mb-3">How Top Clients Move Through The Platform</h2>
                    <p class="section-note">
                        We are shaping the platform around clarity and trust: discover talent quickly, compare proposals with confidence, and keep delivery visible from day one.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="surface-card process-step">
                        <span class="step-badge">01</span>
                        <h3>Publish a polished brief</h3>
                        <p class="mb-0" style="color: #64748b;">
                            Clients describe the work, set expectations, and publish into clear categories that attract the right specialists faster.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="surface-card process-step">
                        <span class="step-badge">02</span>
                        <h3>Evaluate meaningful proposals</h3>
                        <p class="mb-0" style="color: #64748b;">
                            Freelancers present relevant bids, timelines, and positioning so decision-making becomes focused instead of noisy.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="surface-card process-step">
                        <span class="step-badge">03</span>
                        <h3>Deliver with structure</h3>
                        <p class="mb-0" style="color: #64748b;">
                            Contracts, payments, and communication stay organized so the relationship can scale from one job to long-term collaboration.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section padding-top-90 padding-bottom-90">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="hero-kicker">Talent signal</span>
                    <h2 class="mt-3 mb-3">Featured Talent Snapshot</h2>
                    <p class="section-note">
                        A credible freelance marketplace needs a visible layer of professional talent. These highlighted profiles help the platform look active, selective, and trustworthy.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($featuredFreelancers as $freelancer)
                    <div class="col-md-6 col-xl-4">
                        <div class="surface-card expert-card">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <span class="expert-avatar">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($freelancer->first_name ?: $freelancer->user?->name ?: 'F', 0, 1)) }}
                                </span>
                                <div>
                                    <h3 class="mb-1">
                                        {{ trim(($freelancer->first_name ?? '') . ' ' . ($freelancer->last_name ?? '')) ?: ($freelancer->user?->name ?? 'Freelancer') }}
                                    </h3>
                                    <span style="color: #0f766e; font-weight: 700;">
                                        {{ $freelancer->title ?: 'Independent specialist' }}
                                    </span>
                                </div>
                            </div>

                            <p style="color: #64748b; min-height: 72px;">
                                {{ \Illuminate\Support\Str::limit(strip_tags($freelancer->desc), 120) ?: 'Experienced freelancer with a profile optimized for strong client confidence and clear positioning.' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <span style="display: block; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: #94a3b8;">Starting rate</span>
                                    <strong style="font-size: 1.3rem; color: #0f172a;">${{ number_format((float) ($freelancer->hourly_rate ?? 0), 0) }}/hr</strong>
                                </div>
                                <a href="{{ route('projects.browse', ['q' => $freelancer->title]) }}" class="button ripple-effect">Match Projects</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-front-layout>
