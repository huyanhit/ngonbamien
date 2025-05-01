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
                            @foreach ($post_category as $item)
                                <li>
                                    <a href="{{Request::root()}}/noi-dung/{{Str::slug($item->title)}}" class="inline-block avatar">
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
                                    @foreach ($slider as $item)
                                        <img src="{{$item->image->uri}}"
                                             data-thumb="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                             alt="{{$item->title}}"
                                             title="#caption-{{$item->image_id}}"/>
                                    @endforeach
                                </div>
                                @foreach ($slider as $item)
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
    <section class="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar__item">
                        <h4>Nhóm</h4>
                        <div class="sidebar__item__size">
                            <button class="btn btn-outline-dark my-1">
                                Bài mới
                            </button>
                            <button class="btn btn-outline-dark my-1">
                                Bài xem nhiều
                            </button>
                            <button class="btn btn-outline-dark my-1">
                                Review
                            </button>
                            <button class="btn btn-outline-dark my-1">
                                Video
                            </button>
                        </div>
                    </div>
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
                                <h6><span>8</span> Bài viết </h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 0 -10px">
                        <div class="col-lg-4 col-md-4 col-sm-4">
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
                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                        quaerat </p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
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
                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                        quaerat </p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
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
                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                        quaerat </p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="img/blog/blog-4.jpg" alt="">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                        <li><i class="fa fa-comment-o"></i> 5</li>
                                    </ul>
                                    <h5><a href="#">Cooking tips make cooking simple</a></h5>
                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                        quaerat </p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="img/blog/blog-4.jpg" alt="">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                        <li><i class="fa fa-comment-o"></i> 5</li>
                                    </ul>
                                    <h5><a href="#">The Moment You Need To Remove Garlic From The Menu</a></h5>
                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                        quaerat </p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="img/blog/blog-6.jpg" alt="">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                        <li><i class="fa fa-comment-o"></i> 5</li>
                                    </ul>
                                    <h5><a href="#">Cooking tips make cooking simple</a></h5>
                                    <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam
                                        quaerat </p>
                                    <a href="#" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
