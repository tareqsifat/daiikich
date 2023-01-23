<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Controller;
use App\Models\AffiliateUser;
use App\Models\CombinedOrder;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use Session;
use Auth;

class TokenController extends Controller
{
    public function pay(){

        if(Session::has('token_type'))
        {
            if(Session::has('token_type') == 'token_payment')
            {
                $aff_user=AffiliateUser::where('user_id',Auth::user()->id)->first();
                $total_balance=(($aff_user->balance+$aff_user->mlm_balance)*0.25);
                $user = Auth::user();
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                if ($total_balance >= $combined_order->grand_total) {
                    $aff_user->total_balance -= $combined_order->grand_total;
                    $aff_user->token_withdraw_balance += $combined_order->grand_total;
                    $aff_user->save();
                    return (new CheckoutController)->checkout_done($combined_order->id, null);
                }
            }
        }
        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment'){
                $user = Auth::user();
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                if ($user->balance >= $combined_order->grand_total) {
                    $user->balance -= $combined_order->grand_total;
                    $user->save();
                    return (new CheckoutController)->checkout_done($combined_order->id, null);
                }
            }

            elseif (Session::get('payment_type') == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);
                $amount = $customer_package->amount;
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
                $amount = $seller_package->amount;
            }
        }
    }
}
