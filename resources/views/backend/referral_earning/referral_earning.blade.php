@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Referral Earning</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($ref_earning as $item)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$item->user->name}}</td>
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
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $ref_earning->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')

    <div class="modal fade" id="affiliate_withdraw_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="affiliate_withdraw_reject_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Affiliate Withdraw Request Reject')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{translate('Are you sure, You want to reject this?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <a href="#" id="reject_link" class="btn btn-primary">{{ translate('Reject') }}</a>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script type="text/javascript">
        function show_affiliate_withdraw_modal(id) {
            $.post('{{ route('affiliate_withdraw_modal') }}', {_token: '{{ @csrf_token() }}', id: id}, function (data) {
                $('#affiliate_withdraw_modal #modal-content').html(data);
                $('#affiliate_withdraw_modal').modal('show', {backdrop: 'static'});
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }

        function affiliate_withdraw_reject_modal(reject_link) {
            $('#affiliate_withdraw_reject_modal').modal('show');
            document.getElementById('reject_link').setAttribute('href', reject_link);
        }

    </script>
@endsection
