@extends('layouts.app')
@section('content')
    <section class="breadcrumb-section set-bg mb-3" data-setbg="{{Request::root()}}/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h3 class="text-white">Thanh toán đơn hàng</h3>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Thanh toán đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="my-3">
        <div class="container">
            <div class="row">
                <div class="col-8 border">
                    <h4 class="font-bold text-center py-3 font-weight-bold">Chọn hình thức thanh toán</h4>
                    <form action="{{route('tat-toan', $order->id)}}" method="POST" class="py-2 px-3 border-1 my-2 bg-gray-100">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put"/>
                        <div class="px-3">
                            <div>
                                <input class="relative -top-[1px] mr-1" checked id="pay_cod" type="radio" value="1" name="payment">
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
                                <input class="relative -top-[1px] mr-1" id="pay_store" type="radio" value="2" name="payment">
                                <label for="pay_store">Thanh toán các ứng dụng (mã QR)</label>
                            </div>
                            <div id="pay_store_form" class="mt-2 py-1 px-3" style="display: none;">
                                <div class="text-muted font-bold ms-3">
                                    Khách hàng quét mã sau và tiến hành thanh toán. <br/>
                                    Cửa hàng sẻ gửi Hàng đến địa chỉ của quý khách. <br/>
                                    <div class="border my-3 p-2 d-inline-block">
                                        <img src="{{Request::root().'/img/cart/cart-1.jpg'}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input class="relative -top-[1px] mr-1" id="pay_bank" type="radio" value="3" name="payment">
                                <label for="pay_bank">Chuyển khoản ngân hàng</label>
                            </div>
                            <div id="pay_bank_form" class="mt-2" style="display: none;">
                                <div class="form-group px-3 border-1 bg-gray-100">
                                    <div class="text-sm font-bold">Khách hàng chuyển khoản qua ngân hàng</div>
                                    <div class="text-sm"><span class="font-bold">Số tiền chuyển: </span>
                                        <strong class="text-red-600 text-xl">{{ number_format($order->total, 0, ',', '.') }}đ</strong>
                                    </div>
                                    <div class="text-sm p-3 bg-white my-2">
                                        <span class="font-bold">Thông tin chuyển khoản</span>
                                        <p><span class="text-sm font-bold">Số tài khoản</span>
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
                            <div class="text-right mt-3 mb-2">
                                <button class="btn px-2 rounded-2 bg-red-500 text-white hover:bg-red-600 text-sm"><i class="bi bi-ui-radios-grid"></i> Hoàn tất </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="checkout__order">
                        <h4>Thông tin Đơn hàng</h4>
                        <ul>
                            <li>Họ tên <span>{{$order->name}}</span></li>
                            <li>Điện thoại <span>{{$order->phone}}</span></li>
                            <li>Địa chỉ <span>{{$order->address}}</span></li>
                            <li>Ghi chú <span>{{$order->note??'Không có'}}</span></li>
                            <li>Số tiền <span class="total">{{ number_format($order->total, 0, ',', '.') }}đ</span></li>
                        </ul>
                        <button type="submit" class="site-btn">Hoàn thành</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
