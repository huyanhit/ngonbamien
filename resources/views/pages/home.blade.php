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
                            <span>Món ngon ba miền</span>
                        </div>
                        <ul>
                            @foreach ($producers as $item)
                            <li>
                                <a href="{{Request::root()}}/vung-mien/{{$item->slug}}" class="inline-block avatar">
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
                    <div class="position-relative">
                        <div class="nivo-slider">
                            <div class="slider-wrapper theme-default">
                                <div id="slider" class="nivoSlider" >
                                    @foreach ($sliders as $item)
                                        <a href="{{$item->url}}">
                                            <img src="{{$item->image->uri}}"
                                             data-thumb="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                             alt="{{$item->title}}"
                                             title="#caption-{{$item->image_id}}"/>
                                        </a>
                                    @endforeach
                                </div>
                                @foreach ($sliders as $item)
                                    <div id="caption-{{$item->image_id}}" class="nivo-html-caption"> <strong>{{$item->title}}</strong> </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories background margin_15">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @foreach ($product_categories as $item)
                    <div class="col-lg">
                        <a href="./cua-hang/{{Str::slug($item->title)}}">
                            <div class="categories__item set-bg" data-setbg="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}">
                                <h3><span>{{$item->title}}</span></h3>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured background margin_15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Gian hàng hôm nay</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*"><h5>Tất cả</h5></li>
                            <li data-filter=".new"><h5>Món ngon mới</h5></li>
                            <li data-filter=".hot"><h5>Món được mua nhiều</h5></li>
                            <li data-filter=".promotion"><h5>Khuyến mãi</h5></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach ($products as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix
                        {{$item->is_new? 'new': ''}}
                        {{$item->is_hot? 'hot': ''}}
                        {{$item->is_promotion? 'promotion': ''}} ">
                        <x-product-item :item="$item" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog background margin_15">
        <div class="container" >
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Bài viết mới</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($posts as $item)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <a class="blog__item__pic" href="{{Request::root()}}/noi-dung/{{$item->slug}}">
                                <img src="{{$item->image->uri?? ''}}" alt="{{$item->title}}">
                            </a>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-comment"></i> {{$item->view?? 0}} </li>
                                    <li><i class="fa fa-calendar-o"></i> {{\Illuminate\Support\Carbon::parse($item->updated_at)->fromNow()}} </li>
                                </ul>
                                <h5><a href="{{Request::root()}}/noi-dung/{{$item->slug}}">
                                        {{$item->title}}</a>
                                </h5>
                                <p>{{$item->description}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

    <!-- Banner Begin -->
    <div class="banner background margin_15">
        <div class="container">
            <div class="row">
                @foreach ($banners as $item)
                    <a href="{{$item->url}}" class="{{$item->type == 2 ? 'col-lg-6 col-md-12 col-sm-12': 'col-lg-4 col-md-6 col-sm-12'}}">
                        <div class="banner__pic">
                            <img src="{{ $item->image->uri }}" alt="{{$item->title}}">
                        </div>
                        <div class="banner__info position-absolute top-0">
                            <h3>{{$item->title}}</h3>
                            <h6 class="mt-2">{{$item->description}}</h6>
                            <button class="btn btn-outline-danger mt-3"> Xem Ngay <i class="ri ri-arrow-right-line"></i> </button>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product background margin_15">
        <div class="container">
            <div class="row">
                @foreach ($post_categories as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="latest-product__text">
                            <h3>{{$item->title}}</h3>
                            <div class="latest-product__slider owl-carousel">
                                @foreach($item->posts as $key => $post)
                                    @if($key%2 == 0) <div class="latest-prdouct__slider__item"> @endif
                                        <a href="./noi-dung/{{Str::slug($post->title)}}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ $post->image->uri?? '' }}" alt="{{ $post->title }}">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6 class="text-truncate">{{$post->title}}</h6>
                                                <span>
                                                    {{$post->content}}
                                                </span>
                                            </div>
                                        </a>
                                    @if($key%2 == 1)</div> @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->
@endsection


