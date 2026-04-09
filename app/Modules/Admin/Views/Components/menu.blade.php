<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{Request::root()}}" target="blank" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/images/logo-sm.png" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="/images/logo-dark.png" alt="" height="17">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{Request::root()}}" target="blank" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/images/logo-sm.png" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="/images/logo-light.png" alt="" height="17">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav" data-simplebar style="max-height: calc(100vh - 110px);" >
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'dashboard.index'? 'active': ''}}"
                        href="{{Request::root().'/admin/dashboard'}}">
                        <i class="ri-dashboard-2-line"></i><span>Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'products.index'? 'active': ''}}"
                        href="{{Request::root().'/admin/products'}}">
                        <i class="ri-product-hunt-line"></i> <span>Sản phẩm</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'product-categories.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/product-categories'}}">
                        <i class="ri-list-indefinite"></i>
                        <span> Loại sản phẩm </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'orders.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/orders'}}">
                        <i class="ri-bill-line"></i> <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'producer.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/producers'}}">
                        <i class="ri-user-location-line"></i>
                        <span>Xuất xứ</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'producer.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/suppliers'}}">
                        <i class="ri-account-box-line"></i>
                        <span>Nhà cung cấp</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'posts.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/posts'}}">
                        <i class="ri-article-line"></i>
                        <span>Bài viết</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'pages.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/pages'}}">
                        <i class="ri-pages-line"></i>
                        <span>Trang</span>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'chat'? 'active': ''}}"
                       href="{{Request::root().'/chat'}}">
                        <i class="ri-chat-1-line"></i>
                        <span>Chat</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'storages'? 'active': ''}}"
                       href="{{Request::root().'/admin/storages'}}">
                        <i class="ri-store-3-line"></i>
                        <span>QL Kho Hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'bills'? 'active': ''}}"
                       href="{{Request::root().'/admin/bills'}}">
                        <i class="ri-bill-line"></i>
                        <span>QL Hóa Đơn</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'orders-payment'? 'active': ''}}"
                       href="{{Request::root().'/admin/orders-payment'}}">
                        <i class="ri-group-2-line"></i>
                        <span>QL Thanh toán</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'customers.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/customers'}}">
                        <i class="ri-group-2-line"></i>
                        <span>QL Khách Hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'reports'? 'active': ''}}"
                       href="{{Request::root().'/admin/reports'}}">
                        <i class="ri-currency-line"></i>
                        <span>BC Doanh Thu</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link"
                        href="#system" data-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="system">
                        <i class="ri-settings-2-line"></i>
                        <span >Hệ thống</span>
                    </a>
                    <div class="collapse menu-dropdown" id="system">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{Route::currentRouteName() == 'sites.edit'? 'active': ''}}"
                                   href="{{Request::root().'/admin/sites/1/edit'}}"> <i class="ri-home-2-line"></i> Website </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Route::currentRouteName() == 'menus.index'? 'active': ''}}"
                                   href="{{Request::root().'/admin/menus'}}"><i class="ri-menu-2-line"></i> Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Route::currentRouteName() == 'users.index'? 'active': ''}}"
                                   href="{{Request::root().'/admin/users'}}"><i class="ri-user-2-line"></i> Tài khoản</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link menu-link {{Route::currentRouteName() == 'sliders.index'? 'active': ''}}"
                                href="{{Request::root().'/admin/sliders'}}">
                                    <i class="ri-gallery-line"></i>
                                    <span>Slider</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{Route::currentRouteName() == 'banners.index'? 'active': ''}}"
                                href="{{Request::root().'/admin/banners'}}">
                                    <i class="ri-slideshow-2-line"></i>
                                    <span>Banner</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{Route::currentRouteName() == 'contacts.index'? 'active': ''}}"
                                href="{{Request::root().'/admin/contacts'}}">
                                    <i class="ri-contacts-book-2-line"></i>
                                    <span>Liên hệ</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{Route::currentRouteName() == 'contacts.comment'? 'active': ''}}"
                                href="{{Request::root().'/admin/comments'}}">
                                    <i class="ri-contacts-book-2-line"></i>
                                    <span>Comment</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
