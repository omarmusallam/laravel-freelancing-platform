@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div class="mb-3 mb-lg-0">
                <div class="admin-shell-chip mb-3">
                    <i class="fas fa-chart-line"></i>
                    <span>Executive Overview</span>
                </div>
                <h4 class="mb-2">Marketplace operations are now centralized in one control surface.</h4>
                <p class="dashboard-surface-muted mb-0">Use this dashboard to review demand, process decisions, track payment health, and move quickly between the platform's active queues.</p>
            </div>
            <div class="d-flex flex-wrap">
                <a href="{{ route('dashboard.projects.index', ['status' => 'open']) }}" class="btn btn-primary mr-2 mb-2">Review Demand</a>
                <a href="{{ route('dashboard.contracts.index', ['status' => 'active']) }}" class="btn btn-dark mr-2 mb-2">Manage Delivery</a>
                <a href="{{ route('dashboard.payments.index', ['status' => 'pending']) }}" class="btn btn-info mb-2">Check Payments</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['projects'] }}</h3>
                    <p>Total Projects</p>
                </div>
                <div class="icon"><i class="fas fa-briefcase"></i></div>
                <a href="{{ route('dashboard.projects.index') }}" class="small-box-footer">Manage Projects <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['users'] }}</h3>
                    <p>Platform Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">Manage Users <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['proposals'] }}</h3>
                    <p>Total Proposals</p>
                </div>
                <div class="icon"><i class="fas fa-file-signature"></i></div>
                <a href="{{ route('dashboard.proposals.index') }}" class="small-box-footer">Review Proposals <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['contracts'] }}</h3>
                    <p>Total Contracts</p>
                </div>
                <div class="icon"><i class="fas fa-file-contract"></i></div>
                <a href="{{ route('dashboard.contracts.index') }}" class="small-box-footer">Manage Contracts <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div class="mb-2">
                        <h5 class="mb-1">Operations Overview</h5>
                        <p class="text-muted mb-0">Track marketplace activity, intervene quickly, and review the latest operational signals.</p>
                    </div>
                    <div class="d-flex flex-wrap">
                        <a href="{{ route('dashboard.projects.index', ['status' => 'open']) }}" class="btn btn-outline-primary mr-2 mb-2">Open Projects</a>
                        <a href="{{ route('dashboard.proposals.index') }}" class="btn btn-outline-success mr-2 mb-2">Proposal Queue</a>
                        <a href="{{ route('dashboard.contracts.index', ['status' => 'active']) }}" class="btn btn-outline-dark mr-2 mb-2">Active Contracts</a>
                        <a href="{{ route('dashboard.payments.index', ['status' => 'pending']) }}" class="btn btn-outline-info mr-2 mb-2">Pending Payments</a>
                        <a href="{{ route('dashboard.messages.index') }}" class="btn btn-outline-secondary mb-2">Inbox Review</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Operational Alerts</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Unread messages</span>
                        <strong>{{ $stats['unread_messages'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Pending payments</span>
                        <strong>{{ $stats['pending_payments'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Failed payments</span>
                        <strong>{{ $stats['failed_payments'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Projects in progress</span>
                        <strong>{{ $stats['in_progress_projects'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>Accepted proposals</span>
                        <strong>{{ $stats['accepted_proposals'] }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Marketplace Health</h3>
                </div>
                <div class="card-body">
                    <div class="progress-group">
                        Open Projects
                        <span class="float-right"><b>{{ $stats['open_projects'] }}</b>/{{ $stats['projects'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: {{ $stats['projects'] > 0 ? round(($stats['open_projects'] / $stats['projects']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="progress-group mt-3">
                        Active Contracts
                        <span class="float-right"><b>{{ $stats['active_contracts'] }}</b>/{{ $stats['contracts'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-dark" style="width: {{ $stats['contracts'] > 0 ? round(($stats['active_contracts'] / $stats['contracts']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="progress-group mt-3">
                        Completed Contracts
                        <span class="float-right"><b>{{ $stats['completed_contracts'] }}</b>/{{ $stats['contracts'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: {{ $stats['contracts'] > 0 ? round(($stats['completed_contracts'] / $stats['contracts']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="progress-group mt-3">
                        Successful Payments
                        <span class="float-right"><b>{{ $stats['payments'] - $stats['pending_payments'] - $stats['failed_payments'] }}</b>/{{ $stats['payments'] }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" style="width: {{ $stats['payments'] > 0 ? round((($stats['payments'] - $stats['pending_payments'] - $stats['failed_payments']) / $stats['payments']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Action Queue</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($actionQueue as $item)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>{{ $item['label'] }}</strong>
                                        <span class="badge badge-{{ $item['variant'] }}">{{ $item['count'] }}</span>
                                    </div>
                                    <p class="text-muted mb-3">{{ $item['description'] }}</p>
                                    <a href="{{ $item['url'] }}" class="btn btn-sm btn-outline-{{ $item['variant'] }}">Open Queue</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['payments'] }}</h3>
                    <p>Payments</p>
                </div>
                <div class="icon"><i class="fas fa-credit-card"></i></div>
                <a href="{{ route('dashboard.payments.index') }}" class="small-box-footer">Manage Payments <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['messages'] }}</h3>
                    <p>Messages</p>
                </div>
                <div class="icon"><i class="fas fa-comments"></i></div>
                <a href="{{ route('dashboard.messages.index') }}" class="small-box-footer">Review Messages <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $stats['active_contracts'] }}</h3>
                    <p>Active Contracts</p>
                </div>
                <div class="icon"><i class="fas fa-briefcase"></i></div>
                <a href="{{ route('dashboard.contracts.index', ['status' => 'active']) }}" class="small-box-footer">Track Active Work <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>${{ number_format($stats['payment_volume'], 0) }}</h3>
                    <p>Successful Payment Volume</p>
                </div>
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                @if (auth('admin')->user()->super_admin)
                    <a href="{{ route('dashboard.admins.index') }}" class="small-box-footer">Manage Admins <i class="fas fa-arrow-circle-right"></i></a>
                @else
                    <a href="{{ route('dashboard.payments.index', ['status' => 'success']) }}" class="small-box-footer">View Successful Payments <i class="fas fa-arrow-circle-right"></i></a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Projects</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Budget</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->user->name ?? 'Deleted user' }}</td>
                                    <td><span class="badge badge-{{ $project->status === 'open' ? 'success' : ($project->status === 'closed' ? 'secondary' : 'warning') }}">{{ ucfirst($project->status) }}</span></td>
                                    <td>${{ number_format($project->budget ?? 0, 0) }}</td>
                                    <td><a href="{{ route('dashboard.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Open</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No projects yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Platform Snapshot</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Open projects</span>
                        <strong>{{ $stats['open_projects'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Closed projects</span>
                        <strong>{{ $stats['closed_projects'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Contracts</span>
                        <strong>{{ $stats['contracts'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Payments</span>
                        <strong>{{ $stats['payments'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Messages</span>
                        <strong>{{ $stats['messages'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Categories</span>
                        <strong>{{ $stats['categories'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>Roles</span>
                        <strong>{{ $stats['roles'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Newest Users</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->implode(', ') ?: 'No roles' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No users yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Proposals</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Freelancer</th>
                                <th>Project</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentProposals as $proposal)
                                <tr>
                                    <td>{{ $proposal->freelancer->name ?? 'Unknown' }}</td>
                                    <td>{{ $proposal->project->title ?? 'Deleted project' }}</td>
                                    <td>{{ ucfirst($proposal->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No proposals yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Contracts</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Freelancer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentContracts as $contract)
                                <tr>
                                    <td>{{ $contract->project->title ?? 'Deleted project' }}</td>
                                    <td>{{ $contract->freelancer->name ?? 'Unknown' }}</td>
                                    <td>{{ ucfirst($contract->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No contracts yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Payments</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPayments as $payment)
                                <tr>
                                    <td>{{ $payment->reference_id }}</td>
                                    <td>{{ $payment->user->name ?? 'Guest / deleted user' }}</td>
                                    <td>{{ ucfirst($payment->status) }}</td>
                                    <td>${{ number_format($payment->amount, 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No payments yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Messages</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Sender</th>
                                <th>Recipient</th>
                                <th>Preview</th>
                                <th>Status</th>
                                <th>Sent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentMessages as $message)
                                <tr>
                                    <td>{{ $message->sender->name ?? 'Deleted user' }}</td>
                                    <td>{{ $message->recipient->name ?? 'Deleted user' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($message->message, 90) }}</td>
                                    <td>
                                        @if ($message->read_at)
                                            <span class="badge badge-success">Read</span>
                                        @else
                                            <span class="badge badge-warning">Unread</span>
                                        @endif
                                    </td>
                                    <td>{{ $message->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No messages yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Live Activity Feed</h3>
                </div>
                <div class="card-body">
                    @forelse ($activityFeed as $activity)
                        <div class="d-flex align-items-start border-bottom py-3">
                            <div class="mr-3">
                                <span class="btn btn-sm btn-{{ $activity['variant'] }} disabled">
                                    <i class="{{ $activity['icon'] }}"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <strong>{{ $activity['title'] }}</strong>
                                    <span class="text-muted">{{ $activity['time']->diffForHumans() }}</span>
                                </div>
                                <div>{{ $activity['meta'] }}</div>
                                <div class="text-muted">{{ $activity['description'] }}</div>
                            </div>
                            <div class="ml-3">
                                <a href="{{ $activity['url'] }}" class="btn btn-sm btn-outline-secondary">Open</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No activity recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
