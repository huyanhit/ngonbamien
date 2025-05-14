@extends('layouts.app')
@section('content')
    <!-- Hero Section End -->
    <section class="breadcrumb-section set-bg mb-3" data-setbg="{{Request::root()}}/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h3 class="text-white">Đơn hàng</h3>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Trang chủ</a>
                            <span>Đơn hàng</span>
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
                    <div class="hero__search d-flex">
                        <form class="hero__search__form flex-grow-1 mr-3 d-flex border-0" action="{{Request::root()}}/don-hang" method="get">
                            @if(auth()->check())
                                <input type="text" class="flex-fill mr-2 px-3 border"
                                       placeholder="Nhập mã đơn hàng" name="code"
                                       value="{{request('code')?? session('OD_CODE')}}">
                            @else
                                <input type="text" class="flex-fill mr-2 px-3 border"
                                       placeholder="Nhập số điện thoại đặt hàng" name="phone"
                                       value="{{request('phone')??session('OD_PHONE')}}">
                                <input type="text" class="flex-fill mr-2 px-3 border"
                                       placeholder="Nhập mã đơn hàng"
                                       name="code" value="{{request('code')?? session('OD_CODE')}}">
                            @endif
                            <button type="submit" class="site-btn flex-shrink-1">Tìm</button>
                        </form>
                        <a class="hero__search__phone flex-shrink-1" href="tel:{{$sites->hotline}}">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text text-center">
                                <h5>0986 88.06.01</h5>
                                <div class="text-muted">Hổ trợ <b>24/7</b></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if($orders->isEmpty())
                    <div class="p-3 mb-3 border bg-white">
                        Không có đơn hàng nào.
                    </div>
                @else
                    @foreach($orders as $order)
                        <div class="p-3 border bg-white mt-3">
                            <div class="background_pr text-white p-3 mb-1 d-flex text-center">
                                <span class="mr-3 flex-fill"><span>Mã đơn hàng:</span><b class="text-light"> {{$order->code}}</b></span>
                                <span class="mr-3 flex-fill"><span>Khách hàng:</span><b> {{$order->name}}</b></span>
                                <span class="mr-3 flex-fill"><span>Ngày mua:</span> <b> {{$order->created_at->format('d/m/Y')}}</b></span>
                                <span class="mr-3 flex-fill"><span>Ngày giao (dự kiến):</span> <b> {{$order->date_ship->format('d/m/Y')}}</b></span>
                            </div>
                            <div class="d-flex relative">
                                <span class="absolute bg-white flex-fill"></span>
                                <span class="flex-fill inline-block text-center">
                                    <a href="{{Request::root()}}/thanh-toan/{{$order->code}}" title="Click để thanh toán hoặc đổi hình thưc thanh toán" class="icon-md
                                    {{$order->order_status_id >= 1? "background_pr border":'bg-white'}}">
                                        <i class="fa fa-credit-card align-middle {{$order->order_status_id >= 1? "text-white":''}}"></i>
                                    </a>
                                    <p class="font-bold m-0 {{$order->order_status_id >= 1? "text-success":''}}">
                                        Chưa thanh toán
                                    </p>
                                    <p class="m-0">
                                        <a href="{{Request::root()}}/thanh-toan/{{$order->code}}" class="text-info">
                                            Thanh toán hoặc <br/>Đổi cách thanh toán
                                        </a>
                                    </p>
                                </span>
                                @if($order->payment == 1)
                                    <span class="flex-fill inline-block text-center">
                                        <span class="icon-md
                                        {{$order->order_status_id >= 3? "background_pr border":'bg-white'}}">
                                            <i class="fa fa-id-card {{$order->order_status_id >= 3? "text-white":''}}"></i>
                                        </span>
                                    <p class="font-bold
                                    {{$order->order_status_id >= 3? "text-success":''}}">Chờ xác nhận <br/> thanh toán (COD)</p>
                                </span>
                                @else
                                    <span class="flex-fill inline-block text-center">
                                    <span class="icon-md
                                    {{$order->order_status_id >= 2? "background_pr border":'bg-white'}}">
                                        <i class="fa fa-hourglass-half
                                        {{$order->order_status_id >= 2? "text-white":''}}"></i>
                                    </span>
                                    <p class="font-bold
                                    {{$order->order_status_id >= 2? "text-success":''}}">Chờ xác nhận <br/> thanh toán</p>
                                </span>
                                @endif
                                <span class="flex-fill inline-block text-center">
                                     <span class="icon-md
                                     {{$order->order_status_id >= 4? "background_pr border":'bg-white'}}
                                     bg-white">
                                        <i class="fa fa-cube
                                        {{$order->order_status_id >= 4? "text-white":''}}
                                        "></i>
                                    </span>
                                    <p class="font-bold
                                    {{$order->order_status_id >= 4? "text-success":''}}">Đang đóng gói</p>
                                </span>
                                <span class="flex-fill inline-block text-center">
                                    <span class="icon-md
                                    {{$order->order_status_id >= 5? "background_pr border":'bg-white'}}
                                    bg-white">
                                        <i class="fa fa-truck
                                         {{$order->order_status_id >= 5? "text-white":''}}
                                        "></i>
                                    </span>
                                    <p class="font-bold
                                    {{$order->order_status_id >= 5? "text-success":''}}">Đang giao hàng</p>
                                </span>
                                <span class="flex-fill inline-block text-center">
                                <span class="icon-md icon-complete
                                    {{$order->order_status_id >= 6? "background_pr border":'bg-white'}} bg-white">
                                        <i class="fa fa-check-circle
                                         {{$order->order_status_id >= 6? "text-white":''}}
                                        "></i>
                                    </span>
                                    <p class="font-bold
                                    {{$order->order_status_id >= 6? "text-success":''}}">Hoàn thành</p>
                                </span>
                            </div>
                            <div class="border-top">
                                <div class="text-center my-2 mb-3">
                                    <button class="btn btn-outline-success px-2 py-1 mt-2" onclick="hideInfo(this)">Xem đơn hàng</button>
                                </div>
                                <table class="table table-bordered align-middle" style="display: none">
                                    <tr class="bg-light ">
                                        <th width="15%" class="text-center">Hinh ảnh</th>
                                        <th width="30%">Tên sản phẩm</th>
                                        <th width="10%" class="text-center">Số lượng</th>
                                        <th width="10%" class="text-center">Giá</th>
                                        <th width="20%" class="text-center">Tùy chọn</th>
                                    </tr>
                                    @foreach($order->products as $item)
                                        <tr >
                                            <td class="text-center align-middle">
                                                <a href="{{route('san-pham', $item->slug)}}">
                                                    <img class="avatar-auth" alt="{{$item->title}}" onerror="this.src='/images/no-image.png'"
                                                         src="{{route('get-image-thumbnail', $item->image_id)}}"/>
                                                </a>
                                            </td>
                                            <td class="text-center align-middle"><a class="text-success" href="{{route('san-pham', $item->slug)}}">{{$item->title}} </a></td>
                                            <td class="text-center align-middle">{{$item->pivot->quantity}}</td>
                                            <td class="text-center align-middle"> <span class="font-bold text-red-600">{{number_format($item->pivot->price, 0, ',', '.') }}đ </span></td>
                                            <td class="text-center align-middle">
                                                @if(!empty(json_decode($item->pivot->options)))
                                                    {{ json_decode($item->pivot->options)->title }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-bold bg-light">
                                        <td class="text-center align-middle">Tổng tiền</td>
                                        <td class="text-center align-middle" colspan="5">
                                            <span class="ml-2">Tổng: <span class="text-danger">{{number_format(($order->total + $order->discount - $order->ship_price), 0, ',', '.')}}đ</span></span>
                                            <span class="ml-2">Giảm: <span class="text-danger"> - {{number_format($order->discount, 0, ',', '.')}}đ</span></span>
                                            <span class="ml-2">Phí giao hàng: <span class="text-danger"> + {{number_format($order->ship_price, 0, ',', '.')}}đ</span></span>
                                            <span class="ml-2">Còn lại:  <span class="text-danger">{{number_format($order->total, 0, ',', '.')}}đ</span></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    <div class="pull-right my-3">
                        {!! $orders->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function hideInfo(e){
            $(e).parent().next().toggle();
        }
    </script>
@endsection
