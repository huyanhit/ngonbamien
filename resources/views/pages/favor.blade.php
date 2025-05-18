@extends('layouts.app')
@section('content')
    <!-- Hero Section End -->
    <x-breadcrumb name="yeu-thich" title="Sản Phẩm Yêu Thích"></x-breadcrumb>
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

    @if(isset($favors) && !empty($favors))
        <section class="product_section margin_15">
        <div class="container">
            <div class="row filter__list">
                @if(!$favors->isEmpty())
                    @foreach ($favors as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <x-product-item-single :item="$item"/>
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

