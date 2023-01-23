<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /*Now the CSS*/
        * {
            margin: 0;
            padding: 0;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*We will use ::before and ::after to draw the connectors*/

        .tree li::before, .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }

        /*We need to remove left-right connectors from elements without
        any siblings*/
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        /*Remove space from the top of single children*/
        .tree li:only-child {
            padding-top: 0;
        }

        /*Remove left connector from first child and
        right connector from last child*/
        .tree li:first-child::before, .tree li:last-child::after {
            border: 0 none;
        }

        /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        /*Time to add downward connectors from parents*/
        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }

        .tree li a {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            display: inline-block;

            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*Time for some hover effects*/
        /*We will apply the hover effect the the lineage of the element also*/
        .tree li a:hover, .tree li a:hover + ul li a {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }

        /*Connector styles on hover*/
        .tree li a:hover + ul li::after,
        .tree li a:hover + ul li::before,
        .tree li a:hover + ul::before,
        .tree li a:hover + ul ul::before {
            border-color: #94a0b4;
        }
    </style>
</head>
<body>
@extends('frontend.layouts.tree_user_panel')


@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Your Affiliated Tree</h5>
        </div>
        <div class="card-body" style="display: block;margin-left: auto; margin-right: auto;">
            <div class="tree">
                <ul>
                    <li>
                        <a href="#">{{Auth::user()->name}}</a>
                        <ul>
                            {{-- First level users foreach--}}
                            @foreach($first_level_users as $first_level_user)
                                <li>
                                    <a onclick="edit_currency_modal('{{$first_level_user->user_id}}');">{{$first_level_user->user->name}}</a>
                                    {{-- Second level users foreach--}}
                                    @if(App\Models\Tree::where('referral_id', $first_level_user->user_id)->first() != null)
                                        <ul>
                                            @foreach(App\Models\Tree::where('referral_id', $first_level_user->user_id)->get() as $second_level_user)
                                                <li>
                                                    <a onclick="edit_currency_modal('{{$second_level_user->user->id}}')">{{$second_level_user->user->name}}</a>
                                                    {{-- Third level users foreach--}}
                                                    @if(App\Models\Tree::where('referral_id', $second_level_user->user_id)->first() != null)
                                                        <ul>
                                                            @foreach(App\Models\Tree::where('referral_id', $second_level_user->user_id)->get() as $third_level_user)
                                                                <li>
                                                                    <a onclick="edit_currency_modal('{{$third_level_user->user->id}}')">{{$third_level_user->user->name}}</a>

                                                                {{-- Fourth level users foreach--}}
                                                                @if(App\Models\Tree::where('referral_id', $third_level_user->user_id)->first() != null)
                                                                    <ul>
                                                                        @foreach(App\Models\Tree::where('referral_id', $third_level_user->user_id)->get() as $fourth_level_user)
                                                                            <li>
                                                                                <a onclick="edit_currency_modal('{{$fourth_level_user->user->id}}')">{{$fourth_level_user->user->name}}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <script>
        function edit_currency_modal(id) {
            $.post('{{ route('view.affiliated.user.info') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function (data) {
                $('#currency_modal_edit .modal-content').html(data);
                $('#currency_modal_edit').modal('show', {backdrop: 'static'});
            });
        }
    </script>
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
</body>
</html>


