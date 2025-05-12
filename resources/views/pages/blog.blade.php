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
                            <span>Danh mục Bài viết</span>
                        </div>
                        <ul>
                            @foreach ($post_category as $item)
                                <li>
                                    <a href="{{Request::root()}}/bai-viet/{{Str::slug($item->title)}}" class="inline-block avatar">
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
    <!-- Blog Section Begin -->
    <section class="blog background margin_15">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <form class="sidebar" method="get" action="{{Request::url()}}">
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
                        <div class="sidebar__item mt-3">
                            <h4>Danh mục</h4>
                            <div class="sidebar__item__size">
                                <button class="btn btn-outline-dark my-1 {{request('loai') === 'bai-moi'? 'active': ''}}"
                                        name="loai"
                                        value="bai-moi"
                                        type="submit">
                                    Bài mới
                                </button>
                                <button class="btn btn-outline-dark my-1 {{request('loai') === 'che-bien'? 'active': ''}}"
                                        name="loai"
                                        value="che-bien"
                                        type="submit">
                                    Chế biến
                                </button>
                                <button
                                    class="btn btn-outline-dark my-1 {{request('loai') === 'du-lich'? 'active': ''}}"
                                    name="loai"
                                    value="du-lich"
                                    type="submit">
                                    Du lịch
                                </button>
                                <button class="btn btn-outline-dark my-1  {{request('loai') === 'review'? 'active': ''}}"
                                        name="loai"
                                        value="review"
                                        type="submit">
                                    Review
                                </button>
                                <button class="btn btn-outline-dark my-1 {{request('loai') === 'video'? 'active': ''}}"
                                        name="loai"
                                        value="video"
                                        type="submit">
                                    Video
                                </button>
                            </div>
                        </div>
                        <div class="blog__sidebar__item">
                            <h4>Bài đã xem</h4>
                            <div class="blog__sidebar__recent">
                                @foreach($post_recent as $recent)
                                    <a href="#" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{$recent->image->uri}}" alt="{{$recent->title}}">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>{{$recent->title}}</h6>
                                            <span><i class="fa fa-calendar mr-2"></i>{{\Carbon\Carbon::parse($recent->updated_at)->format('d/m/Y')}}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-9">
                    <div class="row" style="padding: 0 5px">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sắp xếp</span>
                                <select>
                                    <option value="1">Theo tên</option>
                                    <option value="2">Theo lượt xem</option>
                                    <option value="3">Theo lượt thích</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{$posts->total()}}</span> Bài viết </h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_ul filter__option_ul"></span>
                                <span class="icon_grid-2x2 filter__option_grid active"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row filter__list" style="margin: 0 -10px">
                        @foreach ($posts as $item)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                               <x-post-item :item="$item"></x-post-item>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="pull-right mt-3">
                                {!! $posts->links('vendor.pagination.bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
