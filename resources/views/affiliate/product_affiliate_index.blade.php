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
                                                    <form action="{{ route('search.ajax.get') }}" method="GET" class="ajax_search_product">
                                                        @csrf
                                                        <div class="d-flex position-relative align-items-center">
                                                            <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                                                <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                                            </div>
                                                            <div class="input-group">
                                                                <input type="text" class="border-0 border-lg form-control search_input_box" id="search" name="keyword" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
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
                                                    <p class="search_product_show">Your searched product will appear here</p>
                                                </div>
                                            </div>
                                        </div>
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
                                                        fill="none" xmlns="http://www.w3.org/2000/svg" >
                                                        <path d="M13.0823 13.9503L13.8098 9.46663H9.2662V6.54483C9.23638 6.20934 9.28614 5.87177 9.41186 5.55695C9.53758 5.24213 9.73606 4.95808 9.99266 4.72568C10.2493 4.49328 10.5575 4.31844 10.8946 4.21404C11.2318 4.10964 11.5893 4.07832 11.9408 4.12239H14V0.297495C12.7893 0.115183 11.5663 0.0157593 10.3405 0C6.60272 0 4.15188 2.12495 4.15188 6.03484V9.46663H0V13.9503H4.15188V24.8087C4.99942 24.937 5.85639 25.0009 6.71464 25C7.56919 25.0014 8.42247 24.9374 9.2662 24.8087V13.9503H13.0823Z"
                                                        fill="white" />
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
                                                {{-- <a target="_blank" href="{{'http://twitter.com/share?text=Join British Market Place and get Discount&url=https://britishmarketplace.co.uk' . $referral_code_url }}">
                                                    <strong>Share on twitter</strong> --}}
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card share_whatsapp">
                                        <div class="form-box-content p-3">
                                            <div class="form-group">
                                                {{-- <a target="_blank" href="{{'https://web.whatsapp.com/send?text=Join British Market Place and get Discount https://britishmarketplace.co.uk' . $referral_code_url}}" data-action="share/whatsapp/share">
                                                    <strong>Share on WhatsApp</strong> --}}
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
        $(".ajax_search_product").on("submit", function (e) {
            e.preventDefault();
        //     let formData = new FormData($(this)[0]);

        //     (async () => {
        //     const rawResponse = await fetch($(this).attr("action"), {
        //         method: 'POST',
        //         headers: {
        //         'Accept': 'application/json',
        //         'Content-Type': 'application/json'
        //         },
        //         body: formData,
        //     });
        //     const content = await rawResponse.json();

        //     // console.log(content);
        //     $('.search_product_show').html('');
        //     $('.search_product_show').html(content);
        //     })();
            let input = $('.search_input_box').val();
            console.log(input);
            fetch($(this).attr("action") + '?search=' + input)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                $('.search_product_show').html('');
                $('.search_product_show').html(data);
            });
            // $.ajax({
            //     url: $(this).attr("action"),
            //     type: "POST",
            //     data: formData,
            //     success: (res) => {
            //         $('.search_product_show').html('');
            //         $('.search_product_show').html(res);
            //         // $(this).trigger("reset");
            //         // $(".note-editable").html("");
            //         // $(".preloader").hide();
            //         console.log(formData);
            //     },
            //     error: (err) => {
            //         //
            //     }
            // });
        });

    </script>
@endsection