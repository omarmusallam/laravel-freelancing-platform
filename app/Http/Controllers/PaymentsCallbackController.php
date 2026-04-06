<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\Thawani;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentsCallbackController extends Controller
{
    public function success()
    {
        $payment_id = Session::get('payment_id');
        $session_id = Session::get('session_id');
        if (!$payment_id && !$session_id) {
            abort(404);
        }

        $payment = Payment::findOrFail($payment_id);
        if ($payment->reference_id !== $session_id) {
            abort(404);
        }

        if ($payment->status === 'success') {
            Session::forget(['payment_id', 'session_id']);

            return redirect()
                ->route('home')
                ->with('success', 'Payment already confirmed successfully.');
        }

        $client = new Thawani(
            config('services.thawani.secret_key'),
            config('services.thawani.publishable_key'),
            'test'
        );

        try {
            $response = $client->getCheckoutSession($session_id);
            if (($response['data']['payment_status'] ?? null) === 'paid') {
                $payment->status = 'success';
                $payment->data = $response;
                $payment->save();

                Session::forget(['payment_id', 'session_id']);

                return redirect()
                    ->route('home')
                    ->with('success', 'Payment completed successfully.');
            }
        } catch (Exception $e) {
            Log::error('Payment success callback failed.', [
                'payment_id' => $payment->id,
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('home')
            ->with('warning', 'Payment is still pending confirmation.');
    }

    public function cancel()
    {
        $payment_id = Session::get('payment_id');
        $session_id = Session::get('session_id');
        if (!$payment_id && !$session_id) {
            abort(404);
        }

        $payment = Payment::findOrFail($payment_id);
        if ($payment->reference_id !== $session_id) {
            abort(404);
        }

        $payment->status = 'failed';
        $payment->save();

        Session::forget(['payment_id', 'session_id']);

        return redirect()
            ->route('home')
            ->with('error', 'Payment was cancelled or failed.');
    }
}
