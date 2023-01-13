@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All Ranks')}}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a onclick="currency_modal()" href="#" class="btn btn-circle btn-primary">
                    <span>{{translate('Add New Rank')}}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('All Ranks') }}</h5>
            </div>
            <div class="col-md-4">
                <form class="" id="sort_currencies" action="" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search"
                               @isset($sort_search) value="{{ $sort_search }}"
                               @endisset placeholder="{{ translate('Type name & Enter') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Rank Name')}}</th>
                    <th>{{translate('Percentage')}}</th>
                    <th>{{translate('Package')}} (per month)</th>
                    <th data-breakpoints="lg">{{translate('Status')}}</th>
                    <th class="text-right">{{translate('Options')}}</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($ranks as $key=> $rank)
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{$rank->rank_name}}</td>
                        <td>{{$rank->percentage}}%</td>
                        <td>{{$rank->package_per_month}}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_currency_status(this)" value="{{ $rank->id }}"
                                       type="checkbox" <?php if ($rank->status == 1) echo "checked";?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                               onclick="edit_currency_modal('{{$rank->id}}');" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $ranks->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')

    <!-- Delete Modal -->
    @include('modals.delete_modal')

    <div class="modal fade" id="add_currency_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="currency_modal_edit">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        function sort_currencies(el) {
            $('#sort_currencies').submit();
        }

        function currency_modal() {
            $.get('{{ route('rank.create') }}', function (data) {
                $('#modal-content').html(data);
                $('#add_currency_modal').modal('show');
            });
        }

        function update_currency_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }

            $.post('{{ route('rank.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Rank Status updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function edit_currency_modal(id) {
            $.post('{{ route('rank.edit') }}', {_token: '{{ @csrf_token() }}', id: id}, function (data) {
                $('#currency_modal_edit .modal-content').html(data);
                $('#currency_modal_edit').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endsection
