@extends('Admin::Layouts.admin')
@section('content')
    <div class="row mb-2 pb-1">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-16 mb-1">Chào, {{auth()->user()->name}}!</h4>
                    <p class="text-muted mb-0 fs-16" id="clock"></p>
                    <script>
                        function updateClock() {
                            const now   = new Date();
                            let year    = now.getFullYear();
                            let month   = now.getMonth() + 1;
                            let date    = now.getDate();
                            let hours   = now.getHours();
                            let minutes = now.getMinutes();
                            let seconds = now.getSeconds();

                            // Format the time with leading zeroes if needed
                            hours = hours < 10 ? "0" + hours : hours;
                            minutes = minutes < 10 ? "0" + minutes : minutes;
                            seconds = seconds < 10 ? "0" + seconds : seconds;

                            // Create the time string
                            const timeString = `${hours}:${minutes}:${seconds} - ${date}/${month}/${year} `;

                            // Update the HTML element with the current time
                            document.getElementById("clock").innerText = timeString;
                        }
                        // Call the function once to set the initial time
                        updateClock();
                        // Update the clock every second (1000 milliseconds)
                        setInterval(updateClock, 1000);
                    </script>
                </div>
                <div class="mt-3 mt-lg-0">
                    <form action="javascript:void(0);">
                        <div class="row g-3 mb-0 align-items-center">
                            <div class="col-sm-auto">
                                <button type="button" class="btn btn-primary waves-effect waves-light" disabled
                                    data-toggle="modal" data-target="#modal_code">
                                    <i class="ri-qr-code-line align-middle me-1"></i> Máy quét mã 
                                </button>
                                <div id="modal_code" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">Modal Heading</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="fs-15">
                                                    Overflowing text to show scroll behavior
                                                </h5>
                                                <p class="text-muted">One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.</p>
                                                <p class="text-muted">The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. "What's happened to me?" he thought.</p>
                                                <p class="text-muted">It wasn't a dream. His room, a proper human room although a little too small, lay peacefully between its four familiar walls.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary ">Save Changes</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                            <div class="col-sm-auto">
                                <button type="button" class="btn btn-secondary waves-effect" disabled>
                                    <i class="ri-add-circle-line align-middle me-1"></i> Tạo đơn hàng</button>
                            </div>
                            <!--end col-->
                            <div class="col-auto">
                                <a href="{{route('product.create')}}" type="button" class="btn btn-success waves-effect waves-light"><i class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm</a>
                            </div>
                                <!--end col-->
                            <div class="col-auto">
                                <a href="{{route('product.create')}}" type="button" class="btn btn-info waves-effect waves-light"><i class="ri-add-circle-line align-middle me-1"></i> Đăng bài viết</a>
                            </div>
                            <!--end col-->
                            <div class="col-auto">
                                <a href="{{route('product.create')}}" type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></a>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div><!-- end card header -->
        </div>
        <!--end col-->
    </div>
    <div class="row">
        <div class="col-xl-9">
            <div class="row">
                @foreach($data as $value)
                <div class="col-xl-4 col-md-6">
                    <a href="{{$value['link']}}" class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{$value['title']}} 
                                        <span class="text-danger"></span> </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-success fs-14 mb-0">
                                        {{$value['desc']}}
                                    </h5>
                                </div>
                            </div>
                            <div class="mt-2">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">{{$value['line_1'][0]}}</a></th>
                                            <td>{{$value['line_1'][1]}} </td>
                                            <td class="text-end"><b class="text-danger">{{$value['line_1'][2]}}</b> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">{{$value['line_2'][0]}}</a></th>
                                            <td>{{$value['line_2'][1]}} </td>
                                            <td class="text-end"><b class="text-danger">{{$value['line_2'][2]}}</b> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">{{$value['line_3'][0]}}</a></th>
                                            <td>{{$value['line_3'][1]}} </td>
                                            <td class="text-end"><b class="text-danger">{{$value['line_3'][2]}}</b> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">{{$value['line_4'][0]}}</a></th>
                                            <td>{{$value['line_4'][1]}} </td>
                                            <td class="text-end"><b class="text-danger">{{$value['line_4'][2]}}</b> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- end card body -->
                    </a>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header align-items-center d-flex py-2 text-uppercase fw-medium text-muted text-truncate mb-0">
                            <h4 class="card-title mb-0 flex-grow-1">Đơn hàng mới</h4>
                            <div class="flex-shrink-0">
                                <a href="{{route('order.index')}}" class="btn btn-soft-info btn-sm">
                                    <i class="ri-file-list-3-line align-middle"></i>
                                </a>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body pb-1">
                            <div class="table-responsive table-card"  style="height:233px; overflow-y: auto;">
                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col">Mã đơn</th>
                                            <th scope="col">Tên khách</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">Điện thoại</th>
                                            <th scope="col">Đơn giá</th>
                                            <th scope="col">Tình trạng</th>
                                            <th scope="col">Cập nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sOderNew as $item)
                                            <tr>
                                                <td>
                                                    <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">{{$item->code}}</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">{{$item->name}}</div>
                                                    </div>
                                                </td>
                                                <td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $item->address }}</td>
                                                <td>
                                                    <span class="text-success">{{$item->phone}}</span>
                                                </td>
                                                <td>{{$item->total}}</td>
                                                <td>
                                                    @if($item->order_status_id == 4)
                                                        <span class="badge bg-success-subtle text-success">Đã xác nhận</span>
                                                    @elseif($item->order_status_id == 5)
                                                        <span class="badge bg-info-subtle text-info">Đang đóng gói</span>
                                                    @elseif($item->order_status_id == 6)
                                                        <span class="badge bg-primary-subtle text-primary">Đang vận chuyển</span>
                                                    @endif
                                                </td>
                                                <th class="text-center">
                                                    <a href="{{route('order.edit', $item->id)}}" target="blank" class="badge bg-success-info text-info border">
                                                        cập nhật
                                                    </a>
                                                </th>
                                            </tr><!-- end tr -->
                                        @endforeach
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>
                        </div>
                    </div> <!-- .card-->
                </div>
                <div class="col-xl-4">
                    <div class="card">
                            <div class="card-header align-items-center d-flex py-2">
                                <h4 class="card-title mb-0 flex-grow-1 text-uppercase fw-medium text-muted text-truncate mb-0">Doanh số bán hàng</h4>
                                <div class="flex-shrink-0">
                                <a href="{{route('report.index')}}" class="btn btn-soft-info btn-sm">
                                    <i class="ri-file-list-3-line align-middle"></i>
                                </a>
                            </div>
                            </div><!-- end card header -->
                            <div class="card-body pb-1"  style="height: 253px;overflow-y: auto;">
                                <table class="w-100 table table-hover border">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Số đơn</th>
                                            <th class="text-end">Trị giá</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">Tuần</a></th>
                                            <th><b class="text-danger">{{$sell['week']['count']}}</b> </th>
                                            <th class="text-end"><b class="text-danger">{{$sell['week']['value']}}</b> </th>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">Tháng</a></th>
                                            <th><b class="text-danger">{{$sell['month']['count']}}</b> </th>
                                            <th class="text-end"><b class="text-danger">{{$sell['month']['value']}}</b></th>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">Quý</a></th>
                                            <th><b class="text-danger">{{$sell['quarter']['count']}}</b> </th>
                                            <th class="text-end"><b class="text-danger">{{$sell['quarter']['value']}}</b></th>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#" class="fw-semibold">Năm</a></th>
                                            <th><b class="text-danger">{{$sell['year']['count']}}</b> </th>
                                            <th class="text-end"><b class="text-danger">{{$sell['year']['value']}}</b></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Đánh giá mới</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            Hiển thị tất cả
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div data-simplebar="init" class="mx-n3 px-3 simplebar-scrollable-y" style="height: 375px;">
                        <div class="simplebar-wrapper" style="margin: 0px -16px;">
                            <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px 16px;">
                                            <div class="vstack gap-3">
                                                @foreach ($comments as $key => $item)
                                                     <div class="d-flex gap-3">
                                                        <img class="avatar-sm rounded flex-shrink-0" 
                                                                src="https://ui-avatars.com/api/?name={{$item->name}}" title="{{$item->name}}">
                                                        <div class="flex-shrink-1">
                                                            <h6 class="mb-2">
                                                                <a href="{{route('san-pham', $item->slug)}}" class="mt-1">#{{$item->title}} </a>
                                                                <span class="text-muted float-end">
                                                                    <span class="pt-2 mr-3 me-1">
                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            @if ($item->rating > $i)
                                                                            <i class="ri-star-fill text-warning"></i>
                                                                            @elseif($item->rating < $i && $item->rating > $i +1)
                                                                            <i class="ri-star-half-line text-warning"></i>
                                                                            @else
                                                                            <i class="ri-star-line text-warning"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </span>
                                                                    @if ($item->report)
                                                                        <span class="text-danger me-1 badge border border-danger">
                                                                            Đã báo cáo
                                                                        </span>
                                                                    @elseif ($item->replies->count())
                                                                        <span class="text-success me-1 badge  border border-info">
                                                                            Đã trả lời
                                                                        </span>
                                                                    @else
                                                                    <div class="dropdown float-end">
                                                                        <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                                            class="feather feather-more-vertical icon-sm"><circle cx="12" cy="12" r="1">
                                                                                </circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
                                                                            </svg>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-end">
                                                                            <a class="dropdown-item" data-toggle="modal" data-target="#modal_reply" 
                                                                                onclick="
                                                                                    document.getElementById('comment_id').value='{{$item->id}}'; 
                                                                                    document.getElementById('product_id').value='{{$item->product_id}}';
                                                                                    document.getElementById('content_reply').innerHTML='{{$item->content}}';
                                                                                ">
                                                                                <i class="ri-reply-line align-bottom text-muted me-2"></i> Trả lời</a>
                                                                            <a class="dropdown-item" data-toggle="modal" data-target="#modal_report" 
                                                                                onclick="
                                                                                    document.getElementById('report_comment_id').value='{{$item->id}}'; 
                                                                                    document.getElementById('content_report').innerHTML='{{$item->content}}';
                                                                                ">
                                                                                <i class="ri-error-warning-line align-bottom text-muted me-2"></i> Báo cáo</a>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </span>
                                                            </h6>
                                                            <p class="text-muted mb-0">" {{$item->content}} "</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 384px; height: 729px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 192px; transform: translate3d(0px, 183px, 0px); display: block;"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card" style="height: 184px;">
                <div class="card-body row p-3 border m-0">
                    <div class="col-xl-4 col-lg-6">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm">
                                <div class="avatar-title rounded bg-transparent text-success fs-24 p-2 border">
                                    <img src="http://ngonbamien.local/admin/get-image/86" alt="Ngon Ba Miền" onerror="this.src='/images/no-image.png'" style="max-width: 50px">
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="shop">
                                    <div class="shop-name text-bold mt-1 fs-18">{{$supplier->title}}</div>
                                    <div class="online text-success fs-12"><i class="ri-circle-fill me-2"></i>Đang hoạt động</div>
                                </div>
                                <div class="flex-grow-1 mt-2">
                                    <div class="mt-1">
                                        <span class="text-muted">Đánh giá:</span>
                                        <span class="text-body">4.5 <i class="ri-star-fill text-warning"></i> - 100k lượt</span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-muted">Lượt theo dõi:</span>
                                        <span class="text-body">123k <i class="ri-thumb-up-line text-info"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="{{route('chi-tiet-san-pham', $supplier->slug)}}" 
                                        class="btn btn-outline-success waves-effect waves-light btn-sm">
                                            <i class="ri-file-copy-2-fill"></i> Xem shop
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- end col -->
                    <div class="col-xl-4 col-lg-6">
                        <h6 class="text-body mt-2 ms-1">Thông tin Shop</h6>
                        <div class="d-flex align-items-center">
                            <ul class="flex-grow-1 list-group list-group-flush text-truncate">
                                <li class="list-group-item p-1"> 
                                    <span class="text-muted">Hoa hồng:</span>
                                    <span class="text-body">{{$supplier->commission}} %</span>
                                </li>
                                <li class="list-group-item p-1">
                                    <span class="text-muted">Hotline:</span>
                                    <span class="text-body text-nowrap">{{$supplier->phone}}</span>
                                </li>
                                <li class="list-group-item p-1 text-nowrap text-truncate"> 
                                    <span class="text-muted">Địa chỉ:</span>
                                    <span class="text-body text-nowrap">{{$supplier->address}}</span>
                                </li>
                                <li class="list-group-item p-1"> 
                                    <span class="text-muted">Mã số thuế:</span>
                                    <span class="text-body">{{$supplier->tax_code}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="mt-2">
                            <h6 class="text-body">Hổ trợ từ Shop</h6>
                            <div class="mb-2">
                                @php $supplier_support = $supplier->supplier_support @endphp
                                @foreach ($supplier_support as $sp)
                                    @switch($sp->support_id)
                                        @case(1)
                                            <span class="badge badge border border-info text-info">
                                                # Miễn phí ship đơn từ {{$sp->value_1/1000}}k</span>
                                            @break
                                        @case(2)
                                            <span class="badge badge border border-success text-success">
                                                # Giảm {{$sp->value_1/1000}}k cho đơn từ {{$sp->value_2/1000}}k
                                                </span>
                                            @break
                                        @default
                                    @endswitch
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                                <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-bar-chart icon-dual-primary"
                                    >
                                        <line x1="12" y1="20" x2="12" y2="10"></line>
                                        <line x1="18" y1="20" x2="18" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="16"></line>
                                    </svg>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <p class="mb-0 text-muted">Lượt truy cập</p>
                                <h5 class="fs-15">1 Đang xem  - Tổng {{$counter['total']}} lượt</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-center">
                            <div class="avatar-sm">
                                <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users icon-dual-success"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <p class="mb-0 text-muted">Bài viết</p>
                                <h5 class="fs-15">160 Bài viết</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-center">
                            <div class="avatar-sm">
                                <div class="avatar-title border bg-warning-subtle border-warning border-opacity-25 rounded-2 fs-17">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text icon-dual-warning"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <p class="mb-0 text-muted">Tin nhắn mới</p>
                                <h5 class="fs-15">2 khách hàng - 15 tin mới</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body d-flex gap-3 align-items-center"><div class="avatar-sm">
                                <div class="avatar-title border bg-danger-subtle border-danger border-opacity-25 rounded-2 fs-17">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart icon-dual-danger">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <p class="mb-0 text-muted">Lượt quan tâm, theo dõi sản phẩm</p>
                                <h5 class="fs-15">100 <i class="ri-heart-2-line text-danger"></i> - 1000k <i class="ri-thumb-up-line text-info"></i></h5> 
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <div id="modal_reply" class="modal fade" tabindex="10" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{route('reply-comment')}}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Hồi đáp khách hàng</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input id="comment_id" name="comment_id" type="hidden" value="0">
                        <input id="product_id" name="product_id" type="hidden" value="0">
                        <pre id="content_reply" class="fs-16"></pre>
                        <textarea class="form-control ckeditor_repply" id="ckeditor_repply" name="content" placeholder="Nội dung"></textarea>
                        <script>
                            CKEDITOR.replaceAll('ckeditor_repply', {filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}'});
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary " value="">Trả lời</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="modal_report" class="modal fade" tabindex="10" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{route('report-comment')}}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Báo cáo đánh giá</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input id="report_comment_id" name="comment_id" type="hidden" value="0">
                        <pre id="content_report" class="fs-16"></pre>
                        <textarea class="form-control ckeditor_repply" id="ckeditor_repply" name="content" placeholder="Nội dung"></textarea>
                        <script>
                            CKEDITOR.replaceAll('ckeditor_repply', {filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}'});
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary ">Báo cáo</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
