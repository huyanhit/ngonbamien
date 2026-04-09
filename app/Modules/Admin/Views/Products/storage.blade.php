@extends('Admin::Layouts.admin')
@section('content')
    <div class="row">
        <a class="col-xl-3 col-md-6" href="{{Request::url()}}">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Tồn Kho</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                {{number_format($report['product_sum_pr'], 0, ',', '.') }}đ
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                <span class="counter-value">{{number_format($report['product_total'])}} Mặt hàng 
                                    @if( $report['supplier_count']) - {{$report['supplier_count']}} Đối tác @endif
                            </h4>
                            <span>{{number_format($report['product_sum_st'])}}</span> Sản phẩm</span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx ri-product-hunt-line text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </a><!-- end col -->

        <a class="col-xl-3 col-md-6" href="{{Request::url()}}?storage_query=4&storage_number=10">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Sắp hết hàng</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-danger fs-14 mb-0">
                                Dưới 10 sản phẩm
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value">{{$report['product_stock']}} Mặc hàng</span></h4>
                            <span >{{$report['sum_product_stock']}} Sản phẩm</span></span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                <i class="bx ri-checkbox-blank-line text-info"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </a><!-- end col -->

        <a class="col-xl-3 col-md-6" href="{{Request::url()}}?storage_query=3&storage_number=10">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Sắp quá hạn</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                Sau 10 ngày
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value">{{$report['product_ex']}} Mặc hàng</span> </h4>
                            <span >{{$report['sum_product_ex']}} Sản phẩm</span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="ri-calendar-line text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </a><!-- end col -->

        <a class="col-xl-3 col-md-6" href="{{Request::url()}}?storage_query=2&picker_from={{date('Y-m-').'01'}}&picker_to={{date('Y-m-d')}}">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đã xuất kho</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0">
                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i> 
                                    {{number_format($report['product_export_week'])}} Sản phẩm (Tuần)
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value">
                                {{number_format($report['product_export_month'])}} Sản phẩm (Tháng)</h4>
                            </span> 
                            <span>{{number_format($report['product_export_year'])}} Sản phẩm (Năm)</span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                <i class="ri-account-box-line text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </a><!-- end col -->
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{Request::url().$url_sort}}" method="get">
                <div class="row row-cols-lg-auto align-items-center">
                    <div class="col-12">
                        <label>Chọn lệnh truy vấn</label>
                            {{Form::select("storage_query", [
                                "Truy vấn kho",
                                "1"=>"Lấy các sản phẩm nhập kho",
                                "2"=>"Lấy các sản phẩm xuất kho",
                                "3"=>"Lấy các sản phẩm sắp quá hạn sau N ngày",
                                "4"=>"Lấy các sản phẩm sắp hết hàng dưới N sản phẩm",
                                "5"=>"Lấy các sản phẩm đang giảm giá",
                                "6"=>"Lấy các sản phẩm chưa niêm yết giá"
                            ], $query['storage_report'], 
                            array('class' => 'form-control', 'id'=>"storage_query", 'onchange'=>"selectStorage(this)"))}}
                    </div><!--end col-->
                    <div class="col-12" id="storage_picker_from" style="display: none">
                        <label>Từ Ngày</label>
                        {{Form::input('text', 'picker_from', $query['picker_from']??'', array('class' => 'form-control', 'id'=>"datetimepicker_from", 'autocomplete'=>"off"))}}
                        <script>
                            $('#datetimepicker_from').datepicker({
                                setDate: new Date(),
                                dateFormat: "dd/mm/yy"
                            });
                        </script>
                    </div><!--end col-->
                    <div class="col-12" id="storage_picker_to" style="display: none">
                        <label>Đến ngày</label>
                        {{Form::input('text', 'picker_to', $query['picker_to']??'',  array('class' => 'form-control',  'id'=>"datetimepicker_to", 'autocomplete'=>"off"))}}
                        <script>
                            $('#datetimepicker_to').datepicker({
                                setDate: new Date(),
                                dateFormat: "dd/mm/yy"
                            });
                        </script>
                    </div>
                    <div class="col-12" id="storage_number" style="display: none">
                        <label>Số N</label>
                        {{Form::input('text', 'storage_number', $query['storage_number']??'10',  array('class' => 'form-control',  'id'=>"storage_number_input", 'autocomplete'=>"off"))}}
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-4" id="storage_submit" >Truy vấn</button>
                        <button type="submit" class="btn btn-info mt-4" name="export_excel" value="1">Xuất Excel</button>
                    </div>
                </div>
            </form>
            <script>
                selectStorage(document.getElementById('storage_query'));
                function selectStorage (e){
                    let picker = ['1','2'];
                    let num    = ['3','4'];
                    let storage_picker_from = document.getElementById('storage_picker_from');
                    let storage_picker_to = document.getElementById('storage_picker_to');
                    let storage_number = document.getElementById('storage_number');
                    let storage_picker_from_input = document.getElementById('datetimepicker_from');
                    let storage_picker_to_input = document.getElementById('datetimepicker_to');
                    let storage_number_input = document.getElementById('storage_number_input');

                    if(picker.includes(e.value)){
                        storage_picker_from.style.display = 'block';
                        storage_picker_from_input.disabled = false;
                        storage_picker_to.style.display = 'block';
                        storage_picker_to_input.disabled = false;
                        storage_number.style.display = 'none';
                        storage_number_input.disabled = true;
                    }else if(num.includes(e.value)){
                        storage_picker_from.style.display = 'none';
                        storage_picker_from_input.disabled = true;
                        storage_picker_to.style.display = 'none';
                        storage_picker_to_input.disabled = true;
                        storage_number.style.display = 'block';
                        storage_number_input.disabled = false;
                    }else{
                        storage_picker_from.style.display = 'none';
                        storage_picker_from_input.disabled = true;
                        storage_picker_to.style.display = 'none';
                        storage_picker_to_input.disabled = true;
                        storage_number.style.display = 'none';
                        storage_number_input.disabled = true;
                    }
                }
            </script>
        </div><!--end col-->
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
                                        @case('date')
                                            <td class="text-left">
                                                @if(empty($val['update']) )
                                                    <span class="p-2">{!! \Carbon\Carbon::parse($l_value[$key])->format('d/m/Y') !!}</span>
                                                @else
                                                    <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                        <span class="p-2">{!! \Carbon\Carbon::parse($l_value[$key])->format('d/m/Y') !!}</span>
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
                            <a title="Xem" target="blank" href="{{route('san-pham', $l_value['slug'])}}" class="btn btn-success btn-sm">
                                <i class="ri ri-eye-line" aria-hidden="true"></i>
                            </a>
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