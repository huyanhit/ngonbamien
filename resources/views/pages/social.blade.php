@extends('layouts.app')
@section('content')
<section class="hero background">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="row bg-light p-2 mb-3 border m-0">
                    <div class="col-lg-12 col-sm-12">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm">
                                <div class="avatar-title rounded bg-transparent text-success fs-24 p-2 border">
                                    <img src="http://ngonbamien.local/admin/get-image/86" alt="Ngon Ba Miền" onerror="this.src='/images/no-image.png'" style="max-width: 50px">
                                </div>
                            </div>
                            <div class="flex-grow-1 ml-3">
                                <div class="shop">
                                    <div class="shop-name font-weight-bold">Ngon Ba Miền</div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle small text-success" type="button" data-toggle="dropdown">
                                            <i class="ri-circle-fill"></i> Online
                                        </a>
                                        <div class="dropdown-menu small">
                                            <a class="dropdown-item" href="#"><i class="ri-circle-fill text-success"></i> Online</a>
                                            <a class="dropdown-item" href="#"><i class="ri-circle-fill text-danger"></i> Offline</a>
                                            <a class="dropdown-item" href="#"><i class="ri-circle-fill text-warning"></i> Đang bận</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="small text-info badge border"><i class="ri-group-line"></i> 29 Bạn</span>
                        <span class="small text-info badge border"><i class="ri-heart-2-line"></i> 293 người theo dõi</span>
                    </div>
                </div>
                <h5 class="font-weight-bold mb-2 mt-3">Lọc bài viết</h5>
                <form class="sidebar border p-3" id="form-shop" method="get" action="http://ngonbamien.local/san-pham">
                    <div class="sidebar__item  my-2">
                        <h5 class="font-weight-bold">Theo nhóm</h5>
                        <div class="sidebar__item__size">
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-moi" type="submit">
                            Cá nhân
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-mua-nhieu" type="submit">
                            Cửa hàng
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="dang-khuyen-mai" type="submit">
                            Hỏi đáp
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-da-thich" type="submit">
                            Chia sẻ 
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-da-mua" type="submit">
                            Thảo luận
                            </button>
                        </div>
                    </div>
                    <div class="sidebar__item my-2">
                        <h5 class="font-weight-bold">Theo loại</h5>
                        <div class="sidebar__item__size">
                            <button class="btn btn-outline-dark my-1 " name="loai" value="mon-moi" type="submit">
                            Bài viết mới
                            </button>
                            <button class="btn btn-outline-dark my-1 " name="loai" value="mon-mua-nhieu" type="submit">
                            Được quan tâm
                            </button>
                            <button class="btn btn-outline-dark my-1 " name="loai" value="dang-khuyen-mai" type="submit">
                            Nhiều lượt chia sẻ
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-3 ">
                    <h5 class="font-weight-bold mb-2">Hội nhóm</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Đồng hương Gia Lai</li>
                        <li class="list-group-item">Thích du lịch</li>
                        <li class="list-group-item">Chị Em 18+</li>
                        <li class="list-group-item">Mê Game</li>
                    </ul>
                </div>

                <div class="mt-3 ">
                    <h5 class="font-weight-bold mb-2">Video ngắn</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Móm ăn</li>
                        <li class="list-group-item">Du lịch</li>
                        <li class="list-group-item">Gái xinh 18+</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="alert alert-success alert-dismissible alert-label-icon rounded-label fade show d-flex" role="alert">
                    <i class="ri-check-double-line label-icon p-2"></i>
                    <input type="text" class="form-control" placeholder="Bạn đang nghĩ gì?"/>
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <h4 class="card-title mb-2">What planning process needs ?</h4>
                        <h6 class="card-subtitle font-14 text-muted">Development</h6>
                    </div>
                    <img class="img-fluid" src="/storage/thumb_ngonbamien/ca-phe-dac-san-gia-lai-mon-qua-tu-dat-do-bazan-tay-nguyen-ehvi0-5.jpg" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Objectively pursue diverse catalysts for change for interoperable meta-services. Distinctively re-engineer revolutionary meta-services.</p>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0);" class="card-link link-secondary">Read More <i class="ri-arrow-right-s-line ms-1 align-middle lh-1"></i></a>
                        <a href="javascript:void(0);" class="card-link link-success">Bookmark <i class="ri-bookmark-line align-middle ms-1 lh-1"></i></a>
                    </div>
                </div>

                <div class="card card-overlay my-3">
                    <img class="card-img img-fluid" src="/storage/thumb_ngonbamien/ca-phe-dac-san-gia-lai-mon-qua-tu-dat-do-bazan-tay-nguyen-ehvi0-5.jpg" alt="Card image">
                    
                    <div class="card-img-overlay p-0">
                        <div class="card-header bg-transparent">
                            <h4 class="card-title text-white mb-0">Design your apps in your own way</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-white mb-2">Each design is a new, unique piece of art birthed into this world, and while you have the opportunity to be creative and make your unpleasant for the reader. </p>
                            <p class="card-text">
                                <small class="text-white">Last updated 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card my-3">
                    <img class="card-img-top img-fluid" src="/storage/thumb_ngonbamien/ca-phe-dac-san-gia-lai-mon-qua-tu-dat-do-bazan-tay-nguyen-ehvi0-5.jpg" alt="Card image cap">
                    <div class="card-header">
                        <h4 class="card-title mb-0">A day in the of a professional fashion designer</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted"> Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee.</p>
                    </div>
                    <div class="card-footer">
                        <p class="card-text mb-0">
                            Last updated 3 mins ago
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <h5 class="mb-2 font-weight-bold">Bài đăng mới</h5>
                <div class="blog__item">
                    <a class="blog__item__pic" href="http://ngonbamien.local/noi-dung/ca-phe-sach-su-lua-chon-hoan-hao-danh-cho-ban">
                        <img src="/storage/ngonbamien/ca-phe-dac-san-gia-lai-mon-qua-tu-dat-do-bazan-tay-nguyen-ehvi0-4.jpg" alt="Cà phê sạch - Sự lựa chọn hoàn hảo dành cho bạn">
                    </a>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-comment"></i> 16 </li>
                            <li><i class="fa fa-calendar-o"></i> 4 ngày trước </li>
                        </ul>
                        <h5><a href="http://ngonbamien.local/noi-dung/ca-phe-sach-su-lua-chon-hoan-hao-danh-cho-ban">
                                Cà phê sạch - Sự lựa chọn hoàn hảo dành cho bạn</a>
                        </h5>
                        <p>Ở thị trường cà phê hiện nay, cà phê sạch đang là một khái niệm mà dường như tất cả các chuỗi, cửa hàng, công ty cà phê đều hướng đến. Tuy nhiên, chưa phải thương hiệu nào cũng thành công bởi nhiều lý do khác nhau. Với mảnh đất Gia Lai, nơi có hương vị cà phê không thua kém bất kỳ đâu, hàng trăm&nbsp;thương hiệu cà phê sạch&nbsp;đã xuất hiện và chỉ có số ít còn trụ lại, tiếp tục phát triển, trong đó có Classic Coffee. Vậy điều gì đã làm nên một thương hiệu cà phê sạch mạnh mẽ đến vậy?</p>
                    </div>
                </div>

                <h5 class="mb-2 font-weight-bold">Có thể bạn quan tâm</h5>
                <div class="blog__item">
                    <a class="blog__item__pic" href="http://ngonbamien.local/noi-dung/ca-phe-sach-su-lua-chon-hoan-hao-danh-cho-ban">
                        <img src="/storage/ngonbamien/ca-phe-dac-san-gia-lai-mon-qua-tu-dat-do-bazan-tay-nguyen-ehvi0-4.jpg" alt="Cà phê sạch - Sự lựa chọn hoàn hảo dành cho bạn">
                    </a>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-comment"></i> 16 </li>
                            <li><i class="fa fa-calendar-o"></i> 4 ngày trước </li>
                        </ul>
                        <h5><a href="http://ngonbamien.local/noi-dung/ca-phe-sach-su-lua-chon-hoan-hao-danh-cho-ban">
                                Cà phê sạch - Sự lựa chọn hoàn hảo dành cho bạn</a>
                        </h5>
                        <p>Ở thị trường cà phê hiện nay, cà phê sạch đang là một khái niệm mà dường như tất cả các chuỗi, cửa hàng, công ty cà phê đều hướng đến. Tuy nhiên, chưa phải thương hiệu nào cũng thành công bởi nhiều lý do khác nhau. Với mảnh đất Gia Lai, nơi có hương vị cà phê không thua kém bất kỳ đâu, hàng trăm&nbsp;thương hiệu cà phê sạch&nbsp;đã xuất hiện và chỉ có số ít còn trụ lại, tiếp tục phát triển, trong đó có Classic Coffee. Vậy điều gì đã làm nên một thương hiệu cà phê sạch mạnh mẽ đến vậy?</p>
                    </div>
                </div>

                <h5 class="mb-2 font-weight-bold">Tin nhắn</h5>
                <div class="chat-message-list">
                    <ul class="list-unstyled small">
                        <li id="contact-id-1" data-name="direct-message" class="active">
                            <a href="javascript: void(0);">
                                <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                    <div class="avatar-xxs">                        <img src="assets/images/users/avatar-2.jpg" class="rounded-circle img-fluid userprofile" alt=""><span class="user-status"></span>                        </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-truncate mb-0">Lisa Parker</p>
                                </div>
                                </div>
                            </a>
                        </li>
                        <li id="contact-id-2" data-name="direct-message" class="">
                            <a href="javascript: void(0);" class="unread-msg-user">
                                <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                    <div class="avatar-xxs">                        <img src="assets/images/users/avatar-3.jpg" class="rounded-circle img-fluid userprofile" alt=""><span class="user-status"></span>                        </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-truncate mb-0">Frank Thomas</p>
                                </div>
                                <div class="ms-auto"><span class="badge bg-dark-subtle text-body rounded p-1">8</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection