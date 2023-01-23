<?php

namespace App\Http\Controllers;

use App\Models\AffiliateTokenTransfer;
use App\Models\BusinessSetting;
use App\Models\Rank;
use App\Models\ReferralEarning;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Models\AffiliateOption;
use App\Models\Order;
use App\Models\AffiliateConfig;
use App\Models\AffiliateUser;
use App\Models\AffiliatePayment;
use App\Models\AffiliateWithdrawRequest;
use App\Models\AffiliateLog;
use App\Models\AffiliateStats;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Tree;
use App\Models\Product;
use Auth;
use DB;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;

class AffiliateController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:affiliate_registration_form_config'])->only('configs');
        $this->middleware(['permission:affiliate_configurations'])->only('index');
        $this->middleware(['permission:view_affiliate_users'])->only('users');
        $this->middleware(['permission:pay_to_affiliate_user'])->only('payment_modal');
        $this->middleware(['permission:affiliate_users_payment_history'])->only('payment_history');
        $this->middleware(['permission:view_all_referral_users'])->only('refferal_users');
        $this->middleware(['permission:view_affiliate_withdraw_requests'])->only('affiliate_withdraw_requests');
        $this->middleware(['permission:accept_affiliate_withdraw_requests'])->only('affiliate_withdraw_modal');
        $this->middleware(['permission:reject_affiliate_withdraw_request'])->only('reject_withdraw_request');
        $this->middleware(['permission:view_affiliate_logs'])->only('affiliate_logs_admin');
    }

    //
    public function index()
    {
        return view('affiliate.index');
    }

    public function affiliate_option_store(Request $request)
    {
        //dd($request->all());
        $affiliate_option = AffiliateOption::where('type', $request->type)->first();
        if ($affiliate_option == null) {
            $affiliate_option = new AffiliateOption;
        }
        $affiliate_option->type = $request->type;

        $commision_details = array();
        if ($request->type == 'user_registration_first_purchase') {
            $affiliate_option->percentage = $request->percentage;
        } elseif ($request->type == 'product_sharing') {
            $commision_details['commission'] = $request->amount;
            $commision_details['commission_type'] = $request->amount_type;
        } elseif ($request->type == 'category_wise_affiliate') {
            foreach (Category::all() as $category) {
                $data['category_id'] = $request['categories_id_' . $category->id];
                $data['commission'] = $request['commison_amounts_' . $category->id];
                $data['commission_type'] = $request['commison_types_' . $category->id];
                array_push($commision_details, $data);
            }
        } elseif ($request->type == 'max_affiliate_limit') {
            $affiliate_option->percentage = $request->percentage;
        }
        $affiliate_option->details = json_encode($commision_details);

        if ($request->has('status')) {
            $affiliate_option->status = 1;
            if ($request->type == 'product_sharing') {
                $affiliate_option_status_update = AffiliateOption::where('type', 'category_wise_affiliate')->first();
                $affiliate_option_status_update->status = 0;
                $affiliate_option_status_update->save();
            }
            if ($request->type == 'category_wise_affiliate') {
                $affiliate_option_status_update = AffiliateOption::where('type', 'product_sharing')->first();
                $affiliate_option_status_update->status = 0;
                $affiliate_option_status_update->save();
            }
        } else {
            $affiliate_option->status = 0;
        }
        $affiliate_option->save();

        flash("This has been updated successfully")->success();
        return back();
    }

    public function configs()
    {
        return view('affiliate.configs');
    }

    public function config_store(Request $request)
    {
        if ($request->type == 'validation_time') {
            //affiliate validation time
            $affiliate_config = AffiliateConfig::where('type', $request->type)->first();
            if ($affiliate_config == null) {
                $affiliate_config = new AffiliateConfig;
            }
            $affiliate_config->type = $request->type;
            $affiliate_config->value = $request[$request->type];
            $affiliate_config->save();

            flash("Validation time updated successfully")->success();
        } else {

            $form = array();
            $select_types = ['select', 'multi_select', 'radio'];
            $j = 0;
            for ($i = 0; $i < count($request->type); $i++) {
                $item['type'] = $request->type[$i];
                $item['label'] = $request->label[$i];
                if (in_array($request->type[$i], $select_types)) {
                    $item['options'] = json_encode($request['options_' . $request->option[$j]]);
                    $j++;
                }
                array_push($form, $item);
            }
            $affiliate_config = AffiliateConfig::where('type', 'verification_form')->first();
            $affiliate_config->value = json_encode($form);

            flash("Verification form updated successfully")->success();
        }
        if ($affiliate_config->save()) {
            return back();
        }
    }

    public function apply_for_affiliate(Request $request)
    {
        if (Auth::check() && AffiliateUser::where('user_id', Auth::user()->id)->first() != null) {
            flash(translate("You are already an affiliate user!"))->warning();
            return back();
        }
//dd($request->referral_code);
        if ($request->has('referral_code') && addon_is_activated('affiliate_system')) {
            try {
                $affiliate_validation_time = AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }

                Cookie::queue('referral_code', $request->referral_code, $cookie_minute);
                $referred_by_user = User::where('referral_code', $request->referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);


            } catch (\Exception $e) {
            }
        }

        return view('affiliate.frontend.apply_for_affiliate');
    }

    public function affiliate_logs_admin()
    {
        $affiliate_logs = AffiliateLog::latest()->paginate(10);
        return view('affiliate.affiliate_logs', compact('affiliate_logs'));
    }

    public function store_affiliate_user(Request $request)
    {
        if (!Auth::check()) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists!'))->error();
                return back();
            }
            if ($request->password == $request->password_confirmation) {


                $referred_by_user = User::where('referral_code', $request->referral_code)->first();
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->user_type = "customer";
                $user->password = Hash::make($request->password);
                $user->referred_by = $referred_by_user->id;

                $user->save();

                if (Cookie::has('referral_code')) {
                    $referral_code = Cookie::get('referral_code');;
                    $referred_by_user = User::where('referral_code', $referral_code)->first();

                    $tree = new Tree();
                    $tree->user_id = $user->id;
                    $tree->referral_id = $referred_by_user->id;
                    $tree->level_type = 1;
                    $tree->save();


                    if ($referred_by_user->referred_by != null) {
                        $second_level_user = User::where('id', $referred_by_user->referred_by)->first();

                        $tree = new Tree();
                        $tree->user_id = $user->id;
                        $tree->referral_id = $second_level_user->id;
                        $tree->level_type = 2;
                        $tree->save();

                    }
                    if ($referred_by_user->referred_by != null && $second_level_user->referred_by != null) {

                        $third_level_user = User::where('id', $second_level_user->referred_by)->first();
                        $tree = new Tree();
                        $tree->user_id = $user->id;
                        $tree->referral_id = $third_level_user->id;
                        $tree->level_type = 3;
                        $tree->save();

                    }
                    if ($referred_by_user->referred_by != null && $second_level_user->referred_by != null && $third_level_user->referred_by != null) {
                        $fourth_level_user = User::where('id', $third_level_user->referred_by)->first();
                        $tree = new Tree();
                        $tree->user_id = $user->id;
                        $tree->referral_id = $fourth_level_user->id;
                        $tree->level_type = 4;
                        $tree->save();

                    }
                }

                auth()->login($user, false);

                if (get_setting('email_verification') != 1) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                } else {
                    event(new Registered($user));
                }
            } else {
                flash(translate('Sorry! Password did not match.'))->error();
                return back();
            }
        }

        $affiliate_user = Auth::user()->affiliate_user;

        if ($affiliate_user == null) {
            $affiliate_user = new AffiliateUser;
            $affiliate_user->user_id = Auth::user()->id;

        }
        $data = array();
        $i = 0;
        foreach (json_decode(AffiliateConfig::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_' . $i]);
            } elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i]->store('uploads/affiliate_verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $affiliate_user->informations = json_encode($data);
        if ($affiliate_user->save()) {
            flash(translate('Your verification request has been submitted successfully!'))->success();
            return redirect()->route('home');
        }

        //Modify here
        Cookie::forget('referral_code');
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function users()
    {
        $affiliate_users = AffiliateUser::paginate(12);
        return view('affiliate.users ', compact('affiliate_users'));
    }

    public function show_verification_request($id)
    {
        $affiliate_user = AffiliateUser::findOrFail($id);
        return view('affiliate.show_verification_request', compact('affiliate_user'));
    }

    public function approve_user($id)
    {
        $affiliate_user = AffiliateUser::findOrFail($id);
        $affiliate_user->status = 1;
        if ($affiliate_user->save()) {
            flash(translate('Affiliate user has been approved successfully'))->success();
            return redirect()->route('affiliate.users');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function reject_user($id)
    {
        $affiliate_user = AffiliateUser::findOrFail($id);
        $affiliate_user->status = 0;
        $affiliate_user->informations = null;
        if ($affiliate_user->save()) {
            flash(translate('Affiliate user request has been rejected successfully'))->success();
            return redirect()->route('affiliate.users');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function updateApproved(Request $request)
    {
        $affiliate_user = AffiliateUser::findOrFail($request->id);
        $affiliate_user->status = $request->status;
        if ($affiliate_user->save()) {
            return 1;
        }
        return 0;
    }

    public function payment_modal(Request $request)
    {
        $affiliate_user = AffiliateUser::findOrFail($request->id);
        return view('affiliate.payment_modal', compact('affiliate_user'));
    }

    public function payment_store(Request $request)
    {
        $affiliate_payment = new AffiliatePayment;
        $affiliate_payment->affiliate_user_id = $request->affiliate_user_id;
        $affiliate_payment->amount = $request->amount;
        $affiliate_payment->payment_method = $request->payment_method;
        $affiliate_payment->save();

        $affiliate_user = AffiliateUser::findOrFail($request->affiliate_user_id);
        $affiliate_user->balance -= $request->amount;

//        $affiliate_user->mlm_balance += $request->amount;

        $affiliate_user->save();

        flash(translate('Payment completed'))->success();
        return back();
    }

    public function payment_history($id)
    {
        $affiliate_user = AffiliateUser::findOrFail(decrypt($id));
        $affiliate_payments = $affiliate_user->affiliate_payments();
        return view('affiliate.payment_history', compact('affiliate_payments', 'affiliate_user'));
    }

    public function user_index(Request $request)
    {
        $affiliate_logs = AffiliateLog::where('referred_by_user', Auth::user()->id)->latest()->paginate(10);

        $query = AffiliateStats::query();
        $query = $query->select(
            DB::raw('SUM(no_of_click) AS count_click, SUM(no_of_order_item) AS count_item, SUM(no_of_delivered) AS count_delivered,  SUM(no_of_cancel) AS count_cancel')
        );
        if ($request->type == 'Today') {
            $query->whereDate('created_at', Carbon::today());
        } else if ($request->type == '7' || $request->type == '30') {
            $query->whereRaw('created_at  <= NOW() AND created_at >= DATE_SUB(created_at, INTERVAL ' . $request->type . ' DAY)');
        }
        $query->where('affiliate_user_id', Auth::user()->id);
        $affliate_stats = $query->first();
        $type = $request->type;

//        dd($type);

        //Total Product Sales Commission
        $total_amount = ReferralEarning::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 1)->sum('amount');

//        $sales_commission_table = ReferralEarning::where('user_id', '=', Auth::user()->id)
//            ->where('type', '=', 1)->get();

        //Total MLM Commission
        $mlm_direct_commission = ReferralEarning::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 2)->sum('amount');

        $level_commission = ReferralEarning::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 3)->sum('amount');

        //Total MLM Commission
        $total_mlm = $mlm_direct_commission + $level_commission;

        return view('affiliate.frontend.index',
            compact('affiliate_logs', 'affliate_stats', 'type', 'total_amount', 'mlm_direct_commission', 'level_commission'));
    }

    // payment history for user
    public function user_payment_history()
    {
        $affiliate_user = Auth::user()->affiliate_user;
        $affiliate_payments = $affiliate_user->affiliate_payments();

        return view('affiliate.frontend.payment_history', compact('affiliate_payments'));
    }

    // withdraw request history for user
    public function user_withdraw_request_history()
    {
        $affiliate_user = Auth::user()->affiliate_user;
        $affiliate_withdraw_requests = AffiliateWithdrawRequest::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        return view('affiliate.frontend.withdraw_request_history', compact('affiliate_withdraw_requests'));
    }

    public function user_token_transfer_history()
    {
        $affiliate_user = Auth::user()->affiliate_user;
        $affiliate_token_transfer = AffiliateTokenTransfer::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        return view('affiliate.frontend.token_transfer_history', compact('affiliate_token_transfer'));
    }

    public function payment_settings()
    {
        $affiliate_user = Auth::user()->affiliate_user;
        return view('affiliate.frontend.payment_settings', compact('affiliate_user'));
    }

    public function payment_settings_store(Request $request)
    {
        $affiliate_user = Auth::user()->affiliate_user;
        $affiliate_user->paypal_email = $request->paypal_email;
        $affiliate_user->bank_information = $request->bank_information;
        $affiliate_user->save();
        flash(translate('Affiliate payment settings has been updated successfully'))->success();
        return redirect()->route('affiliate.user.index');
    }

    public function processAffiliatePoints(Order $order)
    {
        if (addon_is_activated('affiliate_system')) {
            if (AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status) {
                if ($order->user != null && $order->user->orders->count() == 1) {
                    if ($order->user->referred_by != null) {
                        $user = User::find($order->user->referred_by);
                        if ($user != null) {
                            $amount = (AffiliateOption::where('type', 'user_registration_first_purchase')->first()->percentage * $order->grand_total) / 100;
                            $affiliate_user = $user->affiliate_user;
                            if ($affiliate_user != null) {
                                $affiliate_user->balance += $amount;
                                $affiliate_user->save();

                                // Affiliate log
                                $affiliate_log = new AffiliateLog;
                                $affiliate_log->user_id = $order->user_id;
                                $affiliate_log->referred_by_user = $order->user->referred_by;
                                $affiliate_log->amount = $amount;
                                $affiliate_log->order_id = $order->id;
                                $affiliate_log->affiliate_type = 'user_registration_first_purchase';
                                $affiliate_log->save();
                            }
                        }
                    }
                }
            }
            if (AffiliateOption::where('type', 'product_sharing')->first()->status) {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $amount = 0;
                    if ($orderDetail->product_referral_code != null) {
                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();
                        if ($referred_by_user != null) {
                            if (AffiliateOption::where('type', 'product_sharing')->first()->details != null && json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission_type == 'amount') {
                                $amount = json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission;
                            } elseif (AffiliateOption::where('type', 'product_sharing')->first()->details != null && json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission_type == 'percent') {
                                $amount = (json_decode(AffiliateOption::where('type', 'product_sharing')->first()->details)->commission * $orderDetail->price) / 100;
                            }
                            $affiliate_user = $referred_by_user->affiliate_user;
                            if ($affiliate_user != null) {
                                $affiliate_user->balance += $amount;
                                $affiliate_user->save();

                                // Affiliate log
                                $affiliate_log = new AffiliateLog;
                                if ($order->user_id != null) {
                                    $affiliate_log->user_id = $order->user_id;
                                } else {
                                    $affiliate_log->guest_id = $order->guest_id;
                                }
                                $affiliate_log->referred_by_user = $referred_by_user->id;
                                $affiliate_log->amount = $amount;
                                $affiliate_log->order_id = $order->id;
                                $affiliate_log->order_detail_id = $orderDetail->id;
                                $affiliate_log->affiliate_type = 'product_sharing';
                                $affiliate_log->save();
                            }
                        }
                    }
                }
            } elseif (AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $amount = 0;
                    if ($orderDetail->product_referral_code != null) {
                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();
                        if ($referred_by_user != null) {
                            if (AffiliateOption::where('type', 'category_wise_affiliate')->first()->details != null) {
                                foreach (json_decode(AffiliateOption::where('type', 'category_wise_affiliate')->first()->details) as $key => $value) {
                                    if ($value->category_id == $orderDetail->product->category->id) {
                                        if ($value->commission_type == 'amount') {
                                            $amount = $value->commission;
                                        } else {
                                            $amount = ($value->commission * $orderDetail->price) / 100;
                                        }
                                    }
                                }
                            }
                            $affiliate_user = $referred_by_user->affiliate_user;
                            if ($affiliate_user != null) {
                                $affiliate_user->balance += $amount;
                                $affiliate_user->save();

                                // Affiliate log
                                $affiliate_log = new AffiliateLog;
                                if ($order->user_id != null) {
                                    $affiliate_log->user_id = $order->user_id;
                                } else {
                                    $affiliate_log->guest_id = $order->guest_id;
                                }
                                $affiliate_log->referred_by_user = $referred_by_user->id;
                                $affiliate_log->amount = $amount;
                                $affiliate_log->order_id = $order->id;
                                $affiliate_log->order_detail_id = $orderDetail->id;
                                $affiliate_log->affiliate_type = 'category_wise_affiliate';
                                $affiliate_log->save();
                            }
                        }
                    }
                }
            }
        }
    }

    public function processAffiliateStats($affiliate_user_id, $no_click = 0, $no_item = 0, $no_delivered = 0, $no_cancel = 0)
    {
        $affiliate_stats = AffiliateStats::whereDate('created_at', Carbon::today())
            ->where("affiliate_user_id", $affiliate_user_id)
            ->first();

        if (!$affiliate_stats) {
            $affiliate_stats = new AffiliateStats;
            $affiliate_stats->no_of_order_item = 0;
            $affiliate_stats->no_of_delivered = 0;
            $affiliate_stats->no_of_cancel = 0;
            $affiliate_stats->no_of_click = 0;
        }

        $affiliate_stats->no_of_order_item += $no_item;
        $affiliate_stats->no_of_delivered += $no_delivered;
        $affiliate_stats->no_of_cancel += $no_cancel;
        $affiliate_stats->no_of_click += $no_click;
        $affiliate_stats->affiliate_user_id = $affiliate_user_id;

//        dd($affiliate_stats);
        $affiliate_stats->save();

//        foreach($order->orderDetails as $key => $orderDetail) {
//            $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();
//
//            if($referred_by_user != null) {
//                if($orderDetail->delivery_status == 'delivered') {
//                    $affiliate_stats->no_of_delivered++;
//                } if($orderDetail->delivery_status == 'cancelled') {
//                    $affiliate_stats->no_of_cancel++;
//                }
//
//                $affiliate_stats->affiliate_user_id = $referred_by_user->id;
//                dd($affiliate_stats);
//                $affiliate_stats->save();
//            }
//        }
    }

    public function refferal_users()
    {
        $refferal_users = User::where('referred_by', '!=', null)->paginate(10);
        return view('affiliate.refferal_users', compact('refferal_users'));
    }

    // Affiliate Withdraw Request
    public function withdraw_request_store(Request $request)
    {
        $withdraw_request = new AffiliateWithdrawRequest;
        $withdraw_request->user_id = Auth::user()->id;
        $withdraw_request->amount = $request->amount;
        $withdraw_request->status = 0;


        if ($withdraw_request->save()) {
            $affiliate_user = AffiliateUser::where('user_id', Auth::user()->id)->first();
            if ($affiliate_user->next_withdraw_date != null && strtotime($affiliate_user->next_withdraw_date) > strtotime(Carbon::now())) {
                flash(translate('Withdraw not available'))->error();
                return back();
            }
            $partial_balance = (($affiliate_user->balance + $affiliate_user->mlm_balance) * .75) - $affiliate_user->withdraw_balance;
            if ($partial_balance >= $request->amount) {
                $affiliate_user->total_balance = $affiliate_user->total_balance - $request->amount;
                $affiliate_user->withdraw_balance = $affiliate_user->withdraw_balance + $request->amount;

                $affiliate_user->next_withdraw_date = Carbon::now()->addDays(15);
                $affiliate_user->save();
            } else {
                flash(translate('Insufficient Balance'))->error();
                return back();
            }


            flash(translate('New withdraw request created successfully'))->success();
            return redirect()->route('affiliate.user.withdraw_request_history');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    // Affiliate Token Transfer
    public function token_transfer_store(Request $request)
    {
        $affiliate_user = AffiliateUser::where('user_id', Auth::user()->id)->first();
        if ($affiliate_user->next_withdraw_date_token != null && strtotime($affiliate_user->next_withdraw_date_token) > strtotime(Carbon::now())) {
            flash(translate('Withdraw not available'))->error();
            return back();
        }
        $partial_balance = (($affiliate_user->balance + $affiliate_user->mlm_balance) * .25) - $affiliate_user->token_withdraw_balance;
        if ($partial_balance >= $request->amount) {
            $sellerAccount = User::where('email', $request->transfer_account)->first();
            $token_transfer = new AffiliateTokenTransfer();
            $token_transfer->user_id = Auth::user()->id;
            $token_transfer->amount = $request->amount;
            $token_transfer->transfer_user_id = $sellerAccount->id;
            $token_transfer->status = 1;
            $token_transfer->save();

            $affiliate_user->total_balance = $affiliate_user->total_balance - $request->amount;
            $affiliate_user->token_withdraw_balance = $affiliate_user->token_withdraw_balance + $request->amount;

            $affiliate_user->next_withdraw_date_token = Carbon::now()->addDays(15);
            $affiliate_user->save();

            $sellerData = Seller::where('user_id', $sellerAccount->id)->first();
            $sellerData->token_amount += $request->amount;
            $sellerData->save();
        } else {
            flash(translate('Insufficient Balance'))->error();
            return back();
        }
        flash(translate('New withdraw request created successfully'))->success();
        return redirect()->route('affiliate.user.token_transfer_history');
    }


    public function affiliate_withdraw_requests()
    {
        $affiliate_withdraw_requests = AffiliateWithdrawRequest::orderBy('id', 'desc')->paginate(10);
        return view('affiliate.affiliate_withdraw_requests', compact('affiliate_withdraw_requests'));
    }

    public function affiliate_withdraw_modal(Request $request)
    {
        $affiliate_withdraw_request = AffiliateWithdrawRequest::findOrFail($request->id);
        $affiliate_user = AffiliateUser::where('user_id', $affiliate_withdraw_request->user_id)->first();
        return view('affiliate.affiliate_withdraw_modal', compact('affiliate_withdraw_request', 'affiliate_user'));
    }

    public function withdraw_request_payment_store(Request $request)
    {
        $affiliate_payment = new AffiliatePayment;
        $affiliate_payment->affiliate_user_id = $request->affiliate_user_id;
        $affiliate_payment->amount = $request->amount;
        $affiliate_payment->payment_method = $request->payment_method;
        $affiliate_payment->save();

        if ($request->has('affiliate_withdraw_request_id')) {
            $affiliate_withdraw_request = AffiliateWithdrawRequest::findOrFail($request->affiliate_withdraw_request_id);
            $affiliate_withdraw_request->status = 1;
            $affiliate_withdraw_request->save();
        }

        flash(translate('Payment completed'))->success();
        return back();
    }

    public function reject_withdraw_request($id)
    {
        $affiliate_withdraw_request = AffiliateWithdrawRequest::findOrFail($id);
        $affiliate_withdraw_request->status = 2;
        if ($affiliate_withdraw_request->save()) {

            $affiliate_user = AffiliateUser::where('user_id', $affiliate_withdraw_request->user_id)->first();
            $affiliate_user->balance = $affiliate_user->balance + $affiliate_withdraw_request->amount;
            $affiliate_user->save();

            flash(translate('Affiliate withdraw request has been rejected successfully'))->success();
            return redirect()->route('affiliate.withdraw_requests');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function affiliate_child()
    {
        $user = User::where('id', 3)->with('child')->first();
        if (isset($user)) {
            return response()->json($user);
        }
        return response()->json(["Messaage" => "All child"]);
    }

    public function product_affiliate_index(Request $request)
    {
        $affiliate_logs = AffiliateLog::where('referred_by_user', Auth::user()->id)->latest()->paginate(10);

        $query = AffiliateStats::query();
        $query = $query->select(
            DB::raw('SUM(no_of_click) AS count_click, SUM(no_of_order_item) AS count_item, SUM(no_of_delivered) AS count_delivered,  SUM(no_of_cancel) AS count_cancel')
        );
        if ($request->type == 'Today') {
            $query->whereDate('created_at', Carbon::today());
        } else if ($request->type == '7' || $request->type == '30') {
            $query->whereRaw('created_at  <= NOW() AND created_at >= DATE_SUB(created_at, INTERVAL ' . $request->type . ' DAY)');
        }
        $query->where('affiliate_user_id', Auth::user()->id);
        $affliate_stats = $query->first();
        $type = $request->type;
        return view('affiliate.frontend.product_affiliate_index', compact('affiliate_logs', 'affliate_stats', 'type'));
    }

    public function products()
    {
        $products = Product::paginate(20);
        return view('affiliate.products', compact('products'));
    }

    public function affiliate_product_update(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->affiliate = $request->status;
        $product->save();
        return 1;
    }

    public function view_product_sales_commission()
    {
        $report = 0;
        $sales_commission_table = ReferralEarning::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 1)->paginate(10);

        return view('affiliate.frontend.view_product_sales_commission', compact('sales_commission_table', 'report'));
    }

    public function view_mlm_direct_commission()
    {
        $report = 1;
        $sales_commission_table = ReferralEarning::where('user_id', '=', Auth::user()->id)
            ->where('type', '!=', 1)->paginate(10);

        return view('affiliate.frontend.view_product_sales_commission', compact('sales_commission_table', 'report'));

    }

    public function affiliate_ref_earning()
    {
        $ref_earning = ReferralEarning::paginate(10);
        return view('backend.referral_earning.referral_earning', compact('ref_earning'));
    }

    public function rank_qualification()
    {
        $users = AffiliateUser::all();
        foreach ($users as $user) {
            //For First Level Users
            $first_level_users = Tree::where('referral_id',$user->user_id)
                ->where('level_type',1)
                ->get();
            $first_level_sales_volume = 0;
            foreach ($first_level_users as $first_level_user){
                $temp_first_level_sales_volume = AffiliateUser::where('user_id', $first_level_user->user_id)->value('total_sale_volume');
                $temp_first_level_sales_volume *= .04;
                $first_level_sales_volume += $temp_first_level_sales_volume;
            }

            //For Second Level Users
            $second_level_users = Tree::where('referral_id',$user->user_id)
                ->where('level_type',2)
                ->get();
            $second_level_sales_volume = 0;
            foreach ($second_level_users as $second_level_user){
                $temp_second_level_sales_volume = AffiliateUser::where('user_id', $second_level_user->user_id)->value('total_sale_volume');
                $temp_second_level_sales_volume *= .02;
                $second_level_sales_volume += $temp_second_level_sales_volume;
            }

            //For Third Level Users
            $third_level_users = Tree::where('referral_id',$user->user_id)
                ->where('level_type',3)
                ->get();
            $third_level_sales_volume = 0;
            foreach ($third_level_users as $third_level_user){
                $temp_third_level_sales_volume = AffiliateUser::where('user_id', $third_level_user->user_id)->value('total_sale_volume');
                $temp_third_level_sales_volume *= .01;
                $third_level_sales_volume += $temp_third_level_sales_volume;
            }

            //For Fourth Level Users
            $fourth_level_users = Tree::where('referral_id',$user->user_id)
                ->where('level_type',4)
                ->get();
            $fourth_level_sales_volume = 0;
            foreach ($fourth_level_users as $fourth_level_user){
                $temp_fourth_level_sales_volume = AffiliateUser::where('user_id', $fourth_level_user->user_id)->value('total_sale_volume');
                $temp_fourth_level_sales_volume *= .01;
                $fourth_level_sales_volume += $temp_fourth_level_sales_volume;
            }

            $level_sales_volume = $first_level_sales_volume + $second_level_sales_volume + $third_level_sales_volume + $fourth_level_sales_volume;

            $rank = Rank::where('status', 1)->get();
            foreach ($rank as $item) {
                if ($level_sales_volume >= $item->sale_volume) {
                    $level_sales_volume = ($level_sales_volume * $item->percentage) / 100;
                }
            }

            $temp_mlm_balance = AffiliateUser::where('id', $user->id)->value('mlm_balance');
            $user->mlm_balance = $level_sales_volume + $temp_mlm_balance;


            $temp_total_balance = AffiliateUser::where('id', $user->id)->value('total_balance');
            $user->total_balance = $level_sales_volume + $temp_total_balance;
            $user->total_sale_volume = 0;
            $user->save();

            $user_id = AffiliateUser::where('id', $user->id)->value('user_id');
            $info = new ReferralEarning();
            $info->type = 3;
            $info->amount = $level_sales_volume;
            $info->user_id = $user_id;
            $info->status = 1;
            $info->save();

        }
        flash(translate('Level Commission Generate Successfully'))->success();
        return back();
    }

    //Affiliate users tree
    public function tree($id)
    {
        $first_level_users = Tree::where('referral_id', Auth::user()->id)->get();
        return view('frontend.user_tree.user_tree', compact('first_level_users'));
    }

    public function view_affiliated_user_info(Request $request)
    {
        $affiliate_users = User::where('id', $request->id)->get();
        return view('frontend.user_tree.view_affiliated_user', compact('affiliate_users'));
    }
}

