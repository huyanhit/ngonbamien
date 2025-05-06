@extends('layouts.app')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero background margin_15">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Món ngon, đặc sản</span>
                        </div>
                        <ul class="shop-category">
                            @foreach ($product_categories as $item)
                                <li>
                                    <a href="{{Request::root()}}/cua-hang/{{$item->slug}}" class="inline-block avatar">
                                        <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                             style="width: 20px"
                                             alt="{{$item->title}}"
                                             title="#caption-{{$item->image_id}}">
                                        <span class="ml-2">{{$item->title}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search d-flex">
                        <div class="hero__search__form flex-grow-1 mr-3">
                            <form action="#">
                                <select class="form-select border-0 position-relative z-20 mt-1">
                                    <option class="fs-18 fw-bold">
                                        Tất cả
                                    </option>
                                    <option class="fs-18 fw-bold" value="1">
                                        <span class="ml-2">Sản Phẩm</span>
                                    </option>
                                    <option class="fs-18 fw-bold" value="1">
                                        <span class="ml-2">Bài viết</span>
                                    </option>
                                </select>
                                <input type="text" placeholder="Nhập từ khóa tìm kiếm">
                                <button type="submit" class="site-btn">Tìm</button>
                            </form>
                        </div>
                        <div class="hero__search__phone flex-shrink-1">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text text-center">
                                <h5>0986 88.06.01</h5>
                                <div class="text-muted">Hổ trợ <b>24/7</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="product__discount">
                        <div class="product__discount__slider owl-carousel">
                            @foreach ($discount_products as $item)
                                <div class="col-lg-4">
                                    <div class="product__discount__item" >
                                        <a href="{{Request::root()}}/san-pham/{{$item->slug}}" >
                                            <div class="product__discount__item__pic set-bg"
                                                data-setbg="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->uri??'')}}">
                                                <div class="product__discount__percent">-{{$item->discount}}%</div>
                                                <ul class="product__item__pic__hover">
                                                    <li><span title="Yêu thích"><i class="fa fa-heart"></i></span></li>
                                                    <li><span title="Nhắn tin"><i class="fa fa-comment"></i></span></li>
                                                    <li><span title="Thêm vào giỏ"><i class="fa fa-shopping-cart"></i></span></li>
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <h5><b>{{$item->title?? 'Không tên'}}</b>
                                                    @if(!empty($item->option_title))
                                                        <span class="ml-1 text-muted text-sm" >({{ $item->option_title }})</span>
                                                    @endif
                                                </h5>
                                                <div class="product__item__price text-danger">
                                                    {{ number_format($item->price - ($item->price * $item->discount /100), 0, ',', '.') }}đ
                                                    <span class="text-muted"> {{ number_format($item->price, 0, ',', '.') }}đ</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product background margin_15">
        <div class="container">
            <div class="filter__item">
                <div class="row">
                    <div class="col-lg-3 col-md-5">
                        <form class="sidebar">
                            <div class="sidebar__item">
                                <h4>Giá bán</h4>
                                <select class="form-select w-100 mb-3">
                                    <option selected=""> Chọn mức giá </option>
                                    <option value="1"> Dưới 100.000đ </option>
                                    <option value="2"> 100.000đ đến 200.000đ </option>
                                    <option value="3"> 200.000đ đến 500.000đ </option>
                                    <option value="4"> Trên 500.000đ </option>
                                    <option value="5"> Liên hệ </option>
                                </select>
                            </div>
                            <div class="sidebar__item">
                                <h4>Vùng miền</h4>
                                <select class="form-select w-100 mb-3">
                                    <option> Chọn vùng </option>
                                    @foreach ($producers as $item)
                                        <option value="{{$item->id}}">
                                            {{$item->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sidebar__item mt-2">
                                <h4>Nhóm</h4>
                                <div class="sidebar__item__size">
                                    <button class="btn btn-outline-dark my-1">
                                        Món mới
                                    </button>
                                    <button class="btn btn-outline-dark my-1">
                                        Món mua nhiều
                                    </button>
                                    <button class="btn btn-outline-dark my-1">
                                        Khuyến mãi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-9 col-md-7">
                        <div class="row" style="padding: 0 5px">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sắp xếp</span>
                                    <select>
                                        <option value="1">Theo giá</option>
                                        <option value="2">Theo tên</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>{{$products->count()}}</span> Sản phẩm </h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_ul filter__option_ul"></span>
                                    <span class="icon_grid-2x2 filter__option_grid active"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row filter__list" style="padding: 0 5px">
                            @foreach ($products as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <x-product-item :item="$item"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="pull-right">
                            {!! $products->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
