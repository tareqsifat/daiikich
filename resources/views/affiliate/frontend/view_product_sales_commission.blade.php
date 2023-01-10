@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="card col-md-10">
                    <div class="card-header">
                        <h5 class="mb-0 h6">@if($report==0)Total Product Sales Commission @else Total MLM Sales Commission @endif</h5>
                    </div>
                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sales_commission_table as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>@if($item->type==1)
                                            Product Direct Sales Commission
                                        @elseif($item->type==2)
                                            MLM Sales Direct Commission
                                        @else
                                            Level Commission

                                        @endif
                                    </td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        @if($item->status == 0)
                                            Pending
                                        @else
                                            Success
                                        @endif
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        @if($affiliate_withdraw_request->status == 1)--}}
                                    {{--                                            <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>--}}
                                    {{--                                        @elseif($affiliate_withdraw_request->status == 2)--}}
                                    {{--                                            <span class="badge badge-inline badge-danger">{{translate('Rejected')}}</span>--}}
                                    {{--                                        @else--}}
                                    {{--                                            <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>--}}
                                    {{--                                        @endif--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="aiz-pagination">
                            {{ $sales_commission_table->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

