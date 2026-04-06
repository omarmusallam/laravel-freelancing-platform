<x-front-layout title="Browse Projects">
    @php
        $activeCategory = $selectedCategory;
        $heroTitle = $activeCategory ? 'Projects in ' . $activeCategory->name : 'Browse High-Quality Freelance Projects';
        $heroDescription = $activeCategory
            ? 'Explore live opportunities inside ' . $activeCategory->name . ' with filters, budgets, categories, and current demand presented clearly.'
            : 'Discover active freelance work across the marketplace with cleaner filtering, clearer project cards, and a more professional browsing experience.';
    @endphp

    <style>
        .browse-shell {
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 22%),
                radial-gradient(circle at top left, rgba(249, 115, 22, 0.08), transparent 24%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 32%, #f8fafc 100%);
            min-height: calc(100vh - 84px);
        }

        .browse-wrap {
            width: min(1240px, calc(100% - 32px));
            margin: 0 auto;
        }

        .browse-hero {
            padding: 40px 0 28px;
        }

        .browse-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #c2410c;
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.06);
        }

        .browse-hero h1 {
            margin: 18px 0 14px;
            color: #0f172a;
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 0.98;
            letter-spacing: -0.045em;
            max-width: 760px;
        }

        .browse-hero p {
            margin: 0;
            max-width: 720px;
            color: #64748b;
            font-size: 1.04rem;
            line-height: 1.9;
        }

        .browse-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 24px;
        }

        .browse-stat {
            padding: 18px 18px 16px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.06);
        }

        .browse-stat strong {
            display: block;
            margin-bottom: 6px;
            color: #0f172a;
            font-size: 1.65rem;
            line-height: 1;
        }

        .browse-stat span {
            color: #64748b;
            font-size: 0.9rem;
        }

        .browse-grid {
            display: grid;
            grid-template-columns: 320px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
            padding-bottom: 72px;
        }

        .surface-box {
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
        }

        .filter-panel {
            position: sticky;
            top: 104px;
            padding: 22px;
        }

        .filter-panel h3 {
            margin: 0 0 10px;
            color: #0f172a;
            font-size: 1.3rem;
        }

        .filter-panel p {
            margin: 0 0 18px;
            color: #64748b;
            line-height: 1.8;
            font-size: 0.92rem;
        }

        .filter-group {
            margin-bottom: 18px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-weight: 700;
            font-size: 0.92rem;
        }

        .filter-panel input.with-border,
        .filter-panel .bootstrap-select>.dropdown-toggle {
            height: 52px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: none;
        }

        .filter-budget-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .filter-actions {
            display: grid;
            gap: 10px;
            margin-top: 6px;
        }

        .filter-actions .button {
            width: 100%;
            min-height: 50px;
            border-radius: 16px;
        }

        .button-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.05);
            color: #0f172a;
            font-weight: 700;
        }

        .browse-results-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            margin-bottom: 18px;
            padding: 24px;
        }

        .browse-results-head h2 {
            margin: 0 0 8px;
            color: #0f172a;
            font-size: 1.8rem;
        }

        .browse-results-head p {
            margin: 0;
            color: #64748b;
        }

        .browse-results-count {
            color: #2563eb;
            font-weight: 800;
            font-size: 0.95rem;
        }

        .project-stack {
            display: grid;
            gap: 16px;
            padding: 0 24px 24px;
        }

        .project-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px;
            gap: 22px;
            align-items: center;
            padding: 22px;
            border-radius: 24px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, background 0.2s ease;
        }

        .project-card:hover {
            transform: translateY(-3px);
            border-color: rgba(15, 118, 110, 0.2);
            background: linear-gradient(180deg, #fffdf8 0%, #f8fffd 100%);
            box-shadow: 0 28px 56px rgba(148, 163, 184, 0.16);
        }

        .project-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 10px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .project-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .project-card h3 {
            margin: 0 0 10px;
            color: #0f172a;
            font-size: 1.5rem;
            line-height: 1.2;
        }

        .project-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.85;
        }

        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .project-tags span {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #475569;
            font-weight: 600;
            font-size: 0.84rem;
        }

        .project-side {
            display: grid;
            gap: 12px;
            padding-left: 18px;
            border-left: 1px solid rgba(226, 232, 240, 0.9);
            justify-items: start;
        }

        .project-price {
            color: #0f172a;
            font-size: 2rem;
            line-height: 1;
            font-weight: 800;
        }

        .project-type,
        .project-proposals {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            font-weight: 700;
        }

        .project-type {
            background: rgba(37, 99, 235, 0.08);
            color: #1d4ed8;
        }

        .project-proposals {
            background: rgba(15, 118, 110, 0.08);
            color: #0f766e;
        }

        .empty-state {
            margin: 0 24px 24px;
            padding: 28px;
            border-radius: 24px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #64748b;
        }

        .browse-pagination {
            padding: 0 24px 24px;
        }

        .browse-pagination nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            padding: 18px 22px;
            border-radius: 22px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .browse-pagination-summary {
            color: #64748b;
            font-weight: 600;
        }

        .browse-pagination-links {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .browse-page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 46px;
            height: 46px;
            padding: 0 14px;
            border-radius: 14px;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.16);
            color: #334155;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .browse-page-link:hover {
            border-color: rgba(15, 118, 110, 0.22);
            background: #f8fffd;
            color: #0f766e;
        }

        .browse-page-link.is-active {
            background: linear-gradient(135deg, #f97316, #2563eb);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 16px 30px rgba(37, 99, 235, 0.16);
        }

        .browse-page-link.is-disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        @media (max-width: 1199px) {
            .browse-grid {
                grid-template-columns: 1fr;
            }

            .filter-panel {
                position: static;
            }
        }

        @media (max-width: 991px) {
            .browse-stats,
            .project-card {
                grid-template-columns: 1fr;
            }

            .project-side {
                border-left: 0;
                padding-left: 0;
                padding-top: 14px;
                border-top: 1px solid rgba(226, 232, 240, 0.9);
            }
        }

        @media (max-width: 767px) {
            .browse-wrap {
                width: min(100% - 24px, 1240px);
            }

            .browse-results-head,
            .project-stack,
            .browse-pagination {
                padding-left: 18px;
                padding-right: 18px;
            }

            .browse-results-head {
                flex-direction: column;
                align-items: start;
            }

            .browse-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>

    <div class="browse-shell">
        <section class="browse-hero">
            <div class="browse-wrap">
                <span class="browse-kicker">
                    <i class="icon-material-outline-search"></i>
                    Project marketplace
                </span>
                <h1>{{ $heroTitle }}</h1>
                <p>{{ $heroDescription }}</p>

                <div class="browse-stats">
                    <div class="browse-stat">
                        <strong>{{ number_format($stats['results']) }}</strong>
                        <span>Results found</span>
                    </div>
                    <div class="browse-stat">
                        <strong>{{ number_format($stats['fixed']) }}</strong>
                        <span>Fixed-price projects</span>
                    </div>
                    <div class="browse-stat">
                        <strong>{{ number_format($stats['hourly']) }}</strong>
                        <span>Hourly projects</span>
                    </div>
                    <div class="browse-stat">
                        <strong>{{ number_format($stats['budget_projects']) }}</strong>
                        <span>Projects with visible budget</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="browse-wrap">
            <div class="browse-grid">
                <aside class="surface-box filter-panel">
                    <h3>Filter Projects</h3>
                    <p>Refine live opportunities by keyword, category, project type, and budget range.</p>

                    <form method="GET" action="{{ route('projects.browse') }}">
                        <div class="filter-group">
                            <label for="filter-keyword">Keyword</label>
                            <input id="filter-keyword" type="text" class="with-border" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search projects or skills">
                        </div>

                        <div class="filter-group">
                            <label for="filter-category">Category</label>
                            <select id="filter-category" name="category" class="selectpicker with-border" data-size="8" title="All categories">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(($filters['category'] ?? null) == $category->id)>
                                        {{ $category->parent_id ? $category->parent->name . ' / ' . $category->name : $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filter-type">Project Type</label>
                            <select id="filter-type" name="type" class="selectpicker with-border" data-size="6" title="All types">
                                <option value="">All types</option>
                                @foreach ($types as $typeValue => $typeLabel)
                                    <option value="{{ $typeValue }}" @selected(($filters['type'] ?? null) === $typeValue)>
                                        {{ $typeLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Budget Range</label>
                            <div class="filter-budget-grid">
                                <input type="number" class="with-border" name="budget_min" placeholder="Min" value="{{ $filters['budget_min'] ?? '' }}">
                                <input type="number" class="with-border" name="budget_max" placeholder="Max" value="{{ $filters['budget_max'] ?? '' }}">
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button class="button ripple-effect" style="background: linear-gradient(135deg, #f97316, #2563eb);">
                                Apply Filters
                            </button>
                            <a href="{{ route('projects.browse') }}" class="button-ghost">Reset Filters</a>
                        </div>
                    </form>
                </aside>

                <div class="surface-box">
                    <div class="browse-results-head">
                        <div>
                            <h2>Available Projects</h2>
                            <p>{{ $activeCategory ? 'Showing projects under the selected category and its child specializations.' : 'Showing the latest open projects currently available across the marketplace.' }}</p>
                        </div>
                        <div class="browse-results-count">{{ number_format($projects->total()) }} active listings</div>
                    </div>

                    <div class="project-stack">
                        @forelse ($projects as $project)
                            <a href="{{ route('projects.show', $project) }}" class="project-card">
                                <div>
                                    <div class="project-meta">
                                        <span><i class="icon-material-outline-account-circle"></i> {{ $project->user?->name ?? 'Platform Client' }}</span>
                                        @if ($project->category)
                                            <span><i class="icon-material-outline-business-center"></i> {{ $project->category->parent_id ? $project->category->parent->name . ' / ' . $project->category->name : $project->category->name }}</span>
                                        @endif
                                        <span><i class="icon-material-outline-date-range"></i> {{ $project->created_at->diffForHumans() }}</span>
                                    </div>

                                    <h3>{{ $project->title }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($project->desc), 180) }}</p>

                                    @if ($project->tags->isNotEmpty())
                                        <div class="project-tags">
                                            @foreach ($project->tags->take(5) as $tag)
                                                <span>{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="project-side">
                                    <div class="project-price">${{ number_format((float) $project->budget, 0) }}</div>
                                    <span class="project-type">{{ ucfirst($project->type) }}</span>
                                    <span class="project-proposals">{{ number_format($project->proposals_count) }} proposals</span>
                                    <span class="button ripple-effect" style="background: #0f172a;">View Project</span>
                                </div>
                            </a>
                        @empty
                            <div class="empty-state">
                                <strong style="display: block; margin-bottom: 8px; color: #0f172a;">No projects matched your current filters.</strong>
                                <span>Try broadening the category, keyword, or budget range to discover more live opportunities.</span>
                            </div>
                        @endforelse
                    </div>

                    <div class="browse-pagination">
                        @if ($projects->hasPages())
                            <nav aria-label="Projects pagination">
                                <div class="browse-pagination-summary">
                                    Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} results
                                </div>

                                <div class="browse-pagination-links">
                                    <a href="{{ $projects->previousPageUrl() ?: '#' }}"
                                        class="browse-page-link {{ $projects->onFirstPage() ? 'is-disabled' : '' }}"
                                        aria-label="Previous page">
                                        <i class="icon-material-outline-keyboard-arrow-left"></i>
                                    </a>

                                    @foreach ($projects->getUrlRange(max(1, $projects->currentPage() - 2), min($projects->lastPage(), $projects->currentPage() + 2)) as $page => $url)
                                        <a href="{{ $url }}"
                                            class="browse-page-link {{ $page === $projects->currentPage() ? 'is-active' : '' }}">
                                            {{ $page }}
                                        </a>
                                    @endforeach

                                    <a href="{{ $projects->nextPageUrl() ?: '#' }}"
                                        class="browse-page-link {{ $projects->hasMorePages() ? '' : 'is-disabled' }}"
                                        aria-label="Next page">
                                        <i class="icon-material-outline-keyboard-arrow-right"></i>
                                    </a>
                                </div>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-front-layout>
