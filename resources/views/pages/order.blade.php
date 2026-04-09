@extends('layouts.app')
@section('content')
    <x-breadcrumb name="don-hang" title="Đơn Hàng"></x-breadcrumb>
    <!-- Hero Section Begin -->
    <section class="hero background mt-3">
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
                        <a class="hero__search__phone flex-shrink-1" href="tel:{{$sites?->hotline}}">
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
                @if(empty($orders))
                    <div class="p-3 mb-3 border bg-white">
                        Không có đơn hàng nào.
                    </div>
                @else
                    @foreach($orders->resolve() as $order)
                        <div class="bg-white mt-3"> 
                            <div class="background_pr p-2 d-flex justify-content-between">
                                @if ($order['order_status_id'] <= 3)
                                    <a href="{{Request::root()}}/thanh-toan/{{$order['code']}}" class="ml-3 flex-fill mt-1">
                                        Đổi cách thanh toán
                                    </a>
                                @endif
                                <span class="mr-3 flex-fill mt-1 text-white "><span>Mã đơn hàng:</span><b class="text-light"> {{$order['code']}}</b></span>
                                <span class="mr-3 flex-fill mt-1 text-white "><span>Ngày mua:</span>{{$order['created_at']->format('d/m/Y')}}</span>
                                <span class="mr-3 flex-fill mt-1 text-white "><span>Trạng thái:</span> 
                                    @if($order['order_status_id'] == 4)
                                        Đã xác nhận
                                    @else
                                        Chờ xác nhận
                                    @endif 
                                </span>
                                <button class="btn btn-success btn-sm mr-3" onclick="hideInfo(this)">Xem đơn hàng</button>
                            </div>
                            <table class="table table-bordered align-middle mb-0" style="display: none">
                                <tr class="bg-light ">
                                    <th width="15%" class="text-center dis_none">Hinh ảnh</th>
                                    <th width="30%">Tên sản phẩm</th>
                                    <th width="10%" class="text-center">Số lượng</th>
                                    <th width="10%" class="text-center">Giá</th>
                                    <th width="20%" class="text-center dis_none">Tùy chọn</th>
                                </tr>
                                @foreach($order['products'] as $item)
                                    <tr >
                                        <td class="text-center align-middle dis_none">
                                            <a href="{{route('san-pham', $item->slug)}}">
                                                <img class="avatar-auth" alt="{{$item->title}}" onerror="this.src='/images/no-image.png'"
                                                        src="{{route('get-image-thumbnail', $item->image_id)}}"/>
                                            </a>
                                        </td>
                                        <td class="align-middle"><a class="text-success" href="{{route('san-pham', $item->slug)}}">{{$item->title}} </a></td>
                                        <td class="text-center align-middle">{{$item->pivot->quantity}}</td>
                                        <td class="text-center align-middle"> <span class="font-bold text-red-600">{{number_format($item->pivot->price, 0, ',', '.') }}đ </span></td>
                                        <td class="text-center align-middle dis_none">
                                            @if(!empty(json_decode($item->pivot->options)))
                                                {{ json_decode($item->pivot->options)->title }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="font-bold bg-light">
                                    <td class="text-center align-middle flip-span" colspan="5">
                                        <span class="ml-2">Tổng: <span class="text-danger">{{number_format(($order['total']), 0, ',', '.')}}đ</span></span>
                                        <span class="ml-2">Phí giao hàng: <span class="text-danger"> + {{number_format($order['ship_price'], 0, ',', '.')}}đ</span></span>
                                        <span class="ml-2">Shop giảm giá: <span class="text-danger"> - {{number_format($order['down_price'], 0, ',', '.')}}đ</span></span>
                                        <span class="ml-2">Mã giảm giá: <span class="text-danger"> - {{number_format($order['discount'], 0, ',', '.')}}đ</span></span>
                                        <b class="ml-2">Thanh toán: <span class="text-danger">
                                            {{number_format($order['total']+$order['ship_price']-$order['down_price']-$order['discount'], 0, ',', '.')}}đ</span></b>
                                    </td>
                                </tr>
                            </table>
                            <div class="border px-3 pb-2">    
                                <div class="text-center py-1"><b> Chi tiết giao hàng </b></div>
                                    @foreach ($order['supplier_orders']->resolve() as $sorder) 
                                        <div class="border mb-3 small">
                                            <div class="d-flex justify-content-between bg-light p-1">
                                                <span class="mt-1 ml-1">Shop: <a class="text-info" href="{{route('shop-detail', $sorder['supplier']['slug'])}}"> 
                                                    {{$sorder['supplier']['title']}} </a>
                                                </span>
                                                <span class="mt-1">Trạng thái: {{$sorder['order_status_title']}} </span>
                                                @php
                                                    $date_ship = ($sorder['ship_id'] == 1)?
                                                    Carbon\Carbon::parse($order['created_at'])->addDays(2):
                                                    Carbon\Carbon::parse($order['created_at'])->addDays(4);
                                                @endphp
                                                <span class="mt-1">Ngày giao (dự kiến):  {{$date_ship->format('d/m/Y')}} </span>
                                                <button class="btn btn-secondary btn-sm mr-1" onclick="hideInfo(this)">Xem gói hàng</button>
                                            </div>
                                            <table class="table align-middle mb-0" style="display: none">
                                                <tr class="bg-light">
                                                    <th width="15%" class="text-center dis_none">Hinh ảnh</th>
                                                    <th width="30%">Tên sản phẩm</th>
                                                    <th width="10%" class="text-center">Số lượng</th>
                                                    <th width="10%" class="text-center">Giá</th>
                                                    <th width="20%" class="text-center dis_none">Tùy chọn</th>
                                                </tr>
                                                @foreach($sorder['products'] as $item)
                                                    <tr >
                                                        <td class="text-center align-middle dis_none">
                                                            <a href="{{route('san-pham', $item->slug)}}">
                                                                <img class="avatar-auth" alt="{{$item->title}}" onerror="this.src='/images/no-image.png'"
                                                                        src="{{route('get-image-thumbnail', $item->image_id)}}"/>
                                                            </a>
                                                        </td>
                                                        <td class="align-middle"><a class="text-success" href="{{route('san-pham', $item->slug)}}">{{$item->title}} </a></td>
                                                        <td class="text-center align-middle">{{$item->pivot->quantity}}</td>
                                                        <td class="text-center align-middle"> <span class="font-bold text-red-600">{{number_format($item->pivot->price, 0, ',', '.') }}đ </span></td>
                                                        <td class="text-center align-middle dis_none">
                                                            @if(!empty(json_decode($item->pivot->options)))
                                                                {{ json_decode($item->pivot->options)->title }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="font-bold bg-light">
                                                    <td class="text-center align-middle flip-span" colspan="5">
                                                        <span class="ml-2">Tổng: <span class="text-danger">{{number_format(($sorder['total']), 0, ',', '.')}}đ</span></span>
                                                        <span class="ml-2">Phí giao hàng: <span class="text-danger"> + {{number_format($sorder['ship_price'], 0, ',', '.')}}đ</span></span>
                                                        <span class="ml-2">Shop giảm giá: <span class="text-danger"> - {{number_format($sorder['down_price'], 0, ',', '.')}}đ</span></span>
                                                        <span class="ml-2">Mã giảm giá: <span class="text-danger"> - {{number_format($sorder['discount'], 0, ',', '.')}}đ</span></span>
                                                        <b class="ml-2">Thanh toán:  <span class="text-danger">
                                                            {{number_format($sorder['total']+$sorder['ship_price']-$sorder['down_price']-$sorder['discount'], 0, ',', '.')}}đ</span></b>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="d-flex relative cycle-bill">
                                                @if($order['payment'] == 1)
                                                    <span class="flex-fill inline-block text-center">
                                                        <span class="icon-md
                                                        {{$order['order_status_id'] >= 3? "background_pr border":'bg-white'}} border">
                                                            <i class="fa fa-hourglass-half {{$order['order_status_id'] >= 3? "text-white":''}}"></i>
                                                        </span>
                                                        <p class="font-bold
                                                            {{$order['order_status_id'] >= 3? "text-success":''}}">Chờ xác nhận <br/><span class="small text-muted"> Thanh toán (COD)</span>
                                                        </p>
                                                    </span>
                                                @else
                                                    <span class="flex-fill inline-block text-center">
                                                    <span class="icon-md
                                                    {{$order['order_status_id'] >= 2? "background_pr border":'bg-white'}} border">
                                                        <i class="fa fa-hourglass-half
                                                        {{$sorder['order_status_id'] >= 2? "text-white":''}}"></i>
                                                    </span>
                                                    <p class="font-bold
                                                        {{$order['order_status_id'] >= 2? "text-success":''}}">Chờ xác nhận <br/><span class="small text-muted"> Thanh toán ngân hàng</span>
                                                    </p>
                                                </span>
                                                @endif
                                                <span class="flex-fill inline-block text-center">
                                                    <span class="icon-md
                                                    {{$order['order_status_id'] >= 4? "background_pr border":'bg-white'}} border">
                                                        <i class="fa fa-credit-card {{$order['order_status_id'] >= 4? "text-white":''}}"></i>
                                                    </span>
                                                    <p class="font-bold m-0 {{$order['order_status_id'] >= 4? "text-success":''}}">
                                                        Đã xác nhận
                                                    </p>
                                                </span>
                                                <span class="flex-fill inline-block text-center">
                                                    <span class="icon-md {{$sorder['order_status_id'] >= 5? "background_pr border":'bg-white'}} border">
                                                        <i class="fa fa-cube {{$sorder['order_status_id'] >= 5? "text-white":''}}"></i>
                                                    </span>
                                                    <p class="font-bold
                                                    {{$sorder['order_status_id'] >= 5? "text-success":''}}">Đang đóng gói</p>
                                                </span>
                                                <span class="flex-fill inline-block text-center">
                                                    <span class="icon-md
                                                    {{$sorder['order_status_id'] >= 6? "background_pr border":'bg-white'}} border">
                                                        <i class="fa fa-truck {{$sorder['order_status_id'] >= 6? "text-white":''}}"></i>
                                                    </span>
                                                    <p class="font-bold
                                                    {{$sorder['order_status_id'] >= 6? "text-success":''}}">Đang giao hàng</p>
                                                </span>
                                                <span class="flex-fill inline-block text-center">
                                                <span class="icon-md icon-complete
                                                    {{$sorder['order_status_id'] >= 7? "background_pr border":'bg-white'}} border">
                                                        <i class="fa fa-check-circle
                                                        {{$sorder['order_status_id'] >= 7? "text-white":''}}
                                                        "></i>
                                                    </span>
                                                    <p class="font-bold
                                                    {{$sorder['order_status_id'] >= 7? "text-success":''}}">Hoàn thành</p>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
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
