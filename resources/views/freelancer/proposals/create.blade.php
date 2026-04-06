<x-front-layout :title="'Submit Proposal'">
    @php
        $categoryLabel = $project->category?->parent_id
            ? $project->category->parent->name . ' / ' . $project->category->name
            : ($project->category?->name ?? 'General');
    @endphp

    <style>
        .proposal-shell {
            background:
                radial-gradient(circle at top left, rgba(249, 115, 22, 0.08), transparent 24%),
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 20%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 34%, #f8fafc 100%);
            min-height: calc(100vh - 84px);
        }

        .proposal-wrap {
            width: min(1240px, calc(100% - 32px));
            margin: 0 auto;
        }

        .proposal-hero {
            padding: 40px 0 24px;
        }

        .proposal-hero-panel {
            padding: 28px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.08);
        }

        .proposal-kicker {
            display: inline-flex;
            align-items: center;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            background: rgba(255, 247, 237, 0.95);
            border: 1px solid rgba(249, 115, 22, 0.14);
            color: #c2410c;
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .proposal-hero h1 {
            margin: 18px 0 14px;
            color: #0f172a;
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.02;
            letter-spacing: -0.045em;
        }

        .proposal-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 14px;
            color: #64748b;
            font-size: 0.92rem;
        }

        .proposal-meta span,
        .proposal-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .proposal-pill {
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            font-weight: 700;
            background: rgba(37, 99, 235, 0.08);
            color: #1d4ed8;
        }

        .proposal-intro {
            color: #475569;
            line-height: 1.9;
            max-width: 840px;
        }

        .proposal-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 24px;
            align-items: start;
            padding-bottom: 72px;
        }

        .proposal-box {
            border-radius: 28px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .proposal-box-head {
            padding: 22px 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }

        .proposal-box-head h2 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 1.4rem;
        }

        .proposal-box-head p {
            margin: 0;
            color: #64748b;
        }

        .proposal-box-content {
            padding: 24px;
        }

        .proposal-box-content p {
            margin: 0;
            color: #475569;
            line-height: 1.9;
        }

        .proposal-form-grid {
            display: grid;
            gap: 16px;
        }

        .proposal-field {
            display: grid;
            gap: 8px;
        }

        .proposal-field h5 {
            margin: 0;
            color: #334155;
            font-size: 0.92rem;
            font-weight: 700;
        }

        .proposal-field .with-border,
        .proposal-field textarea,
        .proposal-field select {
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: none;
        }

        .proposal-field .with-border,
        .proposal-field select {
            height: 52px;
        }

        .proposal-inline-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .proposal-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .proposal-actions .button,
        .proposal-actions .button.gray {
            min-height: 50px;
            border-radius: 16px;
            padding: 0 22px;
        }

        .proposal-side {
            position: sticky;
            top: 104px;
            display: grid;
            gap: 20px;
        }

        .proposal-side-card {
            padding: 24px;
        }

        .proposal-side-card h3 {
            margin: 0 0 12px;
            color: #0f172a;
            font-size: 1.25rem;
        }

        .proposal-side-card p {
            margin: 0 0 16px;
            color: #64748b;
            line-height: 1.8;
        }

        .proposal-side-list {
            display: grid;
            gap: 12px;
        }

        .proposal-side-item {
            padding: 14px 16px;
            border-radius: 18px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .proposal-side-item span {
            display: block;
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .proposal-side-item strong {
            color: #0f172a;
            font-size: 1rem;
        }

        .proposal-share-box {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 54px;
            gap: 10px;
        }

        .proposal-share-box input {
            height: 50px;
            border-radius: 16px;
        }

        @media (max-width: 1199px) {
            .proposal-layout {
                grid-template-columns: 1fr;
            }

            .proposal-side {
                position: static;
            }
        }

        @media (max-width: 767px) {
            .proposal-wrap {
                width: min(100% - 24px, 1240px);
            }

            .proposal-inline-grid,
            .proposal-share-box {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="proposal-shell">
        <section class="proposal-hero">
            <div class="proposal-wrap">
                <div class="proposal-hero-panel">
                    <span class="proposal-kicker">Submit proposal</span>
                    <h1>{{ $project->title }}</h1>

                    <div class="proposal-meta">
                        <span><i class="icon-material-outline-account-circle"></i> {{ $project->user?->name ?? 'Client' }}</span>
                        <span><i class="icon-material-outline-business-center"></i> {{ $categoryLabel }}</span>
                        <span><i class="icon-material-outline-date-range"></i> {{ $project->created_at->diffForHumans() }}</span>
                        <span class="proposal-pill">{{ ucfirst($project->type) }}</span>
                    </div>

                    <p class="proposal-intro">
                        Review the project carefully, then send a focused proposal that explains your fit, price, and timeline in a confident and structured way.
                    </p>
                </div>
            </div>
        </section>

        <section class="proposal-wrap">
            <div class="proposal-layout">
                <div>
                    <div class="proposal-box">
                        <div class="proposal-box-head">
                            <h2>Project Brief</h2>
                            <p>This is the public description the client provided for the project.</p>
                        </div>
                        <div class="proposal-box-content">
                            <p>{{ $project->desc }}</p>
                        </div>
                    </div>

                    <div class="proposal-box" style="margin-top:24px;">
                        <div class="proposal-box-head">
                            <h2>Your Proposal</h2>
                            <p>Write a strong summary, set your price, and define a realistic delivery duration.</p>
                        </div>
                        <div class="proposal-box-content">
                            <form method="post" action="{{ route('freelancer.proposals.store', $project->id) }}" id="proposal-form" class="proposal-form-grid">
                                @csrf

                                <div class="proposal-field">
                                    <h5>Proposal Summary</h5>
                                    <x-form.textarea class="input-text with-border" name="description" id="description" placeholder="Explain your approach, relevant experience, and expected outcome." required="required" />
                                </div>

                                <div class="proposal-inline-grid">
                                    <div class="proposal-field">
                                        <h5>Your Price</h5>
                                        <x-form.input type="number" class="input-text with-border" name="cost" id="cost" placeholder="Cost" required="required" />
                                    </div>

                                    <div class="proposal-field">
                                        <h5>Duration</h5>
                                        <x-form.input type="number" class="input-text with-border" name="duration" id="duration" placeholder="Duration" required="required" />
                                    </div>
                                </div>

                                <div class="proposal-field">
                                    <h5>Duration Unit</h5>
                                    <x-form.select class="input-text with-border" name="duration_unit" id="duration_unit" required="required" :options="$units" />
                                </div>
                            </form>

                            <div class="proposal-actions">
                                <button class="button ripple-effect" type="submit" form="proposal-form" style="background:linear-gradient(135deg,#f97316,#2563eb);">
                                    Submit Proposal
                                </button>
                                <a href="{{ route('projects.show', $project) }}" class="button gray ripple-effect">Back to Project</a>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="proposal-side">
                    <div class="proposal-box proposal-side-card">
                        <h3>Project Summary</h3>
                        <div class="proposal-side-list">
                            <div class="proposal-side-item">
                                <span>Budget</span>
                                <strong>${{ number_format((float) $project->budget, 0) }}</strong>
                            </div>
                            <div class="proposal-side-item">
                                <span>Type</span>
                                <strong>{{ ucfirst($project->type) }}</strong>
                            </div>
                            <div class="proposal-side-item">
                                <span>Status</span>
                                <strong>{{ ucfirst($project->status) }}</strong>
                            </div>
                            <div class="proposal-side-item">
                                <span>Category</span>
                                <strong>{{ $categoryLabel }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="proposal-box proposal-side-card">
                        <h3>Proposal Tips</h3>
                        <p>Keep your proposal client-centered. Explain why you are a strong fit, how you will deliver, and what timeline the client can rely on.</p>

                        <div class="proposal-side-list">
                            <div class="proposal-side-item">
                                <span>Approach</span>
                                <strong>Lead with relevant experience and a clear delivery plan.</strong>
                            </div>
                            <div class="proposal-side-item">
                                <span>Price</span>
                                <strong>Stay realistic and aligned with the scope and budget.</strong>
                            </div>
                            <div class="proposal-side-item">
                                <span>Timeline</span>
                                <strong>Set a duration you can actually meet confidently.</strong>
                            </div>
                        </div>
                    </div>

                    <div class="proposal-box proposal-side-card">
                        <h3>Share Project</h3>
                        <p>Copy the project URL if you want to review it elsewhere before submitting.</p>

                        <div class="proposal-share-box">
                            <input id="copy-url" type="text" value="{{ $shareUrl }}" class="with-border">
                            <button class="button ripple-effect copy-url-button" data-clipboard-target="#copy-url" style="background:#0f172a;">
                                <i class="icon-material-outline-file-copy"></i>
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </div>
</x-front-layout>
