<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-image="img-1"
    data-sidebar-size="lg" data-preloader="disable">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title> {{ config('app.name', 'Administrator') }} </title> @vite(['resources/css/admin.css'])
        <link   href="{{Request::root()}}/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <script src="{{Request::root()}}/js/jquery.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/layout.js"></script>
        <script src="{{Request::root()}}/js/admin.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/admin-ajax.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/ckeditor/ckeditor.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="layout-wrapper">
            @include('Admin::Components.topbar')
            @include('Admin::Components.menu')
            <div class="vertical-overlay">
                <div id="box-error">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                @switch(Route::currentRouteName())
                                    @case('product-categories.index')
                                        @include('Admin::Components.breadcrumb', ['name'=>'product-categories', 'title' => 'Danh sách loại sản phẩm'])
                                        @break
                                    @case('product-categories.create')
                                        @include('Admin::Components.breadcrumb', ['name'=>'product-categories-create', 'title' => 'Thêm loại sản phẩm'])
                                        @break
                                    @case('product-categories.show')
                                        @include('Admin::Components.breadcrumb', [
                                            'name'=>'product-categories-show',
                                            'title' => 'Copy loại sản phẩm',
                                            'data'=> $data
                                        ])
                                        @break
                                    @case('product-categories.edit')
                                        @include('Admin::Components.breadcrumb', [
                                            'name'=>'product-categories-edit',
                                            'title' => 'Sửa loại sản phẩm',
                                            'data'=> $data
                                        ])
                                        @break

                                    @case('producer.index')
                                        @include('Admin::Components.breadcrumb', ['name'=>'producer', 'title' => 'Danh sách xuất xứ'])
                                        @break
                                    @case('producer.create')
                                        @include('Admin::Components.breadcrumb', ['name'=>'producer-create', 'title' => 'Thêm xuất xứ'])
                                        @break
                                    @case('producer.show')
                                        @include('Admin::Components.breadcrumb', [
                                            'name'=>'producer-show',
                                            'title' => 'Copy xuất xứ',
                                            'data'=> $data
                                        ])
                                        @break
                                    @case('producer.edit')
                                        @include('Admin::Components.breadcrumb', [
                                            'name'=>'producer-edit',
                                            'title' => 'Sửa xuất xứ',
                                            'data'=> $data
                                        ])
                                        @break

                                    @case('products.index')
                                        @include('Admin::Components.breadcrumb', ['name'=>'products', 'title' => 'Danh sách sản phẩm'])
                                        @break
                                    @case('products.create')
                                        @include('Admin::Components.breadcrumb', ['name'=>'products-create', 'title' => 'Thêm sản phẩm'])
                                        @break
                                    @case('products.show')
                                        @include('Admin::Components.breadcrumb', [
                                            'name'  =>'products-show',
                                            'title' => 'Copy sản phẩm',
                                            'data'  => $data
                                        ])
                                        @break
                                    @case('products.edit')
                                        @include('Admin::Components.breadcrumb', [
                                            'name'  =>'products-edit',
                                            'title' => 'Sửa sản phẩm',
                                            'data'  => $data
                                        ])
                                        @break

                                    @default
                                        @include('Admin::Components.breadcrumb', ['name'=>'dashboard', 'title' => 'Tổng quan'])
                                        @break
                                @endswitch
                            </div>
                        </div>
                        @yield('content')
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                               2025 © Velzon.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design &amp; Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <div id="preloader">
            <div id="status">
                <div class="spinner-border text-primary avatar-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{Request::root()}}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{Request::root()}}/libs/simplebar/simplebar.min.js"></script>
        <script src="{{Request::root()}}/libs/node-waves/waves.min.js"></script>
        <script src="{{Request::root()}}/libs/feather-icons/feather.min.js"></script>
        <script src="{{Request::root()}}/js/admin/pages/plugins/lord-icon-2.1.0.js"></script>

        <!-- dropzone js -->
        <script src="{{Request::root()}}/libs/dropzone/dropzone-min.js"></script> <!-- Sweet Alerts js -->
        <script src="{{Request::root()}}/libs/sweetalert2/sweetalert2.min.js"></script>

        <script>
            @if($message = session('message_insert'))
                Swal.fire(
                'Thông báo',
                '{{ $message }}',
                'success'
                )
            @endif

            @if($message = session('message_update'))
                Swal.fire(
                    'Thông báo',
                    '{{ $message }}',
                    'success'
                )
            @endif

            @if($message = session('message_error'))
                Swal.fire(
                    'Cảnh báo',
                    '{{ $message }}',
                    'danger'
                )
            @endif


            let dataLayout      = sessionStorage.getItem("data-layout")?? 'vertical';
            let dataTheme       = sessionStorage.getItem("data-bs-theme")?? 'light';
            let dataSidebarSize = sessionStorage.getItem("data-sidebar-size")?? 'lg';

            document.documentElement.setAttribute("data-layout", dataLayout);
            document.documentElement.setAttribute("data-bs-theme", dataTheme);
            document.documentElement.setAttribute("data-sidebar-size", dataSidebarSize);

            const setDataLayout = function (e) {
                dataLayout = dataLayout === 'horizontal'? 'vertical': 'horizontal';
                sessionStorage.setItem("data-layout", dataLayout);
                document.documentElement.setAttribute("data-layout", dataLayout);
                $(e).children().toggleClass('bx-horizontal-left');
                $(e).children().toggleClass('bx-vertical-top');
            }

            const setTheme = function () {
                dataTheme = dataTheme === 'dark'? 'light': 'dark';
                sessionStorage.setItem("data-bs-theme", dataTheme);
                document.documentElement.setAttribute("data-bs-theme", dataTheme);
            }

            const setSidebarSize = function (e) {
                dataSidebarSize = dataSidebarSize === 'lg'? 'sm': 'lg';
                sessionStorage.setItem("data-sidebar-size", dataSidebarSize);
                document.documentElement.setAttribute("data-sidebar-size", dataSidebarSize);
                $(e).children().toggleClass('open');
            }
        </script>
    </body>
</html>
