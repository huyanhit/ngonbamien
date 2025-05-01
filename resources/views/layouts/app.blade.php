<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>{{isset($meta)?$meta['title']: $sites->meta ?? ''}}</title>
        <meta name="description" content="{!!isset($meta)?$meta['description']:$sites->description ?? ''!!}"/>
        <meta name="keywords" content="{!!isset($meta)?$meta['keyword']:$sites->keyword ?? ''!!}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta HTTP-EQUIV="Content-Language" CONTENT="vi">
        <meta property="og:locale" content="vi_VN">
        <meta property="og:type" content="article">
        <meta property="og:title" content="Vạn Lợi Phát cung cấp lắp đặt sửa chữa các thiết bị lọc nước">
        <meta property="og:site_name" content="Công ty TNHH vạn lợi phát - www.ogani.local - www.vafa.vn">
        <meta property="og:description" content="Chuyên cung cấp mua bán sửa chữa máy linh kiện các thiết bị lọc xử lý nước sạch">
        <meta itemprop="name" content="Vạn Lợi Phát cung cấp lắp đặt sửa chữa các thiết bị lọc nước">
        <meta itemprop="description" content="Chuyên cung cấp mua bán sửa chữa máy linh kiện các thiết bị lọc xử lý nước sạch">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

        <!-- Google tag (gtag.js) -->
        @if(isset($sites->analytic))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$sites->analytic}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', {{$sites->analytic}});
        </script>
        @endif
        <!-- Css Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Page Preloder -->
        <div id="preloder">
            <div class="loader"></div>
        </div>

        @include('includes.header')

        @yield('content')

        @include('includes.footer')

        @if(isset($sites->zalo))
            <div class="zalo-chat-widget" data-oaid="{{$sites->zalo}}"
                data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="300" data-height="300">
            </div>
            <script src="https://sp.zalo.me/plugins/sdk.js"> </script>
        @endif
        <!-- Js Plugins -->
        <script src="{{Request::root()}}/js/jquery.min.js" ></script>
        <script src="{{Request::root()}}/js/bootstrap.min.js" ></script>
        <script src="{{Request::root()}}/js/jquery.nivo.slider.js"></script>
        <script src="{{Request::root()}}/js/jquery.nice-select.min.js"></script>
        <script src="{{Request::root()}}/js/jquery-ui.min.js"></script>
        <script src="{{Request::root()}}/js/jquery.slicknav.js"></script>
        <script src="{{Request::root()}}/js/mixitup.min.js"></script>
        <script src="{{Request::root()}}/js/owl.carousel.min.js"></script>
    </body>
</html>
