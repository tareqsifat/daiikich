<form action="{{ route('your_rank.update') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $rank->id }}">
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Update Rank')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-sm-2 col-from-label" for="name">{{translate('Rank Name')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{translate('Rank Name')}}" id="name" name="rank_name"
                       value="{{ $rank->rank_name }}" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-from-label" for="symbol">{{translate('Percentage')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{translate('Percentage')}}" id="symbol" name="percentage"
                       value="{{ $rank->percentage }}" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-from-label" for="code">{{translate('Package')}} (per month)</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{translate('Package')}}" id="code" name="package_per_month"
                       value="{{ $rank->package_per_month }}" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
    </div>
</form>
