@extends('layouts.frontend.app')
@section('meta')
<title>{{ __('Customer Dashboard') }}</title>

@endsection


@section('css')
<style type="text/css">
    #login .container #login-row #login-column #login-box {
        margin-top: 40px;
        max-width: 600px;

        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
        margin-bottom: 40px;
    }

    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }

    #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -85px;
    }
</style>
@endsection
@section('content')
<div class="order-history">
    <div class="container">
        @include('frontend.customer-dashboard.common.profile_thumb')
        <div class="row">
            @include('frontend.customer-dashboard.common.customer-dashboard-menu')
            <div class="col-lg-9 col-md-8">
                <div class="order-filter d-md-none">
                    <div class="filter-button">
                        <button type="button" class="filterBtn">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                </div>
                @php
                    $code = explode('/',$referral->link);
                @endphp
                <!-- profile area start -->
                <div class="e_profile">
                    <div class="e_profile_wrapper style_one">
                        <div class="e_profile_right">
                            <div class="referral_freiends">
                                <h4>Referral Friends</h4>
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="e_refe_item">
                                            <h6>Your Referral Link</h6>
                                            <span>You're just steps away from receiving your reward.</span>
                                            <div class="link_item">
                                                <div class="link_text">
                                                    <span>Your Referral ID:</span>
                                                    <strong id="Referral_code">{{ $code[2] }}</strong>
                                                </div>
                                                <div class="link_icon">
                                                    <button type="button" onclick="copyFunction('Referral_code')">
                                                        <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.21266 11.1032C4.21266 9.53506 4.20984 7.96667 4.21266 6.39997C4.21519 5.334 4.87784 4.49193 5.88788 4.27085C6.05914 4.23564 6.23369 4.21892 6.40853 4.221C9.53959 4.218 12.6707 4.218 15.8017 4.221C17.0828 4.221 17.997 5.13855 17.9976 6.42053C17.9987 9.55055 17.9987 12.6807 17.9976 15.8109C17.9976 17.0796 17.076 18.0008 15.811 18.0014C12.6743 18.0014 9.53706 18.0014 6.39924 18.0014C5.1424 18.0014 4.21773 17.0861 4.21322 15.8292C4.20843 14.2521 4.21266 12.6775 4.21266 11.1032ZM5.62474 11.1085C5.62474 12.6637 5.62474 14.2189 5.62474 15.7743C5.62474 16.3282 5.88393 16.5876 6.43868 16.5876C9.54983 16.5876 12.6612 16.5876 15.7727 16.5876C16.326 16.5876 16.5861 16.3271 16.5861 15.7731C16.5861 12.6624 16.5861 9.55196 16.5861 6.44165C16.5861 5.88768 16.3266 5.62858 15.7718 5.62858C12.6603 5.62858 9.54898 5.62858 6.43783 5.62858C5.88281 5.62858 5.62502 5.8874 5.62474 6.44277C5.62436 7.99849 5.62436 9.55374 5.62474 11.1085Z" fill="url(#paint0_linear_1074_24968)" />
                                                            <path d="M13.7542 2.77211H12.3737C12.3737 2.58736 12.3737 2.40346 12.3737 2.21927C12.3737 1.68812 12.0939 1.40593 11.5676 1.40593C8.44973 1.40593 5.33182 1.40593 2.21391 1.40593C1.6817 1.40593 1.40024 1.68389 1.40024 2.2111C1.40024 5.32779 1.40024 8.44496 1.40024 11.5626C1.40024 12.0932 1.68029 12.3742 2.20686 12.3757C2.39985 12.3757 2.59284 12.3757 2.79851 12.3757V13.7469C1.41799 13.9618 0.277515 13.3445 0.0245138 11.9893C0.00632056 11.8783 -0.00160414 11.7659 0.000845217 11.6536C-0.000281739 8.48053 -0.000281739 5.30752 0.000845217 2.1345C0.00281739 1.04995 0.723504 0.212951 1.7882 0.0310186C1.92413 0.0116586 2.06143 0.00356154 2.19869 0.0068024C5.32289 0.0068024 8.44738 0.0169344 11.5713 3.67134e-05C12.6983 -0.00615912 13.6114 0.772544 13.748 1.81682C13.788 2.12239 13.7542 2.43951 13.7542 2.77211Z" fill="url(#paint1_linear_1074_24968)" />
                                                            <defs>
                                                                <linearGradient id="paint0_linear_1074_24968" x1="4.50896" y1="4.81736" x2="16.4926" y2="17.4076" gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#028FF0" />
                                                                    <stop offset="1" stop-color="#0DC1D9" />
                                                                </linearGradient>
                                                                <linearGradient id="paint1_linear_1074_24968" x1="0.29759" y1="0.598879" x2="12.2876" y2="13.1721" gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#028FF0" />
                                                                    <stop offset="1" stop-color="#0DC1D9" />
                                                                </linearGradient>
                                                            </defs>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="link_item">
                                                <div class="link_text style_one">
                                                    <span>Your Referral Link:</span>
                                                    <strong id="Referral_link_modal">{{"https://britishmarketplace.co.uk" . $referral->link }}</strong>
                                                </div>
                                                <div class="link_icon">
                                                    <button type="button" onclick="copyFunction('Referral_link_modal')">
                                                        <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.21266 11.1032C4.21266 9.53506 4.20984 7.96667 4.21266 6.39997C4.21519 5.334 4.87784 4.49193 5.88788 4.27085C6.05914 4.23564 6.23369 4.21892 6.40853 4.221C9.53959 4.218 12.6707 4.218 15.8017 4.221C17.0828 4.221 17.997 5.13855 17.9976 6.42053C17.9987 9.55055 17.9987 12.6807 17.9976 15.8109C17.9976 17.0796 17.076 18.0008 15.811 18.0014C12.6743 18.0014 9.53706 18.0014 6.39924 18.0014C5.1424 18.0014 4.21773 17.0861 4.21322 15.8292C4.20843 14.2521 4.21266 12.6775 4.21266 11.1032ZM5.62474 11.1085C5.62474 12.6637 5.62474 14.2189 5.62474 15.7743C5.62474 16.3282 5.88393 16.5876 6.43868 16.5876C9.54983 16.5876 12.6612 16.5876 15.7727 16.5876C16.326 16.5876 16.5861 16.3271 16.5861 15.7731C16.5861 12.6624 16.5861 9.55196 16.5861 6.44165C16.5861 5.88768 16.3266 5.62858 15.7718 5.62858C12.6603 5.62858 9.54898 5.62858 6.43783 5.62858C5.88281 5.62858 5.62502 5.8874 5.62474 6.44277C5.62436 7.99849 5.62436 9.55374 5.62474 11.1085Z" fill="url(#paint0_linear_1074_24968)" />
                                                            <path d="M13.7542 2.77211H12.3737C12.3737 2.58736 12.3737 2.40346 12.3737 2.21927C12.3737 1.68812 12.0939 1.40593 11.5676 1.40593C8.44973 1.40593 5.33182 1.40593 2.21391 1.40593C1.6817 1.40593 1.40024 1.68389 1.40024 2.2111C1.40024 5.32779 1.40024 8.44496 1.40024 11.5626C1.40024 12.0932 1.68029 12.3742 2.20686 12.3757C2.39985 12.3757 2.59284 12.3757 2.79851 12.3757V13.7469C1.41799 13.9618 0.277515 13.3445 0.0245138 11.9893C0.00632056 11.8783 -0.00160414 11.7659 0.000845217 11.6536C-0.000281739 8.48053 -0.000281739 5.30752 0.000845217 2.1345C0.00281739 1.04995 0.723504 0.212951 1.7882 0.0310186C1.92413 0.0116586 2.06143 0.00356154 2.19869 0.0068024C5.32289 0.0068024 8.44738 0.0169344 11.5713 3.67134e-05C12.6983 -0.00615912 13.6114 0.772544 13.748 1.81682C13.788 2.12239 13.7542 2.43951 13.7542 2.77211Z" fill="url(#paint1_linear_1074_24968)" />
                                                            <defs>
                                                                <linearGradient id="paint0_linear_1074_24968" x1="4.50896" y1="4.81736" x2="16.4926" y2="17.4076" gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#028FF0" />
                                                                    <stop offset="1" stop-color="#0DC1D9" />
                                                                </linearGradient>
                                                                <linearGradient id="paint1_linear_1074_24968" x1="0.29759" y1="0.598879" x2="12.2876" y2="13.1721" gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#028FF0" />
                                                                    <stop offset="1" stop-color="#0DC1D9" />
                                                                </linearGradient>
                                                            </defs>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="link_btn">
                                                <button type="button" class="e_btn" data-toggle="modal" data-target="#InvitationModalCenter">Invite Friend</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                                        <div class="e_refe_item style_one @if(Auth::user()->wallet->withdrable_status < 3)
                                            overlay_show
                                        @endif">
                                            <div class="item_text">
                                                <p class="pb-2">Your total referral reword balance</p>
                                                <h4>{{CustomHelper::countryCurrency()}} {{CustomHelper::Show_wallet_amount($wallet->amount)}}</h4>
                                            </div>
                                            @if(Auth::user()->wallet->withdrable_status < 3)
                                                <div class="overlay_text">
                                                    <p>You can use this amount when 
                                                        @if(Auth::user()->wallet->withdrable_status == 0) three @endif
                                                        @if(Auth::user()->wallet->withdrable_status == 1) two @endif
                                                        @if(Auth::user()->wallet->withdrable_status == 2) one @endif
                                                         more buy somthings for our site</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @dd(Auth::user()->id) --}}
                            <div class="referral_overview style_one">
                                <h4 class="p-3">Referral History</h4>
                                <div class="overview_table">
                                    <div class="table_row">
                                        <ul class="table_header d-md-flex d-none">
                                            <li>
                                                <span>SL No.</span>
                                            </li>
                                            <li>
                                                <span>Referrals user name</span>
                                            </li>
                                            <li>
                                                <span>Notification</span>
                                            </li>
                                        </ul>
                                        @foreach ($child as $key=> $item)
                                            <ul class="table_header d-md-none">
                                                <li>
                                                    <span>SL No.</span>
                                                </li>
                                                <li>
                                                    <span>Referrals user name</span>
                                                </li>
                                                <li>
                                                    <span>Notification</span>
                                                </li>
                                            </ul>
                                            <ul class="table_body">
                                                <li>
                                                    <span>{{$key+1}}</span>
                                                </li>
                                                <li>
                                                    <span class="ref_email">
                                                        @if($item->first_name != null && $item->last_name != null)
                                                            {{$item->first_name . ' ' . $item->last_name}}
                                                        @else
                                                            {{$item->email}}
                                                        @endif
                                                </li>
                                                @php
                                                    $child_order = $item->orders->where('status',1)->count('status');
                                                @endphp
                                                <li>
                                                    @if(isset($item->orders) && count($item->orders) != null && $child_order == 0)
                                                        Purchase
                                                    @elseif($child_order > 0)
                                                        Purchase Confirmed
                                                    @else
                                                       <a href="{{ route('child_referral_notification', $item->email) }}" type="button">Reminder</a>
                                                    @endif
                                                </li>
                                            </ul>
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal e_apply_modal invite_share_modal fade" id="InvitationModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
            <div class="modal-body p-0">
                <div class="modal-header p-0">
                    <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="20"
                        width="20"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#fff"
                        stroke-width="2"
                    >
                        <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                    </button>
                </div>
                <div class="invite_modal_body">
                    <div class="modal_header">
                        <div class="shape_one absolute top-0 left-0">
                            <img class="lazyload rounded-tl-md" data-src="{{asset('frontend/images')}}/shape-1.png" alt="" />
                        </div>
                        <div class="shape_two">
                            <img class="lazyload rounded-bl-md" data-src="{{asset('frontend/images')}}/shape-2.png" alt="" />
                        </div>
                        <div class="shape_three">
                            <img class="lazyload rounded-br-md" data-src="{{asset('frontend/images')}}/shape-3.png" alt="" />
                        </div>
                        <div class="header_grid">
                            <div class="phone_thumb">
                                <img class="lazyload" data-src="{{asset('frontend/images')}}/phone.png" alt="" />
                            </div>
                            <div class="apps_content">
                                <div class="app_thumb">
                                    <img class="lazyload"  data-src="{{asset('frontend/images')}}/apple.png" alt="" />
                                    <img class="lazyload"  data-src="{{asset('frontend/images')}}/google.png" alt="" />
                                </div>
                                <div class="app_qr">
                                    <img class="lazyload"  data-src="{{asset('frontend/images')}}/qr.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_body">
                        <div class="invite_link">
                            <div class="link_item">
                                <div class="item_text">
                                    <span>Your Referral ID:</span>
                                    <strong id="Referral_id_modal">{{ $code[2] }}</strong>
                                </div>
                                <button type="button" onclick="copyFunction('Referral_id_modal')">
                                    <svg width="20" height="20" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.21168 11.1032C4.21168 9.53506 4.20886 7.96667 4.21168 6.39997C4.21422 5.334 4.87687 4.49193 5.8869 4.27085C6.05816 4.23564 6.23272 4.21892 6.40755 4.221C9.53861 4.218 12.6697 4.218 15.8007 4.221C17.0818 4.221 17.996 5.13855 17.9966 6.42053C17.9977 9.55055 17.9977 12.6807 17.9966 15.8109C17.9966 17.0796 17.075 18.0008 15.81 18.0014C12.6733 18.0014 9.53608 18.0014 6.39826 18.0014C5.14142 18.0014 4.21675 17.0861 4.21225 15.8292C4.20746 14.2521 4.21168 12.6775 4.21168 11.1032ZM5.62376 11.1085C5.62376 12.6637 5.62376 14.2189 5.62376 15.7743C5.62376 16.3282 5.88296 16.5876 6.4377 16.5876C9.54885 16.5876 12.6602 16.5876 15.7717 16.5876C16.325 16.5876 16.5851 16.3271 16.5851 15.7731C16.5851 12.6624 16.5851 9.55196 16.5851 6.44165C16.5851 5.88768 16.3256 5.62858 15.7709 5.62858C12.6593 5.62858 9.548 5.62858 6.43686 5.62858C5.88183 5.62858 5.62404 5.8874 5.62376 6.44277C5.62339 7.99849 5.62339 9.55374 5.62376 11.1085Z"
                                            fill="url(#paint0_linear_1_17912)"
                                        />
                                        <path
                                            d="M13.7542 2.77211H12.3737C12.3737 2.58736 12.3737 2.40346 12.3737 2.21927C12.3737 1.68812 12.0939 1.40593 11.5676 1.40593C8.44973 1.40593 5.33182 1.40593 2.21391 1.40593C1.6817 1.40593 1.40024 1.68389 1.40024 2.2111C1.40024 5.32779 1.40024 8.44496 1.40024 11.5626C1.40024 12.0932 1.68029 12.3742 2.20686 12.3757C2.39985 12.3757 2.59284 12.3757 2.79851 12.3757V13.7469C1.41799 13.9618 0.277515 13.3445 0.0245138 11.9893C0.00632056 11.8783 -0.00160414 11.7659 0.000845217 11.6536C-0.000281739 8.48053 -0.000281739 5.30752 0.000845217 2.1345C0.00281739 1.04995 0.723504 0.212951 1.7882 0.0310186C1.92413 0.0116586 2.06143 0.00356154 2.19869 0.0068024C5.32289 0.0068024 8.44738 0.0169344 11.5713 3.67134e-05C12.6983 -0.00615912 13.6114 0.772544 13.748 1.81682C13.788 2.12239 13.7542 2.43951 13.7542 2.77211Z"
                                            fill="url(#paint1_linear_1_17912)"
                                        />
                                        <defs>
                                            <linearGradient id="paint0_linear_1_17912" x1="4.50798" y1="4.81736" x2="16.4916" y2="17.4076" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#028FF0" />
                                                <stop offset="1" stop-color="#0DC1D9" />
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_1_17912" x1="0.29759" y1="0.598879" x2="12.2876" y2="13.1721" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#028FF0" />
                                                <stop offset="1" stop-color="#0DC1D9" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                            <div class="link_item">
                                <div class="item_text">
                                    <span>Your Referral Link:</span>
                                    <strong id="Referral_link_modal">{{"https://britishmarketplace.co.uk" . $referral->link }}</strong>
                                </div>
                                <button type="button" onclick="copyFunction('Referral_link_modal')">
                                    <svg width="20" height="20" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.21168 11.1032C4.21168 9.53506 4.20886 7.96667 4.21168 6.39997C4.21422 5.334 4.87687 4.49193 5.8869 4.27085C6.05816 4.23564 6.23272 4.21892 6.40755 4.221C9.53861 4.218 12.6697 4.218 15.8007 4.221C17.0818 4.221 17.996 5.13855 17.9966 6.42053C17.9977 9.55055 17.9977 12.6807 17.9966 15.8109C17.9966 17.0796 17.075 18.0008 15.81 18.0014C12.6733 18.0014 9.53608 18.0014 6.39826 18.0014C5.14142 18.0014 4.21675 17.0861 4.21225 15.8292C4.20746 14.2521 4.21168 12.6775 4.21168 11.1032ZM5.62376 11.1085C5.62376 12.6637 5.62376 14.2189 5.62376 15.7743C5.62376 16.3282 5.88296 16.5876 6.4377 16.5876C9.54885 16.5876 12.6602 16.5876 15.7717 16.5876C16.325 16.5876 16.5851 16.3271 16.5851 15.7731C16.5851 12.6624 16.5851 9.55196 16.5851 6.44165C16.5851 5.88768 16.3256 5.62858 15.7709 5.62858C12.6593 5.62858 9.548 5.62858 6.43686 5.62858C5.88183 5.62858 5.62404 5.8874 5.62376 6.44277C5.62339 7.99849 5.62339 9.55374 5.62376 11.1085Z"
                                            fill="url(#paint0_linear_1_17912)"
                                        />
                                        <path
                                            d="M13.7542 2.77211H12.3737C12.3737 2.58736 12.3737 2.40346 12.3737 2.21927C12.3737 1.68812 12.0939 1.40593 11.5676 1.40593C8.44973 1.40593 5.33182 1.40593 2.21391 1.40593C1.6817 1.40593 1.40024 1.68389 1.40024 2.2111C1.40024 5.32779 1.40024 8.44496 1.40024 11.5626C1.40024 12.0932 1.68029 12.3742 2.20686 12.3757C2.39985 12.3757 2.59284 12.3757 2.79851 12.3757V13.7469C1.41799 13.9618 0.277515 13.3445 0.0245138 11.9893C0.00632056 11.8783 -0.00160414 11.7659 0.000845217 11.6536C-0.000281739 8.48053 -0.000281739 5.30752 0.000845217 2.1345C0.00281739 1.04995 0.723504 0.212951 1.7882 0.0310186C1.92413 0.0116586 2.06143 0.00356154 2.19869 0.0068024C5.32289 0.0068024 8.44738 0.0169344 11.5713 3.67134e-05C12.6983 -0.00615912 13.6114 0.772544 13.748 1.81682C13.788 2.12239 13.7542 2.43951 13.7542 2.77211Z"
                                            fill="url(#paint1_linear_1_17912)"
                                        />
                                        <defs>
                                            <linearGradient id="paint0_linear_1_17912" x1="4.50798" y1="4.81736" x2="16.4916" y2="17.4076" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#028FF0" />
                                                <stop offset="1" stop-color="#0DC1D9" />
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_1_17912" x1="0.29759" y1="0.598879" x2="12.2876" y2="13.1721" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#028FF0" />
                                                <stop offset="1" stop-color="#0DC1D9" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <ul class="social_link">
                            <li>
                            <button type="button" class="fb_share_icon">
                                <i>
                                    <svg width="24" height="16" class="mx-auto" viewBox="0 0 14 25"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" >
                                        <path d="M13.0823 13.9503L13.8098 9.46663H9.2662V6.54483C9.23638 6.20934 9.28614 5.87177 9.41186 5.55695C9.53758 5.24213 9.73606 4.95808 9.99266 4.72568C10.2493 4.49328 10.5575 4.31844 10.8946 4.21404C11.2318 4.10964 11.5893 4.07832 11.9408 4.12239H14V0.297495C12.7893 0.115183 11.5663 0.0157593 10.3405 0C6.60272 0 4.15188 2.12495 4.15188 6.03484V9.46663H0V13.9503H4.15188V24.8087C4.99942 24.937 5.85639 25.0009 6.71464 25C7.56919 25.0014 8.42247 24.9374 9.2662 24.8087V13.9503H13.0823Z"
                                        fill="white" />
                                    </svg>
                                </i>
                            </button>
                            <input type="hidden" name="" class="fb_share_link" value="{{'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fbritishmarketplace.co.uk%2Freferral%2F'.$code[2].'&amp;data-src=sdkpreparse'}}">
                            <div class="fb-share-button d-none" data-href="{{"https://britishmarketplace.co.uk" . $referral->link }}" data-layout="button" data-size="small">
                                <a target="_blank" href="{{'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fbritishmarketplace.co.uk%2Freferral%2F'.$code[2].'&amp;data-src=sdkpreparse'}}" class="fb-xfbml-parse-ignore">
                                    Share
                                </a>
                            </div>
                            </li>
                            <li>
                            <button type="button">
                                <i>
                                
                                <a target="_blank" class="twitter-share-button" href="{{'http://twitter.com/share?text=Join British Market Place and get Discount&url=https://britishmarketplace.co.uk' . $referral->link }}"
                                    data-size="large">
                                    <svg width="24" height="16" class="mx-auto" viewBox="0 0 17 15"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                        d="M16.9358 1.81492C16.3827 2.06975 15.8012 2.24667 15.2057 2.34125C15.4833 2.28404 15.8892 1.74626 16.06 1.52886C16.3135 1.18849 16.5054 0.800449 16.6261 0.384657C16.6261 0.384657 16.6261 0.304563 16.6261 0.281679C16.5951 0.269418 16.561 0.269418 16.53 0.281679C15.8852 0.650303 15.2 0.930913 14.4901 1.11695C14.4694 1.13124 14.4453 1.13884 14.4207 1.13884C14.3961 1.13884 14.372 1.13124 14.3513 1.11695C14.2962 1.0465 14.2355 0.981405 14.1697 0.922436C13.8771 0.649745 13.5453 0.429506 13.1872 0.270239C12.7025 0.0628003 12.1809 -0.0270774 11.66 0.00706724C11.1594 0.0405636 10.6714 0.18884 10.2289 0.441867C9.78 0.692572 9.38383 1.03914 9.06478 1.46021C8.73573 1.89643 8.4989 2.40392 8.3706 2.94768C8.2745 3.46513 8.2745 3.99779 8.3706 4.51524C8.3706 4.60678 8.37059 4.61822 8.29584 4.60678C5.59622 4.31523 3.09473 2.95687 1.2792 0.796572C1.19376 0.693594 1.15105 0.693594 1.08697 0.796572C0.723399 1.5185 0.5863 2.34659 0.695926 3.15844C0.805552 3.9703 1.15609 4.72281 1.69572 5.30474C1.83456 5.44205 1.97339 5.57936 2.12291 5.70522C1.65117 5.66518 1.19084 5.52927 0.766553 5.30474C0.691795 5.30474 0.649081 5.30475 0.638401 5.3734C0.62248 5.51783 0.62248 5.66377 0.638401 5.8082C0.720743 6.48616 0.969842 7.12848 1.36019 7.66933C1.75053 8.21018 2.26811 8.63012 2.85982 8.88611C3.00563 8.9477 3.15556 8.99742 3.30835 9.03486C2.86972 9.11013 2.4227 9.11013 1.98407 9.03486C1.87727 9.03486 1.84522 9.03486 1.87726 9.17216C2.10687 9.80991 2.48418 10.3745 2.9737 10.8129C3.46321 11.2513 4.04882 11.549 4.67537 11.678C4.80352 11.678 4.92101 11.678 5.04917 11.7352C4.50799 12.2562 3.85493 12.6257 3.14816 12.8107C2.22158 13.1659 1.23435 13.3025 0.253943 13.2112C0.0937462 13.2112 0.0617055 13.2112 0.0189863 13.2112C-0.0237329 13.2112 0.0189863 13.2799 0.0189863 13.3256C0.225463 13.4629 0.428387 13.5888 0.627743 13.7032C1.24242 14.0548 1.89046 14.3348 2.56079 14.5385C4.28812 15.0895 6.11973 15.1482 7.87471 14.7087C9.62969 14.2693 11.2473 13.3469 12.5678 12.0327C13.5163 10.9297 14.2496 9.63481 14.7246 8.22403C15.1996 6.81324 15.4067 5.31501 15.3338 3.81728C15.3338 3.70286 15.462 3.6342 15.5367 3.57699C16.0612 3.1602 16.5254 2.66285 16.9144 2.10097C16.9721 2.01863 17.0022 1.91785 16.9999 1.81492C16.9999 1.81492 16.9999 1.78059 16.9358 1.81492Z"
                                        fill="white"/>
                                    </svg>
                                    </a>
                                </i>
                            </button>
                            </li>
                            <li>
                                <button type="button">
                                    <i>
                                        <a target="_blank" href="{{'https://web.whatsapp.com/send?text=Join British Market Place and get Discount https://britishmarketplace.co.uk' . $referral->link}}" data-action="share/whatsapp/share">
                                            <svg width="24" height="16" class="mx-auto" viewBox="0 0 18 18"
                                                fill="none" xmlns="http://www.w3.org/2000/svg" >
                                                <path
                                                d="M0 18L1.29481 13.1824C0.562848 11.8673 0.179302 10.3877 0.180439 8.88353C0.183251 6.5265 1.12373 4.26697 2.79533 2.60128C4.46693 0.935603 6.73294 -1.67023e-06 9.09553 0C11.4571 0 13.722 0.935941 15.3919 2.60193C17.0619 4.26791 18 6.52747 18 8.88353C18 11.2406 17.0622 13.5012 15.3926 15.1689C13.723 16.8365 11.4581 17.7748 9.09553 17.7776C7.61467 17.7785 6.15648 17.4148 4.85025 16.7188L0 18ZM5.09433 14.8976L5.40212 15.0777C6.51514 15.7561 7.79126 16.122 9.09553 16.1365C11.0125 16.1309 12.8492 15.3679 14.2038 14.0146C15.5583 12.6613 16.3203 10.8278 16.3231 8.91529C16.3203 7.00379 15.5579 5.17137 14.2031 3.81973C12.8483 2.46809 11.0115 1.70751 9.09553 1.70471C7.17853 1.7075 5.34068 2.46774 3.98417 3.81908C2.62765 5.17042 1.86292 7.00281 1.85731 8.91529C1.86137 10.2379 2.22842 11.5342 2.91863 12.6635L3.10966 12.9706L2.41981 15.6388L5.09433 14.8976Z"
                                                fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12.9355 9.33766C12.7495 9.20009 12.5345 9.10317 12.3055 9.05367C12.0765 9.00417 11.839 9.00328 11.6096 9.05106C11.256 9.18905 11.046 9.70917 10.814 9.97454C10.769 10.0381 10.7002 10.0825 10.6219 10.0983C10.5436 10.1141 10.4619 10.1002 10.3941 10.0595C9.12626 9.59124 8.06496 8.71785 7.38867 7.58622C7.32576 7.52137 7.29075 7.43603 7.29075 7.34738C7.29075 7.25874 7.32576 7.1734 7.38867 7.10855C7.6421 6.87488 7.82856 6.58242 7.93009 6.25937C7.96675 5.88982 7.88173 5.51853 7.687 5.19789C7.54818 4.75873 7.27944 4.36781 6.91352 4.07272C6.73028 4.00398 6.53128 3.98347 6.33703 4.01333C6.14278 4.04319 5.96033 4.12232 5.80856 4.24256C5.54286 4.45983 5.33215 4.73236 5.19239 5.0395C5.05263 5.34664 4.98753 5.68031 5.00197 6.01523C5.00215 6.20805 5.02438 6.40027 5.06827 6.58843C5.19122 7.02687 5.3811 7.4454 5.63177 7.83036C5.81961 8.12757 6.00745 8.41417 6.21739 8.69016C6.91273 9.60083 7.78284 10.3755 8.78089 10.9723C9.27991 11.2721 9.81397 11.5144 10.372 11.6941C10.9494 11.9465 11.5866 12.0454 12.2173 11.9807C12.5713 11.9338 12.9087 11.8075 13.2024 11.612C13.4961 11.4166 13.7378 11.1574 13.9079 10.8556C13.9932 10.6614 14.02 10.448 13.9852 10.2399C13.8858 9.79409 13.2891 9.54995 12.9355 9.33766Z"
                                                fill="white" />
                                            </svg>
                                        </a>
                                    </i>
                                </button>
                            </li>
                            <li>
                                <button type="button">
                                    <i>
                                        <a target="_blank" id="emailMe" href="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                                                <path d="M15.5 31C24.0604 31 31 24.0604 31 15.5C31 6.93959 24.0604 0 15.5 0C6.93959 0 0 6.93959 0 15.5C0 24.0604 6.93959 31 15.5 31Z" fill="black"/>
                                                <path d="M24 19.8366C23.9532 19.9833 23.9024 20.1339 23.8624 20.2657L18.7265 15.0912L23.8712 9.91776L24 10.321V19.8366Z" fill="white"/>
                                                <path d="M23.1365 9.15972C22.879 9.41537 22.636 9.65516 22.3989 9.89397C20.2525 12.0779 18.106 14.2628 15.9595 16.4487C15.658 16.7549 15.3302 16.7559 15.0316 16.4487L7.9873 9.27169C7.95218 9.23701 7.91998 9.19935 7.85168 9.12602C8.04682 9.08143 8.21756 9.03982 8.38635 9.00811C8.45107 8.99992 8.5164 8.99793 8.58149 9.00216H22.4038C22.6571 8.99307 22.9086 9.04717 23.1365 9.15972V9.15972Z" fill="white"/>
                                                <path d="M17.986 15.8294L23.1473 21.0217C22.9424 21.0683 22.7755 21.1099 22.6077 21.1426C22.5361 21.1507 22.464 21.1524 22.3921 21.1476H8.59904C8.35158 21.159 8.1051 21.109 7.88095 21.0019L13.0159 15.8393C13.4481 16.2753 13.9047 16.7401 14.3653 17.2018C14.8658 17.7032 15.5702 17.837 16.182 17.5278C16.3574 17.4334 16.5179 17.3128 16.6581 17.1701C17.0718 16.7648 17.4728 16.3447 17.8796 15.9315C17.9216 15.8899 17.9655 15.8493 17.986 15.8294Z" fill="white"/>
                                                <path d="M7.14042 9.89594L12.2715 15.0605L7.13554 20.233C7.03905 20.0289 6.99284 19.8042 7.0009 19.578C7.0009 17.9879 7.0009 16.3975 7.0009 14.8068C7.0009 13.3912 7.0009 11.9752 7.0009 10.5588C6.99682 10.3299 7.04456 10.1031 7.14042 9.89594V9.89594Z" fill="white"/>
                                            </svg>
                                        </a>
                                    </i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function copyFunction(id) {

        var copyText = document.getElementById(id);

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.innerHTML);

        // Alert the copied text
        alert("Copied Sussessfully");
    }
    
    $(document).on('click', '.fb_share_icon', function (e) {
        e.preventDefault();
        let url = $('.fb_share_link').val();
        window.open(url, '_blank', 'popup');
    });
    
    $(document).on('click', '#emailMe', function (e) {
        e.preventDefault();
        let refer_link = $('#Referral_link_modal').html();
        let url = 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&su=Join+British+Market+Place+and+get+Discount&body=go+to '+ refer_link +'&ui=2&tf=1&pli=1';

        window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');

    });
</script>
<!-- profile area ends  -->
@endsection