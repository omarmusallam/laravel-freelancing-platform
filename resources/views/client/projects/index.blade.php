<x-app-layout>
    <style>
        .client-projects-shell {
            display: grid;
            gap: 24px;
        }

        .client-projects-hero {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            padding: 28px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 70%, #0f766e 100%);
            color: #fff;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.18);
        }

        .client-projects-hero h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -0.04em;
            color: #fff;
        }

        .client-projects-hero p {
            margin: 0;
            max-width: 720px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.85;
        }

        .client-projects-hero .button {
            min-height: 52px;
            padding: 0 22px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f97316, #2563eb);
            font-weight: 800;
            white-space: nowrap;
        }

        .client-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .client-stat-card {
            padding: 20px;
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
        }

        .client-stat-card strong {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 1.8rem;
            line-height: 1;
        }

        .client-stat-card span {
            color: #64748b;
            font-weight: 600;
        }

        .client-list-box {
            border-radius: 28px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .client-list-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 22px 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }

        .client-list-head h2 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 1.45rem;
        }

        .client-list-head p {
            margin: 0;
            color: #64748b;
        }

        .client-projects-list {
            display: grid;
            gap: 0;
        }

        .client-project-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 20px;
            padding: 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
        }

        .client-project-card:last-child {
            border-bottom: 0;
        }

        .client-project-title-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 12px;
        }

        .client-project-title-row h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1.3rem;
        }

        .client-status-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: capitalize;
        }

        .client-status-open {
            background: rgba(15, 118, 110, 0.08);
            color: #0f766e;
        }

        .client-status-progress {
            background: rgba(37, 99, 235, 0.08);
            color: #1d4ed8;
        }

        .client-status-closed {
            background: rgba(148, 163, 184, 0.14);
            color: #475569;
        }

        .client-project-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 14px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .client-project-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .client-project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .client-project-tags span {
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #475569;
            font-weight: 600;
            font-size: 0.82rem;
        }

        .client-project-actions {
            display: grid;
            gap: 10px;
            min-width: 190px;
            align-content: start;
        }

        .client-project-actions .button,
        .client-project-actions .button.gray {
            min-height: 46px;
            border-radius: 14px;
            text-align: center;
        }

        .client-project-actions .button.gray {
            background: rgba(15, 23, 42, 0.05);
            color: #0f172a;
        }

        .client-empty {
            padding: 28px 24px;
            color: #64748b;
        }

        .client-pagination {
            padding: 22px 24px 24px;
            border-top: 1px solid rgba(226, 232, 240, 0.85);
        }

        @media (max-width: 991px) {
            .client-projects-hero,
            .client-project-card {
                grid-template-columns: 1fr;
            }

            .client-projects-hero {
                align-items: start;
            }

            .client-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .client-stats-grid {
                grid-template-columns: 1fr;
            }

            .client-list-head {
                flex-direction: column;
                align-items: start;
            }
        }
    </style>

    <div class="client-projects-shell">
        <section class="client-projects-hero">
            <div>
                <h1>Client Project Workspace</h1>
                <p>Manage all published projects from one place, track their current status, review structure and tags, and jump quickly into editing or viewing the public listing.</p>
            </div>
            <a href="{{ route('client.projects.create') }}" class="button ripple-effect">
                <i class="icon-feather-plus"></i> New Project
            </a>
        </section>

        <section class="client-stats-grid">
            <div class="client-stat-card">
                <strong>{{ number_format($stats['total']) }}</strong>
                <span>Total projects</span>
            </div>
            <div class="client-stat-card">
                <strong>{{ number_format($stats['open']) }}</strong>
                <span>Open projects</span>
            </div>
            <div class="client-stat-card">
                <strong>{{ number_format($stats['in_progress']) }}</strong>
                <span>In-progress projects</span>
            </div>
            <div class="client-stat-card">
                <strong>{{ number_format($stats['closed']) }}</strong>
                <span>Closed projects</span>
            </div>
        </section>

        <section class="client-list-box">
            <div class="client-list-head">
                <div>
                    <h2>Your Project Listings</h2>
                    <p>Each card gives a quick operational summary plus direct actions.</p>
                </div>
                <div style="color:#2563eb;font-weight:800;">{{ number_format($projects->total()) }} visible records</div>
            </div>

            <div class="client-projects-list">
                @forelse ($projects as $project)
                    @php
                        $statusClass = $project->status === 'open'
                            ? 'client-status-open'
                            : ($project->status === 'in-progress' ? 'client-status-progress' : 'client-status-closed');
                    @endphp
                    <div class="client-project-card">
                        <div>
                            <div class="client-project-title-row">
                                <h3>{{ $project->title }}</h3>
                                <span class="client-status-pill {{ $statusClass }}">{{ $project->status }}</span>
                            </div>

                            <div class="client-project-meta">
                                <span><i class="icon-material-outline-date-range"></i> {{ $project->created_at->format('M d, Y') }}</span>
                                <span><i class="icon-material-outline-business-center"></i> {{ $project->type_name }}</span>
                                <span><i class="icon-material-outline-account-balance-wallet"></i> ${{ number_format((float) ($project->budget ?? 0), 0) }}</span>
                                <span><i class="icon-material-outline-category"></i> {{ $project->category?->parent_id ? $project->category->parent->name . ' / ' . $project->category->name : ($project->category?->name ?? 'General') }}</span>
                                <span><i class="icon-material-outline-rate-review"></i> {{ number_format($project->proposals_count) }} proposals</span>
                                <span><i class="icon-material-outline-assignment"></i> {{ number_format($project->contracts_count) }} contracts</span>
                            </div>

                            @if ($project->tags->isNotEmpty())
                                <div class="client-project-tags">
                                    @foreach ($project->tags->take(6) as $tag)
                                        <span>{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="client-project-actions">
                            <a href="{{ route('client.projects.show', $project) }}" class="button ripple-effect" style="background:#0f172a;">
                                View Workspace
                            </a>
                            <a href="{{ route('projects.show', $project) }}" class="button gray ripple-effect">
                                Public Page
                            </a>
                            <a href="{{ route('client.projects.edit', $project->id) }}" class="button gray ripple-effect">
                                Edit Project
                            </a>
                            <form action="{{ route('client.projects.destroy', $project->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button gray ripple-effect" style="width:100%;" onclick="return confirm('Delete this project?')">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="client-empty">
                        No client projects exist yet. Start by creating your first project and the workspace will populate here.
                    </div>
                @endforelse
            </div>

            @if ($projects->hasPages())
                <div class="client-pagination">
                    {{ $projects->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
