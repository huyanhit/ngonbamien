@extends('layouts.app')
@section('content')

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Danh mục Bài viết</span>
                        </div>
                        <ul>
                            @foreach ($producers as $item)
                                <li>
                                    <a href="{{Request::root()}}/vung-mien/{{Str::slug($item->title)}}" class="inline-block avatar">
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
                                <div id="slider" class="nivoSlider">
                                    @foreach ($sliders as $item)
                                        <img src="{{$item->image->uri}}"
                                             data-thumb="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                             alt="{{$item->title}}"
                                             title="#caption-{{$item->image_id}}"/>
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
    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Gian hàng {{$producer->title}}</h2>
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
            <div class="row featured__filter ">
                @if($products->isNotEmpty())
                    @foreach ($products as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 mix
                        {{$item->is_new? 'new': ''}}
                        {{$item->is_hot? 'hot': ''}}
                        {{$item->is_promotion? 'promotion': ''}} ">
                            <x-product-item :item="$item"/>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center p-3 border mb-3">
                        <span class="text-muted"> Không có sản phầm. </span>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Bài viết liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-1.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-2.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-3.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
