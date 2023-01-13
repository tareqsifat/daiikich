@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="mb-0 h6">{{translate('Token Transfer Histories')}}</h3>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Date') }}</th>
                    <th>{{translate('From')}}</th>
                    <th>{{translate('To')}}</th>
                    <th>{{translate('Amount')}}</th>
                    <th>{{ translate('Status') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tokens as $key => $token)

                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $token->created_at }}</td>
                            <td>
                                {{$token->user->name}}
                            </td>
                            <td>
                                {{$token->transferUser->name}}
                            </td>
                            <td>
                                {{ single_price($token->amount) }}
                            </td>
                            <td>
                                @if($token->status==0) Pending
                                @else
                                Successful
                                    @endif
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $tokens->links() }}
            </div>
        </div>
    </div>

@endsection
