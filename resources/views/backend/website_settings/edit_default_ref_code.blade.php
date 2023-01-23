@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h6 class="fw-600 mb-0">Edit Default Ref. Code</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('save.default.ref.code') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Default Referral Code</label>
                            <div class="col-md-8">
{{--                                <input type="hidden" name="code" value="website_name">--}}
                                <input type="text" name="ref_code" class="form-control" value="{{$code}}">
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
