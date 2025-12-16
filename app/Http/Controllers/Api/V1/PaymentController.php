<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\PaymentCompleted;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Throwable;

class PaymentController extends Controller
{
    use ApiResponse;
    public function pay(Request $request, int $orderId)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);
        $order = Order::findOrFail($orderId);
        Stripe::setApiKey(config('services.stripe.secret'));
        DB::beginTransaction();
        try {
            $intent = PaymentIntent::create([
                'amount' => (int) $order->total * 100,
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'confirm' => true,
            ]);
            $payment = Payment::create([
                'order_id' => $order->id,
                'provider' => 'stripe',
                'status' => 'succeeded',
                'transaction_id' => $intent->id,
                'meta' => $intent->toArray(),
            ]);
            $order->update(['status' => 'paid']);
            DB::commit();
            $this->success($payment);
        } catch (Throwable $e) {
            Db::rollBack();
            return $this->error($e->getMessage());
        }
    }
     public function checkout(Request $request)
    { 
        $paymentData = [
            'amount' => $request->amount,
            'user_id' => Auth::user()->id,
            'status' => 'success'
        ];

        event(new PaymentCompleted($paymentData));

        return response()->json([
            'status' => true,
            'message' => 'Payment completed successfully',
            'data' => $paymentData
        ], 200);
    }
}
