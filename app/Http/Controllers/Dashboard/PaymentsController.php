<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $gateway = trim((string) $request->input('gateway', ''));
        $query = trim((string) $request->input('q', ''));

        $payments = Payment::with('user')
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($paymentQuery) use ($query) {
                    $paymentQuery->where('reference_id', 'like', '%' . $query . '%')
                        ->orWhereHas('user', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        });
                });
            })
            ->when(in_array($status, ['pending', 'success', 'failed'], true), function ($builder) use ($status) {
                $builder->where('status', $status);
            })
            ->when($gateway !== '', function ($builder) use ($gateway) {
                $builder->where('gateway', 'like', '%' . $gateway . '%');
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'pending' => Payment::where('status', 'pending')->count(),
            'success' => Payment::where('status', 'success')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'volume' => Payment::where('status', 'success')->sum('amount'),
        ];

        return view('dashboard.payments.index', [
            'payments' => $payments,
            'status' => $status,
            'gateway' => $gateway,
            'query' => $query,
            'stats' => $stats,
        ]);
    }

    public function show(Payment $payment)
    {
        return view('dashboard.payments.show', [
            'payment' => $payment->load('user'),
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'success', 'failed'])],
            'gateway' => ['required', 'string', 'max:255'],
            'reference_id' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $payment->update($data);

        return redirect()
            ->route('dashboard.payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }
}
