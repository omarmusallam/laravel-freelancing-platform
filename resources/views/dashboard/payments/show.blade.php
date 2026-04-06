@extends('layouts.dashboard')

@section('title', 'Manage Payment')

@section('content')
    <x-flash-message />

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Payment Review Desk</h5>
                        <p class="text-muted mb-0">Verify the transaction, standardize gateway details, and keep the ledger clean.</p>
                    </div>
                    <div class="d-flex flex-wrap mt-2 mt-lg-0">
                        @if ($payment->user)
                            <a href="{{ route('dashboard.users.edit', $payment->user) }}" class="btn btn-outline-primary mr-2 mb-2">Open User</a>
                        @endif
                        <a href="{{ route('dashboard.payments.index', ['gateway' => $payment->gateway]) }}" class="btn btn-outline-info mb-2">Same Gateway</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.payments.update', $payment) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="pending" @selected(old('status', $payment->status) === 'pending')>Pending</option>
                                    <option value="success" @selected(old('status', $payment->status) === 'success')>Success</option>
                                    <option value="failed" @selected(old('status', $payment->status) === 'failed')>Failed</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gateway">Gateway</label>
                                <input type="text" class="form-control" id="gateway" name="gateway" value="{{ old('gateway', $payment->gateway) }}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="amount">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reference_id">Reference ID</label>
                            <input type="text" class="form-control" id="reference_id" name="reference_id" value="{{ old('reference_id', $payment->reference_id) }}" required>
                        </div>

                        <button class="btn btn-primary">Save Payment</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Snapshot</h3>
                </div>
                <div class="card-body">
                    <p><strong>User:</strong> {{ $payment->user->name ?? 'Guest / deleted user' }}</p>
                    <p><strong>Email:</strong> {{ $payment->user->email ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
                    <p><strong>Gateway:</strong> {{ $payment->gateway }}</p>
                    <p><strong>Created:</strong> {{ $payment->created_at->diffForHumans() }}</p>
                    <p><strong>Updated:</strong> {{ $payment->updated_at->diffForHumans() }}</p>
                    <p class="mb-2"><strong>Stored data:</strong></p>
                    <pre class="bg-light p-3 rounded mb-0" style="max-height: 280px; overflow:auto;">{{ json_encode($payment->data ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        </div>
    </div>
@endsection
