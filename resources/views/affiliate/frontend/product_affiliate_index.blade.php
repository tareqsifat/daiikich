@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Affiliate') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row gutters-10">
                        <div class="col-md-4 mx-auto mb-3" >
                          <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                            <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                                <i class="las la-dollar-sign la-2x text-white"></i>
                            </span>
                            <div class="px-3 pt-3 pb-3">
                                <div class="h4 fw-700 text-center">{{ single_price(Auth::user()->affiliate_user->balance) }}</div>
                                <div class="opacity-50 text-center">{{ translate('Affiliate Balance') }}</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 mx-auto mb-3" >
                            <a href="{{ route('affiliate.payment_settings') }}">
                                <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                    <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                        <i class="las la-dharmachakra la-3x text-white"></i>
                                    </span>
                                    <div class="fs-18 text-primary">{{ translate('Configure Payout') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mx-auto mb-3" >
                          <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition" onclick="show_affiliate_withdraw_modal()">
                              <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                  <i class="las la-plus la-3x text-white"></i>
                              </span>
                              <div class="fs-18 text-primary">{{  translate('Affiliate Withdraw Request') }}</div>
                          </div>
                        </div>
                    </div>


                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="form-box-content p-3">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="h6" style="margin-bottom: 5px">Search product to get product referral link</h5>
                                                </div>
                                                <div class="col-md-12">
                                                    <form action="{{ route('search.ajax.get') }}" method="GET" class="ajax_search_product">
                                                        @csrf
                                                        <div class="d-flex position-relative align-items-center">
                                                            <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                                                <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                                            </div>
                                                            <div class="input-group">
                                                                <input type="text" class="border-0 border-lg form-control search_input_box" id="search" name="keyword" placeholder="Search product" autocomplete="off">
                                                                <div class="input-group-append d-none d-lg-block">
                                                                    <button class="btn btn-primary" type="submit">
                                                                        <i class="la la-search la-flip-horizontal fs-18"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="px-2 py-1 text-uppercase fs-12 text-center text-muted bg-soft-secondary" style="margin-top: 15px">{{translate('Products')}}</div>
                                                    <ul class="list-group list-group-raw search_product_show">
                                                        <li>
                                                            <p>Your searched product will appear here</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            if(Auth::user()->referral_code == null){
                                Auth::user()->referral_code = substr(Auth::user()->id.Str::random(), 0, 10);
                                Auth::user()->save();
                            }
                            $referral_code = Auth::user()->referral_code;
                        @endphp
                        <input type="hidden" name="" class="user_referral_link" value="{{ $referral_code }}">
                        <div class="row gutters-10 product_referral_link_section d-none">
                            <div class="col">
                                <div class="card">
                                    <div class="form-box-content p-3">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5 class="h6" style="margin-bottom: 5px">here is your product referral link</h5>
                                                    <h5 class="product_referral_link" style="
                                                        padding: 6px;
                                                        background-color: rgba(0, 0, 0, 0.18);
                                                        border-radius: 10px;
                                                        border-right: 1px solid rgba(2, 2, 2, 0.28);
                                                        border-left: 2px solid rgba(2, 2, 2, 0.28);
                                                        border-top: 1px solid rgba(250, 250, 250, 0.27);
                                                        box-shadow: 0 0 5px rgba(1, 1, 1, 0.7);" ></h5>
                                                </div>
                                                <div class="col-md-2">
                                                    <h5 class="h6" style="margin-bottom: 5px; visibility: hidden;">here is</h5>
                                                    <a class="ml-auto mr-0 btn btn-primary btn-sm shadow-md text-white copy_product_referral_link">
                                                        copy link
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row"> 
                                        <div class="col-md-3" style="cursor: pointer">
                                            <div class="card">
                                                <div class="fb_share_icon form-box-content p-3">
                                                    <div class="form-group">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                                                                <path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z"/>
                                                                <path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"/>
                                                            </svg>
                                                        </i>
                                                        <strong style="cursor: pointer">Share on facebook</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="cursor: pointer">
                                            <div class="card emailMe">
                                                <div class="form-box-content p-3">
                                                    <div class="form-group">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="48px" height="48px">
                                                                <path fill="#e0e0e0" d="M5.5,40.5h37c1.933,0,3.5-1.567,3.5-3.5V11c0-1.933-1.567-3.5-3.5-3.5h-37C3.567,7.5,2,9.067,2,11v26C2,38.933,3.567,40.5,5.5,40.5z"/>
                                                                <path fill="#d9d9d9" d="M26,40.5h16.5c1.933,0,3.5-1.567,3.5-3.5V11c0-1.933-1.567-3.5-3.5-3.5h-37C3.567,7.5,2,9.067,2,11L26,40.5z"/>
                                                                <path fill="#eee" d="M6.745,40.5H42.5c1.933,0,3.5-1.567,3.5-3.5V11.5L6.745,40.5z"/>
                                                                <path fill="#e0e0e0" d="M25.745,40.5H42.5c1.933,0,3.5-1.567,3.5-3.5V11.5L18.771,31.616L25.745,40.5z"/>
                                                                <path fill="#ca3737" d="M42.5,9.5h-37C3.567,9.5,2,9.067,2,11v26c0,1.933,1.567,3.5,3.5,3.5H7V12h34v28.5h1.5c1.933,0,3.5-1.567,3.5-3.5V11C46,9.067,44.433,9.5,42.5,9.5z"/>
                                                                <path fill="#f5f5f5" d="M42.5,7.5H24H5.5C3.567,7.5,2,9.036,2,11c0,1.206,1.518,2.258,1.518,2.258L24,27.756l20.482-14.497c0,0,1.518-1.053,1.518-2.258C46,9.036,44.433,7.5,42.5,7.5z"/>
                                                                <path fill="#e84f4b" d="M43.246,7.582L24,21L4.754,7.582C3.18,7.919,2,9.297,2,11c0,1.206,1.518,2.258,1.518,2.258L24,27.756l20.482-14.497c0,0,1.518-1.053,1.518-2.258C46,9.297,44.82,7.919,43.246,7.582z"/>
                                                            </svg>
                                                        </i>
                                                        <strong style="cursor: pointer">Share on email</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 twitter_share" style="cursor: pointer">
                                            <div class="card">
                                                <div class="form-box-content p-3">
                                                    <div class="form-group">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="48px" height="48px">
                                                                <path fill="#03A9F4" d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429"/>
                                                            </svg>
                                                        </i>
                                                        <strong>Share on twitter</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="cursor: pointer">
                                            <div class="card share_whatsapp">
                                                <div class="form-box-content p-3">
                                                    <div class="form-group">
                                                        <i>
                                                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="48px" height="48px" fill-rule="evenodd" clip-rule="evenodd">
                                                                <path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"/>
                                                                <path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"/>
                                                                <path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"/>
                                                                <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"/>
                                                                <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </i>
                                                        <strong>Share on WhatsApp</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <br>

                    <div class="card">
                        <form class="" id="sort_blogs" action="" method="GET">
                            <div class="card-header row">
                                <div class="col text-center text-md-left">
                                    <h5 class="mb-md-0 h6">{{translate('Affiliate Stats')}}</h5>
                                </div>
                                <div class="col-md-5 col-xl-4">
                                    <div class="input-group mb-0">
                                        <select class="form-control aiz-selectpicker" name="type" data-live-search="true">
                                            <option value="">Choose</option>
                                            <option value="Today" @if($type == 'Today') selected @endif>Today</option>
                                            <option value="7" @if($type == '7') selected @endif>Last 7 Days</option>
                                            <option value="30" @if($type == '30') selected @endif>Last 30 Days</option>
                                        </select>
                                        <button class="btn btn-primary input-group-append" type="submit">{{ translate('Filter') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body">
                            <div class="row gutters-10">
                                <div class="col-md-3 mx-auto mb-3">
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    @if($affliate_stats->count_click)
                                                        {{ $affliate_stats->count_click }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary">{{ translate('No of click') }}</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mx-auto mb-3" >
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    @if($affliate_stats->count_item)
                                                        {{ $affliate_stats->count_item }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary">{{ translate('No of item') }}</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mx-auto mb-3" >
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    @if($affliate_stats->count_delivered)
                                                        {{ $affliate_stats->count_delivered }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary">{{ translate('No of deliverd') }}</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mx-auto mb-3" >
                                    <a href="#">
                                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                                <span class="la-3x text-white">
                                                    @if($affliate_stats->count_cancel)
                                                        {{ $affliate_stats->count_cancel }}
                                                    @else
                                                        0
                                                    @endif
                                                </span>
                                            </span>
                                            <div class="fs-18 text-primary">{{ translate('No of cancel') }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate('Affiliate Earning History')}}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Referral User')}}</th>
                                    <th>{{ translate('Amount')}}</th>
                                    <th data-breakpoints="lg">{{ translate('Order Id')}}</th>
                                    <th data-breakpoints="lg">{{ translate('Referral Type') }}</th>
                                    <th data-breakpoints="lg">{{ translate('Product') }}</th>
                                    <th data-breakpoints="lg">{{ translate('Date') }}</th>
                                </thead>
                                <tbody>
                                @foreach($affiliate_logs as $key => $affiliate_log)
                                    <tr>
                                        <td>{{ ($key+1) + ($affiliate_logs->currentPage() - 1)*$affiliate_logs->perPage() }}</td>
                                        <td>
                                            @if($affiliate_log->user_id !== null)
                                                {{ $affiliate_log->user->name }}
                                            @else
                                                {{ translate('Guest').' ('. $affiliate_log->guest_id.')' }}
                                            @endif
                                        </td>
                                        <td>{{ single_price($affiliate_log->amount) }}</td>
                                        <td>
                                            @if($affiliate_log->order_id != null)
                                                {{ $affiliate_log->order->code }}
                                            @else
                                                {{ $affiliate_log->order_detail->order->code }}
                                            @endif
                                        </td>
                                        <td> {{ ucwords(str_replace('_',' ', $affiliate_log->affiliate_type)) }}</td>
                                        <td>
                                            @if($affiliate_log->order_detail_id != null)
                                                {{ $affiliate_log->order_detail->product->name }}
                                            @endif
                                        </td>
                                        <td>{{ $affiliate_log->created_at->format('d, F Y') }} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                {{ $affiliate_logs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        var product_referral_link;
        var user_referral_link = $('.user_referral_link').val();
        $(".ajax_search_product").on("submit", function (e) {
            e.preventDefault();
            let input = $('.search_input_box').val();
            let output = '';
            let html= '';
            fetch($(this).attr("action") + '?search=' + input)
            .then((response) => response.json())
            .then((data) => {
                $('.search_product_show').html('');
                $('.search_product_show').html(data);
                $('.search_affiliate_product').each(function(){
                    $(this).on('click', function(e){
                        e.preventDefault();
                        let link = $(this).children('a').attr('href') + '?referral_code=' + user_referral_link;
                        product_referral_link = link;
                        $('.product_referral_link_section').removeClass('d-none');
                        $('.product_referral_link').fadeIn().delay(100).html(link);
                        $('.search_product_show').html('');
                    })
                });
            });
        });
        $('.copy_product_referral_link').click(function(){
            try {
                navigator.clipboard.writeText(product_referral_link);
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        });
        $(document).on('click', '.share_whatsapp', function (e) {
            e.preventDefault();
            console.log(product_referral_link);
            let url = "https://web.whatsapp.com/send?text=&url=" + product_referral_link;
            window.open(url, '_blank');
        });
        $(document).on('click', '.twitter_share', function (e) {
            e.preventDefault();
            let url = "http://twitter.com/share?text=&url=" + product_referral_link;
            window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        });

        $(document).on('click', '.fb_share_icon', function (e) {
            e.preventDefault();
            let url = "https://www.facebook.com/sharer/sharer.php?u="+ encodeURIComponent(product_referral_link)  +"%2F&amp;src=sdkpreparse";
            window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        });

        $(document).on('click', '.emailMe', function (e) {
            e.preventDefault();
            let refer_link = $('.fb_share_link').html();
            let url = 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&su=Daiikichi+|+Daiikichi.net+Shop+Earn+And+Advertise&body=go+to '+ product_referral_link +'&ui=2&tf=1&pli=1';

            window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        });
    </script>
@endsection