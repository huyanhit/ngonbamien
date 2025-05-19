@extends('layouts.app')
@section('content')
    <x-breadcrumb name="noi-dung" title="Nội Dung Bài Viết" :data="$post"></x-breadcrumb>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details margin_15 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 order-md-1 order-2">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__item">
                            <div class="sidebar__item">
                                <div class="hero__categories">
                                    <div class="hero__categories__all">
                                        <i class="fa fa-bars"></i>
                                        <span>Danh mục Bài viết</span>
                                    </div>
                                    <ul>
                                        @foreach ($post_category as $item)
                                            <li>
                                                <a href="{{Request::root()}}/bai-viet/{{Str::slug($item->title)}}"
                                                    class="inline-block avatar">
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
                        </div>
                        <form class="sidebar" method="get" action="{{Request::url()}}">
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
                                                <img src="{{$recent->image->uri}}" class="avatar-sm" alt="{{$recent->title}}"/>
                                            </div>
                                            <div class="blog__sidebar__recent__item__text">
                                                <h6>{{$recent->title}}</h6>
                                                <span><i class="fa fa-calendar mr-2"></i>
                                                    {{\Carbon\Carbon::parse($recent->updated_at)->format('d/m/Y')}}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 order-md-1 order-1">
                    <!-- Hero Section Begin -->
                    <section class="hero background">
                        <div class="row">
                           <div class="col-12">
                               <x-hero-search :sites="$sites"/>
                           </div>
                        </div>
                    </section>
                    <!-- Blog Details Hero Begin -->
                    <section class="hero background">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product__details__pic">
                                    <a class="product__details__pic__item" data-lightbox="roadtrip"
                                       data-title="{{$post->title}}"
                                       href="{{$post->image->uri}}">
                                        <img class="product__details__pic__item--large"
                                             src="{{Request::root()}}/{{$post->image->uri?? ''}}" alt="{{$post->title}}">
                                    </a>
                                    <div class="product__details__pic__slider owl-carousel">
                                        @if($post->images)
                                            @foreach(explode(',',$post->images) as $id)
                                                <img data-imgbigurl="{{route('get-image', $id)}}"
                                                     src="{{route('get-image', $id)}}" alt="{{$post->title}}"
                                                     onerror="this.src='/images/no-image.png'">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h3>{{$post->title}}</h3>
                                <div class="border rounded p-2 mt-3">
                                    <i>{!! $post->description !!}</i>
                                </div>
                                <div class="blog__details__content mt-2">
                                    <div class="blog__details__author d-flex">
                                        <div class="avatar-auth p-2 border rounded">
                                            @if($post->author->image_id)
                                                <img src="{{route('get-image-thumbnail', $post->author->image_id)}}" alt="">
                                            @endif
                                        </div>
                                        <div class="blog__details__author__text p-1 ml-2">
                                            <h6>{{$post->author->name?? ''}}</h6>
                                            <div class="pull-right text-muted my-2">
                                                <i class="fa fa-calendar mr-2"></i>
                                                {{\Illuminate\Support\Carbon::parse($post->updated_at)->format('d/m/Y')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 doc-content">
                                <div class="my-3 pt-3">
                                    {!! $post->content !!}
                                </div>
                                <div class="my-3">
                                    <x-comment-block :data="['post_id' => $post->id]" :comments="$comments"></x-comment-block>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <!-- Related Blog Section Begin -->
    <section class="related-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-blog-title">
                        <h2>Bài viết tương tự</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($post_same as $save)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{$save->image->uri}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> {{\Illuminate\Support\Carbon::parse($save->updated_at)->format('d/m/Y')}}</li>
                                <li><i class="fa fa-comment-o"></i> {{$save->comment}} </li>
                            </ul>
                            <h5><a href="#">{{$save->title}}</a></h5>
                            <p>{{$save->description}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Blog Section End -->
@endsection
