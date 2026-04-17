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
                            <span>Món ngon, Đặc sản</span>
                        </div>
                        <ul class="shop-category">
                            @foreach ($product_categories as $item)
                                <li class="{{$item->slug == request()->route('slug')? 'active': ''}}">
                                    <a href="{{Request::root()}}/loai-san-pham/{{$item->slug}}" class="inline-block avatar">
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
                    <form class="sidebar border p-3 mt-3" id="form-shop" method="get" action="{{Request::url()}}">
                        <h4 class="text-center font-weight-bold text-uppercase">Lọc theo</h4>
                        <div class="sidebar__item mt-3">
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
                                <button class="btn bg-light text-body border my-1 {{request('loai') === 'mon-moi'? 'active': ''}}"
                                        name="loai"
                                        value="mon-moi"
                                        type="submit">
                                        Món mới
                                </button>
                                <button class="btn bg-primary my-1 text-white {{request('loai') === 'mon-mua-nhieu'? 'active': ''}}"
                                        name="loai"
                                        value="mon-mua-nhieu"
                                        type="submit">
                                        Món mua nhiều
                                </button>
                                <button
                                        class="btn bg-secondary my-1 text-white {{request('loai') === 'dang-khuyen-mai'? 'active': ''}}"
                                        name="loai"
                                        value="dang-khuyen-mai"
                                        type="submit">
                                        Đang khuyến mãi
                                </button>
                                <button class="btn bg-info my-1 text-white {{request('loai') === 'mon-da-thich'? 'active': ''}}"
                                        name="loai"
                                        value="mon-da-thich"
                                        type="submit">
                                        Món đã thích
                                </button>
                                <button class="btn bg-warning my-1 text-white {{request('loai') === 'mon-da-mua'? 'active': ''}}"
                                        name="loai"
                                        value="mon-da-mua"
                                        type="submit">
                                        Món đã mua
                                </button>
                            </div>
                        </div>
                        <input type="hidden" value="ten" name="sap-xep" id='hiden-sort-filter'/>
                    </form>
                </div>
                <div class="col-lg-9">
                    <x-hero-search :sites="$sites"/>
                    <div class="p-2 pb-3 border">
                        <div class="d-flex align-items-center border px-3 pt-2 pb-1 mb-2">
                            <div class="flex-fill">
                                <div class="filter__sort">
                                    <span class="font-weight-bold small text-dark"> Sắp xếp </span>
                                    <select class="small" id="sort_list_product">
                                        <option value="">Không sắp xếp</option>
                                        <option value="ten" {{request('sap-xep') === 'ten' ? 'selected': ''}}>Tên sản phẩm</option>
                                        <option value="gia-tang" {{request('sap-xep') === 'gia-tang' ? 'selected': ''}}>Giá tăng dần</option>
                                        <option value="gia-giam" {{request('sap-xep') === 'gia-giam' ? 'selected': ''}}>Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="filter__found">
                                    <h6><span class="text-danger">
                                        <span class="small">Tìm thấy</span> 
                                        {{$products->total()}}</span> <span class="small"> Sản phẩm </span>
                                    </h6>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="filter__option">
                                    <span class="icon_ul filter__option_ul"></span>
                                    <span class="icon_grid-2x2 filter__option_grid"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row filter__list product__discount">
                            @foreach ($products as $item)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <x-product-item-single :item="$item"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="pull-right">
                            {!! $products->appends([
                                'gia' => Request::get('gia'), 
                                'xuat-xu' => Request::get('xuat-xu'), 
                                'loai' => Request::get('loai'), 
                                'sap-xep' => Request::get('sap-xep')
                            ])->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
    <section class="background">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Sản phẩm đang giảm giá</h2>
                    </div>
                    <div class="product__discount px-1">
                        <div class="product__discount__slider owl-carousel">
                            @foreach ($discount_products as $item)
                                <div class="px-2">
                                    <x-product-item-promotion :item="$item"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>
    <section class="product background">
        <div class="container">
            @if(!empty($category))
                <div class="row product__discount bg-light ">
                    <div class="col-4 product__details__pic p-3">
                        <a class="product__details__pic__item" data-lightbox="roadtrip"
                            data-title="{{$category->title}}"
                            href="{{$category->image->uri}}">
                            <img class="product__details__pic__item--large border rounded"
                            src="{{Request::root()}}/{{$category->image->uri?? ''}}" alt="{{$category->title}}">
                        </a>
                        <div class="product__details__pic__slider owl-carousel">
                            @if($category->images)
                                @foreach(explode(',',$category->images) as $id)
                                    <img data-imgbigurl="{{route('get-image', $id)}}" src="{{route('get-image', $id)}}" alt="{{$category->title}}"
                                        onerror="this.src='/images/no-image.png'">
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="section-title mt-3">
                            <h2>{{$category->title}}</h2>
                        </div>
                        <p class="text-italic mt-3">{!! $category->content !!}</p>
                    </div>
                </div>
            @endif
            @if(isset($category->banner))
                <div class="row product__discount bg-light ">
                    <div class="col-12 p-3">
                        <img src="{{$category?->banner}}" alt="{{$category->title}}"/>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Product Section End -->
@endsection
