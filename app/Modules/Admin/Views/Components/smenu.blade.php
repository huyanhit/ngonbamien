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
                        href="{{Request::root().'/admin/board'}}">
                        <i class="ri-dashboard-2-line"></i><span>Dashboards</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'product.index'? 'active': ''}}"
                        href="{{Request::root().'/admin/product'}}">
                        <i class="ri-product-hunt-line"></i> <span>Sản phẩm</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'order.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/order'}}">
                        <i class="ri-bill-line"></i> <span>Đơn hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'order.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/shop'}}">
                        <i class="ri-bill-line"></i> <span>Cửa hàng</span>
                    </a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'storage'? 'active': ''}}"
                       href="{{Request::root().'/admin/storage'}}">
                        <i class="ri-store-3-line"></i>
                        <span>QL Kho Hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'bill'? 'active': ''}}"
                       href="{{Request::root().'/admin/bill'}}">
                        <i class="ri-bill-line"></i>
                        <span>QL Hóa Đơn</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'customer.index'? 'active': ''}}"
                       href="{{Request::root().'/admin/customer'}}">
                        <i class="ri-group-2-line"></i>
                        <span>QL Khách Hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'order-payment'? 'active': ''}}"
                       href="{{Request::root().'/admin/order-payment'}}">
                        <i class="ri-group-2-line"></i>
                        <span>BC Thanh toán</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'report'? 'active': ''}}"
                       href="{{Request::root().'/admin/report'}}">
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
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{Route::currentRouteName() == 'chat'? 'active': ''}}"
                       href="{{Request::root().'/chat'}}">
                        <i class="ri-chat-1-line"></i>
                        <span>Chat</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
