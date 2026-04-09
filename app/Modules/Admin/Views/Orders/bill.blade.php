@extends('Admin::Layouts.admin')
@section('content')
<div class="card">
        <div class="card-body">
            <form action="{{Request::url().$url_sort}}" method="get">
                <div class="row row-cols-lg-auto align-items-center">
                    <div class="col-12">
                        <label>Chọn lệnh truy vấn</label>
                            {{Form::select("bill_query", [
                                "Truy vấn hóa đơn",
                                "1"=>"Lấy các đơn trong ngày",
                                "2"=>"Lấy các đơn trong tuần",
                                "3"=>"Lấy các đơn trong tháng",
                                "4"=>"Lấy các đơn trong năm",
                                "5"=>"Lấy các đơn trong khoản thời gian",
                                "6"=>"Lấy các đơn trong vòng N ngày",
                            ], $report['bill_query']??2, 
                            array('class' => 'form-control', 'id'=>"bill_query", 'onchange'=>"selectBill(this)"))}}
                    </div><!--end col-->
                    <div class="col-12" id="bill_picker_from" style="display: none">
                        <label>Từ ngày</label>
                        {{Form::input('text', 'picker_from', $report['picker_from']??'', array('class' => 'form-control', 'id'=>"datetimepicker_from", 'autocomplete'=>"off"))}}
                        <script>
                            $('#datetimepicker_from').datepicker({
                                setDate: new Date(),
                                dateFormat: "dd/mm/yy"
                            });
                        </script>
                    </div><!--end col-->
                    <div class="col-12" id="bill_picker_to" style="display: none">
                        <label>Đến ngày</label>
                        {{Form::input('text', 'picker_to', $report['picker_to']??'',  array('class' => 'form-control',  'id'=>"datetimepicker_to", 'autocomplete'=>"off"))}}
                        <script>
                            $('#datetimepicker_to').datepicker({
                                setDate: new Date(),
                                dateFormat: "dd/mm/yy"
                            });
                        </script>
                    </div>
                    <div class="col-12" id="bill_number" style="display: none">
                        <label>Số N</label>
                        {{Form::input('text', 'bill_number',  $report['bill_number']??'10',  array('class' => 'form-control', 'id'=>"bill_number_input", 'autocomplete'=>"off"))}}
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-4" id="bill_submit">Truy vấn</button>
                        <button type="submit" class="btn btn-info mt-4" name="export_excel" value="1">Xuất Excel</button>
                    </div>
                </div>
            </form>
            <script>
                selectBill(document.getElementById('bill_query'));
                function selectBill (e){
                    let picker = ['5'];
                    let num = ['6'];
                    let status = 0;
                    
                    let bill_picker_from = document.getElementById('bill_picker_from');
                    let bill_picker_to = document.getElementById('bill_picker_to');
                    let bill_number = document.getElementById('bill_number');

                    let bill_picker_from_input = document.getElementById('datetimepicker_from');
                    let bill_picker_to_input = document.getElementById('datetimepicker_to');
                    let bill_number_input = document.getElementById('bill_number_input');

                    if(picker.includes(e.value)){
                        bill_picker_from.style.display = 'block';
                        bill_picker_from_input.disabled = false;
                        bill_picker_to.style.display = 'block';
                        bill_picker_to_input.disabled = false;
                        bill_number.style.display = 'none';
                        bill_number_input.disabled = true;
                    }else if(num.includes(e.value)){
                        bill_picker_from.style.display = 'none';
                        bill_picker_from_input.disabled = true;
                        bill_picker_to.style.display = 'none';
                        bill_picker_to_input.disabled = true;
                        bill_number.style.display = 'block';
                        bill_number_input.disabled = false;
                    }else{
                        bill_picker_from.style.display = 'none';
                        bill_picker_from_input.disabled = true;
                        bill_picker_to.style.display = 'none';
                        bill_picker_to_input.disabled = true;
                        bill_number.style.display = 'none';
                        bill_number_input.disabled = true;
                    }
                }
            </script>
        </div><!--end col-->
    </div>
    
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng đơn hàng <span class="text-danger">
                                {{
                                    $report['time_query']
                                }}
                            </span> </p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                {{
                                    $report['all_order'][1]+
                                    $report['all_order'][2]+
                                    $report['all_order'][3]+
                                    $report['all_order'][4]+
                                    $report['all_order'][5]+
                                    $report['all_order'][6]+
                                    $report['all_order'][7]+
                                    $report['all_order'][8]+
                                    $report['all_order'][9]+
                                    $report['all_order'][9]+
                                    $report['all_order'][10]+
                                    $report['all_order'][11]+
                                    $report['all_order'][12]
                                }} Đơn
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">Tổng tiền: 
                                <span class="counter-value text-danger">{{
                                    number_format(
                                        $report['sum_order'][1]+
                                        $report['sum_order'][2]+
                                        $report['sum_order'][3]+
                                        $report['sum_order'][4]+
                                        $report['sum_order'][5]+
                                        $report['sum_order'][6]+
                                        $report['sum_order'][7]+
                                        $report['sum_order'][8]+
                                        $report['sum_order'][9]+
                                        $report['sum_order'][10]+
                                        $report['sum_order'][11]+
                                        $report['sum_order'][12]
                                    , 0, ',', '.')}}đ </span></h4>
                            <span>
                                Tổng đơn hủy: <span class="text-danger">
                                {{  $report['all_order'][8]+
                                    $report['all_order'][9]+
                                    $report['all_order'][11]+
                                    $report['all_order'][12]
                                }} đơn - {{ 
                                number_format(
                                    $report['sum_order'][8]+
                                    $report['sum_order'][9]+
                                    $report['sum_order'][11]+
                                    $report['sum_order'][12]
                                , 0, ',', '.')
                                }}đ</span>
                            </span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx ri-product-hunt-line text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn đang xác nhận <span class="text-danger">
                                {{$report['time_query']}}</span> </p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                {{$report['all_order'][2]+$report['all_order'][3]+$report['all_order'][4]}} Đơn
                            </h5>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Mới khởi tạo</a></th>
                                    <td>{{$report['all_order'][1]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][1], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Thu hộ</a></th>
                                    <td>{{$report['all_order'][2]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][2], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Chuyển khoản</a></th>
                                    <td>{{$report['all_order'][3]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][3], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Đã xác nhận</a></th>
                                    <td>{{$report['all_order'][4]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][4], 0, ',', '.')}}đ </b> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn đang xử lý <span class="text-danger">
                                {{$report['time_query']}}</span> </p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                {{$report['all_order'][5]+$report['all_order'][6]+$report['all_order'][7]}} Đơn
                            </h5>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Đóng gói</a></th>
                                    <td>{{$report['all_order'][5]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][5], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Đang giao</a></th>
                                    <td>{{$report['all_order'][6]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][6], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Hoàn thành</a></th>
                                    <td>{{$report['all_order'][7]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][7], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Đã chốt</a></th>
                                    <td>{{$report['all_order'][10]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][10], 0, ',', '.')}}đ </b> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hoàn trả, hủy, từ chối <span class="text-danger">
                                {{$report['time_query']}}</span> </p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                {{$report['all_order'][8]+$report['all_order'][9]}} Đơn
                            </h5>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Hoàn trả</a></th>
                                    <td>{{$report['all_order'][8]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][8], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Hủy</a></th>
                                    <td>{{$report['all_order'][9]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][9], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Từ chối</a></th>
                                    <td>{{$report['all_order'][11]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][11], 0, ',', '.')}}đ </b> </td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Không xác nhận</a></th>
                                    <td>{{$report['all_order'][12]}} </td>
                                    <td class="text-end"><b class="text-danger">{{number_format($report['sum_order'][12], 0, ',', '.')}}đ </b> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div id="list" class="card">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle table-nowrap mb-0">
                <thead>
                    <tr>
                        <th width="3%" class="text-center">
                            STT {{ csrf_field() }}
                        </th>
                        @foreach($list as $key => $val)
                            @if(!isset($val['hidden']))
                            <th width="{{isset($val['width'])?$val['width']:''}}%">
                                <div class="d-flex flex-fill">
                                    <span class="flex-grow-1">{{isset($val['title'])?$val['title']:''}}</span>
                                    @if(!isset($val['sort']) || ($val['sort'] != 'hidden'))
                                        <span class="flex-shrink-1 d-flex" title="Sắp Xếp">
                                            @if(($sort['order'] == $key))
                                                @if($sort['by'] == 'asc')
                                                    <a href="{{Request::url()}}{{(Session::get('page') != null)?
                                                    '?page='.Session::get('page').'&order='.$key.'&by=asc': '?order='.$key.'&by='}}">
                                                        <i class="ri-arrow-up-s-fill" aria-hidden="true"></i>
                                                    </a>
                                                @else
                                                    <a href="{{Request::url()}}{{(Session::get('page') != null)?
                                                        '?page='.Session::get('page').'&order='.$key.'&by=desc': '?order='.$key.'&by=asc'}}">
                                                        <i class="ri-arrow-down-s-fill" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{Request::url()}}{{(Session::get('page') != null)?
                                                    '?page='.Session::get('page').'&order='.$key.'&by=desc': '?order='.$key.'&by=desc'}}">
                                                    <i class="ri-expand-up-down-fill" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </th>
                            @endif
                        @endforeach
                        <th width="8%" class="text-center">
                            Thực Hiện
                        </th>
                    </tr>
                </thead>
                <form id="filter" method="get" action="{{Request::url().$url_sort}}">
                    <tr class="filter-list table-light">
                        <td class="text-center align-middle">
                            #
                        </td>
                        @foreach($list as $key => $val)
                            @if(!isset($val['hidden']))
                                <td>
                                @if(isset($val['filter']['type']))
                                    @switch($val['filter']['type'])
                                        @case('text')
                                            {{Form::input('text', $key, $val['filter']['value'], array('class' => 'form-control', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                                        @break
                                        @case('select')
                                            {{Form::select($key, $val['data'], isset($val['filter']['value'])? $val['filter']['value']: null, array('class' => 'form-control'))}}
                                        @break
                                        @default
                                            {{Form::input('text',$key, $val['filter']['value'], array('class' => 'form-control', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                                        @break
                                    @endswitch
                                @endif
                                </td>
                            @endif
                        @endforeach
                        <td colspan="2" class="text-center">
                            <div class="group-button">
                                <input type="submit" class="btn btn-secondary" name="submit" value="Lọc">
                            </div>
                        </td>
                    </tr>
                </form>
                <tbody>
                    @foreach($data as $l_key => $l_value)
                    <tr>
                        <td class="text-center">
                            {{$l_key + 1}}
                        </td>
                        @foreach($list as $key => $val)
                            @if(!isset($val['hidden']))
                                @if(isset($val['views']) && isset($val['views']['type']))
                                    @switch($val['views']['type'])
                                        @case('images')
                                            <td class="text-center">
                                                @if(!empty($l_value[$key]))
                                                    @foreach (explode(',', $l_value[$key]) as $item)
                                                        <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $item)}}"></span>
                                                    @endforeach
                                                @endif
                                            </td>
                                        @break
                                        @case('image')
                                            <td class="text-center">
                                            @if(empty($val['update']) )
                                                <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{$l_value[$key]}}"></span>
                                            @else
                                                <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                    <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{$l_value[$key]}}"></span>
                                                </span>
                                            @endif
                                            </td>
                                        @break
                                        @case('image_id')
                                            <td class="text-center">
                                            @if(empty($val['update']) && isset($l_value[$key]))
                                                <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $l_value[$key])}}"></span>
                                            @else
                                                <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                    @if($l_value[$key])
                                                    <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $l_value[$key])}}"></span>
                                                    @endif
                                                </span>
                                            @endif
                                            </td>
                                        @break
                                        @case('file')
                                            <td class="text-center">
                                            @if(empty($val['update']) )
                                                <span>{{preg_replace('/(.)*(?:\/)/','',$l_value[$key])}}</span>
                                            @else
                                                <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                    <span>{{preg_replace('/(.)*(?:\/)/','',$l_value[$key])}}</span>
                                                </span>
                                            @endif
                                            </td>
                                        @break
                                        @case('check')
                                            <td class="text-center form-switch check-list">
                                                {{Form::checkbox($key, $l_value['id'], $l_value[$key], array('class'=>'form-check-input', 'fid='.$l_value['id'], (empty($val['update']) )?'disabled':''))}}
                                            </td>
                                        @break
                                        @case('select')
                                            <td class="text-left">
                                            @if(empty($val['update']) )
                                                <span class="no-update">
                                                    @foreach($val['data'] as $k => $value)
                                                        @if($l_value[$key] == $k)
                                                            {{$value}}
                                                        @endif
                                                    @endforeach
                                                </span>
                                            @else
                                                <span class="can_update_text" type="{{$val['views']['type']}}" data="{{json_encode($val['data'])}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                    @foreach($val['data'] as $k => $value)
                                                        @if($l_value[$key] == $k)
                                                            <span class="inline badge bg-info" uid="{{$k}}">{{$value}}</span>
                                                        @endif
                                                    @endforeach
                                                </span>
                                            @endif
                                            </td>
                                        @break
                                        @case('area')
                                            <td class="text-left">
                                                @if(empty($val['update']) )
                                                    <span class="no-update">{!! $l_value[$key] !!}</span>
                                                @else
                                                    <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                        <span class="inline">{!! $l_value[$key] !!}</span>
                                                    </span>
                                                @endif
                                            </td>
                                        @break
                                        @case('text')
                                            <td class="text-left">
                                                @if(empty($val['update']) )
                                                    <span class="p-2">{!! $l_value[$key] !!}</span>
                                                @else
                                                    <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                        <span class="p-2">{!! $l_value[$key] !!}</span>
                                                    </span>
                                                @endif
                                            </td>
                                        @break
                                        @case('price')
                                            <td class="text-left">
                                                @if(empty($val['update']) )
                                                    <span class="p-2 font-weight-bold">{!! number_format($l_value[$key], 0, ',', '.') !!} đ</span>
                                                @else
                                                    <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                        <span class="p-2 font-weight-bold">{!! number_format($l_value[$key], 0, ',', '.') !!} đ</span>
                                                    </span>
                                                @endif
                                            </td>
                                            @break
                                        @default
                                            <td class="text-left">
                                                <span class="p-2">{!! $l_value[$key] !!}</span>
                                            </td>
                                        @break
                                    @endswitch
                                @else
                                    <td class="text-left">
                                    @if(empty($val['update']) )
                                        <span class="no-update">{!! $l_value[$key] !!}</span>
                                    @else
                                        <span class="can_update_text" field="{{$key}}" type="text" uid="{{$l_value['id']}}">
                                            <span class="inline">{!! $l_value[$key] !!}</span>
                                        </span>
                                    @endif
                                    </td>
                                @endif
                            @endif
                        @endforeach
                        <td class="action_row text-center">
                            @if($l_value['supplier_id'])
                                <a title="Xem" target="blank" href="{{route('order-detail', $l_value['id'])}}" class="btn btn-success btn-sm">
                                    <i class="ri ri-eye-line" aria-hidden="true"></i>
                                </a>
                            @else
                                <a title="Xem" target="blank" href="{{route('orders-detail', $l_value['id'])}}" class="btn btn-success btn-sm">
                                    <i class="ri ri-eye-line" aria-hidden="true"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6 action mt-2">
                </div>
                <div class="col-md-6 mt-2">
                    @if(!empty($paginate))
                        {!! $data->appends(['order' => Request::get('order'), 'by'=>Request::get('by')])->links('vendor.pagination.bootstrap-4') !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection