@extends('layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <x-breadcrumb name="dat-hang" title="Thanh toán đơn hàng" :data="$order"></x-breadcrumb>
    <!-- Breadcrumb Section End -->
    <section class="py-3 margin_15">
        <div class="container">
            <form action="{{route('tat-toan', $order->code)}}" method="POST">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order border">
                            <h4>Thông tin Đơn Hàng</h4>
                            <ul>
                                <li>Mã đơn hàng<span class="text-danger bold">{{$order->code}}</span></li>
                                <li>Họ tên <span>{{$order->name}}</span></li>
                                <li>Điện thoại <span>{{$order->phone}}</span></li>
                                <li>Địa chỉ <span>{{$order->address}}</span></li>
                                <li>Ghi chú <span>{{$order->note??'Không có'}}</span></li>
                                <li>Số tiền <span class="total text-danger">{{ number_format($order->total, 0, ',', '.') }}đ</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6">
                        <div class="bg-light p-3 border">
                            <h4 class="font-bold text-center py-3 font-weight-bold">Chọn hình thức thanh toán</h4>
                            <div class="py-2 px-3 my-1">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put"/>
                                <div class="px-3">
                                    <div>
                                        <input class="relative mr-1" checked id="pay_cod" type="radio" value="1" name="payment">
                                        <label for="pay_cod">Giao hàng và thu tiền (COD)</label>
                                    </div>
                                    <div id="pay_cod_form" style="display: block;">
                                        <div class="form-group py-1 px-3 border-1 bg-gray-100">
                                            <div class="text-muted font-bold">
                                                Nhân viên giao hàng đem sản phẩm đến nhà. <br/>
                                                Khách hàng kiểm tra và thanh toán theo hóa đơn.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input class="relative mr-1" id="pay_store" type="radio" value="2" name="payment">
                                        <label for="pay_store">Thanh toán các ứng dụng (mã QR)</label>
                                    </div>
                                    <div id="pay_store_form" class="px-3" style="display: none;">
                                        <div class="text-muted font-bold ms-3">
                                            Khách hàng quét mã sau và tiến hành thanh toán. <br/>
                                            Cửa hàng sẻ gửi Hàng đến địa chỉ của quý khách. <br/>
                                            <div class="border my-3 p-2 d-inline-block">
                                                <img src="{{Request::root().'/img/cart/cart-1.jpg'}}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input class="relative mr-1" id="pay_bank" type="radio" value="3" name="payment">
                                        <label for="pay_bank">Chuyển khoản ngân hàng</label>
                                    </div>
                                    <div id="pay_bank_form" class="mt-2" style="display: none;">
                                        <div class="form-group px-3 ">
                                            <div class="text-sm font-bold">Khách hàng chuyển khoản qua ngân hàng</div>
                                            <div class="text-sm"><span class="font-bold">Số tiền chuyển: </span>
                                                <strong class="text-red-600 text-xl">{{ number_format($order->total, 0, ',', '.') }}đ</strong>
                                            </div>
                                            <div class="text-sm p-3 bg-white my-2">
                                                <span class="font-bold">Thông tin chuyển khoản</span>
                                                <p>
                                                    <span class="text-sm font-bold">Số tài khoản</span>
                                                    <span class="text-red-600 text-xl"> xxxx </span>
                                                </p>
                                                <p><span class="text-sm font-bold">Ngân hàng:</span>
                                                    <span class="text-sm"> xxxx </span>
                                                </p>
                                                <p><span class="text-sm font-bold">Chủ tài khoản:</span>
                                                    <span class="text-sm">xxx</span>
                                                </p>
                                                <p><span class="text-sm font-bold">Nội dung chuyển khoản:</span>
                                                    <span class="text-sm">Thanh toán HĐ {{$order->id}}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3 pb-2">
                                        <button type="submit" class="site-btn">Hoàn thành</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
