@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Total Convert History')}}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Amount')}}</th>
                                    <th>{{ translate('Wallet Address')}}</th>
                                    <th data-breakpoints="lg">{{ translate('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($history as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{$item->balance}}</td>
                                        <td>{{$item->wallet_address}}</td>
                                        <td>
                                            @if($item->status == 0)
                                                <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                                            @elseif($item->status == 1)
                                                <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>

                                            @else
                                                <span class="badge badge-inline badge-danger">{{translate('Rejected')}}</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
{{--                            <div class="aiz-pagination">--}}
{{--                                {{ $history->links() }}--}}
{{--                            </div>--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

