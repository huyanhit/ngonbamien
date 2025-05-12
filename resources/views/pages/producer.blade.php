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
                    <x-hero-search :sites="$sites"/>
                    <div class="position-relative">
                        <div class="nivo-slider">
                            <div class="slider-wrapper theme-default">
                                <div id="slider" class="nivoSlider">
                                    @foreach ($producer->slider as $item)
                                        <img src="{{$item->uri}}"
                                             data-thumb="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->uri)}}"
                                             alt="{{$item->description}}"
                                             title="#caption-{{$item->id}}"/>
                                    @endforeach
                                </div>
                                @foreach ($producer->slider as $item)
                                    <div id="caption-{{$item->id}}" class="nivo-html-caption"> <strong>Hình ảnh {{$producer->title}}</strong> </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-12 producer_blog">
                    <div class="producer-image">
                        <img class="border rounded bg-light" src="http://ngonbamien.local/img/blog/details/details-pic.jpg" alt="The corner window forms a place within">
                    </div>
                    <div class="producer_content">
                        <div class="producer_desc text-left">
                            <h3 class="text-center background_pr text-white rounded">Giới thiệu {{$producer->title}}</h3>
                            <div class="description px-3 py-2 my-2 rounded bg-light">
                                <i> {!! $producer->description !!} </i>
                            </div>
                        </div>
                    </div>
                    <div class="producer_show">
                        <div class="content_blog">
                            {!! $producer->content !!}
                        </div>
                    </div>
                    <div class="text-center mt-2 btn_producer">
                        <button class="btn text-white primary-btn show-more" href="#"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Featured Section Begin -->
<section class="featured m-2">
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
@if($products->isNotEmpty())
<div class="row featured__filter">
@foreach ($products as $item)
<div class="col-lg-3 col-md-4 col-sm-6 mix
{{$item->is_new? 'new': ''}}
{{$item->is_hot? 'hot': ''}}
{{$item->is_promotion? 'promotion': ''}} ">
    <x-product-item :item="$item"/>
</div>
@endforeach
<div class="col-12">
<div class="pull-right">
    {!! $products->links('vendor.pagination.bootstrap-4') !!}
</div>
</div>
</div>
@else
<div class="row text-center p-3 border mb-3">
<span class="text-muted"> Không có sản phầm. </span>
</div>
@endif
</div>
</section>
<!-- Featured Section End -->

<!-- Blog Section Begin -->
<section class="from-blog my-3">
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="section-title from-blog__title">
<h2>Bài viết liên quan</h2>
</div>
</div>
</div>
<div class="row">
@foreach ($posts as $item)
<div class="col-lg-4 col-md-4 col-sm-6">
<x-post-item :item="$item"></x-post-item>
</div>
@endforeach
<div class="col-12">
<div class="pull-right">
{!! $posts->links('vendor.pagination.bootstrap-4') !!}
</div>
</div>
</div>
</div>
</section>
<!-- Blog Section End -->
@endsection
