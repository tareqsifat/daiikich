<?php

namespace App\Http\Controllers\Seller;

use App\Models\AffiliateTokenTransfer;
use App\Models\AffiliateUser;
use App\Models\Seller;
use App\Models\TotalConvert;
use App\Models\User;
use App\Models\WalletTransactionHistory;
use Illuminate\Http\Request;
use App\Models\SellerWithdrawRequest;
use Auth;

class SellerWithdrawRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller_withdraw_requests = SellerWithdrawRequest::where('user_id', Auth::user()->id)->latest()->paginate(9);
        return view('seller.money_withdraw_requests.index', compact('seller_withdraw_requests'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller_withdraw_request = new SellerWithdrawRequest;
        $seller_withdraw_request->user_id = Auth::user()->id;
        $seller_withdraw_request->amount = $request->amount;
        $seller_withdraw_request->message = $request->message;
        $seller_withdraw_request->status = '0';
        $seller_withdraw_request->viewed = '0';
        if ($seller_withdraw_request->save()) {
            flash(translate('Request has been sent successfully'))->success();
            return redirect()->route('seller.money_withdraw_requests.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function transferSellerWallet(){
        return view('seller.transfer_seller_wallet');
    }

    public function saveTransferSellerWallet(Request $request){

        $request->validate([
            'wallet_address' => 'required',
            'user_id' => 'required',
            'balance' => 'required',
            'transaction_id' => 'required',
        ]);

        if (\App\Models\Seller::where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->value('token_amount')<$request->balance)
        {
            flash(translate('Please enter less amount than available token balance'))->error();
        }
        else{
            WalletTransactionHistory::saveTransactionHistory($request);
            flash(translate('Transaction Request Accepted'))->success();
        }
        return back();

    }

    public function total_convert_history(){
        $history = AffiliateTokenTransfer::where('transfer_user_id',Auth::user()->id)->get();
        return view('seller.token_history.total_history',compact('history'));
    }

    public function total_history_status_approve($id){
        $seller = Seller::where('user_id',Auth::user()->id)->first();
        $seller->token_amount += AffiliateTokenTransfer::where('id',$id)->value('amount');
        $seller->save();
        $user_id = AffiliateTokenTransfer::where('id',$id)->first();
        $user_id->status = 1;
        $user_id->save();
        flash(translate('Request Approved'))->success();
        return back();
    }

    public function total_history_status_reject($id){
        $user_id = AffiliateTokenTransfer::where('id',$id)->first();
        $affiliate_user = AffiliateUser::where('user_id',$user_id->user_id)->first();
        $affiliate_user->total_convert_balance = $affiliate_user->total_balance + $user_id->amount;
        $affiliate_user->save();
        $user_id->status = 2;
        $user_id->save();
        flash(translate('Request Rejected'))->success();
        return back();
    }
}
