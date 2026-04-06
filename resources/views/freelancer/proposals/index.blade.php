<x-app-layout>
    <style>
        .freelancer-proposals-shell {
            display: grid;
            gap: 24px;
        }

        .freelancer-proposals-hero {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 18px;
            padding: 28px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 70%, #2563eb 100%);
            color: #fff;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.18);
        }

        .freelancer-proposals-hero h1 {
            margin: 0 0 10px;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .freelancer-proposals-hero p {
            margin: 0;
            max-width: 760px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.85;
        }

        .freelancer-proposals-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .freelancer-proposals-stat {
            padding: 20px;
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
        }

        .freelancer-proposals-stat strong {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 1.8rem;
            line-height: 1;
        }

        .freelancer-proposals-stat span {
            color: #64748b;
            font-weight: 600;
        }

        .freelancer-proposals-box {
            border-radius: 28px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .freelancer-proposals-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 22px 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }

        .freelancer-proposals-head h2 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 1.45rem;
        }

        .freelancer-proposals-head p {
            margin: 0;
            color: #64748b;
        }

        .freelancer-proposals-list {
            display: grid;
        }

        .freelancer-proposal-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 20px;
            padding: 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
        }

        .freelancer-proposal-card:last-child {
            border-bottom: 0;
        }

        .freelancer-proposal-title-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 12px;
        }

        .freelancer-proposal-title-row h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1.3rem;
        }

        .freelancer-proposal-status {
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: capitalize;
        }

        .proposal-status-pending {
            background: rgba(245, 158, 11, 0.12);
            color: #b45309;
        }

        .proposal-status-accepted {
            background: rgba(15, 118, 110, 0.1);
            color: #0f766e;
        }

        .proposal-status-declined {
            background: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
        }

        .freelancer-proposal-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 12px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .freelancer-proposal-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .freelancer-proposal-body {
            color: #475569;
            line-height: 1.85;
        }

        .freelancer-proposal-actions {
            display: grid;
            gap: 10px;
            min-width: 190px;
            align-content: start;
        }

        .freelancer-proposal-actions .button,
        .freelancer-proposal-actions .button.gray {
            min-height: 46px;
            border-radius: 14px;
            text-align: center;
        }

        .freelancer-proposal-actions .button.gray {
            background: rgba(15, 23, 42, 0.05);
            color: #0f172a;
        }

        .freelancer-proposals-empty {
            padding: 28px 24px;
            color: #64748b;
        }

        .freelancer-proposals-pagination {
            padding: 22px 24px 24px;
            border-top: 1px solid rgba(226, 232, 240, 0.85);
        }

        @media (max-width: 991px) {
            .freelancer-proposals-hero,
            .freelancer-proposal-card {
                grid-template-columns: 1fr;
            }

            .freelancer-proposals-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .freelancer-proposals-stats {
                grid-template-columns: 1fr;
            }

            .freelancer-proposals-head {
                flex-direction: column;
                align-items: start;
            }
        }
    </style>

    <div class="freelancer-proposals-shell">
        <section class="freelancer-proposals-hero">
            <div>
                <h1>Freelancer Proposal Workspace</h1>
                <p>Track every submitted proposal, monitor current statuses, and jump back into the public project page or your profile workflow from one organized screen.</p>
            </div>
        </section>

        <section class="freelancer-proposals-stats">
            <div class="freelancer-proposals-stat">
                <strong>{{ number_format($stats['total']) }}</strong>
                <span>Total proposals</span>
            </div>
            <div class="freelancer-proposals-stat">
                <strong>{{ number_format($stats['pending']) }}</strong>
                <span>Pending review</span>
            </div>
            <div class="freelancer-proposals-stat">
                <strong>{{ number_format($stats['accepted']) }}</strong>
                <span>Accepted</span>
            </div>
            <div class="freelancer-proposals-stat">
                <strong>{{ number_format($stats['declined']) }}</strong>
                <span>Declined</span>
            </div>
        </section>

        <section class="freelancer-proposals-box">
            <div class="freelancer-proposals-head">
                <div>
                    <h2>Submitted Proposals</h2>
                    <p>Each proposal card shows the project, your submission timing, and its latest status.</p>
                </div>
                <div style="color:#2563eb;font-weight:800;">{{ number_format($proposals->total()) }} records</div>
            </div>

            <div class="freelancer-proposals-list">
                @forelse ($proposals as $proposal)
                    @php
                        $statusClass = $proposal->status === 'accepted'
                            ? 'proposal-status-accepted'
                            : ($proposal->status === 'declined' ? 'proposal-status-declined' : 'proposal-status-pending');
                    @endphp
                    <div class="freelancer-proposal-card">
                        <div>
                            <div class="freelancer-proposal-title-row">
                                <h3>{{ $proposal->project?->title ?? 'Project unavailable' }}</h3>
                                <span class="freelancer-proposal-status {{ $statusClass }}">{{ $proposal->status }}</span>
                            </div>

                            <div class="freelancer-proposal-meta">
                                <span><i class="icon-material-outline-date-range"></i> {{ $proposal->created_at->format('M d, Y') }}</span>
                                <span><i class="icon-material-outline-account-circle"></i> {{ $proposal->project?->user?->name ?? 'Client' }}</span>
                                <span><i class="icon-material-outline-business-center"></i> {{ $proposal->project?->category?->parent_id ? $proposal->project->category->parent->name . ' / ' . $proposal->project->category->name : ($proposal->project?->category?->name ?? 'General') }}</span>
                                <span><i class="icon-material-outline-access-time"></i> {{ $proposal->duration }} {{ ucfirst($proposal->duration_unit) }}</span>
                                <span><i class="icon-material-outline-account-balance-wallet"></i> ${{ number_format((float) $proposal->cost, 0) }}</span>
                            </div>

                            <div class="freelancer-proposal-body">
                                {{ \Illuminate\Support\Str::limit($proposal->description, 210) }}
                            </div>
                        </div>

                        <div class="freelancer-proposal-actions">
                            @if ($proposal->project)
                                <a href="{{ route('projects.show', $proposal->project) }}" class="button ripple-effect" style="background:#0f172a;">
                                    View Project
                                </a>
                            @endif
                            @if ($proposal->status === 'accepted')
                                <a href="{{ route('freelancer.contracts.index') }}" class="button ripple-effect" style="background:#0f766e;">
                                    Delivery Workspace
                                </a>
                            @endif
                            <a href="{{ route('freelancer.profile.edit') }}" class="button gray ripple-effect">
                                Profile Workspace
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="freelancer-proposals-empty">
                        No proposals have been submitted yet. Browse projects and start sending strong proposals from the marketplace.
                    </div>
                @endforelse
            </div>

            @if ($proposals->hasPages())
                <div class="freelancer-proposals-pagination">
                    {{ $proposals->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
