<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\userSubscription;
use Auth;
use Carbon\Carbon;
use Str;
use Midtrans;

class SubscriptionPlanController extends Controller
{

    public function __construct(){
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = false;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = false;
    }

    public function index()
    {
        return inertia('User/Dashboard/SubscriptionPlan/Index',[
            'subscriptionPlans' => SubscriptionPlan::all(),
        ]);
    }

    public function userSubscribe(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $data = [
            'user_id'=>Auth::id(),
            'subscription_plan_id'=> $subscriptionPlan->id,
            'price' => $subscriptionPlan->price,
            // 'expired_date'=>Carbon::now()->addMonths($subscriptionPlan->active_periode_in_months),
            'payment_status'=>'pending'
        ];
        $userSubscription = UserSubscription::create($data);

        $params = [
            'transaction_details' => [
                'order_id' => $userSubscription->id.'-'.Str::random(5),
                'gross_amount' => $userSubscription->price
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return redirect(route('user.dashboard.index'));
    }
}
