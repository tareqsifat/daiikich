 <div class="modal-header">
        <h5 class="modal-title h6">Affiliate User Info.</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        @foreach($affiliate_users as $user)
            <h3>Name: {{$user->name}}</h3>
            <h5>Email: {{$user->email}}</h5>
            <h5>Total Sale Volume: {{$user->affiliate_user->total_sale_volume}}</h5>
        @endforeach
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
    </div>
