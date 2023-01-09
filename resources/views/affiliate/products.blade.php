@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="form-box-content p-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="h6" style="margin-bottom: 5px;">Search product to create affiliate product</h5>
                </div>
                <div class="col-md-12">
                    <form action="http://localhost/daiikich/produt-only-ajax-search" method="GET" class="ajax_search_product">
                        <input type="hidden" name="_token" value="BGWxKTbY9jZ6OcSFdTn2g2S6HtO7hNehGEKpjaJM" />
                        <div class="d-flex position-relative align-items-center">
                            <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                            </div>
                            <div class="input-group">
                                <input type="text" class="border-0 border-lg form-control search_input_box" id="search" name="keyword" placeholder="Search product" autocomplete="off" />
                                <div class="input-group-append d-none d-lg-block">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="la la-search la-flip-horizontal fs-18"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="px-2 py-1 text-uppercase fs-12 text-center text-muted bg-soft-secondary" style="margin-top: 15px;">Products</div>
                    <ul class="list-group list-group-raw search_product_show">
                        <li class="list-group-item search_affiliate_product">
                            <a class="text-reset" href="http://localhost/daiikich/product/iphone-11">
                                <div class="d-flex search-product align-items-center">
                                    <div class="mr-3">
                                        <img class="size-40px img-fit rounded" src="http://localhost/daiikich/public/uploads/all/xbcB0OuZwcL3x4b5qnid7UmONiHGNIk5TSo5dmq5.png" />
                                    </div>
                                    <div class="flex-grow-1 overflow--hidden minw-0">
                                        <div class="product-name text-truncate fs-14 mb-5px">Iphone 11</div>
                                        <div class=""><span class="fw-600 fs-16 text-primary">$2,200.00</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item search_affiliate_product">
                            <a class="text-reset" href="http://localhost/daiikich/product/laptop">
                                <div class="d-flex search-product align-items-center">
                                    <div class="mr-3">
                                        <img class="size-40px img-fit rounded" src="http://localhost/daiikich/public/uploads/all/Y5kwH0dpcQ7kJ0U4U8md6Z3NzeTXVjA8l3mnx0fA.jpg" />
                                    </div>
                                    <div class="flex-grow-1 overflow--hidden minw-0">
                                        <div class="product-name text-truncate fs-14 mb-5px">Aspire 3 | A315-35-C2EV</div>
                                        <div class=""><span class="fw-600 fs-16 text-primary">$429.50</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item search_affiliate_product">
                            <a class="text-reset" href="http://localhost/daiikich/product/misterg-std15">
                                <div class="d-flex search-product align-items-center">
                                    <div class="mr-3">
                                        <img class="size-40px img-fit rounded" src="http://localhost/daiikich/public/uploads/all/hcKeucY3ntoOEs6fFU4BIAeq0CFkTWWMqQFjfQTB.png" />
                                    </div>
                                    <div class="flex-grow-1 overflow--hidden minw-0">
                                        <div class="product-name text-truncate fs-14 mb-5px">MisterG STD15</div>
                                        <div class=""><span class="fw-600 fs-16 text-primary">$51.60</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="form-box-content p-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="h6" style="margin-bottom: 5px;">All products</h5>
                </div>
                <div class="col-md-12">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>{{translate('Name')}}</th>
                                <th data-breakpoints="sm">{{translate('Info')}}</th>
                                <th data-breakpoints="md">{{translate('Total Stock')}}</th>
                                <th data-breakpoints="lg">Affiliate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                            <tr>
                                <td>
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">
                                        <div class="col-auto">
                                            <img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="size-50px img-fit">
                                        </div>
                                        <div class="col">
                                            <span class="text-muted text-truncate-2">{{ $product->getTranslation('name') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{translate('Num of Sale')}}:</strong> {{ $product->num_of_sale }} {{translate('times')}} </br>
                                    <strong>{{translate('Base Price')}}:</strong> {{ single_price($product->unit_price) }} </br>
                                    <strong>{{translate('Rating')}}:</strong> {{ $product->rating }} </br>
                                </td>
                                <td>
                                    @php
                                        $qty = 0;
                                        if($product->variant_product) {
                                            foreach ($product->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                                echo $stock->variant.' - '.$stock->qty.'<br>';
                                            }
                                        }
                                        else {
                                            //$qty = $product->current_stock;
                                            $qty = optional($product->stocks->first())->qty;
                                            echo $qty;
                                        }
                                    @endphp
                                    @if($qty <= $product->low_stock_quantity)
                                        <span class="badge badge-inline badge-danger">Low</span>
                                    @endif
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->todays_deal == 1) echo "checked"; ?> >
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function update_todays_deal(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        console.log(status);
        $.post('{{ route('affiliate.product.update') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                AIZ.plugins.notify('success', '{{ translate('affiliate updated successfully') }}');
            }
            else{
                AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
            }
        });
    }
</script>

@endsection
