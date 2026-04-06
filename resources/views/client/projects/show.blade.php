<x-app-layout>
    @php
        $categoryLabel = $project->category?->parent_id
            ? $project->category->parent->name . ' / ' . $project->category->name
            : ($project->category?->name ?? 'General');
        $statusClass = $project->status === 'open'
            ? 'client-workspace-status-open'
            : ($project->status === 'in-progress' ? 'client-workspace-status-progress' : 'client-workspace-status-closed');
    @endphp

    <style>
        .client-workspace-shell {
            display: grid;
            gap: 24px;
        }

        .client-workspace-hero {
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

        .client-workspace-hero h1 {
            margin: 0 0 12px;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .client-workspace-hero p {
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.8;
            max-width: 760px;
        }

        .client-workspace-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.85rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: capitalize;
            margin-top: 8px;
        }

        .client-workspace-status-open {
            background: rgba(15, 118, 110, 0.16);
            color: #d1fae5;
        }

        .client-workspace-status-progress {
            background: rgba(37, 99, 235, 0.16);
            color: #dbeafe;
        }

        .client-workspace-status-closed {
            background: rgba(148, 163, 184, 0.2);
            color: #e2e8f0;
        }

        .client-workspace-hero .button {
            min-height: 52px;
            padding: 0 22px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f97316, #2563eb);
            font-weight: 800;
            white-space: nowrap;
        }

        .client-workspace-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 16px;
        }

        .client-workspace-stat {
            padding: 20px;
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
        }

        .client-workspace-stat strong {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 1.8rem;
            line-height: 1;
        }

        .client-workspace-stat span {
            color: #64748b;
            font-weight: 600;
        }

        .client-workspace-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            gap: 24px;
            align-items: start;
        }

        .client-workspace-box {
            border-radius: 28px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.07);
            overflow: hidden;
        }

        .client-workspace-head {
            padding: 22px 24px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.9);
        }

        .client-workspace-head h2 {
            margin: 0 0 6px;
            color: #0f172a;
            font-size: 1.4rem;
        }

        .client-workspace-head p {
            margin: 0;
            color: #64748b;
        }

        .client-workspace-content {
            padding: 24px;
        }

        .client-workspace-content p {
            margin: 0;
            color: #475569;
            line-height: 1.9;
        }

        .client-workspace-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .client-workspace-card {
            padding: 18px;
            border-radius: 20px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .client-workspace-card span {
            display: block;
            margin-bottom: 6px;
            color: #94a3b8;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .client-workspace-card strong {
            color: #0f172a;
            font-size: 1rem;
        }

        .client-tag-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .client-tag-row span {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.8rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #475569;
            font-weight: 600;
            font-size: 0.82rem;
        }

        .client-attachments {
            display: grid;
            gap: 10px;
        }

        .client-attachments a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border-radius: 16px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
            color: #2563eb;
            font-weight: 600;
        }

        .client-proposal-list {
            display: grid;
            gap: 14px;
        }

        .client-proposal-item {
            padding: 18px;
            border-radius: 20px;
            background: linear-gradient(180deg, #fff 0%, #fbfdff 100%);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .client-proposal-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: start;
            margin-bottom: 10px;
        }

        .client-proposal-head strong {
            color: #0f172a;
            font-size: 1rem;
        }

        .client-proposal-price {
            color: #0f766e;
            font-weight: 800;
        }

        .client-proposal-status {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: capitalize;
        }

        .client-proposal-status-pending {
            background: rgba(245, 158, 11, 0.12);
            color: #b45309;
        }

        .client-proposal-status-accepted {
            background: rgba(15, 118, 110, 0.12);
            color: #0f766e;
        }

        .client-proposal-status-declined {
            background: rgba(148, 163, 184, 0.18);
            color: #475569;
        }

        .client-proposal-meta {
            margin-top: 6px;
            color: #64748b;
            font-size: 0.88rem;
        }

        .client-proposal-note {
            margin-top: 10px;
            color: #0f766e;
            font-size: 0.84rem;
            font-weight: 700;
        }

        .client-proposal-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .client-proposal-actions form {
            margin: 0;
        }

        .client-proposal-actions .button,
        .client-proposal-actions .button.gray {
            min-height: 42px;
            border-radius: 14px;
            padding: 0 16px;
            border: 0;
            font-weight: 700;
        }

        .client-proposal-actions .button.gray {
            background: #e2e8f0;
            color: #0f172a;
        }

        .client-workspace-side {
            position: sticky;
            top: 104px;
            display: grid;
            gap: 20px;
        }

        .client-side-card {
            padding: 24px;
        }

        .client-side-card h3 {
            margin: 0 0 12px;
            color: #0f172a;
            font-size: 1.25rem;
        }

        .client-side-card p {
            margin: 0 0 16px;
            color: #64748b;
            line-height: 1.8;
        }

        .client-side-actions {
            display: grid;
            gap: 10px;
        }

        .client-side-actions .button,
        .client-side-actions .button.gray {
            min-height: 50px;
            border-radius: 16px;
            text-align: center;
        }

        .client-side-actions .button.gray {
            background: rgba(15, 23, 42, 0.05);
            color: #0f172a;
        }

        .client-side-summary {
            display: grid;
            gap: 12px;
        }

        .client-side-summary-item {
            padding: 14px 16px;
            border-radius: 18px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .client-side-summary-item span {
            display: block;
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .client-side-summary-item strong {
            color: #0f172a;
            font-size: 1rem;
        }

        .client-contract-panel {
            display: grid;
            gap: 14px;
        }

        .client-contract-card,
        .client-payment-card {
            padding: 18px;
            border-radius: 20px;
            background: linear-gradient(180deg, #fff 0%, #fbfdff 100%);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .client-contract-grid,
        .client-payment-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 14px;
        }

        .client-contract-grid span,
        .client-payment-grid span {
            display: block;
            color: #94a3b8;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 4px;
        }

        .client-contract-grid strong,
        .client-payment-grid strong {
            color: #0f172a;
        }

        .client-payment-list {
            display: grid;
            gap: 12px;
        }

        @media (max-width: 1199px) {
            .client-workspace-layout {
                grid-template-columns: 1fr;
            }

            .client-workspace-side {
                position: static;
            }
        }

        @media (max-width: 991px) {
            .client-contract-grid,
            .client-payment-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .client-workspace-hero,
            .client-workspace-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="client-workspace-shell">
        <section class="client-workspace-hero">
            <div>
                <h1>{{ $project->title }}</h1>
                <p>This is your internal client workspace for the project. Review the brief, current status, activity summary, and direct management actions from one place.</p>
                <span class="client-workspace-pill {{ $statusClass }}">{{ ucfirst($project->status) }}</span>
            </div>
            <a href="{{ route('client.projects.edit', $project) }}" class="button ripple-effect">
                <i class="icon-feather-edit"></i> Edit Project
            </a>
        </section>

        <section class="client-workspace-stats">
            <div class="client-workspace-stat">
                <strong>{{ number_format($stats['proposals']) }}</strong>
                <span>Total proposals</span>
            </div>
            <div class="client-workspace-stat">
                <strong>{{ number_format($stats['accepted_proposals']) }}</strong>
                <span>Accepted proposals</span>
            </div>
            <div class="client-workspace-stat">
                <strong>{{ number_format($stats['contracts']) }}</strong>
                <span>Contracts</span>
            </div>
            <div class="client-workspace-stat">
                <strong>{{ number_format($stats['attachments']) }}</strong>
                <span>Attachments</span>
            </div>
            <div class="client-workspace-stat">
                <strong>{{ number_format($stats['payments']) }}</strong>
                <span>Payments</span>
            </div>
        </section>

        <div class="client-workspace-layout">
            <div>
                <section class="client-workspace-box">
                    <div class="client-workspace-head">
                        <h2>Project Brief</h2>
                        <p>The public-facing description and core project information.</p>
                    </div>
                    <div class="client-workspace-content">
                        <p>{{ $project->desc }}</p>
                    </div>
                </section>

                <section class="client-workspace-box" style="margin-top:24px;">
                    <div class="client-workspace-head">
                        <h2>Project Details</h2>
                        <p>Operational details that define how the project appears and behaves.</p>
                    </div>
                    <div class="client-workspace-content">
                        <div class="client-workspace-grid">
                            <div class="client-workspace-card">
                                <span>Type</span>
                                <strong>{{ $project->type_name }}</strong>
                            </div>
                            <div class="client-workspace-card">
                                <span>Budget</span>
                                <strong>${{ number_format((float) ($project->budget ?? 0), 0) }}</strong>
                            </div>
                            <div class="client-workspace-card">
                                <span>Category</span>
                                <strong>{{ $categoryLabel }}</strong>
                            </div>
                            <div class="client-workspace-card">
                                <span>Created</span>
                                <strong>{{ $project->created_at->diffForHumans() }}</strong>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="client-workspace-box" style="margin-top:24px;">
                    <div class="client-workspace-head">
                        <h2>Tags</h2>
                        <p>Keywords associated with the project and its search visibility.</p>
                    </div>
                    <div class="client-workspace-content">
                        @if ($project->tags->isNotEmpty())
                            <div class="client-tag-row">
                                @foreach ($project->tags as $tag)
                                    <span>{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p>No tags added yet.</p>
                        @endif
                    </div>
                </section>

                <section class="client-workspace-box" style="margin-top:24px;">
                    <div class="client-workspace-head">
                        <h2>Attachments</h2>
                        <p>Reference files and supporting materials uploaded for this project.</p>
                    </div>
                    <div class="client-workspace-content">
                        @if (!empty($project->attachments))
                            <div class="client-attachments">
                                @foreach ($project->attachments as $file)
                                    <a href="{{ asset('uploads/' . $file) }}" target="_blank" rel="noopener">
                                        <i class="icon-feather-paperclip"></i> {{ basename($file) }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p>No attachments uploaded yet.</p>
                        @endif
                    </div>
                </section>

                <section class="client-workspace-box" style="margin-top:24px;">
                    <div class="client-workspace-head">
                        <h2>Contract & Payment</h2>
                        <p>Track the current delivery agreement and launch payment from the same client workspace.</p>
                    </div>
                    <div class="client-workspace-content">
                        <div class="client-contract-panel">
                            @if ($activeContract)
                                <div class="client-contract-card">
                                    <strong style="font-size:1.05rem;color:#0f172a;">Active contract overview</strong>
                                    <div class="client-contract-grid">
                                        <div>
                                            <span>Freelancer</span>
                                            <strong>{{ $activeContract->freelancer?->name ?? 'Freelancer' }}</strong>
                                        </div>
                                        <div>
                                            <span>Status</span>
                                            <strong>{{ ucfirst($activeContract->status) }}</strong>
                                        </div>
                                        <div>
                                            <span>Contract Value</span>
                                            <strong>${{ number_format((float) $activeContract->cost, 0) }}</strong>
                                        </div>
                                        <div>
                                            <span>Delivery Window</span>
                                            <strong>{{ optional($activeContract->start_on)->format('M d, Y') }} - {{ optional($activeContract->end_on)->format('M d, Y') }}</strong>
                                        </div>
                                    </div>

                                    @if ($activeContract->status === 'active')
                                        <div class="client-proposal-actions" style="margin-top:18px;">
                                            <a href="{{ route('payments.create', ['contract' => $activeContract->id]) }}" class="button ripple-effect" style="background:#0f766e;">
                                                Start Contract Payment
                                            </a>
                                            <a href="{{ route('messages', ['recipient_id' => $activeContract->freelancer_id]) }}" class="button gray ripple-effect">
                                                Contact Freelancer
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p>No active contract yet. Accept a proposal first to move the project into delivery and payment.</p>
                            @endif

                            @if ($payments->isNotEmpty())
                                <div class="client-payment-list">
                                    @foreach ($payments->take(5) as $payment)
                                        <div class="client-payment-card">
                                            <div class="client-payment-grid">
                                                <div>
                                                    <span>Reference</span>
                                                    <strong>{{ $payment->reference_id }}</strong>
                                                </div>
                                                <div>
                                                    <span>Status</span>
                                                    <strong>{{ ucfirst($payment->status) }}</strong>
                                                </div>
                                                <div>
                                                    <span>Amount</span>
                                                    <strong>${{ number_format((float) $payment->amount, 0) }}</strong>
                                                </div>
                                                <div>
                                                    <span>Created</span>
                                                    <strong>{{ $payment->created_at->diffForHumans() }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="client-workspace-box" style="margin-top:24px;">
                    <div class="client-workspace-head">
                        <h2>Proposal Activity</h2>
                        <p>Recent proposal activity linked to this project.</p>
                    </div>
                    <div class="client-workspace-content">
                        @if ($project->proposals->isNotEmpty())
                            <div class="client-proposal-list">
                                @foreach ($project->proposals as $proposal)
                                    @php
                                        $proposalStatusClass = $proposal->status === 'accepted'
                                            ? 'client-proposal-status-accepted'
                                            : ($proposal->status === 'declined' ? 'client-proposal-status-declined' : 'client-proposal-status-pending');
                                    @endphp
                                    <div class="client-proposal-item">
                                        <div class="client-proposal-head">
                                            <div>
                                                <strong>{{ $proposal->freelancer?->name ?? 'Freelancer' }}</strong>
                                                <div class="client-proposal-meta">
                                                    {{ ucfirst($proposal->status) }} · {{ $proposal->duration }} {{ ucfirst($proposal->duration_unit) }}
                                                </div>
                                            </div>
                                            <div class="client-proposal-price">
                                                ${{ number_format((float) $proposal->cost, 0) }}
                                            </div>
                                        </div>
                                        <p>{{ \Illuminate\Support\Str::limit($proposal->description, 180) }}</p>

                                        @if ($proposal->status === 'accepted' && $proposal->contract && $proposal->contract->exists)
                                            <div class="client-proposal-note">
                                                Contract is active for this proposal.
                                            </div>
                                        @endif

                                        @if ($project->status !== 'closed')
                                            <div class="client-proposal-actions">
                                                @if ($proposal->status !== 'accepted')
                                                    <form action="{{ route('client.projects.proposals.update', [$project, $proposal]) }}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="button ripple-effect" style="background:#0f766e;">
                                                            Accept Proposal
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($proposal->status !== 'declined')
                                                    <form action="{{ route('client.projects.proposals.update', [$project, $proposal]) }}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="declined">
                                                        <button type="submit" class="button gray ripple-effect">
                                                            Decline Proposal
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('messages', ['recipient_id' => $proposal->freelancer_id]) }}" class="button gray ripple-effect">
                                                    Message Freelancer
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No proposals have been submitted yet.</p>
                        @endif
                    </div>
                </section>
            </div>

            <aside class="client-workspace-side">
                <div class="client-workspace-box client-side-card">
                    <h3>Quick Actions</h3>
                    <p>Jump quickly to the most common next steps for this project.</p>
                    <div class="client-side-actions">
                        <a href="{{ route('client.projects.edit', $project) }}" class="button ripple-effect" style="background:#0f172a;">Edit Project</a>
                        <a href="{{ route('projects.show', $project) }}" class="button gray ripple-effect">View Public Page</a>
                        <a href="{{ route('client.projects.index') }}" class="button gray ripple-effect">Back to Workspace List</a>
                    </div>
                </div>

                <div class="client-workspace-box client-side-card">
                    <h3>Workspace Summary</h3>
                    <div class="client-side-summary">
                        <div class="client-side-summary-item">
                            <span>Status</span>
                            <strong>{{ ucfirst($project->status) }}</strong>
                        </div>
                        <div class="client-side-summary-item">
                            <span>Category</span>
                            <strong>{{ $categoryLabel }}</strong>
                        </div>
                        <div class="client-side-summary-item">
                            <span>Budget</span>
                            <strong>${{ number_format((float) ($project->budget ?? 0), 0) }}</strong>
                        </div>
                        <div class="client-side-summary-item">
                            <span>Public URL</span>
                            <strong>{{ route('projects.show', $project) }}</strong>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
