@extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Total Convert History') }}</h5>
        </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('User ID')}}</th>
                        <th>{{ translate('Amount')}}</th>
                        <th>{{ translate('Transaction Hash')}}</th>
                        <th>{{ translate('Status')}}</th>
                        <th>{{ translate('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($history as $key => $item)
                        <tr>
                            <td>
                                {{ $key+1 }}
                            </td>
                            <td>{{$item->user_id}}</td>
{{--                            <td>{{$item->user->name}}</td>--}}
                            <td>{{$item->amount}}</td>
                            <td>{{$item->transaction_hash}}</td>
                            <td>
                                @if($item->status == 0)
                                    <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                                @elseif($item->status == 1)
                                    <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>

                                @else
                                    <span class="badge badge-inline badge-danger">{{translate('Rejected')}}</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 0)
                                    <a href="{{route('seller.total.history.status.approve',$item->id)}}" class="btn btn-sm btn-primary">Approve</a>
                                    <a href="{{route('seller.total.history.status.reject',$item->id)}}" class="btn btn-sm btn-warning">Reject</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="aiz-pagination">--}}
{{--                    {{ $history->links() }}--}}
{{--                </div>--}}
            </div>
    </div>

@endsection
