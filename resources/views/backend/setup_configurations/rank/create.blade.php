
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<form action="{{ route('rank.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Add New Rank')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-sm-2 col-from-label" for="name">{{translate('Rank Name')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{translate('Rank Name')}}" id="name" name="rank_name"
                       class="form-control" >
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-from-label" for="symbol">{{translate('Percentage')}}</label>
            <div class="col-sm-10">
                <input type="text" placeholder="{{translate('Percentage')}}" id="symbol" name="percentage"
                       class="form-control" >
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-from-label" for="code">{{translate('Package')}} (per month)</label>
            <div class="col-sm-10">
{{--                <input type="text" placeholder="{{translate('Package')}}" id="code" name="package_per_month"--}}
{{--                       class="form-control" required>--}}
{{--            </div>--}}

            <div class="mb-3 repeatDiv" id="repeatDiv">
                <select class="form-control" id="sel1" name="package_name[]">
                    <option>Select Package</option>
                    @foreach($pacakges as $package)
                        <option value="{{$package->id}}">{{$package->name}}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" class="btn btn-info" id="repeatDivBtn" data-increment="1">Add More Input</button>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
    </div>
</form>

        <script type="text/javascript">
        $(document).ready(function () {

            $("#repeatDivBtn").click(function () {

                $newid = $(this).data("increment");
                $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
                $('#repeatDiv').unwrap();
                $($repeatDiv).insertAfter($(".repeatDiv").last());
                $(".repeatDiv").last().attr('id',   "repeatDiv" + '_' + $newid);
                $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv'+'_'+ $newid+'">Remove</button></div>');
                $newid++;
                $(this).data("increment", $newid);

            });


            $(document).on('click', '.removeDivBtn', function () {

                $divId = $(this).data("id");
                $("#"+$divId).remove();
                $inc = $("#repeatDivBtn").data("increment");
                $("#repeatDivBtn").data("increment", $inc-1);

            });

        });
    </script>



