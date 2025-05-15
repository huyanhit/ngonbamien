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
            <div class="row" style="padding: 0 5px">
                <div class="col-lg-4 col-md-5">
                    <div class="filter__sort">
                        <span>Sắp xếp</span>
                        <select style="display: none;">
                            <option value="1">Theo giá</option>
                            <option value="2">Theo tên</option>
                        </select>
                        <div class="nice-select" tabindex="0">
                            <span class="current">Theo giá</span>
                            <ul class="list">
                                <li data-value="1" class="option selected">Theo giá</li>
                                <li data-value="2" class="option">Theo tên</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="filter__found">
                        <h4 class="text-uppercase"><span>{{$promotions->total()}}</span> Sản phẩm</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3">
                    <div class="filter__option">
                        <span class="icon_ul filter__option_ul"></span>
                        <span class="icon_grid-2x2 filter__option_grid active"></span>
                    </div>
                </div>
            </div>
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

