@extends('layouts.app')
@section('content')
    <!-- Hero Section End -->
    <x-breadcrumb name="khuyen-mai" title="Sản Phẩm Đang Giảm Giá"></x-breadcrumb>
    <!-- Hero Section Begin -->
    <section class="hero background mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <x-hero-search :sites="$sites"/>
                </div>
            </div>
        </div>
    </section>
    @if(isset($promotions) && !empty($promotions))
        <section class="product_section">
        <div class="container">
            <div class="row filter__list">
                @if(!$promotions->isEmpty())
                    @foreach ($promotions as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6 mt-3">
                            <x-product-item-promotion :item="$item"/>
                        </div>
                    @endforeach
                    <div class="col-12 mt-3">
                        <div class="pull-right">
                            {!! $promotions->links('vendor.pagination.bootstrap-4') !!}
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

