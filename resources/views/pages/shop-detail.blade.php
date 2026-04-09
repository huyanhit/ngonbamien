@extends('layouts.app')
@section('content')
    <x-breadcrumb name="san-pham" title="Chi Tiết Sản Phẩm" :data="$product"></x-breadcrumb>
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                @if(!empty($product))
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic border">
                        <a class="product__details__pic__item" data-lightbox="roadtrip" id="product_details_pic_large"
                            data-title="{{$product->title}}"
                            href="{{$product->image->uri}}">
                            <img class="product__details__pic__item--large" 
                            src="{{Request::root()}}/{{$product->image->uri?? ''}}" alt="{{$product->title}}">
                        </a>
                        <div class="product__details__pic__slider owl-carousel">
                            @if($product->images)
                                <img data-imgbigurl="{{Request::root()}}/{{$product->image->uri?? ''}}" 
                                    src="{{Request::root()}}/{{$product->image->uri?? ''}}"
                                    alt="{{$product->title}}"
                                    onerror="this.src='/images/no-image.png'"
                                    onclick="document.getElementById('product_details_pic_large').href=this.src">
                                @foreach(json_decode($product->images) as $id)
                                    <img data-imgbigurl="{{route('get-image', $id)}}" 
                                         src="{{route('get-image', $id)}}" alt="{{$product->title}}"
                                         onerror="this.src='/images/no-image.png'"
                                         onclick="document.getElementById('product_details_pic_large').href=this.src">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h2 class="fw-bold">{{$product->title}}</h2>
                        <div class="product__details__rating">
                            @for($i = 1; $i < 6; $i ++)
                                {!! $comments->avg('rating') >= $i ? '<i class="fa fa-star"></i>':
                                ($i > ($comments->avg('rating') + 0.5)? '<i class="fa fa-star-o"></i>' :'<i class="fa fa-star-half-o"></i>')!!}
                            @endfor
                            <a data-toggle="tab" href="#tabs-3" class="text-danger"
                                onclick='window.scrollTo({top: 850, left:0, behavior: "smooth"});'>
                                ({{$comments->total()}} đánh giá)
                            </a>
                        </div>
                        @foreach ($product->product_option as $key => $item)
                            <div class="product_detail_option {{$key === 0 ?'active':''}} product_detail_{{$item->id}}">
                                @if(empty($item->price) || ($item->price < $item->price_root))
                                    <h4><b class="text-danger">Liên hệ</b></h4>
                                @else
                                    @if($item->discount > 0)
                                        <span class="product__details__price">
                                        <span class="text-muted" style="font-weight: 600; font-size: 18px;"> Giá:</span>
                                            {{ number_format($item->price - ($item->price * $item->discount /100), 0, ',', '.') }}đ
                                        </span>
                                        <span class="product_detail_price_root text-muted"> {{ number_format($item->price, 0, ',', '.') }}đ</span>
                                        <span class="product_detail_discount">-{{$item->discount}}%</span>
                                    @else
                                        <span class="product__details__price">
                                            {{ number_format($item->price - ($item->price * $item->discount /100), 0, ',', '.') }}đ
                                        </span>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        <div class="my-3">
                            <span class="option_type text-muted"> Phân loại: </span>
                            <div class="form-check form-check-inline">
                                @foreach ($product->product_option as $key => $item)
                                    @if (!empty($item->title))
                                        <a class="m-2 select_price_option btn btn-outline-dark rounded-pill
                                            select_price_{{$item->id}} {{$key === 0 ?'active':''}}"
                                            data-value="{{$item->id}}">
                                            {{$item->title}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="my-3">
                            <a href="#" class="heart-icon border primary-btn add_favor" data-value="{{$product->id}}">
                                <span class="icon_heart_alt"></span> Yêu thích </a>
                            <a href="#" class="heart-icon border primary-btn"><span class="icon_cloud_alt"></span> Chia Sẻ </a>
                            <a href="#" class="heart-icon border primary-btn"><span class="icon_chat_alt"></span> Tư Vấn </a>
                        </div>
                        <div class="my-3 pt-2">
                            <div class="product__details__quantity border">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                            </div>
                            <a data-value="{{$product->id}}" href="javascript:void(0)" class="primary-btn add_cart_detail">Thêm vào giỏ</a>
                            <a data-value="{{$product->id}}" data-link="{{Request::root()}}/dat-hang"
                               class="primary-btn bg-danger text-white add_cart_detail">Mua ngay</a>
                        </div>
                        <p>{!! $product->description !!}</p>
                        @if($product->supplier)
                            <div class="row bg-light p-2 border m-0">
                                <div class="col-lg-7 col-sm-12">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24 p-2 border">
                                                @if($product->supplier->image_id)
                                                <img 
                                                    src="{{route('get-image', $product->supplier->image_id)}}" 
                                                    alt="{{$product->supplier->title}}"
                                                    onerror="this.src='/images/no-image.png'" style="max-width: 50px"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ml-3">
                                            <div class="shop">
                                                <div class="shop-name text-bold">{{$product->supplier->title}}</div>
                                                <div class="online small">Online 23 phút trước</div>
                                            </div>
                                            <div class="d-flex mt-2">
                                                <button type="button" class="btn btn-outline-secondary waves-effect waves-light mr-3 btn-sm shop_chat"
                                                    data-value="{{$product->supplier->id}}">
                                                    <i class="ri-file-copy-2-fill"></i>Chat ngay
                                                </button>
                                                <a href="{{route('chi-tiet-san-pham', $product->supplier->slug)}}" 
                                                        class="btn btn-outline-success waves-effect waves-light btn-sm">
                                                        <i class="ri-file-copy-2-fill"></i>
                                                    Xem shop
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-5 col-sm-12">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 pt-1 small">
                                            <div>
                                                <span class="text-muted">Sản phẩm:</span>
                                                <span class="text-body">50</span>
                                            </div>
                                            <div>
                                                <span class="text-muted">Đánh giá:</span>
                                                <span class="text-body">4.5 <i class="fa fa-star text-warning"></i> - 123k</span>
                                            </div>
                                            <div>
                                                <span class="text-muted">Kho hàng:</span>
                                                <span class="text-body">{{$product->supplier->warehouse}}</span>
                                            </div>
                                            <div>
                                                <span class="text-muted">Điện thoại:</span>
                                                <span class="text-body">{{$product->supplier->phone}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="my-3 text-center">
                                        <h6 class="text-body">Hổ trợ từ Shop</h6>
                                        <div class="pt-1">
                                            @php $supplier_support = $product->supplier->supplier_support @endphp
                                            @foreach ($supplier_support as $sp)
                                                @switch($sp->support_id)
                                                    @case(1)
                                                        <span class="badge badge border border-info text-info">
                                                            # Miễn phí ship đơn từ {{$sp->value_1/1000}}k</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge badge border border-success text-success">
                                                            # Giảm {{$sp->value_1/1000}}k cho đơn từ {{$sp->value_2/1000}}k
                                                            </span>
                                                        @break
                                                    @default
                                                @endswitch
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
               
                <div class="col-lg-12">
                    <div class="product__details__tab" id="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase" data-toggle="tab" href="#tabs-1" role="tab"
                                   aria-selected="true">Chi tiết</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" data-toggle="tab" href="#tabs-2" role="tab"
                                   aria-selected="false">Chế biến</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase" data-toggle="tab" href="#tabs-3" role="tab"
                                   aria-selected="false">Đánh giá <span>({{$comments->total()}})</span></a>
                            </li>
                        </ul>
                        <div class="tab-content doc-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    {!! $product->content !!}
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                   {!! $product->make !!}
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc tab__ccomment">
                                    <x-review-block :data="['product_id' => $product->id]" :comments="$comments"></x-review-block>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Sản phẩm tương tự -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Sản phẩm tương tự</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($r_products as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <x-product-item :item="$item"/>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End sản phẩm tương tự -->
@endsection
