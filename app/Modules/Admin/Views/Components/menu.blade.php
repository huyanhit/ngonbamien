<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/images/logo-sm.png" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="/images/logo-dark.png" alt="" height="17">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
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
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/dashboard'}}"> <i class="ri-dashboard-2-line"></i> <span>Dashboards</span> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/products'}}"> <i class="ri-dashboard-2-line"></i> <span>Sản phẩm</span> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/product-categories'}}">
                        <i class="ri-dashboard-2-line"></i>
                        <span> Loại sản phẩm </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/producer'}}">
                        <i class="ri-dashboard-2-line"></i>
                        <span>Xuất xứ</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/posts'}}">
                        <i class="ri-dashboard-2-line"></i>
                        <span>Bài viết</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/pages'}}">
                        <i class="ri-dashboard-2-line"></i>
                        <span>Trang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{Request::root().'/admin/sliders'}}">
                        <i class="ri-dashboard-2-line"></i>
                        <span>Slider</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#system" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="system">
                        <i class="ri-dashboard-2-line"></i>
                        <span href="{{Request::root().'/admin/sites/1/edit'}}">Website</span>
                    </a>
                    <div class="collapse menu-dropdown" id="system">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{Request::root().'/admin/menus'}}">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{Request::root().'/admin/users'}}">Tài khoản</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{Request::root().'/admin/news'}}">Tin Tức</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{Request::root().'/admin/contacts'}}">Liên hệ</a>
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