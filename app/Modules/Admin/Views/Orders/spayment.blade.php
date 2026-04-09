@extends('Admin::Layouts.admin')
@section('content')
<!-- Accordions Bordered -->
<div class="card p-3">
    <div class="col-12">
        <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tuần</th>
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
                    @foreach ($order as $key => $item)
                        @foreach ($item as $k => $shop)
                            <tr class="align-middle">
                                @php
                                    $total      = $shop->sum(function($item){ return ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']); });
                                    $total_done = $shop->sum(function($item){ return ($item->done == 2)? 
                                        ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0; });
                                    $total_wait = $shop->sum(function($item){ return ($item->done != 2)? 
                                        ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0; });
                                    $total_cod = $shop->sum(function($item){ return (($item->done != 2) && $item->cod)? 
                                        ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0; });
                                    $total_bill = $total_wait - ($total_wait*0.05) - $total_cod; 

                                    $order_ids  = $shop->filter(function($item){ return ($item->done != 2); })->pluck('id');
                                    $store      = $shop->first()->supplier;
                                @endphp
                                <th> Tuần {{$key}}</th>
                                <td class="text-center">
                                    @if($shop->every(function($item){ return ($item->done == 2); }))
                                        <span class="badge bg-primary">Đã thanh toán</span>
                                    @elseif($shop->every(function($item){ return ($item->done == 1); }))
                                        <span class="badge bg-info">Đang xác nhận</span>
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
                                    @if($total_bill < 0 && $shop->every(function($item){ return ($item->done != 1); }))
                                        <button class="btn btn-danger btn-sm" 
                                            data-toggle="modal" data-target="#bank_modal_{{$key}}_{{$k}}">Thanh toán</button>
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
                                                        <div class="col-8">
                                                            <div class="border py-3">
                                                                <table class="fs-16 w-100">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td scope="row" class="text-end">Chủ tài khoản:</td>
                                                                            <th class="text-start ps-2">LEANHHUY</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row" class="text-end">Ngân hàng:</td>
                                                                            <th class="text-start ps-2">Vietcombank</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row" class="text-end">Số tài khoản:</td>
                                                                            <th class="text-start ps-2">0291000261672</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td scope="row" class="text-end">Số tiền:</td>
                                                                            <th class="text-start text-danger ps-2">
                                                                                {{number_format(abs($total_bill), 0, ',', '.')}}đ  
                                                                            </th>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="border">
                                                                <img src="https://api.vietqr.io/image/970436-0291000261672-TjJxHA8.jpg
                                                                ?accountName=LEANHHUY&amp;amount={{abs($total_bill)}}đ&amp;addInfo=Shop%20{{
                                                                    \Illuminate\Support\Str::slug($store['title'])
                                                                }}Thanh%20Toan%20Tuan%20{{$key}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form method="POST" action="{{route('update-spayment')}}" enctype="multipart/form-data">
                                                        <div class="my-3 text-start">
                                                            {{ csrf_field() }}
                                                            <label for="formFile" class="form-label text-muted ">
                                                                Shop quét QR để lấy thông tin hoặc chuyển tiền vào số tài khoản trên. 
                                                                Chúng tôi sẻ kiểm tra và cập nhật thông tin. 
                                                                Cảm ơn Shop.
                                                            </label>
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
                                                        <div class="justify-content-end ">
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-success">Hoàn thành</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection