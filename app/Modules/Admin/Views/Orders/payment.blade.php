@extends('Admin::Layouts.admin')
@section('content')
<!-- Accordions Bordered -->
<div class="card p-3">
    <div class="col-12">
        <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-secondary" id="accordionBordered">
            @foreach ($order as $key => $item)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion_{{$key}}">
                        <button class="accordion-button text-bold fs-16" type="button" data-toggle="collapse" data-target="#accor__{{$key}}" aria-expanded="true" aria-controls="accor__{{$key}}">
                            Tuần {{$key}}
                        </button>
                    </h2>
                    <div id="accor__{{$key}}" class="accordion-collapse collapse show" 
                    aria-labelledby="accordion_{{$key}}" data-parent="#accordionBordered">
                        <div class="accordion-body p-1">
                                <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Shop</th>
                                        <th class="text-center">Trang thái</th>
                                        <th class="text-center">Tổng số đơn</th>
                                        <th class="text-center">Tổng đơn giá</th>
                                        <th class="text-center">Đã thanh toán</th>
                                        <th class="text-center border-start">Chưa thanh toán</th>
                                        <th class="text-center">- Phí 5%</th>
                                        <th class="text-center">- Thu hộ</th>
                                        <th class="text-center border-end">= Dư nợ</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item as $k => $shop)
                                        <tr class="align-middle">
                                            @php
                                                $total      = $shop->sum(function($item){ return ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']); });
                                                $total_done = $shop->sum(function($item){ return $item->done == 2? 
                                                    ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0; });
                                                $total_wait = $shop->sum(function($item){ return $item->done != 2? 
                                                    ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0; });
                                                $total_cod = $shop->sum(function($item){ return ($item->done != 2 && $item->cod)? 
                                                    ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0; });
                                                    
                                                $total_bill = $total_wait - ($total_wait*0.05) - $total_cod; 
                                                $order_ids  = $shop->filter(function($item){ return $item->done != 2; })->pluck('id');
                                                $conf_ids   = $shop->filter(function($item){ return $item->done != 2; })->pluck('id');
                                                $store      = $shop->first()->supplier;
                                            @endphp
                                            <th >{{$store? $store['title']: ''}}</th>
                                            <td class="text-center">
                                                @if($shop->every(function($item){ return ($item->done == 2); }))
                                                    <span class="badge bg-primary">Đã thanh toán</span>
                                                @else
                                                    <span class="badge bg-danger">Chưa thanh toán</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$shop->count()}}</th>
                                            <td class="text-center">{{number_format($total, 0, ',', '.')}}đ</th>
                                            <td class="text-center ">{{number_format($total_done, 0, ',', '.')}}đ</th>
                                            <td class="text-center text-success border-start">{{number_format($total_wait, 0, ',', '.')}}đ</th>
                                            <td class="text-center text-info">{{number_format($total_wait*0.05, 0, ',', '.')}}đ</th>
                                            <td class="text-center text-warning">{{number_format($total_cod, 0, ',', '.')}}đ</th>
                                            <td class="text-center text-danger border-end">{{
                                                number_format($total_bill, 0, ',', '.')}}đ</th>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success bg-primary btn-sm" 
                                                    data-toggle="modal" data-target="#shop_modal_{{$key}}_{{$k}}">Xem</button>
                                                @if($shop->every(function($item){ return ($item->done != 2); }) && ($total_bill > 0))
                                                    <button class="btn btn-danger btn-sm" 
                                                        data-toggle="modal" data-target="#bank_modal_{{$key}}_{{$k}}">Thanh toán</button>
                                                @elseif($total_bill < 0)
                                                    <button class="btn btn-success btn-sm" 
                                                        data-toggle="modal" data-target="#confirm_modal_{{$key}}_{{$k}}">Xác nhận</button>
                                                @endif

                                                <!-- Grids in modals -->
                                                <div class="modal fade modal-lg" id="shop_modal_{{$key}}_{{$k}}" tabindex="-1" aria-modal="true">
                                                    <div class="modal-dialog modal-dialog-center">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Shop: {{$shop->first()->supplier? $shop->first()->supplier['title']: ''}} 
                                                                    - Đơn hàng (Tuần {{$key}})
                                                                </h5>
                                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr class="bg-light">
                                                                            <th class="text-center">Mã đơn</th>
                                                                            <th class="text-center">Khách hàng</th>
                                                                            <th class="text-center">Điện thoại</th>
                                                                            <th class="text-center">Đơn giá</th>
                                                                            <th class="text-center">Ngày mua</th>
                                                                            <th class="text-center">Ngày chốt</th>
                                                                            <th class="text-center">Tình trạng</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($shop as $sorder)
                                                                            <tr>
                                                                                <th class="text-center">{{$sorder->code}}</th>
                                                                                <td class="text-center">{{$sorder->name}}</td>
                                                                                <td class="text-center">{{$sorder->phone}}</td>
                                                                                <td class="text-center">{{
                                                                                    number_format(($sorder['total'] + $sorder['ship_price'] - $sorder['down_price']), 0, ',', '.')}} đ
                                                                                </td>
                                                                                <td class="text-center">{{$sorder->created_at->format('d/m/Y')}}</td>
                                                                                <td class="text-center">{{$sorder->updated_at->format('d/m/Y')}}</td>
                                                                                <td class="text-center">
                                                                                    @if($sorder->done)
                                                                                        <span class="badge bg-primary">Đã thanh toán</span>
                                                                                    @else
                                                                                        <span class="badge bg-danger">Chưa thanh toán</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="bg-light">
                                                                            <th class="text-center" colspan="2">Tổng đơn <br/>{{number_format($total, 0, ',', '.')}} đ</th>
                                                                            <th class="text-center">Đã thanh toán <br/> {{number_format($total_done, 0, ',', '.')}} đ</th>
                                                                            <th class="text-center text-success">Chưa thanh toán <br/> {{number_format($total_wait, 0, ',', '.')}} đ</th>
                                                                            <th class="text-center text-info"> - Phí 5%<br/> {{number_format($total_wait*0.05, 0, ',', '.')}} đ</th>
                                                                            <th class="text-center text-warning">- Thu hộ<br/>{{number_format($total_cod, 0, ',', '.')}}đ</th>
                                                                            <th class="text-center text-danger" colspan="2">= Dư nợ <br/><span class="text-danger">
                                                                                {{number_format($total_bill, 0, ',', '.')}}đ</span> </th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="bank_modal_{{$key}}_{{$k}}" tabindex="-1" aria-modal="true">
                                                    <div class="modal-dialog modal-dialog-center">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"> 
                                                                    Thanh toán (Tuần {{$key}}) - Shop {{$store? $store['title']: ''}} 
                                                                </h5>
                                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row"> 
                                                                    <div class="col-8 border py-4">
                                                                        <table class="fs-16 w-100">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td scope="row" class="text-end">Chủ tài khoản:</td>
                                                                                    <th class="text-start">{{$store['bank_name']??''}} </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td scope="row" class="text-end">Ngân hàng:</td>
                                                                                    <th class="text-start">{{$store['bank']??''}} </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td scope="row" class="text-end">Số tài khoản:</td>
                                                                                    <th class="text-start">{{$store['bank_number']??''}} </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td scope="row" class="text-end">Số tiền:</td>
                                                                                    <th class="text-start text-danger">{{number_format($total_bill, 0, ',', '.')}}đ  </th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                   
                                                                    <div class="col-4 border">
                                                                        <div class="my-3"> 
                                                                            @if(isset($store['bank_qr']))
                                                                                <img src="https://api.vietqr.io/image/970436-0291000261672-TjJxHA8.jpg
                                                                                ?accountName=LEANHHUY&amp;amount={{$total_bill}}đ&amp;addInfo=Thanh%20Toan%20Don%20Hang%20DH796595">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                   
                                                                </div>
                                                                <form method="POST" action="{{route('update-payment')}}" enctype="multipart/form-data">
                                                                    <div class="my-3">
                                                                        {{ csrf_field() }}
                                                                        <label for="formFile" class="form-label text-danger">Tải ảnh hóa đơn chuyển khoản 
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <input type="hidden" name="shop_id" value="{{$store['id']??'0'}}"/>
                                                                        <input type="hidden" name="order_ids" value="{{json_encode($order_ids)}}"/>
                                                                        <input class="form-control" type="file" name="upload_payment" id="upload_payment" required>
                                                                        <x-input-error :messages="$errors->get('upload_payment')"/>
                                                                        <x-input-error :messages="$errors->get('order_ids')"/>
                                                                        <x-input-error :messages="$errors->get('shop_id')"/>
                                                                    </div>
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                                                                        <button type="submit" class="btn btn-danger">Thanh Toán</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="confirm_modal_{{$key}}_{{$k}}" tabindex="-1" aria-modal="true">
                                                    <div class="modal-dialog modal-dialog-center">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"> 
                                                                    Thanh toán (Tuần {{$key}}) - Shop {{$store? $store['title']: ''}} 
                                                                </h5>
                                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row"> 
                                                                    <div class="col-12 border py-4 text-center">
                                                                        @foreach($shop as $sorder)
                                                                            @if($sorder->done == 1)
                                                                                <img src="{{Request::root().'/storage/'.$sorder->pay_file}}" 
                                                                                    class="border m-2" style="max-width: 300px"/>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <form method="POST" action="{{route('confirm-payment')}}" enctype="multipart/form-data">
                                                                    <div class="my-3">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="shop_id" value="{{$store['id']??'0'}}"/>
                                                                        <input type="hidden" name="conf_ids" value="{{json_encode($conf_ids)}}"/>
                                                                        <x-input-error :messages="$errors->get('conf_ids')"/>
                                                                        <x-input-error :messages="$errors->get('shop_id')"/>
                                                                    </div>
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                                                                        <button type="submit" class="btn btn-danger">Xác nhận</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection