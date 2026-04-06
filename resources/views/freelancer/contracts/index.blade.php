<x-app-layout>
    <style>
        .freelancer-contracts-shell {
            display: grid;
            gap: 24px;
        }

        .freelancer-contracts-hero {
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

        .freelancer-contracts-hero h1 {
            margin: 0 0 10px;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .freelancer-contracts-hero p {
            margin: 0;
            max-width: 760px;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.85;
        }

        .freelancer-contract-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }

        .freelancer-contract-stat,
        .freelancer-contract-card {
            padding: 20px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
        }

        .freelancer-contract-stat strong {
            display: block;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 1.8rem;
            line-height: 1;
        }

        .freelancer-contract-stat span {
            color: #64748b;
            font-weight: 600;
        }

        .freelancer-contract-list {
            display: grid;
            gap: 18px;
        }

        .freelancer-contract-top {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: start;
            margin-bottom: 12px;
        }

        .freelancer-contract-top h2 {
            margin: 0 0 8px;
            color: #0f172a;
            font-size: 1.35rem;
        }

        .freelancer-contract-meta,
        .freelancer-payment-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }

        .freelancer-contract-meta div,
        .freelancer-payment-card {
            padding: 14px 16px;
            border-radius: 18px;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .freelancer-contract-meta span,
        .freelancer-payment-card span {
            display: block;
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 0.74rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .freelancer-contract-meta strong,
        .freelancer-payment-card strong {
            color: #0f172a;
        }

        .freelancer-contract-status {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.9rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: capitalize;
        }

        .status-active {
            background: rgba(15, 118, 110, 0.12);
            color: #0f766e;
        }

        .status-completed {
            background: rgba(37, 99, 235, 0.12);
            color: #2563eb;
        }

        .status-terminated {
            background: rgba(148, 163, 184, 0.18);
            color: #475569;
        }

        .freelancer-contract-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .freelancer-contract-actions .button,
        .freelancer-contract-actions .button.gray {
            min-height: 46px;
            border-radius: 14px;
            padding: 0 18px;
        }

        .freelancer-contract-actions .button.gray {
            background: #e2e8f0;
            color: #0f172a;
        }

        .freelancer-contract-payments {
            margin-top: 18px;
            display: grid;
            gap: 12px;
        }

        .freelancer-contract-empty {
            padding: 28px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.14);
            text-align: center;
            color: #64748b;
        }
    </style>

    <div class="freelancer-contracts-shell">
        <section class="freelancer-contracts-hero">
            <div>
                <h1>Delivery Workspace</h1>
                <p>Track every accepted contract, see which client and project are active, and monitor related payments from one clear freelancer operations screen.</p>
            </div>
        </section>

        <section class="freelancer-contract-stats">
            <div class="freelancer-contract-stat">
                <strong>{{ number_format($stats['total']) }}</strong>
                <span>Total contracts</span>
            </div>
            <div class="freelancer-contract-stat">
                <strong>{{ number_format($stats['active']) }}</strong>
                <span>Active contracts</span>
            </div>
            <div class="freelancer-contract-stat">
                <strong>{{ number_format($stats['completed']) }}</strong>
                <span>Completed</span>
            </div>
            <div class="freelancer-contract-stat">
                <strong>{{ number_format($stats['terminated']) }}</strong>
                <span>Terminated</span>
            </div>
        </section>

        @if ($contracts->isNotEmpty())
            <section class="freelancer-contract-list">
                @foreach ($contracts as $contract)
                    @php
                        $statusClass = $contract->status === 'active'
                            ? 'status-active'
                            : ($contract->status === 'completed' ? 'status-completed' : 'status-terminated');
                        $projectPayments = $paymentsByProject->get($contract->project_id, collect());
                    @endphp
                    <div class="freelancer-contract-card">
                        <div class="freelancer-contract-top">
                            <div>
                                <h2>{{ $contract->project->title ?? 'Project unavailable' }}</h2>
                                <div style="color:#64748b;">
                                    Client: {{ $contract->project->user->name ?? 'Unknown client' }}
                                </div>
                            </div>
                            <span class="freelancer-contract-status {{ $statusClass }}">{{ $contract->status }}</span>
                        </div>

                        <div class="freelancer-contract-meta">
                            <div>
                                <span>Contract Value</span>
                                <strong>${{ number_format((float) $contract->cost, 0) }}</strong>
                            </div>
                            <div>
                                <span>Type</span>
                                <strong>{{ ucfirst($contract->type) }}</strong>
                            </div>
                            <div>
                                <span>Start</span>
                                <strong>{{ optional($contract->start_on)->format('M d, Y') ?: 'Not set' }}</strong>
                            </div>
                            <div>
                                <span>End</span>
                                <strong>{{ optional($contract->end_on)->format('M d, Y') ?: 'Not set' }}</strong>
                            </div>
                        </div>

                        @if ($projectPayments->isNotEmpty())
                            <div class="freelancer-contract-payments">
                                @foreach ($projectPayments->take(3) as $payment)
                                    <div class="freelancer-payment-row">
                                        <div class="freelancer-payment-card">
                                            <span>Payment Reference</span>
                                            <strong>{{ $payment->reference_id }}</strong>
                                        </div>
                                        <div class="freelancer-payment-card">
                                            <span>Status</span>
                                            <strong>{{ ucfirst($payment->status) }}</strong>
                                        </div>
                                        <div class="freelancer-payment-card">
                                            <span>Amount</span>
                                            <strong>${{ number_format((float) $payment->amount, 0) }}</strong>
                                        </div>
                                        <div class="freelancer-payment-card">
                                            <span>Created</span>
                                            <strong>{{ $payment->created_at->diffForHumans() }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="freelancer-contract-actions">
                            @if ($contract->project)
                                <a href="{{ route('projects.show', $contract->project) }}" class="button ripple-effect" style="background:#0f172a;">
                                    Open Project
                                </a>
                                <a href="{{ route('messages', ['recipient_id' => $contract->project->user_id]) }}" class="button gray ripple-effect">
                                    Message Client
                                </a>
                            @endif
                            <a href="{{ route('freelancer.proposals.index') }}" class="button gray ripple-effect">
                                Back to Proposals
                            </a>
                        </div>
                    </div>
                @endforeach
            </section>

            @if ($contracts->hasPages())
                <div>{{ $contracts->links() }}</div>
            @endif
        @else
            <div class="freelancer-contract-empty">
                No contracts yet. Once a client accepts your proposal, the delivery workspace will start tracking the contract and any related payments here.
            </div>
        @endif
    </div>
</x-app-layout>
