@extends('layouts.app')
@section('content')
    <!-- Hero Section End -->
    <x-breadcrumb name="khuyen-mai" title="Sản Phẩm Đang Giảm Giá"></x-breadcrumb>
    <!-- Hero Section Begin -->
    <section class="hero background mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <x-hero-search :sites="$sites"/>
                </div>
            </div>
        </div>
    </section>
    @if(isset($promotions) && !empty($promotions))
        <section class="product_section margin_15">
        <div class="container">
            <div class="row filter__list">
                @if(!$promotions->isEmpty())
                    @foreach ($promotions as $item)
                        <div class="col-lg-3">
                            <div class="product__discount__item my-2">
                                <div class="featured__item__pic">
                                    <a href="{{Request::root()}}/san-pham/{{$item->slug}}" >
                                        <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->uri??'')}}"
                                             alt="{{$item->title}}">
                                    </a>
                                    <div class="product__discount__percent">-{{$item->discount}}%</div>
                                    <ul class="product__item__pic__hover">
                                        <li><span title="Yêu thích" class="add_favor"
                                                  data-value="{{$item->id}}"
                                                  option-value="{{$item->option_id}}">
                                                    <i class="fa fa-heart"></i></span></li>
                                        <li><span title="Nhắn tin"><i class="fa fa-comment"></i></span></li>
                                        <li>
                                                    <span title="Thêm vào giỏ" class="add_cart"
                                                          data-value="{{$item->id}}"
                                                          option-value="{{$item->option_id}}">
                                                        <i class="fa fa-shopping-cart"></i></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__discount__item__text">
                                    <h5>
                                        <a href="{{Request::root()}}/san-pham/{{$item->slug}}" >
                                            <b>{{$item->title?? 'Không tên'}}</b>
                                            @if(!empty($item->option_title))
                                                <span class="ml-1 text-muted text-sm" >({{ $item->option_title }})</span>
                                            @endif
                                        </a>
                                    </h5>
                                    <div class="product__item__price text-danger">
                                        @if(empty($item->price) || ($item->price < $item->price_root))
                                            <h5 class="text-danger font-bold">Liên hệ</h5>
                                        @else
                                            @if($item->discount)
                                                {{ number_format($item->price - ($item->price * $item->discount /100), 0, ',', '.') }}đ
                                                <span class="text-muted"> {{ number_format($item->price, 0, ',', '.') }}đ</span>
                                            @else
                                                {{ number_format($item->price, 0, ',', '.') }}đ
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        <div class="pull-right">
                            {!! $promotions->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
                @else
                    <div class="my-1 p-3 prose prose-sm prose-p:m-0 text-center text-uppercase border-1">
                        Không tìm thấy sản phẩm nào hợp lệ.
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif
@endsection

