@extends('Admin::Layouts.admin')
@section('content')
    <script src="{{Request::root()}}/libs/apexcharts/apexcharts.js"></script>
     <div class="row">
        <div class="col-12">
             <div class="card">
                <form class="card-body d-flex" method="GET" action="{{Request::url()}}">
                    <h4 class="card-title mb-0 flex-grow-1 mt-2">Biểu đồ thống kê doanh số bán hàng <span class="text-danger">({{$report['time_query']}})</span></h4>
                    <div>
                        {{  
                            Form::select("report_query", [
                                "1"=>"Hiển thị theo tuần",
                                "2"=>"Hiển thị theo tháng",
                                "3"=>"Hiển thị theo năm",
                            ], $report['report_query'], 
                            array('class' => 'form-control', 'id'=>"report_query", 'onchange'=>"selectReport(this); this.form.submit()"))
                        }}
                    </div>
                    <div class="ms-2">
                        <select class="form-control" name="report_type_week" id="report_type_week" onchange="this.form.submit()" >
                            <option value=""> Chọn tuần </option>
                            @foreach ($data['weeks'] as $key => $item)
                                <option value="{{$key}}" 
                                    {{($key == $report['report_type_week'])? 'selected': ''}}
                                    title="{{$item['start']->format('d')}} - {{$item['end']->format('d')}}">
                                    Tuần {{$key}}
                                </option>
                            @endforeach
                        </select>
                        <select class="form-control" name="report_type_month" id="report_type_month" onchange="this.form.submit()">
                            <option value=""> Chọn tháng </option>
                            @foreach ($data['months'] as $key => $item)
                                <option value="{{$key}}" 
                                    {{($key == $report['report_type_month'])? 'selected': ''}}
                                    title="{{$item['start']->format('m')}} - {{$item['end']->format('m')}}">Tháng {{$key}}
                                </option>
                            @endforeach
                        </select>
                        <select class="form-control" name="report_type_year" id="report_type_year" onchange="this.form.submit()">
                            <option value=""> Chọn năm </option>
                            @foreach ($data['years'] as $item)
                                {{($item == $report['report_type_year'])? 'selected': ''}}
                                <option value="{{$item}}">Năm {{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <script>
                        selectReport(document.getElementById('report_query'));
                        function selectReport (e){
                            let report_type_week  = document.getElementById('report_type_week');
                            let report_type_month = document.getElementById('report_type_month');
                            let report_type_year  = document.getElementById('report_type_year');
                            if(e.value == 2){
                                report_type_week.style.display = 'none';
                                report_type_week.disabled = true;
                                report_type_month.style.display = 'block';
                                report_type_month.disabled = false;
                                report_type_year.style.display = 'none';
                                report_type_year.disabled = true;
                            }else if(e.value == 3){
                                report_type_week.style.display = 'none';
                                report_type_week.disabled = true;
                                report_type_month.style.display = 'none';
                                report_type_month.disabled = true;
                                report_type_year.style.display = 'block';
                                report_type_year.disabled = false;
                            }else{
                                report_type_week.style.display = 'block';
                                report_type_week.disabled = false;
                                report_type_month.style.display = 'none';
                                report_type_month.disabled = true;
                                report_type_year.style.display = 'none';
                                report_type_year.disabled = true;
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card card-height-100">
                <div class="card-body px-0">
                    <div id="chart-bill"></div>
                    <script>
                        var options = {
                            series: {!! $report['chart']['series'] !!},
                            chart: {
                                height: 450,
                                type: 'line',
                            },
                            stroke: {
                                width: [0, 2, 2],
                                curve: 'smooth'
                            },
                            dataLabels: {
                                enabled: true,
                                enabledOnSeries: [1]
                            },
                            labels: {!! $report['chart']['labels'] !!},
                            yaxis: [
                                {
                                    opposite: false,
                                    labels: {
                                        formatter: (value) => { 
                                            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value)
                                        },
                                    }
                                },
                                {
                                    show: false,
                                    opposite: true,
                                    labels: {
                                        formatter: (value) => { 
                                           return value +' đơn'
                                        },
                                    }
                                },
                                {
                                    opposite: true       ,
                                    labels: {
                                        formatter: (value) => { 
                                           return value +' đơn'
                                        },
                                    }
                                }
                            ]
                        };

                        var chart = new ApexCharts(document.querySelector("#chart-bill"), options);
                        chart.render();
                    </script>
                </div>
            </div><!-- end card -->
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Thống kê doanh thu 
                                <span class="text-danger">({{$report['time_query']}})</span> 
                            </p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Số đơn</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Phí 5%</th>
                                    <th class="text-center">Thực nhận</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Tổng số đơn</a></th>
                                    <td>{{$report['all_order']}}</td>
                                    <td>{{number_format($report['sum_order'], 0, ',', '.')}}đ</td>
                                    <th>{{number_format($report['sum_order']* 0.05, 0, ',', '.')}}đ</th>
                                    <th class="text-center"><b class="text-danger">{{number_format($report['sum_order']*0.95, 0, ',', '.')}}đ</b> </th>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Đơn đã chốt</a></th>
                                    <td>{{$report['all_order_done']}}</td>
                                    <td>{{number_format($report['sum_order_done'], 0, ',', '.')}}đ</td>
                                    <th>{{number_format($report['sum_order_done']* 0.05, 0, ',', '.')}}đ</th>
                                    <th class="text-center"><b class="text-danger">{{number_format($report['sum_order_done']*0.95, 0, ',', '.')}}đ</b> </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

             <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Thống kê khác <span class="text-danger">({{$report['time_query']}})</span> </p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <table class="w-100 table table-hover border">
                            <tbody class="small">
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Ngày bán nhiều đơn hàng nhất</a></th>
                                    <th><b class="text-danger">{{$report['report_order']['date_sell_est']['date']}}</b> </th>
                                    <td  class="text-end"> {{$report['report_order']['date_sell_est']['value']}} đơn</td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Ngày bán có doanh thu cao nhất</a></th>
                                    <th><b class="text-danger">{{$report['report_order']['date_bill_est']['date']}}</b></th>
                                    <td  class="text-end"> {{number_format($report['report_order']['date_bill_est']['value'], 0, ',', '.')}} đ</td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Hóa đơn giá trị lớn nhất</a></th>
                                    <th ><b class="text-danger">{{$report['report_order']['bill_est']['code']}}</b></th>
                                    <td  class="text-end"> {{number_format($report['report_order']['bill_est']['value'], 0, ',', '.')}} đ</td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Sản phẩm bán nhiều nhất</a></th>
                                    <th ><b class="text-danger">{{$report['report_order']['product_sell_est']['code']}}</b></th>
                                    <td  class="text-end"> {{number_format($report['report_order']['product_sell_est']['value'], 0, ',', '.')}} lượt</td>
                                </tr>
                                <tr>
                                    <th scope="row"><a href="#" class="fw-semibold">Khách hàng mua nhiều nhất</a></th>
                                    <th ><b class="text-danger">{{$report['report_order']['customer_buy_est']['name']}}</b> </th>
                                    <td class="text-end"> {{number_format($report['report_order']['customer_buy_est']['value'], 0, ',', '.')}} đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection