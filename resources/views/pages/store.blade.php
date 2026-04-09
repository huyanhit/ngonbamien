@extends('layouts.app')
@section('content')
    <!-- Hero Section End -->
    <x-breadcrumb name="yeu-thich" title="Cửa hàng"></x-breadcrumb>
    <!-- Hero Section Begin -->
    <section class="spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <form class="sidebar" method="get" action="http://ngonbamien.local/bai-viet">
                        <div class="hero__categories">
                            <div class="hero__categories__all">
                                <i class="fa fa-bars"></i>
                                <span>Vị trí cửa hàng </span>
                            </div>
                            <ul>
                                @foreach ($producers as $item)
                                <li>
                                    <a href="{{Request::root()}}/vung-mien/{{$item->slug}}" class="inline-block avatar">
                                        @if(isset($item->image->uri))
                                            <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}"
                                            style="width: 20px"
                                            alt="{{$item->title}}"
                                            title="#caption-{{$item->image_id}}">
                                        @endif
                                        <span class="ml-2">{{$item->title}}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sidebar__item mt-3">
                            <h4>Chuyên bán</h4>
                            <div class="sidebar__item__size">
                                @php
                                    $badge = ["bg-light text-body border","bg-primary","bg-secondary","bg-info","bg-warning","bg-danger","bg-dark","bg-success"]
                                @endphp
                                @foreach ($product_categories as $key => $item)
                                    <button class="btn {{$badge[$key]}} my-1 text-white" name="loai" value="bai-moi" type="submit">
                                        {{ $item->title }}
                                    </button>
                                 @endforeach
                            </div>
                        </div>
                        <div class="sidebar__item mt-3">
                            <h4>Sắp xếp</h4>
                            <div class="sidebar__item__size">
                                <button class="btn btn-outline-dark my-1 " name="loai" value="bai-moi" type="submit">
                                    Lượt theo dõi
                                </button>
                                <button class="btn btn-outline-dark my-1 " name="loai" value="che-bien" type="submit">
                                    Lượt bán
                                </button>
                                <button class="btn btn-outline-dark my-1 " name="loai" value="du-lich" type="submit">
                                    Đánh giá
                                </button>
                                <button class="btn btn-outline-dark my-1  " name="loai" value="review" type="submit">
                                    Vị trí
                                </button>
                                <button class="btn btn-outline-dark my-1 " name="loai" value="video" type="submit">
                                    Hổ trợ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-9">
                    <x-hero-search :sites="$sites"/>
                    @foreach ($suppliers as $item)
                    <div class="row bg-light p-2 mb-3 border m-0">
                        <div class="col-lg-4 col-sm-12">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded bg-transparent text-success fs-24 p-2 border">
                                                                                        <img src="http://ngonbamien.local/admin/get-image/86" alt="Ngon Ba Miền" onerror="this.src='/images/no-image.png'" style="max-width: 50px">
                                                                                    </div>
                                </div>
                                <div class="flex-grow-1 ml-3">
                                    <div class="shop">
                                        <div class="shop-name font-weight-bold">Ngon Ba Miền</div>
                                        <div class="online small">Online 23 phút trước</div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <button type="button" class="btn btn-outline-secondary waves-effect waves-light mr-2 btn-sm shop_chat" data-value="1">
                                            <i class="ri-file-copy-2-fill"></i>Chat ngay
                                        </button>
                                        <a href="http://ngonbamien.local/san-pham/ngon-ba-mien" class="btn btn-outline-success waves-effect waves-light btn-sm">
                                                <i class="ri-file-copy-2-fill"></i>
                                            Xem shop
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 small">
                                    <div>
                                        <span class="text-muted">Sản phẩm:</span>
                                        <span class="text-body">50 mặt hàng</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Đã bán:</span>
                                        <span class="text-body">50 đơn hàng</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Đánh giá:</span>
                                        <span class="text-body">4.5 <i class="fa fa-star text-warning"></i> - 123k</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Lượt theo dõi:</span>
                                        <span class="text-body">123k</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Địa chỉ:</span>
                                        <span class="text-body">An phú - Gia lai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-12">
                            <div class="text-end">
                                <h6 class="text-muted small font-weight-bold">Hổ trợ từ Shop</h6>
                                <div class="mb-2">
                                    <span class="badge badge border border-info text-info">
                                    # Miễn phí ship nội thành pleiku</span>
                                    <span class="badge badge border border-info text-info">
                                    # Miễn phí ship đơn từ 200k</span>
                                    <span class="badge badge border border-success text-success">
                                    # Giảm 50k cho đơn từ 1000k</span>
                                    <span class="badge badge border border-info text-info">
                                    # Hổ trợ trả hàng miễn phí ship</span>
                                </div>
                            </div>
                        </div>
                        <div class="my-2 row" style="display: none">
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                            <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                                <span class="badge badge-dark text-white">Huong Nui</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                                                                                                                            <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ 100k">Freeship</span>
                                                                                                                </span>
                                        </div>
                                                <a href="http://ngonbamien.local/san-pham/sed-cupiditate-quis">
                                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Sed cupiditate quis.">
                                                    </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="260" option-value="519"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="260"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="260" option-value="519">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Sed cupiditate quis.</h5>
                                        <p class="text-muted description">Ullam voluptate ut at quo delectus dolores. Ipsam odit nihil ratione consequatur adipisci omnis.</p>
                                        <h6 class="text-danger">
                                                                                <div class="">
                                                        <b class="text-danger price">672.000đ</b>
                                                        <span class="text-muted price_root text-decoration-line-through">840.000đ</span>
                                                    </div>
                                                    <div class="mx-1 badge badge-dark price-title" title="Iure quo."> Iure quo. </div>
                                                                    </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                            <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                                <span class="badge badge-dark text-white">Huong Nui</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                                                                                                                            <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ 100k">Freeship</span>
                                                                                                                </span>
                                        </div>
                                                <a href="http://ngonbamien.local/san-pham/sed-cupiditate-quis">
                                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Sed cupiditate quis.">
                                                    </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="260" option-value="519"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="260"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="260" option-value="519">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Sed cupiditate quis.</h5>
                                        <p class="text-muted description">Ullam voluptate ut at quo delectus dolores. Ipsam odit nihil ratione consequatur adipisci omnis.</p>
                                        <h6 class="text-danger">
                                                                                <div class="">
                                                        <b class="text-danger price">672.000đ</b>
                                                        <span class="text-muted price_root text-decoration-line-through">840.000đ</span>
                                                    </div>
                                                    <div class="mx-1 badge badge-dark price-title" title="Iure quo."> Iure quo. </div>
                                                                    </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                            <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                                <span class="badge badge-dark text-white">Huong Nui</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                                                                                                                            <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ 100k">Freeship</span>
                                                                                                                </span>
                                        </div>
                                                <a href="http://ngonbamien.local/san-pham/sed-cupiditate-quis">
                                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Sed cupiditate quis.">
                                                    </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="260" option-value="519"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="260"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="260" option-value="519">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Sed cupiditate quis.</h5>
                                        <p class="text-muted description">Ullam voluptate ut at quo delectus dolores. Ipsam odit nihil ratione consequatur adipisci omnis.</p>
                                        <h6 class="text-danger">
                                                                                <div class="">
                                                        <b class="text-danger price">672.000đ</b>
                                                        <span class="text-muted price_root text-decoration-line-through">840.000đ</span>
                                                    </div>
                                                    <div class="mx-1 badge badge-dark price-title" title="Iure quo."> Iure quo. </div>
                                                                    </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                            <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                                <span class="badge badge-dark text-white">Huong Nui</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                                                                                                                            <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ 100k">Freeship</span>
                                                                                                                </span>
                                        </div>
                                                <a href="http://ngonbamien.local/san-pham/sed-cupiditate-quis">
                                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Sed cupiditate quis.">
                                                    </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="260" option-value="519"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="260"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="260" option-value="519">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Sed cupiditate quis.</h5>
                                        <p class="text-muted description">Ullam voluptate ut at quo delectus dolores. Ipsam odit nihil ratione consequatur adipisci omnis.</p>
                                        <h6 class="text-danger">
                                                                                <div class="">
                                                        <b class="text-danger price">672.000đ</b>
                                                        <span class="text-muted price_root text-decoration-line-through">840.000đ</span>
                                                    </div>
                                                    <div class="mx-1 badge badge-dark price-title" title="Iure quo."> Iure quo. </div>
                                                                    </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

