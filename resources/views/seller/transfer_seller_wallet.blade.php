@extends('seller.layouts.app')

@section('panel_content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Add New Product')}}</h5>
    </div>
    <div class="">
        <!-- Error Meassages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="form form-horizontal mar-top" action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8">
                    @csrf
                    <input type="hidden" name="added_by" value="admin">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Transfer Wallet</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Wallet Address<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="wallet_address" placeholder="Wallet Address" required>
                                </div>

                                <label class="col-md-3 mt-3 col-from-label">Balance<span class="text-danger">*</span></label>
                                <div class="col-md-8 mt-3">
                                    <input type="text" class="form-control" name="balance" placeholder="Balance" required>
                                </div>

                                <label class="col-md-3 mt-3 col-from-label">Transaction ID<span class="text-danger">*</span></label>
                                <div class="col-md-8 mt-3">
                                    <input type="text" class="form-control" name="transaction_id" placeholder="Transaction ID" required>
                                </div>

                                <div class="col-md-8 mt-3">
                                    <button class="btn btn-primary" type="submit" class="form-control" >Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
