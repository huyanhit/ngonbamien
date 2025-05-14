@extends('layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <x-breadcrumb name="dat-hang" title="Xác nhận đơn hàng"></x-breadcrumb>
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
                            @if(auth()->check())
                                <div class="checkout__input">
                                    <p>Họ & Tên<span>*</span></p>
                                    <input type="text" name="name" placeholder="Nhập vào Họ & Tên"
                                           value="{{request()->name??auth()->user()->name}}" />
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                    @endif
                                </div>
                                <div class="checkout__input">
                                    <p>Số điện thoại<span>*</span></p>
                                    <input type="tel" name="phone" placeholder="Nhập vào Số điện thoại"
                                           value="{{request()->phone??auth()->user()->phone}}"/>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="checkout__input">
                                    <p>Địa chỉ giao hàng<span>*</span></p>
                                    <input type="text" name="address" placeholder="Nhập vào Địa chỉ giao hàng"
                                           value="{{request()->address??auth()->user()->address}}"/>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="checkout__input">
                                    <p>Ghi chú</p>
                                    <textarea class="form-control" name="note"
                                              cols="30" rows="3" placeholder="Ghi chú thêm (Không bắt buộc)">{{request()->note}}</textarea>
                                </div>
                            @else
                                <div class="checkout__input">
                                    <p>Họ & Tên<span>*</span></p>
                                    <input type="text" name="name" placeholder="Nhập vào Họ & Tên"
                                           value="{{request()->name}}" />
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                    @endif
                                </div>
                                <div class="checkout__input">
                                    <p>Số điện thoại<span>*</span></p>
                                    <input type="tel" name="phone" placeholder="Nhập vào Số điện thoại"
                                           value="{{request()->phone}}"/>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="checkout__input">
                                    <p>Địa chỉ giao hàng<span>*</span></p>
                                    <input type="text" name="address" placeholder="Nhập vào Địa chỉ giao hàng"
                                           value="{{request()->address}}"/>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="checkout__input">
                                    <p>Ghi chú</p>
                                    <textarea class="form-control" name="note"
                                              cols="30" rows="3" placeholder="Ghi chú thêm (Không bắt buộc)">{{request()->note}}</textarea>
                                </div>
                            @endif
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
