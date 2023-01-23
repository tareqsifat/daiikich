<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WalletTransactionHistory extends Model
{
    public static function saveTransactionHistory($request){
        $user = new WalletTransactionHistory();
        $user->wallet_address = $request->wallet_address;
        $user->user_id = $request->user_id;
        $user->balance = $request->balance;
        $user->transaction_id = $request->transaction_id;
        $seller = Seller::where('user_id',Auth::user()->id)->first();
        $seller->token_amount -= $request->balance;
        $user->save();
        $seller->save();
    }
}
