@extends('layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h3 class="text-white">Xác nhận đơn hàng</h3>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Xác nhận đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout">
        <div class="container">
            <div class="checkout__form">
                <form action="{{route('mua-hang')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6 border p-3">
                            <h4 class="text-center">Thông tin khách hàng</h4>
                            <div class="form-group mt-2">
                                <span class="mr-2">
                                    <input {{request()->sex == 1?'checked':''}} type="radio" value="1" name="sex" id="male"/>
                                    <label class="ml-1" for="male">Anh</label>
                                </span>
                                <span>
                                    <input {{request()->sex == 2?'checked':''}} type="radio" checked value="2" name="sex" id="gender" />
                                    <label class="ml-1" for="gender">Chị</label>
                                </span>
                                @if ($errors->has('sex'))
                                    <span class="text-danger">{{ $errors->first('sex') }}</span>
                                @endif
                            </div>
                            <div class="checkout__input">
                                <p>Họ & Tên<span>*</span></p>
                                <input type="text" name="name" placeholder="Nhập vào Họ & Tên" value="{{request()->name}}" />
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="checkout__input">
                                <p>Số điện thoại<span>*</span></p>
                                <input type="tel" name="phone" placeholder="Nhập vào Số điện thoại" value="{{request()->phone}}"/>
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                            <div class="checkout__input">
                                <p>Địa chỉ giao hàng<span>*</span></p>
                                <input type="text" name="address" placeholder="Nhập vào Địa chỉ giao hàng" value="{{request()->address}}"/>
                                @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú</p>
                                <textarea class="form-control" name="note"
                                          cols="30" rows="3" placeholder="Ghi chú thêm (Không bắt buộc)">{{request()->note}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            @if(!empty($cart))
                            <div class="checkout__order">
                                <h4>Đơn hàng của bạn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Tổng</span></div>
                                <ul>
                                    @foreach($cart->items as $item)
                                        <li>{{$item->title}} <span>{{ number_format($item->price*$item->quantity, 0, ',', '.') }}đ</span></li>
                                    @endforeach
                                </ul>
                                <div class="checkout__order__shipping">Phí giao hàng <span>{{ number_format($shipping, 0, ',', '.') }}đ</span></div>
                                <div class="checkout__order__subtotal">Giảm giá <span> -{{ number_format(($coupon['discount']?? 0), 0, ',', '.') }}đ</span></div>
                                <div class="checkout__order__total">Tổng đơn <span>{{ number_format($cart->total + $shipping - ($coupon['discount']?? 0), 0, ',', '.') }}đ</span></div>
                                <button type="submit" class="site-btn">Thanh Toán</button>
                            </div>
                            @else
                                <div class="checkout__order"></div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
