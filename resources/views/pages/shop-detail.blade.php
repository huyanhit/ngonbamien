@extends('layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{Request::root()}}/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12 breadcrumb__option">
                    <a href="./index.html">Home</a>
                    <a href="./index.html">Vegetables</a>
                    <span>Vegetable’s Package</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                @if(!empty($product))
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <a class="product__details__pic__item" data-lightbox="roadtrip"
                            data-title="{{$product->title}}"
                            href="{{$product->image->uri}}">
                            <img class="product__details__pic__item--large"
                            src="{{Request::root()}}/{{$product->image->uri?? ''}}" alt="{{$product->title}}">
                        </a>
                        <div class="product__details__pic__slider owl-carousel">
                            @if($product->images)
                                @foreach(explode(',',$product->images) as $id)
                                    <img data-imgbigurl="{{route('get-image', $id)}}" src="{{route('get-image', $id)}}" alt="{{$product->title}}"
                                         onerror="this.src='/images/no-image.png'">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h2 class="fw-bold">{{$product->title}}</h2>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        @foreach ($product->product_option as $key => $item)
                            <div class="product_detail_option {{$key === 0 ?'active':''}} product_detail_{{$item->id}}">
                                @if(empty($item->price) || ($item->price < $item->price_root))
                                    <h4><b class="text-danger">Liên hệ</b></h4>
                                @else
                                    @if($item->discount > 0)
                                        <span class="product__details__price">
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
                                        <a class="m-2 select_price_option btn btn-outline-dark rounded-pill select_price_{{$item->id}} {{$key === 0 ?'active':''}}"
                                            data-value="{{$item->id}}">
                                            {{$item->title}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="my-3">
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                            </div>
                            <a onclick="addCart(this, {id: {{$item->id}}})" href="javascript:void(0)" class="primary-btn">Thêm vào giỏ</a>
                            <a onclick="addCart(this, {id: 18}, 'dat-hang')" href="javascript:void(0)" class="primary-btn bg-danger">Mua ngay</a>
                            <a href="#" class="heart-icon border"><span class="icon_heart_alt"></span></a>
                        </div>
                        <p>{!! $product->description !!}</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
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
                                   aria-selected="false">Đánh giá <span>(1)</span></a>
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
                                <div class="product__details__tab__desc">
                                    <x-review-block :data="['product_id' => $product->id]"></x-review-block>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
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
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic">
                            <img src="{{Request::root()}}/img/product/product-1.jpg" alt="">
                            <ul class="product__item__pic__hover">
                                <li><span href="#"><i class="fa fa-heart"></i></span></li>
                                <li><span href="#"><i class="fa fa-retweet"></i></span></li>
                                <li><span href="#"><i class="fa fa-shopping-cart"></i></span></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{Request::root()}}/img/product/product-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><span href="#"><i class="fa fa-heart"></i></span></li>
                                <li><span href="#"><i class="fa fa-retweet"></i></span></li>
                                <li><span href="#"><i class="fa fa-shopping-cart"></i></span></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{Request::root()}}/img/product/product-3.jpg">
                            <ul class="product__item__pic__hover">
                                <li><span href="#"><i class="fa fa-heart"></i></span></li>
                                <li><span href="#"><i class="fa fa-retweet"></i></span></li>
                                <li><span href="#"><i class="fa fa-shopping-cart"></i></span></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{Request::root()}}/img/product/product-7.jpg">
                            <ul class="product__item__pic__hover">
                                <li><span href="#"><i class="fa fa-heart"></i></span></li>
                                <li><span href="#"><i class="fa fa-retweet"></i></span></li>
                                <li><span href="#"><i class="fa fa-shopping-cart"></i></span></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection
