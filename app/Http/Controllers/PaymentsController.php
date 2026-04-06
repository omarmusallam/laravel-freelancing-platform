<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Payment;
use App\Services\Payments\Thawani;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    public function create(Request $request)
    {
        $contractId = (int) $request->query('contract', 0);
        $contract = null;
        $paymentAmount = 200;
        $productName = 'Platform Payment';
        $referenceLabel = 'Marketplace Payment';
        $metadata = [];

        if ($contractId) {
            $contract = Contract::with(['project.user', 'freelancer'])
                ->whereKey($contractId)
                ->firstOrFail();

            abort_unless((int) $contract->project?->user_id === (int) Auth::id(), 403);

            $paymentAmount = (float) $contract->cost;
            $productName = 'Contract payment for ' . ($contract->project->title ?? 'project');
            $referenceLabel = 'Contract #' . $contract->id;
            $metadata = [
                'project_id' => $contract->project_id,
                'contract_id' => $contract->id,
                'proposal_id' => $contract->proposal_id,
                'project_title' => $contract->project->title ?? null,
                'freelancer_name' => $contract->freelancer->name ?? null,
            ];
        }

        $client = new Thawani(
            config('services.thawani.secret_key'),
            config('services.thawani.publishable_key'),
            'test'
        );

        $data = [
            'client_reference_id' => $referenceLabel,
            'mode' => 'payment',
            'products' => [
                [
                    'name' => $productName,
                    'unit_amount' => (int) round($paymentAmount * 1000),
                    'quantity' => 1,
                ],
            ],
            'success_url' => route('payments.success'),
            'cancel_url' => route('payments.cancel'),
        ];

        try {
            $session_id = $client->createCheckoutSession($data);

            $payment = Payment::forceCreate([
                'user_id' => Auth::id(),
                'gateway' => 'thawani',
                'reference_id' => $session_id,
                'amount' => $paymentAmount,
                'status' => 'pending',
                'data' => $metadata,
            ]);

            Session::put('payment_id', $payment->id);
            Session::put('session_id', $session_id);

            return redirect()->away($client->getPayUrl($session_id));
        } catch (Exception $e) {
            Log::error('Unable to create payment checkout session.', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('home')
                ->with('error', 'Unable to start the payment session right now.');
        }
    }
}
