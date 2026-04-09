@extends('layouts.app')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero background">
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
                                    @if(isset($item->image->uri))
                                        <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                         style="width: 20px"
                                         alt="{{$item->title}}"
                                         title="#caption-{{$item->image_id}}">
                                    @endif
                                    <span class="ml-2">{{$item->title}}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <x-hero-search :sites="$sites"/>
                    <div class="position-relative">
                        <div class="nivo-slider">
                            <div class="slider-wrapper theme-default">
                                <div id="slider" class="nivoSlider"  style="max-height: 350px;">
                                    @foreach ($sliders as $item)
                                        <a  href="{{$item->url}}">
                                            @if(isset($item->image->uri))
                                            <img src="{{$item->image->uri}}"
                                            data-thumb="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                            alt="{{$item->title}}"
                                            title="#caption-{{$item->image_id}}"/>
                                            @endif
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
                            <div class="categories__item" >
                                @if(isset($item->image->uri))
                                <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}" alt="{{$item->title}}">
                                @endif
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
    @if(count($products))
    <section class="featured background margin_15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Gian hàng hôm nay</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*"><h5>Đề xuất hôm nay</h5></li>
                            <li data-filter=".new"><h5>Sản phẩm mới</h5></li>
                            <li data-filter=".hot"><h5>Được mua nhiều</h5></li>
                            <li data-filter=".promotion"><h5>Đang khuyến mãi</h5></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach ($products as $item)
                    <div class="col-20p col-md-3 col-sm-4 mix
                        {{$item->is_new? 'new': ''}}
                        {{$item->is_hot? 'hot': ''}}
                        {{$item->is_promotion? 'promotion': ''}} ">
                        <x-product-item :item="$item" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    @if(count($banners))
    <div class="banner background margin_15">
        <div class="container">
            <div class="row">
                @foreach ($banners as $item)
                    <a href="{{$item->url}}" class="{{$item->type == 2 ? 'col-lg-6 col-md-12 col-sm-12': 'col-sm-12'}}">
                        <div class="banner__pic">
                            <img src="{{ $item->image?->uri }}" alt="{{$item->title}}">
                        </div>
                        @if(isset($item->description))
                        <div class="banner__info position-absolute top-0">
                            <h3>{{$item->title}}</h3>
                            <h6 class="mt-2">{{$item->description}}</h6>
                            <button class="btn btn-outline-danger mt-3"> Xem Ngay <i class="ri ri-arrow-right-line"></i> </button>
                        </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- Banner End -->

    <!-- Supplier Begin -->
    @if(!empty($suppliers))
    <div class="banner background margin_15 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-suppliers owl-carousel inline-block text-center">
                        @foreach($suppliers as $item)
                            <a href="{{route('cua-hang', $item->slug)}}" class="shadow">
                                @if($item->image_id)
                                <img class="inline-block" 
                                    src="{{route('get-image',$item->image_id)}}" 
                                    alt="{{$item ->title}}"
                                    onerror="this.src='/images/no-image.png'" style="max-width: 50px; display: inline-block"/>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Supplier End -->
@endsection


