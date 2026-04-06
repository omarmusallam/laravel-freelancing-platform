<x-front-layout title="Home Page">
    @php
        $topCategories = $categories->take(8);
        $primaryCategories = $categories->whereNull('parent_id')->take(6);
        $currentUser = auth()->user();
        $userRoles = ($currentUser && method_exists($currentUser, 'roles')) ? $currentUser->roles : collect();
        $isFreelancer = $userRoles->contains('name', 'freelancer');
        $isClient = $userRoles->contains('name', 'client');
        $projectBrowseUrl = route('projects.browse');
        $dashboardUrl = auth()->check()
            ? ($isFreelancer
                ? route('freelancer.profile.edit')
                : ($isClient ? route('client.projects.index') : route('home')))
            : route('register');
    @endphp

    <style>
        .landing-shell {
            background:
                radial-gradient(circle at top left, rgba(249, 115, 22, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.12), transparent 26%),
                linear-gradient(180deg, #fffaf5 0%, #ffffff 34%, #f7fafc 100%);
        }

        .landing-container {
            width: min(1240px, calc(100% - 32px));
            margin: 0 auto;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(15, 23, 42, 0.08);
            color: #c2410c;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.08);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .hero-stage {
            position: relative;
            overflow: hidden;
            padding: 72px 0 54px;
        }

        .hero-stage::before {
            content: '';
            position: absolute;
            inset: 22px auto auto -90px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(249, 115, 22, 0.12);
            filter: blur(16px);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr);
            gap: 28px;
            align-items: stretch;
        }

        .hero-copy h1 {
            margin: 22px 0 18px;
            font-size: clamp(2.6rem, 4.4vw, 5rem);
            line-height: 0.96;
            letter-spacing: -0.05em;
            color: #0f172a;
            max-width: 720px;
        }

        .hero-copy p {
            max-width: 680px;
            margin: 0 0 22px;
            color: #475569;
            font-size: 1.06rem;
            line-height: 1.9;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .hero-actions .button {
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 24px;
            border-radius: 16px;
            font-weight: 700;
        }

        .button-soft {
            background: rgba(15, 23, 42, 0.06);
            color: #0f172a;
        }

        .surface-panel {
            position: relative;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.1);
        }

        .hero-form-panel {
            padding: 22px;
        }

        .hero-form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(220px, 0.8fr) 160px;
            gap: 14px;
            align-items: end;
        }

        .hero-form-panel label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .hero-form-panel input.with-border,
        .hero-form-panel .bootstrap-select>.dropdown-toggle {
            height: 56px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.32);
            box-shadow: none;
            background: #ffffff;
            padding-inline: 18px;
        }

        .hero-form-panel .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
            color: #475569;
            font-weight: 600;
            line-height: 54px;
        }

        .hero-form-panel .bootstrap-select {
            width: 100% !important;
        }

        .hero-form-panel .bootstrap-select>.dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-form-panel .bootstrap-select>.dropdown-toggle::after {
            margin-left: 12px;
            color: #64748b;
        }

        .hero-form-panel .bootstrap-select .dropdown-menu {
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
            padding: 8px;
        }

        .hero-form-panel .bootstrap-select .dropdown-menu li a {
            border-radius: 12px;
            min-height: 42px;
            display: flex;
            align-items: center;
            color: #334155;
            font-weight: 600;
        }

        .hero-form-panel .bootstrap-select .dropdown-menu li.selected a,
        .hero-form-panel .bootstrap-select .dropdown-menu li a:hover {
            background: rgba(37, 99, 235, 0.08);
            color: #1d4ed8;
        }

        .hero-chip-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            padding: 0.7rem 1rem;
            border-radius: 999px;
            background: #fff7ed;
            border: 1px solid rgba(249, 115, 22, 0.16);
            color: #9a3412;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .hero-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .metric-card {
            padding: 18px 16px;
            border-radius: 22px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.06);
        }

        .metric-card strong {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 1.9rem;
            line-height: 1;
        }

        .metric-card span {
            color: #64748b;
            font-size: 0.92rem;
        }

        .trust-panel {
            padding: 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 18px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.94)),
                linear-gradient(135deg, rgba(249, 115, 22, 0.08), rgba(37, 99, 235, 0.06));
        }

        .trust-panel h2 {
            margin: 0;
            color: #0f172a;
            font-size: 1.8rem;
            line-height: 1.15;
        }

        .trust-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .trust-card {
            padding: 16px;
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.95);
        }

        .trust-card strong {
            display: block;
            color: #0f172a;
            font-size: 1.5rem;
            margin-bottom: 6px;
        }

        .signal-list {
            display: grid;
            gap: 12px;
        }

        .signal-item {
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(255, 247, 237, 0.78);
            border: 1px solid rgba(249, 115, 22, 0.12);
        }

        .signal-item strong {
            display: block;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .signal-item span {
            color: #64748b;
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .contact-rail {
            display: grid;
            gap: 10px;
        }

        .contact-rail a,
        .contact-rail div {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #334155;
            font-weight: 600;
        }

        .section-shell {
            padding: 78px 0;
        }

        .section-shell.is-alt {
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.86) 0%, rgba(255, 255, 255, 0.98) 100%);
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            margin-bottom: 30px;
        }

        .section-head h2 {
            margin: 16px 0 10px;
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1;
            color: #0f172a;
            letter-spacing: -0.04em;
        }

        .section-head p {
            margin: 0;
            max-width: 640px;
            color: #64748b;
            line-height: 1.8;
        }

        .category-grid,
        .freelancer-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .category-box,
        .freelancer-box,
        .flow-box,
        .project-card {
            display: block;
            height: 100%;
            padding: 24px;
            border-radius: 26px;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 20px 42px rgba(15, 23, 42, 0.07);
        }

        .category-box:hover,
        .freelancer-box:hover,
        .project-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 55px rgba(148, 163, 184, 0.18);
            border-color: rgba(15, 118, 110, 0.22);
            background: linear-gradient(180deg, #fffdf8 0%, #f8fffd 100%);
        }

        .category-box,
        .freelancer-box,
        .project-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .category-icon,
        .freelancer-avatar,
        .flow-badge {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f97316, #2563eb);
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.18);
        }

        .category-box h3,
        .freelancer-box h3,
        .flow-box h3,
        .project-card h3 {
            margin: 16px 0 10px;
            color: #0f172a;
            font-size: 1.22rem;
            line-height: 1.2;
        }

        .category-box p,
        .freelancer-box p,
        .flow-box p,
        .project-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.8;
        }

        .category-meta {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #0f766e;
            font-weight: 700;
        }

        .project-grid {
            display: grid;
            gap: 16px;
        }

        .project-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 190px;
            gap: 18px;
            align-items: center;
        }

        .project-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 12px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .project-side {
            display: grid;
            gap: 10px;
            justify-items: start;
            padding-left: 16px;
            border-left: 1px solid rgba(226, 232, 240, 0.9);
        }

        .project-price {
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 800;
        }

        .project-type {
            display: inline-flex;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.08);
            color: #1d4ed8;
            font-weight: 700;
        }

        .flow-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .flow-box {
            position: relative;
            padding-top: 78px;
        }

        .flow-badge {
            position: absolute;
            top: 22px;
            left: 22px;
            font-size: 1rem;
            font-weight: 800;
        }

        .freelancer-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .freelancer-avatar {
            font-weight: 800;
            font-size: 1.1rem;
        }

        .freelancer-role {
            display: inline-block;
            color: #0f766e;
            font-weight: 700;
            margin-top: 4px;
        }

        .freelancer-footer {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 14px;
            margin-top: 18px;
        }

        .freelancer-rate-label {
            display: block;
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .freelancer-rate {
            color: #0f172a;
            font-size: 1.32rem;
            font-weight: 800;
        }

        .settings-band {
            padding: 26px 30px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 70%, #0f766e 100%);
            color: #ffffff;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.18);
        }

        .settings-band-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) repeat(3, minmax(0, 0.6fr));
            gap: 18px;
            align-items: center;
        }

        .settings-band strong {
            display: block;
            margin-bottom: 6px;
            font-size: 1.08rem;
        }

        .settings-band span,
        .settings-band a {
            color: rgba(255, 255, 255, 0.82);
        }

        @media (max-width: 1199px) {
            .hero-grid,
            .settings-band-grid {
                grid-template-columns: 1fr;
            }

            .category-grid,
            .freelancer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991px) {
            .hero-form-grid,
            .flow-grid,
            .project-card {
                grid-template-columns: 1fr;
            }

            .hero-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .project-side {
                border-left: 0;
                padding-left: 0;
                padding-top: 6px;
                border-top: 1px solid rgba(226, 232, 240, 0.9);
            }

            .section-head {
                align-items: start;
                flex-direction: column;
            }
        }

        @media (max-width: 767px) {
            .landing-container {
                width: min(100% - 24px, 1240px);
            }

            .hero-stage {
                padding: 48px 0 36px;
            }

            .hero-metrics,
            .trust-meta,
            .category-grid,
            .freelancer-grid {
                grid-template-columns: 1fr;
            }

            .hero-copy h1,
            .section-head h2 {
                letter-spacing: -0.03em;
            }
        }
    </style>

    <div class="landing-shell">
        <section class="hero-stage">
            <div class="landing-container">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <span class="eyebrow">
                            <i class="icon-material-outline-verified-user"></i>
                            {{ $siteSettings->site_name }}
                        </span>

                        <h1>{{ $siteSettings->meta_title ?: 'A world-class freelance marketplace built for trust, speed, and polished delivery.' }}</h1>

                        <p>
                            {{ $siteSettings->meta_description ?: ($siteSettings->site_tagline ?: 'Professional freelance marketplace for serious clients and top talent.') }}
                        </p>

                        <div class="hero-actions">
                            <a href="{{ $projectBrowseUrl }}" class="button ripple-effect" style="background: linear-gradient(135deg, #f97316, #2563eb);">Browse Projects</a>
                            <a href="{{ $dashboardUrl }}" class="button button-soft">Open Workspace</a>
                        </div>

                        <div class="surface-panel hero-form-panel">
                            <form action="{{ route('projects.browse') }}" method="GET">
                                <div class="hero-form-grid">
                                    <div>
                                        <label for="home-search-query">What do you need done?</label>
                                        <input id="home-search-query" type="text" class="with-border" name="q"
                                            placeholder="Search by project, skill, service, or specialist title">
                                    </div>
                                    <div>
                                        <label for="home-search-category">Category</label>
                                        <select id="home-search-category" class="selectpicker with-border" data-size="8"
                                            title="All categories" name="category">
                                            <option value="">All categories</option>
                                            @foreach ($topCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <button class="button ripple-effect" type="submit"
                                            style="width: 100%; height: 56px; border-radius: 16px; background: #0f172a;">
                                            Search Now
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="hero-chip-list">
                                @foreach ($primaryCategories as $category)
                                    <a class="hero-chip" href="{{ route('projects.browse', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="hero-metrics">
                            <div class="metric-card">
                                <strong>{{ number_format($stats['projects']) }}</strong>
                                <span>Published projects</span>
                            </div>
                            <div class="metric-card">
                                <strong>{{ number_format($stats['open_projects']) }}</strong>
                                <span>Open opportunities</span>
                            </div>
                            <div class="metric-card">
                                <strong>{{ number_format($stats['freelancers']) }}</strong>
                                <span>Verified freelancers</span>
                            </div>
                            <div class="metric-card">
                                <strong>{{ number_format($stats['completed_contracts']) }}</strong>
                                <span>Completed contracts</span>
                            </div>
                        </div>
                    </div>

                    <div class="surface-panel trust-panel">
                        <span class="eyebrow" style="width: fit-content;">Live marketplace signal</span>

                        <h2>{{ $siteSettings->site_tagline ?: 'Professional freelance marketplace for serious clients and top talent.' }}</h2>

                        <div class="signal-list">
                            @foreach ($recent_projects->take(3) as $project)
                                <div class="signal-item">
                                    <strong>{{ $project->title }}</strong>
                                    <span>{{ \Illuminate\Support\Str::limit(strip_tags($project->desc), 120) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="trust-meta">
                            <div class="trust-card">
                                <strong>{{ number_format($stats['clients']) }}</strong>
                                <span>Clients building today</span>
                            </div>
                            <div class="trust-card">
                                <strong>{{ number_format($stats['categories']) }}</strong>
                                <span>Structured categories</span>
                            </div>
                        </div>

                        <div class="contact-rail">
                            <a href="mailto:{{ $siteSettings->contact_email }}">
                                <i class="icon-feather-mail"></i>
                                {{ $siteSettings->contact_email }}
                            </a>
                            <div>
                                <i class="icon-feather-phone"></i>
                                {{ $siteSettings->contact_phone }}
                            </div>
                            @if ($siteSettings->contact_whatsapp)
                                <div>
                                    <i class="icon-brand-whatsapp"></i>
                                    {{ $siteSettings->contact_whatsapp }}
                                </div>
                            @endif
                            @if ($siteSettings->contact_address)
                                <div>
                                    <i class="icon-material-outline-location-on"></i>
                                    {{ $siteSettings->contact_address }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell is-alt">
            <div class="landing-container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Explore sectors</span>
                        <h2>Explore High-Intent Categories</h2>
                        <p>Every category is pulled dynamically from the platform so the homepage always reflects the current structure configured inside the dashboard.</p>
                    </div>
                    <a href="{{ $projectBrowseUrl }}" class="button ripple-effect">View all project opportunities</a>
                </div>

                <div class="category-grid">
                    @foreach ($topCategories as $category)
                        @php
                            $categoryProjectCount = (int) ($category->projects_count ?? 0) + (int) $category->children->sum('projects_count');
                            $categoryDescription = $category->parent_id
                                ? 'Specialized subcategory inside ' . ($category->parent?->name ?? 'its parent category') . '.'
                                : 'Primary category grouping multiple active freelance specializations.';
                        @endphp
                        <a href="{{ route('projects.browse', ['category' => $category->id]) }}" class="category-box">
                            <span class="category-icon">
                                <i class="icon-line-awesome-folder-open-o"></i>
                            </span>
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $categoryDescription }}</p>
                            <div class="category-meta">
                                <span>{{ number_format($categoryProjectCount) }} projects</span>
                                <span>Browse</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell">
            <div class="landing-container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Recent demand</span>
                        <h2>Fresh Projects That Prove The Marketplace Is Active</h2>
                        <p>Projects, owners, categories, budgets, and timestamps are rendered from live platform data so the homepage stays believable and current after every seed or real activity update.</p>
                    </div>
                </div>

                <div class="project-grid">
                    @foreach ($recent_projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="project-card">
                            <div>
                                <div class="project-meta">
                                    <span><i class="icon-material-outline-account-circle"></i> {{ $project->user?->name ?? 'Platform Client' }}</span>
                                    @if ($project->category)
                                        <span><i class="icon-material-outline-business-center"></i> {{ $project->category->name }}</span>
                                    @endif
                                    <span><i class="icon-material-outline-date-range"></i> {{ optional($project->created_at)->diffForHumans() }}</span>
                                </div>
                                <h3>{{ $project->title }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($project->desc), 170) }}</p>
                            </div>

                            <div class="project-side">
                                <div class="project-price">${{ number_format((float) $project->budget, 0) }}</div>
                                <span class="project-type">{{ ucfirst($project->type) }}</span>
                                <span class="button ripple-effect" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">View Project</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell is-alt">
            <div class="landing-container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Platform flow</span>
                        <h2>How Clients Move Smoothly Through The Platform</h2>
                        <p>The homepage now explains the platform workflow with clean structure so visitors understand how the marketplace works before they even enter the dashboard.</p>
                    </div>
                </div>

                <div class="flow-grid">
                    <div class="flow-box">
                        <span class="flow-badge">01</span>
                        <h3>Publish a polished brief</h3>
                        <p>Clients create projects with clear scopes, categories, budgets, and expectations so specialists can respond with accurate and useful proposals.</p>
                    </div>
                    <div class="flow-box">
                        <span class="flow-badge">02</span>
                        <h3>Review qualified proposals</h3>
                        <p>Freelancers send structured bids, positioning, and timelines that make shortlisting more professional and less noisy for serious buyers.</p>
                    </div>
                    <div class="flow-box">
                        <span class="flow-badge">03</span>
                        <h3>Manage delivery with confidence</h3>
                        <p>Projects, contracts, messages, and payments stay visible in one ecosystem designed for clean administration and real operational clarity.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell">
            <div class="landing-container">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Talent signal</span>
                        <h2>Featured Talent Snapshot</h2>
                        <p>These freelancer cards are built directly from the platform profiles so portfolio screenshots feel real, curated, and consistent with the actual marketplace data.</p>
                    </div>
                </div>

                <div class="freelancer-grid">
                    @foreach ($featuredFreelancers as $freelancer)
                        <div class="freelancer-box">
                            <div class="freelancer-top">
                                <span class="freelancer-avatar">
                                    {{ strtoupper(\Illuminate\Support\Str::substr($freelancer->first_name ?: $freelancer->user?->name ?: 'F', 0, 1)) }}
                                </span>
                                <div>
                                    <h3>{{ trim(($freelancer->first_name ?? '') . ' ' . ($freelancer->last_name ?? '')) ?: ($freelancer->user?->name ?? 'Freelancer') }}</h3>
                                    <span class="freelancer-role">{{ $freelancer->title ?: 'Independent specialist' }}</span>
                                </div>
                            </div>

                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($freelancer->desc), 132) ?: 'Experienced freelancer with a profile tailored for client trust and strong positioning.' }}</p>

                            <div class="freelancer-footer">
                                <div>
                                    <span class="freelancer-rate-label">Starting rate</span>
                                    <div class="freelancer-rate">${{ number_format((float) ($freelancer->hourly_rate ?? 0), 0) }}/hr</div>
                                </div>
                                <a href="{{ route('projects.browse', ['q' => $freelancer->title]) }}" class="button ripple-effect">Match Projects</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell" style="padding-top: 0; padding-bottom: 90px;">
            <div class="landing-container">
                <div class="settings-band">
                    <div class="settings-band-grid">
                        <div>
                            <strong>{{ $siteSettings->site_name }}</strong>
                            <span>{{ $siteSettings->site_tagline ?: 'Professional freelance marketplace for serious clients and top talent.' }}</span>
                        </div>
                        <div>
                            <strong>Email</strong>
                            <a href="mailto:{{ $siteSettings->contact_email }}">{{ $siteSettings->contact_email }}</a>
                        </div>
                        <div>
                            <strong>Phone</strong>
                            <span>{{ $siteSettings->contact_phone }}</span>
                        </div>
                        <div>
                            <strong>Keywords</strong>
                            <span>{{ $siteSettings->meta_keywords }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-front-layout>
