@extends('Admin::Layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-9">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">{{$order->code}}</h5>
                <div class="flex-shrink-0">
                    @if($order->supplier_id)
                        <a href="{{route('order-invoice', $order->id)}}" 
                            class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>Hóa Đơn </a>
                    @else
                        <a href="{{route('orders-invoice', $order->id)}}" 
                            class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>Hóa Đơn </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table table-nowrap align-middle table-borderless mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col" class="text-end">Tổng tiền</th>
                        </tr>
                    </thead>
                    @if(!empty($order->products))
                    <tbody>
                        @foreach($order->products as $item)
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                        <a href="{{route('san-pham', $item->slug)}}">
                                            <img class="img-fluid d-block" alt="{{$item->title}}" onerror="this.src='/images/no-image.png'"
                                                src="{{route('get-image-thumbnail', $item->image_id)}}"/>
                                        </a>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="fs-15 mt-2">
                                            <a class="link-primary" href="{{route('san-pham', $item->slug)}}">{{$item->title}} </a>
                                        </h5>
                                        <p class="text-muted mb-0">  
                                            @if(!empty(json_decode($item->pivot->options)))
                                                {{ json_decode($item->pivot->options)->title }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>{{$item->pivot->quantity}}</td>
                            <td><span class="font-bold text-red-600">{{number_format($item->pivot->price, 0, ',', '.') }}đ </span></td>
                            <td class="fw-medium text-end">
                               {{number_format($item->pivot->price * $item->pivot->quantity, 0, ',', '.') }}đ
                            </td>
                        </tr>
                        @endforeach
                        <tr class="border-top border-top-dashed">
                            <td colspan="3"></td>
                            <td colspan="2" class="fw-medium p-0">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Tổng tiền</td>
                                            <td class="text-end">{{number_format(($order->total), 0, ',', '.')}}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Phí giao hàng</td>
                                            <td class="text-end"> + {{number_format($order->ship_price, 0, ',', '.')}}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Shop giảm giá</td>
                                            <td class="text-end"> - {{number_format($order->down_price, 0, ',', '.')}}đ</td>
                                        </tr>
                                         <tr>
                                            <td>Mã giảm giá<span class="text-muted"> ({{$order->coupon??'Không có'}})</span></td>
                                            <td class="text-end"> - {{number_format($order->discount, 0, ',', '.')}}đ</td>
                                        </tr>
                                        <tr class="border-top border-top-dashed">
                                            <th scope="row">Tiền thanh toán</th>
                                            <th class="text-end">
                                                {{number_format($order->total+$order->ship_price-$order->down_price-$order->discount, 0, ',', '.')}}đ
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <!--end card-->
    <div class="card">
        <div class="card-header">
            <div class="d-sm-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">Trạng thái đơn hàng</h5>
                <div class="flex-shrink-0 mt-2 mt-sm-0">{{ csrf_field() }}
                    <a href="javascript:void(0);" class="btn btn-soft-info btn-sm mt-2 mt-sm-0" 
                        data-toggle="modal" data-target="#varyingcontentModal" data-whatever="@mdo">
                    <i class="ri-map-pin-line align-middle me-1"></i>Đổi địa chỉ giao hàng</a>
                    <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm mt-2 mt-sm-0" 
                        id="cancel_order_submit" url="{{ route('orders.update', $order->id) }}">
                        <i class="mdi mdi-archive-remove-outline align-middle me-1"></i> Hủy đơn hàng
                    </a>
                    <!-- Varying modal content -->
                    <div class="modal fade" id="varyingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Đổi địa chỉ giao hàng</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form> 
                                        <div class="mb-3">
                                            <label for="order_name" class="col-form-label">Tên:</label>
                                            <input type="text" class="form-control"  id="order_name" value="{{$order->name}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_phone" class="col-form-label">Số điện thoại:</label>
                                            <input type="text" class="form-control" id="order_phone" value="{{$order->phone}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_address" class="col-form-label">Địa chỉ:</label>
                                            <textarea class="form-control" id="order_address">{{$order->address}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="order_note" class="col-form-label">Ghi chú:</label>
                                            <textarea class="form-control" id="order_note">{{$order->note}}</textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="change_order_submit"
                                        url="{{ route('orders.update', $order->id) }}"
                                    >Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="profile-timeline">
                    @php 
                        $supplier_status = $order->supplier_order_status;
                        $status = $order->order_order_status->merge($supplier_status)->keyBy('order_status_id');
                    @endphp
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingOne">
                            <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title rounded-circle {{$order->order_status_id >= 3 || $order->order_status_id >= 2? "bg-success":''}}">
                                            <i class="mdi mdi-progress-check"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        @if($order->payment == 1)
                                            <span class="font-bold {{$order->order_status_id >= 3? "text-success":''}}">Chờ xác nhận thanh toán (COD)</span>
                                        @else
                                            <span class="font-bold {{$order->order_status_id >= 2? "text-success":''}}">Chờ xác nhận thanh toán</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @if($order->payment == 1)
                            <div id="collapseOne" class="accordion-collapse collapse {{$order->order_status_id >= 3? "show":'hide'}} " aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[3]))
                                        {!!$status[3]->note !!} lúc {{$status[3]->updated_at}}
                                    @else
                                        Chưa có thông tin
                                    @endif
                                </div>
                            </div>
                        @else
                            <div id="collapseOne" class="accordion-collapse collapse {{$order->order_status_id >= 2? "show":'hide'}} " aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[2]))
                                       {!! $status[2]->note !!} lúc {{$status[2]->updated_at}}
                                    @else
                                        Chưa có thông tin
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingTwo">
                            <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title rounded-circle {{$order->order_status_id >= 4? "bg-success":''}}">
                                            <i class="ri-bank-card-line" ></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <span class="flex-fill inline-block text-center  {{$order->order_status_id >= 4? "text-success":''}}">
                                            Xác nhận thanh toán thành công
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="collapseTwo" class="accordion-collapse collapse {{$order->order_status_id >= 4? "show":'hide'}}" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="accordion-body ms-2 ps-5 pt-0">
                                @if(isset($status[4]))
                                    {!! $status[4]->note !!} lúc {{$status[4]->updated_at}}
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($supplier_status->isNotEmpty())
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingThree">
                                <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle {{$order->order_status_id >= 5? "bg-success":''}}">
                                                <i class="mdi mdi-gift-outline" ></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="flex-fill inline-block text-center  {{$order->order_status_id >= 5? "text-success":''}}">
                                                Đang đóng gói
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseThree" class="accordion-collapse collapse {{$order->order_status_id >= 5? "show":'hide'}}" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[5]))
                                        {!! $status[5]->note !!} lúc {{$status[5]->updated_at}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingFour">
                                <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseFour" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle {{$order->order_status_id >= 6? "bg-success":''}}">
                                                <i class="ri-truck-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="flex-fill inline-block text-center">
                                            <span class="icon-md {{$order->order_status_id >= 6? "text-success":''}}">Đang giao hàng</span> 
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseFour" class="accordion-collapse collapse {{$order->order_status_id >= 6? "show":'hide'}}" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[6]))
                                        {!! $status[6]->note !!} lúc {{$status[6]->updated_at}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingFive">
                                <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle {{$order->order_status_id >= 7? "bg-success":''}}">
                                                <i class="mdi mdi-package-variant"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="icon-md icon-complete {{$order->order_status_id >= 7? "text-success":''}}">
                                                Hoàn thành
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseFile" class="accordion-collapse collapse {{$order->order_status_id >= 7? "show":'hide'}}" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[7]))
                                        {!! $status[7]->note !!} lúc {{$status[7]->updated_at}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($order->order_status_id == 8)
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingFive">
                                <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle {{$order->order_status_id == 8? "bg-danger":''}}">
                                                <i class="ri-refund-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="icon-md icon-complete {{$order->order_status_id == 8? "text-danger":''}}">
                                                Trả hàng
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseFile" class="accordion-collapse collapse {{$order->order_status_id == 8? "show":'hide'}}" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[8]))
                                        {!! $status[8]->note !!} lúc {{$status[8]->updated_at}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($order->order_status_id == 9)
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingFive">
                                <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle {{$order->order_status_id == 9? "bg-danger":''}}">
                                                <i class="ri-close-circle-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="icon-md icon-complete {{$order->order_status_id == 9? "text-danger":''}}">
                                                Hủy đơn
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseFile" class="accordion-collapse collapse {{$order->order_status_id == 9? "show":'hide'}}" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[9]))
                                        {!! $status[9]->note !!} lúc {{$status[9]->updated_at}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                    @if($order->order_status_id == 10)
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingFive">
                                <a class="accordion-button p-2 shadow-none" data-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle {{$order->order_status_id == 10? "bg-danger":''}}">
                                                <i class="ri-close-circle-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="icon-md icon-complete {{$order->order_status_id == 10? "text-danger":''}}">
                                                Hủy đơn
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseFile" class="accordion-collapse collapse {{$order->order_status_id == 9? "show":'hide'}}" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    @if(isset($status[9]))
                                        {!! $status[9]->note !!} lúc {{$status[9]->updated_at}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end accordion-->
            </div>
        </div>
    </div>
    <!--end card-->
    </div>
    <!--end col-->
    <div class="col-xl-3">
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-truck-fast-outline me-1 text-muted"></i> Thông tin vận chuyển</h5>
                <div class="flex-shrink-0">
                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary fs-11" data-toggle="modal" data-target="#staticBackdrop">Chi tiết</a>
                    <!-- Static Backdrop -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center p-5">
                                    <div class="mt-4">
                                        <h4 class="mb-3">Chưa có thông tin!</h4>
                                        <p class="text-muted mb-4"> Chúng tôi sẻ cập nhật khi có thông tin.</p>
                                        <div class="hstack gap-2 justify-content-center">
                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-dismiss="modal">
                                                <i class="ri-close-line align-middle"></i> Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="text-center">
                <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:80px;height:80px"></lord-icon>
                <p class="text-muted mb-0">Chưa có thông tin</p>
            </div>
        </div>
    </div>
    <!--end card-->
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <h5 class="card-title flex-grow-1 mb-0"><i class="ri-shield-user-line me-1 text-muted"></i> Thông tin khách hàng</h5>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0 vstack gap-3">
                <li>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ $order->name }}" alt="" class="avatar-sm rounded">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-12 mb-1 text-capitalize">{{$order->name}}</h6>
                            <p class="text-muted mb-0 small"><span>Ngày mua:</span> <b> {{$order->created_at->format('d/m/Y')}}</b></p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--end card-->
    @if(!empty($supplier))
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ri-store-3-line me-1 text-muted"></i>Shop bán hàng</h5>
        </div>
        <div class="card-body d-flex align-items-center">
            <div class="flex-shrink-0">
                <img src="{{route('get-image-thumbnail', $supplier->image_id)}}" alt="" class="avatar-sm rounded border">
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="fs-12 mb-1 text-capitalize">{{$supplier->title}}</h6>
                <p class="text-muted mb-0 small"><span>Địa chỉ:</span> <b> {{$supplier->address}}</b></p>
                <p class="text-muted mb-0 small"><span>Số điện thoại:</span> <b> {{$supplier->phone}}</b></span></p>
             </div>
        </div>
    </div>
    @endif
    <!--end card-->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ri-map-pin-line me-1 text-muted"></i>Địa chỉ giao hàng</h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-0 ">Người nhận:<b> {{$order->name}}</b></p>
            <p class="text-muted mb-0 "><span>Địa chỉ:</span> <b> {{$order->address}}</b></p>
            <p class="text-muted mb-0 "><span>Số điện thoại:</span> <b> {{$order->phone}}</b></span></p>
            <p class="text-muted mb-0 "><span>Thanh toán:</span> 
                @if($order->payment == 1)
                    <b>Thu hộ (COD)</b>
                @else
                    <b>Chuyển khoản</b>
                @endif
            </p>
            <p class="text-muted mb-0 "><span>Ghi chú:</span>{{$order->note??"Không có"}}</p>
        </div>
    </div>
    <!--end card-->

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ri-secure-payment-line me-1 text-muted"></i> Thông tin thanh toán</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <div id="pay_store_form">
                    <div class="text-muted font-bold ms-3">
                        <div class="border p-3 d-inline-block w-50">
                            <img src="https://api.vietqr.io/image/970436-0291000261672-TjJxHA8.jpg?accountName=LEANHHUY&amount=
                            {{$order->total+$order->ship_price-$order->down_price-$order->discount}}đ&addInfo=Thanh%20Toan%20Don%20Hang%20{{$order->code}}"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-2">
                <div class="form-group px-3">
                    <div class="text-sm">
                        <div>
                            <span class="text-sm font-bold">Số tài khoản:</span>
                            <b class="text-red-600 text-xl"> 0291000261672 </b>
                        </div>
                        <div><span class="text-sm font-bold">Ngân hàng:</span>
                            <b class="text-sm"> Vietcombank </b>
                        </div>
                        <div><span class="text-sm font-bold">Chủ tài khoản:</span>
                            <b class="text-sm">LEANHHUY</b>
                        </div>
                        <div>
                            <span class="text-sm font-bold">Số tiền:</span>
                            <b class="text-red-600 text-xl"> {{number_format($order->total+$order->ship_price-$order->down_price-$order->discount, 0, ',', '.')}}đ </b>
                        </div>
                        <div><span class="text-sm font-bold">Nội dung chuyển khoản:</span>
                            <b class="text-sm">TTĐH {{$order->code}}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end card-->
    </div>
    <!--end col-->
    <div class="col-12 text-center">
        <div class="card">
            <div class="card-body">
                @if($order->supplier_id)
                    <a class="btn btn-info" href="{{route('order.index')}}"> Back </a>
                @else
                    <a class="btn btn-info" href="{{route('orders.index')}}"> Back </a>
                @endif
            </div>
        </div>
    </div>
    </div>
                    
@endsection