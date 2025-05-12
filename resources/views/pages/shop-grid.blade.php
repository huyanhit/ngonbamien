@extends('layouts.app')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero background">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Món ngon, Đặc sản</span>
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
                <div class="col-lg-9 col-md-7">
                    <x-hero-search :sites="$sites"/>
                    <div class="product__discount">
                        <div class="product__discount__slider owl-carousel">
                            @foreach ($discount_products as $item)
                                <div class="col-lg-4">
                                    <div class="product__discount__item" >
                                        <div>
                                            <div class="featured__item__pic">
                                                <a href="{{Request::root()}}/san-pham/{{$item->slug}}" >
                                                    <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->uri??'')}}"
                                                     alt="{{$item->title}}">
                                                </a>
                                                <div class="product__discount__percent">-{{$item->discount}}%</div>
                                                <ul class="product__item__pic__hover">
                                                    <li><span title="Yêu thích"><i class="fa fa-heart"></i></span></li>
                                                    <li><span title="Nhắn tin"><i class="fa fa-comment"></i></span></li>
                                                    <li>
                                                        <span title="Thêm vào giỏ" class="add_cart" data-value="{{$item->id}}"><i class="fa fa-shopping-cart"></i></span>
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
                        <form class="sidebar" id="form-shop" method="get" action="{{Request::url()}}">
                            <div class="sidebar__item">
                                <h4>Giá bán</h4>
                                <select class="form-select w-100 mb-3" name="gia" onchange="this.form.submit()">
                                    <option value=""> Chọn mức giá </option>
                                    <option value="duoi-100k" {{request('gia') === 'duoi-100k' ? 'selected': ''}}> Dưới 100.000đ </option>
                                    <option value="100k-200k" {{request('gia') === '100k-200k' ? 'selected': ''}}> 100.000đ đến 200.000đ </option>
                                    <option value="200k-500k" {{request('gia') === '200k-500k' ? 'selected': ''}}> 200.000đ đến 500.000đ </option>
                                    <option value="tren-500k" {{request('gia') === 'tren-500k' ? 'selected': ''}}> Trên 500.000đ </option>
                                    <option value="lien-he"   {{request('gia') === '5' ? 'selected': ''}}> Liên hệ </option>
                                </select>
                            </div>
                            <div class="sidebar__item">
                                <h4>Vùng miền</h4>
                                <select class="form-select w-100 mb-3" name="xuat-xu" onchange="this.form.submit()">
                                    <option value=""> Chọn vùng </option>
                                    @foreach ($producers as $item)
                                        <option value="{{$item->slug}}" {{request('xuat-xu') == $item->slug ? 'selected': ''}}>
                                            {{$item->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sidebar__item mt-2">
                                <h4>Danh mục</h4>
                                <div class="sidebar__item__size">
                                    <button class="btn btn-outline-dark my-1 {{request('loai') === 'mon-moi'? 'active': ''}}"
                                            name="loai"
                                            value="mon-moi"
                                            type="submit">
                                            Món mới
                                    </button>
                                    <button class="btn btn-outline-dark my-1 {{request('loai') === 'mon-mua-nhieu'? 'active': ''}}"
                                            name="loai"
                                            value="mon-mua-nhieu"
                                            type="submit">
                                            Món mua nhiều
                                    </button>
                                    <button
                                            class="btn btn-outline-dark my-1 {{request('loai') === 'dang-khuyen-mai'? 'active': ''}}"
                                            name="loai"
                                            value="dang-khuyen-mai"
                                            type="submit">
                                            Đang khuyến mãi
                                    </button>
                                    <button class="btn btn-outline-dark my-1  {{request('loai') === 'mon-da-thich'? 'active': ''}}"
                                            name="loai"
                                            value="mon-da-thich"
                                            type="submit">
                                            Món đã thích
                                    </button>
                                    <button class="btn btn-outline-dark my-1 {{request('loai') === 'mon-da-mua'? 'active': ''}}"
                                            name="loai"
                                            value="mon-da-mua"
                                            type="submit">
                                            Món đã mua
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
                                    <h6><span>{{$products->total()}}</span> Sản phẩm </h6>
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
                                    <x-product-item-single :item="$item"/>
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

    <script>
        setTimeout(function () {
            console.log(window.location.href.indexOf('?'))
            if(window.location.href.indexOf('?') !== -1){
                window.scroll({
                    top: 420,
                    behavior: "smooth",
                });
            }
        }, 100)
    </script>
    <!-- Product Section End -->
@endsection
