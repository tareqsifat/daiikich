@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
                        <div class="col-md-4 mx-auto mb-3">
                            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                            <span
                                class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                                <i class="las la-dollar-sign la-2x text-white"></i>
                            </span>
                                <div class="px-3 pt-3 pb-3">
                                    <div
                                        class="h4 fw-700 text-center">{{ single_price(Auth::user()->affiliate_user->balance) }}</div>
                                    <div class="opacity-50 text-center">{{ translate('Affiliate Balance') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mx-auto mb-3">
                            <a href="{{ route('affiliate.payment_settings') }}">
                                <div
                                    class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                    <span
                                        class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                        <i class="las la-dharmachakra la-3x text-white"></i>
                                    </span>
                                    <div class="fs-18 text-primary">{{ translate('Configure Payout') }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 mx-auto mb-3">
                            <div
                                class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition"
                                onclick="show_affiliate_withdraw_modal()">
                              <span
                                  class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                  <i class="las la-plus la-3x text-white"></i>
                              </span>
                                <div class="fs-18 text-primary">{{  translate('Affiliate Withdraw Request') }}</div>
                            </div>
                        </div>

                    </div>

                    <div class="row gutters-10">
                        <div class="col-md-6 mx-auto mb-3">
                            <a href="{{ route('view.product.sales.commission') }}">
                                <div
                                    class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition"
                                    onclick="">
                              <span
                                  class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                  <i class="las la-dollar-sign la-3x text-white"></i>
                              </span>
                                    <div class="fs-18 text-primary">Total Product Sales Commission:</div>
                                    <div class="fs-18 text-primary"><i
                                            class="las la-dollar-sign text-primary"></i>{{$total_amount}}</div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-6 mx-auto mb-3">
                            <a href="{{ route('view.mlm.direct.commission') }}">
                            <div
                                class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition"
                                onclick="">
                              <span
                                  class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                  <i class="las la-dollar-sign la-3x text-white"></i>
                              </span>
                                <div class="fs-18 text-primary">
                                    Total MLM Commission:
                                </div>
                                <div class="fs-18 text-primary"><i
                                        class="las la-dollar-sign text-primary"></i>{{$mlm_direct_commission + $level_commission}}
                                </div>
                            </div>
                            </a>
                        </div>

                    </div>


                    <div class="row">
                        @php
                            if(Auth::user()->referral_code == null){
                                Auth::user()->referral_code = substr(Auth::user()->id.Str::random(), 0, 10);
                                Auth::user()->save();
                            }
                            $referral_code = Auth::user()->referral_code;
                            $referral_code_url = URL::to('/users/registration')."?referral_code=$referral_code";
                            $referral_code_url_seller = URL::to('/shops/create')."?referral_code=$referral_code";
                            $referral_code_url_affiliate = URL::to('/affiliate')."?referral_code=$referral_code";
                        @endphp
                        <div class="col">
                            <div class="card">
                                <div class="form-box-content p-3">
                                    <div class="form-group">
                                        <textarea id="referral_code_url" class="form-control fb_share_link" readonly
                                                  type="text">{{$referral_code_url}}</textarea>
                                        <textarea id="referral_code_url" class="form-control" readonly
                                                  type="text">{{$referral_code_url_seller}}</textarea>
                                        <textarea id="referral_code_url" class="form-control" readonly
                                                  type="text">{{$referral_code_url_affiliate}}</textarea>
                                    </div>
                                    <button type=button id="ref-cpurl-btn" class="btn btn-primary float-right"
                                            data-attrcpy="{{translate('Copied')}}"
                                            onclick="copyToClipboard('url')">{{translate('Copy Url')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="fb_share_icon form-box-content p-3">
                                        <div class="form-group">
                                            <i>
                                                <svg width="24" height="16" class="mx-auto" viewBox="0 0 14 25"
                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.0823 13.9503L13.8098 9.46663H9.2662V6.54483C9.23638 6.20934 9.28614 5.87177 9.41186 5.55695C9.53758 5.24213 9.73606 4.95808 9.99266 4.72568C10.2493 4.49328 10.5575 4.31844 10.8946 4.21404C11.2318 4.10964 11.5893 4.07832 11.9408 4.12239H14V0.297495C12.7893 0.115183 11.5663 0.0157593 10.3405 0C6.60272 0 4.15188 2.12495 4.15188 6.03484V9.46663H0V13.9503H4.15188V24.8087C4.99942 24.937 5.85639 25.0009 6.71464 25C7.56919 25.0014 8.42247 24.9374 9.2662 24.8087V13.9503H13.0823Z"
                                                        fill="white"/>
                                                </svg>
                                            </i>
                                            <strong>Share on facebook</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card emailMe">
                                    <div class="form-box-content p-3">
                                        <div class="form-group">
                                            <strong>Share on email</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="form-box-content p-3">
                                        <div class="form-group">
                                            <a target="_blank"
                                               href="{{'http://twitter.com/share?text=Join British Market Place and get Discount&url=https://britishmarketplace.co.uk' . $referral_code_url }}">
                                                <strong>Share on twitter</strong>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card share_whatsapp">
                                    <div class="form-box-content p-3">
                                        <div class="form-group">
                                            <a target="_blank"
                                               href="{{'https://web.whatsapp.com/send?text=Join British Market Place and get Discount https://britishmarketplace.co.uk' . $referral_code_url}}"
                                               data-action="share/whatsapp/share">
                                                <strong>Share on WhatsApp</strong>
                                            </a>
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
                                        <select class="form-control aiz-selectpicker" name="type"
                                                data-live-search="true">
                                            <option value="">Choose</option>
                                            <option value="Today" @if($type == 'Today') selected @endif>Today</option>
                                            <option value="7" @if($type == '7') selected @endif>Last 7 Days</option>
                                            <option value="30" @if($type == '30') selected @endif>Last 30 Days</option>
                                        </select>
                                        <button class="btn btn-primary input-group-append"
                                                type="submit">{{ translate('Filter') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="card-body">
                            <div class="row gutters-10">
                                <div class="col-md-3 mx-auto mb-3">
                                    <a href="#">
                                        <div
                                            class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span
                                                class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
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
                                <div class="col-md-3 mx-auto mb-3">
                                    <a href="#">
                                        <div
                                            class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span
                                                class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
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
                                <div class="col-md-3 mx-auto mb-3">
                                    <a href="#">
                                        <div
                                            class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span
                                                class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
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
                                <div class="col-md-3 mx-auto mb-3">
                                    <a href="#">
                                        <div
                                            class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                            <span
                                                class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
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
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Affiliate payment history')}}</h5>
                                </div>
                                  <div class="card-body">
                                      <table class="table aiz-table mb-0">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>{{ translate('Date') }}</th>
                                                  <th>{{translate('Amount')}}</th>
                                                  <th>{{translate('Payment Method')}}</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach ($affiliate_payments as $key => $affiliate_payment)
                                                  <tr>
                                                      <td>{{ $key+1 }}</td>
                                                      <td>{{ date('d-m-Y', strtotime($affiliate_payment->created_at)) }}</td>
                                                      <td>{{ single_price($affiliate_payment->amount) }}</td>
                                                      <td>{{ ucfirst(str_replace('_', ' ', $affiliate_payment ->payment_method)) }}</td>
                                                  </tr>
                                              @endforeach

                                          </tbody>
                                      </table>
                                      <div class="aiz-pagination">
                                          {{ $affiliate_payments->links() }}
                                      </div>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Affiliate withdraw request history')}}</h5>
                                </div>
                                  <div class="card-body">
                                      <table class="table aiz-table mb-0">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>{{ translate('Date') }}</th>
                                                  <th>{{ translate('Amount')}}</th>
                                                  <th>{{ translate('Status')}}</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach ($affiliate_withdraw_requests as $key => $affiliate_withdraw_request)
                                                  <tr>
                                                      <td>{{ $key+1 }}</td>
                                                      <td>{{ date('d-m-Y', strtotime($affiliate_withdraw_request->created_at)) }}</td>
                                                      <td>{{ single_price($affiliate_withdraw_request->amount) }}</td>
                                                      <td>
                                                          @if($affiliate_withdraw_request->status == 1)
                                                              <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                                                          @elseif($affiliate_withdraw_request->status == 2)
                                                              <span class="badge badge-inline badge-danger">{{translate('Rejected')}}</span>
                                                          @else
                                                              <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                                                          @endif
                                                      </td>
                                                  </tr>
                                              @endforeach
                                          </tbody>
                                      </table>
                                      <div class="aiz-pagination">
                                          {{ $affiliate_withdraw_requests->links() }}
                                      </div>
                                  </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')

    <div class="modal fade" id="affiliate_withdraw_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Affiliate Withdraw Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="" action="{{ route('affiliate.withdraw_request.store') }}" method="post">
                    @csrf
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{ translate('Amount')}} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control mb-3" name="amount" min="1"
                                       max="{{ Auth::user()->affiliate_user->balance }}"
                                       placeholder="{{ translate('Amount')}}" required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit"
                                    class="btn btn-sm btn-primary transition-3d-hover mr-1">{{translate('Confirm')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        function copyToClipboard(btn) {
            // var el_code = document.getElementById('referral_code');
            var el_url = document.getElementById('referral_code_url');
            // var c_b = document.getElementById('ref-cp-btn');
            var c_u_b = document.getElementById('ref-cpurl-btn');

            // if(btn == 'code'){
            //     if(el_code != null && c_b != null){
            //         el_code.select();
            //         document.execCommand('copy');
            //         c_b .innerHTML  = c_b.dataset.attrcpy;
            //     }
            // }

            if (btn == 'url') {
                if (el_url != null && c_u_b != null) {
                    el_url.select();
                    document.execCommand('copy');
                    c_u_b.innerHTML = c_u_b.dataset.attrcpy;
                }
            }
        }

        function show_affiliate_withdraw_modal() {
            $('#affiliate_withdraw_modal').modal('show');
        }

        $(document).on('click', '.fb_share_icon', function (e) {
            e.preventDefault();
            let url = "href=https://www.facebook.com/sharer/sharer.php?u=" + $('.fb_share_link').html() + "%2F&amp;src=sdkpreparse";
            // let url = "https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fbritishmarketplace.co.uk%2Freferral%2F"+  +"&amp;data-src=sdkpreparse";
            window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        });

        $(document).on('click', '.emailMe', function (e) {
            e.preventDefault();
            let refer_link = $('.fb_share_link').html();
            let url = 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&su=Join+British+Market+Place+and+get+Discount&body=go+to ' + refer_link + '&ui=2&tf=1&pli=1';

            window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        });
    </script>
@endsection
