@extends('layouts.app')
@section('content')
    <!-- Hero Section End -->
    <section class="breadcrumb-section set-bg mb-3" data-setbg="{{Request::root()}}/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h3 class="text-white">Tìm kiếm</h3>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Tìm kiếm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section Begin -->
    <section class="hero background">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <x-hero-search :sites="$sites"/>
                </div>
            </div>
        </div>
    </section>

    @if(isset($favors) && !empty($favors))
        <section class="product_section margin_15">
        <div class="container">
            <div class="row" style="padding: 0 5px">
                <div class="col-lg-4 col-md-5">
                    <div class="filter__sort">
                        <span>Sắp xếp</span>
                        <select style="display: none;">
                            <option value="1">Theo giá</option>
                            <option value="2">Theo tên</option>
                        </select>
                        <div class="nice-select" tabindex="0">
                            <span class="current">Theo giá</span>
                            <ul class="list">
                                <li data-value="1" class="option selected">Theo giá</li>
                                <li data-value="2" class="option">Theo tên</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="filter__found">
                        <h4 class="text-uppercase"><span>{{$favors->total()}}</span> Sản phẩm</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3">
                    <div class="filter__option">
                        <span class="icon_ul filter__option_ul active"></span>
                        <span class="icon_grid-2x2 filter__option_grid"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!$favors->isEmpty())
                    @foreach ($favors as $item)
                        <div class="col-3">
                            <x-product-item :item="$item"/>
                        </div>
                    @endforeach
                    <div class="col-12">
                        <div class="pull-right">
                            {!! $favors->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
                @else
                    <div class="my-1 p-3 prose prose-sm prose-p:m-0 text-center text-uppercase border-1">
                        Không tìm thấy sản phẩm nào hợp lệ.
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif
@endsection

