@extends('layouts.store')
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
                                    <div class="online small">Online 23 phút trước</div>
                                </div>
                            </div>
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
                    <div class="col-lg-12 col-sm-12 mt-3">
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
                    <div class="col-lg-12 col-sm-12 mt-3">
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
                </div>
               
                <form class="sidebar border p-3" id="form-shop" method="get" action="http://ngonbamien.local/san-pham">
                    <h4 class="text-center font-weight-bold text-uppercase">Lọc theo</h4>
                    <div class="sidebar__item my-3">
                        <h4>Giá bán</h4>
                        <select class="form-select w-100 mb-3" name="gia" onchange="this.form.submit()" style="display: none;">
                            <option value=""> Chọn mức giá </option>
                            <option value="duoi-100k"> Dưới 100.000đ </option>
                            <option value="100k-200k"> 100.000đ đến 200.000đ </option>
                            <option value="200k-500k"> 200.000đ đến 500.000đ </option>
                            <option value="tren-500k"> Trên 500.000đ </option>
                            <option value="lien-he"> Liên hệ </option>
                        </select>
                        <div class="nice-select form-select w-100 mb-3" tabindex="0">
                            <span class="current"> Chọn mức giá </span>
                            <ul class="list">
                                <li data-value="" class="option selected"> Chọn mức giá </li>
                                <li data-value="duoi-100k" class="option"> Dưới 100.000đ </li>
                                <li data-value="100k-200k" class="option"> 100.000đ đến 200.000đ </li>
                                <li data-value="200k-500k" class="option"> 200.000đ đến 500.000đ </li>
                                <li data-value="tren-500k" class="option"> Trên 500.000đ </li>
                                <li data-value="lien-he" class="option"> Liên hệ </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar__item my-3">
                        <h4>Loại sản phẩm</h4>
                        <div class="sidebar__item__size">
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-moi" type="submit">
                            Đặc sản
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-mua-nhieu" type="submit">
                            Món ngon
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="dang-khuyen-mai" type="submit">
                            Cà Phê
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-da-thich" type="submit">
                            Quả tặng
                            </button>
                            <button class="btn btn-outline-dark my-1" name="loai" value="mon-da-mua" type="submit">
                            Mắm
                            </button>
                        </div>
                    </div>
                    <div class="sidebar__item">
                        <h4>Danh mục</h4>
                        <div class="sidebar__item__size">
                            <button class="btn btn-outline-dark my-1 " name="loai" value="mon-moi" type="submit">
                            Món mới
                            </button>
                            <button class="btn btn-outline-dark my-1 " name="loai" value="mon-mua-nhieu" type="submit">
                            Món mua nhiều
                            </button>
                            <button class="btn btn-outline-dark my-1 " name="loai" value="dang-khuyen-mai" type="submit">
                            Đang khuyến mãi
                            </button>
                            <button class="btn btn-outline-dark my-1  " name="loai" value="mon-da-thich" type="submit">
                            Món đã thích
                            </button>
                            <button class="btn btn-outline-dark my-1 " name="loai" value="mon-da-mua" type="submit">
                            Món đã mua
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-9">
                <div class="tab-content p-3 border" id="myTabContent">
                    <div class="tab-pane fade show active" id="home">
                        <x-hero-search :sites="$sites"/>
                        <div class="product__discount">
                            <div class="product__discount__slider owl-carousel">
                                @foreach ($discount_products as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <x-product-item-promotion :item="$item"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3" style="padding: 0 5px">
                            <div class="flex-fill">
                                <div class="filter__sort">
                                    <span>Sắp xếp</span>
                                    <select style="display: none;">
                                        <option value="1">Theo giá</option>
                                        <option value="2">Theo tên</option>
                                    </select>
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">Theo giá</span>
                                        <ul class="list">
                                            <li data-value="1" class="option selected">Theo giá</li>
                                            <li data-value="2" class="option">Theo tên</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="filter__found">
                                    <h6><span>2000</span> Sản phẩm </h6>
                                </div>
                            </div>
                            <div class="flex-fill">
                                <div class="filter__option">
                                    <span class="icon_ul filter__option_ul"></span>
                                    <span class="icon_grid-2x2 filter__option_grid active"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row filter__list product__discount">
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/dolorem-consequatur">
                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Dolorem consequatur.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="419" option-value="837"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="419"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="419" option-value="837">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Dolorem consequatur.</h5>
                                        <p class="text-muted description">Natus rerum animi eligendi et quia est. Nostrum molestiae sapiente aut quia minus saepe.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">604.800đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">756.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Quis."> Quis. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/qui-quod-similique">
                                        <img src="/storage/thumb_ngonbamien/img-3.png" alt="Qui quod similique.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="976" option-value="1951"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="976"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="976" option-value="1951">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Qui quod similique.</h5>
                                        <p class="text-muted description">Sit vitae est consequuntur. Quia et voluptatem minus optio. Autem unde aut ad.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">57.600đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">72.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Enim quas."> Enim quas. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/quia-totam-suscipit">
                                        <img src="/storage/thumb_ngonbamien/img-6.png" alt="Quia totam suscipit.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="6" option-value="12"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="6"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="6" option-value="12">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Quia totam suscipit.</h5>
                                        <p class="text-muted description">Occaecati mollitia quas omnis et sint est ratione. Libero sed et ut autem omnis fugiat voluptas.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">345.800đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">494.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Et."> Et. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Ngon Ba Miền</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ 200k">Freeship</span>
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 50k cho đơn từ 1000k">Giam 50k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/iusto-voluptates">
                                        <img src="/storage/thumb_ngonbamien/img-5.png" alt="Iusto voluptates.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="847" option-value="1694"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="847"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="847" option-value="1694">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Iusto voluptates.</h5>
                                        <p class="text-muted description">Ut repudiandae quia eaque. Corrupti et autem non. Fuga quae ullam placeat alias ut rerum.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">58.500đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">65.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Inventore."> Inventore. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Monkey</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 10k cho đơn từ 1000k">Giam 10k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/consectetur-quae">
                                        <img src="/storage/thumb_ngonbamien/img-10.png" alt="Consectetur quae.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="34" option-value="67"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="34"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="34" option-value="67">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Consectetur quae.</h5>
                                        <p class="text-muted description">Vel atque numquam inventore unde laboriosam aut. Maiores accusantium sint consectetur.</p>
                                        <h6 class="text-danger">
                                            <div><b class="text-danger price">672.000đ</b> </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Qui vel."> Qui vel. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/placeat-quo-natus">
                                        <img src="/storage/thumb_ngonbamien/img-3.png" alt="Placeat quo natus.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="148" option-value="295"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="148"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="148" option-value="295">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Placeat quo natus.</h5>
                                        <p class="text-muted description">Repudiandae autem perspiciatis id modi error ut. In alias ea commodi autem at et.</p>
                                        <h6 class="text-danger">
                                            <div><b class="text-danger price">72.000đ</b> </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Et velit."> Et velit. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Monkey</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 10k cho đơn từ 1000k">Giam 10k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/nisi-quas-dolore">
                                        <img src="/storage/thumb_ngonbamien/img-10.png" alt="Nisi quas dolore.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="219" option-value="437"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="219"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="219" option-value="437">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Nisi quas dolore.</h5>
                                        <p class="text-muted description">Cumque aut laudantium fuga quisquam. Libero magni fugit doloremque aut autem est.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">596.400đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">852.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Qui."> Qui. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/perspiciatis-et">
                                        <img src="/storage/thumb_ngonbamien/img-2-1.png" alt="Perspiciatis et.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="916" option-value="1832"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="916"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="916" option-value="1832">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Perspiciatis et.</h5>
                                        <p class="text-muted description">Ut quae aut sed labore. Fugit est sint sit nobis provident quos similique.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">436.800đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">624.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Vel."> Vel. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/quam-accusantium-at">
                                        <img src="/storage/thumb_ngonbamien/img-10.png" alt="Quam accusantium at.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="21" option-value="41"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="21"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="21" option-value="41">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Quam accusantium at.</h5>
                                        <p class="text-muted description">Quae reprehenderit omnis est. Et voluptatibus corrupti doloremque consectetur eos.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">576.000đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">720.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Iusto."> Iusto. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Ngon Ba Miền</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ 200k">Freeship</span>
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 50k cho đơn từ 1000k">Giam 50k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/illo-neque-ut-esse">
                                        <img src="/storage/thumb_ngonbamien/img-7.png" alt="Illo neque ut esse.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="689" option-value="1377"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="689"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="689" option-value="1377">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Illo neque ut esse.</h5>
                                        <p class="text-muted description">Repudiandae sequi ipsa velit et quia voluptas aut. Iste vero est eveniet consequatur unde.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">594.000đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">660.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Non."> Non. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Monkey</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 10k cho đơn từ 1000k">Giam 10k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/voluptas-repellat">
                                        <img src="/storage/thumb_ngonbamien/img-2-1.png" alt="Voluptas repellat.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="262" option-value="524"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="262"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="262" option-value="524">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Voluptas repellat.</h5>
                                        <p class="text-muted description">Ab accusamus deserunt ab qui aspernatur blanditiis. Id quo corrupti commodi nesciunt amet earum.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">254.800đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">364.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Rerum a."> Rerum a. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/deleniti">
                                        <img src="/storage/thumb_ngonbamien/img-2-1.png" alt="Deleniti.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="795" option-value="1589"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="795"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="795" option-value="1589">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Deleniti.</h5>
                                        <p class="text-muted description">Numquam eveniet accusamus illum non. Ut et aspernatur nihil illum voluptas.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">345.600đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">432.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Culpa."> Culpa. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Monkey</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 10k cho đơn từ 1000k">Giam 10k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/consectetur">
                                        <img src="/storage/thumb_ngonbamien/img-1.png" alt="Consectetur.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="873" option-value="1746"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="873"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="873" option-value="1746">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Consectetur.</h5>
                                        <p class="text-muted description">Unde molestiae similique odio ducimus. Voluptas dolor vero earum cupiditate voluptas fuga facilis.</p>
                                        <h6 class="text-danger">
                                            <div><b class="text-danger price">923.000đ</b> </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Excepturi."> Excepturi. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/minus-molestiae">
                                        <img src="/storage/thumb_ngonbamien/img-1.png" alt="Minus molestiae.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="965" option-value="1929"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="965"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="965" option-value="1929">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Minus molestiae.</h5>
                                        <p class="text-muted description">Voluptas velit reprehenderit eos sed ut aperiam. Aut quae vel enim id.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">720.000đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">900.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Maxime."> Maxime. </div>
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
                                        <a href="http://ngonbamien.local/san-pham/tempora-vel-et">
                                        <img src="/storage/thumb_ngonbamien/img-5.png" alt="Tempora vel et.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="615" option-value="1230"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="615"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="615" option-value="1230">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Tempora vel et.</h5>
                                        <p class="text-muted description">Dignissimos sit et veniam commodi cumque. Tempora quae commodi velit ex commodi.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">156.000đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">195.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Ut est."> Ut est. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <div class="w-100 position-absolute">
                                            <span class="pull-left p-1 text-left" style="width: 40%">
                                            <span class="badge badge-dark text-white">Monkey</span>
                                            </span>
                                            <span class="pull-right text-right p-1" style="width: 60%">
                                            <span class="badge badge-label bg-success text-white small" title="Giảm 10k cho đơn từ 1000k">Giam 10k</span>
                                            </span>
                                        </div>
                                        <a href="http://ngonbamien.local/san-pham/doloribus-sapiente">
                                        <img src="/storage/thumb_ngonbamien/img-1.png" alt="Doloribus sapiente.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="272" option-value="544"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="272"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="272" option-value="544">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Doloribus sapiente.</h5>
                                        <p class="text-muted description">Debitis atque aut voluptate beatae quidem dolorum deserunt. Aut incidunt molestias molestias earum.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">596.700đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">663.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Enim."> Enim. </div>
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
                                        <a href="http://ngonbamien.local/san-pham/maxime-quo-et">
                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Maxime quo et.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="128" option-value="255"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="128"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="128" option-value="255">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Maxime quo et.</h5>
                                        <p class="text-muted description">Ipsa reprehenderit quae aut. Laborum et et sequi fugit debitis velit. Necessitatibus ut vitae sit.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">67.200đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">84.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Pariatur."> Pariatur. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/rerum-odit-omnis">
                                        <img src="/storage/thumb_ngonbamien/img-7.png" alt="Rerum odit omnis.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="162" option-value="324"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="162"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="162" option-value="324">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Rerum odit omnis.</h5>
                                        <p class="text-muted description">Sapiente amet non perferendis modi. Est dolore autem et est vitae. Ut aut est omnis.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">364.000đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">520.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Sint."> Sint. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/unde-molestiae">
                                        <img src="/storage/thumb_ngonbamien/img-8.png" alt="Unde molestiae.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="209" option-value="417"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="209"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="209" option-value="417">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Unde molestiae.</h5>
                                        <p class="text-muted description">Minus similique cupiditate inventore dicta pariatur quia dolor. Voluptate in aut et animi.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">748.800đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">936.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Nesciunt."> Nesciunt. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/hic-consequatur-sit">
                                        <img src="/storage/thumb_ngonbamien/img-2-1.png" alt="Hic consequatur sit.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="652" option-value="1304"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="652"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="652" option-value="1304">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Hic consequatur sit.</h5>
                                        <p class="text-muted description">Recusandae sapiente dignissimos fugit asperiores. At exercitationem enim est voluptatem.</p>
                                        <h6 class="text-danger">
                                            <div><b class="text-danger price">975.000đ</b> </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Incidunt."> Incidunt. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="featured__item">
                                    <div class="featured__item__pic">
                                        <a href="http://ngonbamien.local/san-pham/suscipit-atque">
                                        <img src="/storage/thumb_ngonbamien/img-2-1.png" alt="Suscipit atque.">
                                        </a>
                                        <ul class="featured__item__pic__hover">
                                            <li><span title="Yêu thích" class="add_favor" data-value="920" option-value="1840"><i class="fa fa-heart"></i></span></li>
                                            <li><span title="Nhắn tin" class="as_message" data-value="920"><i class="fa fa-comment"></i></span></li>
                                            <li><span title="Thêm vào giỏ" class="add_cart" data-value="920" option-value="1840">
                                                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h5>Suscipit atque.</h5>
                                        <p class="text-muted description">Et saepe possimus tempora. Eius dolorem earum laboriosam consequatur exercitationem ipsam.</p>
                                        <h6 class="text-danger">
                                            <div class="">
                                                <b class="text-danger price">748.800đ</b>
                                                <span class="text-muted price_root text-decoration-line-through">936.000đ</span>
                                            </div>
                                            <div class="mx-1 badge badge-dark price-title" title="Beatae ut."> Beatae ut. </div>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item disabled" aria-disabled="true" aria-label="pagination.previous">
                                        <span class="page-link" aria-hidden="true">‹</span>
                                    </li>
                                    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=2">2</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=3">3</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=4">4</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=5">5</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=6">6</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=7">7</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=8">8</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=9">9</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=10">10</a></li>
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=95">95</a></li>
                                    <li class="page-item"><a class="page-link" href="http://ngonbamien.local/san-pham?page=96">96</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="http://ngonbamien.local/san-pham?page=2" rel="next" aria-label="pagination.next">›</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection