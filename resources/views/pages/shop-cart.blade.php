@extends('layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h3 class="text-white">Giỏ Hàng</h3>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Giỏ Hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="cart-container m-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="my-cart py-2"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="shoping__continue mb-3">
                        <div class="shoping__discount">
                            <h5>Mã giảm giá</h5>
                            <form action="{{Request::root()}}/gio-hang" method="POST">
                                {{ csrf_field() }}
                                <input type="text" placeholder="Nhập vào mã giảm giá" name="coupon" value="{{$coupon['coupon']->code?? request('coupon')}}">
                                <button type="submit" class="site-btn update_coupon">ÁP DỤNG MÃ</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout mb-3">
                        <h5>Tổng tiền</h5>
                        <ul>
                            <li class="ml-2 text-sm"> Giảm:
                                @if(!empty($coupon['coupon']))
                                    <i class="ml-2 text-muted">{{ $coupon['coupon']->value }}{{$coupon['coupon']->type == 2? '%': 'đ'}}</i>
                                @endif
                                <span id="coupon-down" data-value="{{ $coupon['discount'] ?? 0}}">0đ</span>
                            </li>
                            <li class="ml-2 text-sm"> Còn lại:
                                <span id="total-check">0đ</span>
                            </li>
                        </ul>
                        <a href="{{Request::root()}}/dat-hang" class="primary-btn text-uppercase">Đặt Hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
