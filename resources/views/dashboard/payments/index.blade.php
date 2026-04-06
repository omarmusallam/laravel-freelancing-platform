@extends('layouts.dashboard')

@section('title', 'Payments')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-md-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>Pending Payments</p>
                </div>
                <div class="icon"><i class="fas fa-hourglass-half"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['success'] }}</h3>
                    <p>Successful Payments</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['failed'] }}</h3>
                    <p>Failed Payments</p>
                </div>
                <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>${{ number_format($stats['volume'], 0) }}</h3>
                    <p>Successful Volume</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.payments.index') }}" method="get" class="row">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" value="{{ $query }}" placeholder="Search by reference or user">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="success" @selected($status === 'success')>Success</option>
                        <option value="failed" @selected($status === 'failed')>Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="gateway" class="form-control" value="{{ $gateway }}" placeholder="Filter by gateway">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>User</th>
                        <th>Gateway</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->reference_id }}</td>
                            <td>{{ $payment->user->email ?? 'Guest / deleted user' }}</td>
                            <td>{{ $payment->gateway }}</td>
                            <td>{{ ucfirst($payment->status) }}</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $payments->links() }}</div>
@endsection
