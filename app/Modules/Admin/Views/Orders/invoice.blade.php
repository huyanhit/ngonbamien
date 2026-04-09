@extends('Admin::Layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card" id="demo">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-header border-bottom-dashed p-4">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <img src="/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="30" style="width: auto;">
                                <img src="/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="30" style="width: auto;">
                                <div class="mt-sm-3 mt-3">
                                    <h6 class="text-muted text-uppercase fw-semibold">Cửa hàng Ngon Ba Mien</h6>
                                    <p class="text-muted mb-1" id="address-details">31 Đặng Dung, P. An Phú, Gia Lai</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                <h6><span class="text-muted fw-normal">Giấy phép số:</span><span id="legal-register-no"> 987654</span></h6>
                                <h6><span class="text-muted fw-normal">Email:</span><span id="email">cskh@ngonbamien.com</span></h6>
                                <h6><span class="text-muted fw-normal">Website:</span> <a href="https://ngonbamien.com/" class="link-primary" target="_blank" id="website">https://ngonbamien.com</a></h6>
                                <h6 class="mb-0"><span class="text-muted fw-normal">Điện thoại: </span><span id="contact-no"> +(84) 986 880 601</span></h6>
                            </div>
                        </div>
                    </div>
                    <!--end card-header-->
                </div><!--end col-->
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Hóa đơn số</p>
                                <h5 class="fs-14 mb-0">#<span id="invoice-no">{{$order->code}}</span></h5>
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Ngày lập</p>
                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{now()}}</span></h5>
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Hình thức thanh toán</p>
                                @if($order->payment == 1)
                                    <h5 class="fs-14 mb-0"><span>Thu hộ (COD)</span></h5>
                                @else
                                    <h5 class="fs-14 mb-0"><span>Chuyển khoản</span></h5>
                                @endif
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Tiền cần thanh toán</p>
                                <h5 class="fs-14 mb-0"><b id="total-amount">
                                    {{number_format($order->total+$order->ship_price-$order->down_price-$order->discount, 0, ',', '.')}}đ
                                </b></h5>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
                <div class="col-lg-12">
                    <div class="card-body p-4 border-top border-top-dashed">
                        <div class="row g-3">
                            @if(!empty($supplier))
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Shop bán hàng</h6>
                                    <p class="fw-medium mb-1" id="billing-name">Cửa hàng: {{$supplier->title}}</p>
                                    <p class="mb-1" id="billing-address-line-1">Địa chỉ: <span class="text-muted">{{$supplier->address}}</p>
                                    <p class="mb-1"><span>Số điện thoại: </span><span class="text-muted"> {{$supplier->phone}}</span></p>
                                    <a class="mb-1" href="https://ngonbamien.com/shop/{{$supplier->slug}}"><span>Website:</span>
                                        <span>https://ngonbamien.com/shop/{{$supplier->slug}}</span></a>
                                </div> 
                            @endif
                            <div class="col-6">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ giao hàng</h6>
                                <p class="fw-medium mb-1" id="shipping-name">Người nhận: {{$order->name}}</p>
                                <p class="mb-1 " id="shipping-address-line-1">Địa chỉ: <span class="text-muted">{{$order->address}}</span></p>
                                <p class="mb-1"><span>Số điện thoại: </span><span class="text-muted"> {{$order->phone}}</span></p>
                                <p class="mb-1"><span>Ghi chú: </span><span class="text-muted "> {{$order->note??'Không có'}}</span></p>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">Sản Phẩm</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col" class="text-end">Tổng tiền</th>
                                    </tr>
                                </thead>
                                
                                @if(!empty($order->products))
                                <tbody id="products-list">
                                @foreach($order->products as $key => $item)
                                    <tr>
                                        <th scope="row">{{$key + 1}}</th>
                                        <td class="text-start">
                                            <span class="fw-medium">{{$item->title}}</span>
                                            <p class="text-muted mb-0"> 
                                                @if(!empty(json_decode($item->pivot->options)))
                                                    {{ json_decode($item->pivot->options)->title }}
                                                @endif
                                            </p>
                                        </td>
                                        <td>{{number_format($item->pivot->price, 0, ',', '.') }}đ </td>
                                        <td>{{$item->pivot->quantity}}</td>
                                        <td class="text-end">{{number_format($item->pivot->price * $item->pivot->quantity, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                @endif
                            </table><!--end table-->
                        </div>
                        <div class="border-top border-top-dashed mt-2">
                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                <tbody>
                                    <tr>
                                        <td>Tổng tiền</td>
                                        <td class="text-end">{{number_format($order->total, 0, ',', '.')}}đ</td>
                                    </tr>
                                    <tr>
                                        <td>Phí giao hàng</td>
                                        <td class="text-end">+ {{number_format($order->ship_price, 0, ',', '.')}}đ</td>
                                    </tr>
                                    @if($order->down_price)
                                    <tr>
                                        <td>Shop giảm giá</td>
                                        <td class="text-end">- {{number_format($order->down_price, 0, ',', '.')}}đ</td>
                                    </tr>
                                    @endif
                                    @if($order->coupon)
                                        <tr>
                                            <td>Mã giảm giá <small class="text-muted">({{$order->coupon??'Không có'}})</small></td>
                                            <td class="text-end">- {{number_format($order->discount, 0, ',', '.')}}đ</td>
                                        </tr>
                                    @endif
                                    <tr class="border-top border-top-dashed fs-15">
                                        <th scope="row">Thanh toán</th>
                                        <th class="text-end">{{number_format($order->total+$order->ship_price-$order->down_price-$order->discount, 0, ',', '.')}}đ</th>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <div class="mt-4">
                            <div class="alert alert-info">
                                <p class="mb-0"><span class="fw-semibold">Ghi chú:</span>
                                    <span id="note">Đơn hàng đã hoàn thành sau 7 ngày sẻ không được hoàn trả. 
                                        Nếu có gì thắc mắc về hóa đơn này, hãy liên hệ với cửa hàng theo thời gian quy định, 
                                        để được giải quyết trong thời gian sớm nhất.
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                        </div>
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
@endsection