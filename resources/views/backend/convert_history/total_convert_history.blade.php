@extends('backend.layouts.app')

@section('content')
    <div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th data-breakpoints="lg">{{translate('User ID')}}</th>
                <th data-breakpoints="lg">{{translate('Amount')}}</th>
                <th data-breakpoints="lg">{{translate('Wallet Address')}}</th>
                <th data-breakpoints="lg">{{translate('Status')}}</th>
                <th data-breakpoints="lg">{{translate('Action')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($history as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>G{{$item->balance}}</td>
                        <td>{{$item->wallet_address}}</td>
                        <td>
                            @if($item->status == 0)
                                Pending
                            @else
                            Approved
                            @endif
                        </td>
                        @if($item->status == 0)
                            <td>
                                <a href="{{route('total.convert.status.change',$item->id)}}" class="btn btn-primary btn-sm">Paid</a>
                            </td>
                        @else
                            <td></td>
                        @endif
                    </tr>
            @endforeach
            </tbody>
        </table>
{{--        <div class="aiz-pagination">--}}
{{--            {{ $history->appends(request()->input())->links() }}--}}
{{--        </div>--}}
    </div>
    </div>
@endsection
