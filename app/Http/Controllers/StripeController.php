<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function stripePost(Request $request) {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'currency' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if($request->type == 'card') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $intent = $stripe->paymentIntents->create([
                'amount' => $request->amount, 
                'currency' => $request->currency,
                'payment_method_types' => ['card']
            ]);

            return response()->json([
                'success' => true,
                'client_secret' => $intent->client_secret
            ], 200);
        }

        return response()->json(['error', 'Payment method is only available for cards.'], 200);
    }
}
