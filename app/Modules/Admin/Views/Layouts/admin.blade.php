<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Administrator') }}</title>
        <script src="{{Request::root()}}/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/popper.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/admin.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/admin-ajax.js" type="text/javascript"></script>
        <script src="{{Request::root()}}/js/ckeditor/ckeditor.js" type="text/javascript"></script>
        @vite(['resources/css/admin.css'])
    </head>
    <body>
        <div id="box-error">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div id="ajax_send"></div>
        <div id="header" class="shadow">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2" id="logo">
                        <a href="{{route('dashboard.index')}}">Administrator</a>
                    </div>
                    <div class="col-md-7">
                        <ul id="menu">
                            <li>
                                <a href="{{Request::root().'/admin/products'}}">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="{{Request::root().'/admin/product-categories'}}"> Loại sản phẩm </a>
                            </li>
                            <li>
                                <a href="{{Request::root().'/admin/producer'}}">Hãng sản xuất</a>
                            </li>
                            <li>
                                <a href="{{Request::root().'/admin/services'}}">Dịch vụ</a>
                            </li>
                            <li>
                                <a href="{{Request::root().'/admin/pages'}}">Trang</a>
                            </li>
                            <li>
                                <a href="{{Request::root().'/admin/sliders'}}">Slider</a>
                            </li>
                            <li>
                                <a href="{{Request::root().'/admin/sites/1/edit'}}">Website</a>
                                <ul class="submenu">
                                    <li>
                                        <a href="{{Request::root().'/admin/menus'}}">Menu</a>
                                    </li>
                                    <li>
                                        <a href="{{Request::root().'/admin/users'}}">Tài khoản</a>
                                    </li>
                                    <li>
                                        <a href="{{Request::root().'/admin/news'}}">Tin Tức</a>
                                    </li>
                                    <li>
                                        <a href="{{Request::root().'/admin/contacts'}}">Liên hệ</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <div class="avata">
                            @if(Auth::user()->image_id)
                                <a href="#" >
                                    <img onerror="this.src='/images/no-image.png'" src="{{route('get-image', Auth::user()->image_id)}}" alt="Magazine">
                                </a>
                            @endif
                        </div>
                        <div class="logout">
                            <a href="#">Chào: {{Auth::user()->name}} </a> ||
                            <form method="POST" action="{{ route('logout') }}" style="display: inline-block;color: #fff; cursor: pointer;">
                                @csrf
                                <a :href="route('logout')"
                                   onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                    Đăng xuất
                                </a>
                            </form>
                        </div>
                        <div class="home-page pull-right">
                            <a target="_blank" href="{{Request::root()}}"><i class="fa fa-home" aria-hidden="true"></i>
                                Xem Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </body>
</html>