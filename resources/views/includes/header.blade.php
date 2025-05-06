<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="{{Request::root()}}">
            <img src="{{$sites->image->uri?? Request::root().'/img/logo.png'}}" alt="{{$sites->meta_title?? ''}}">
        </a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>$150.00</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="{{Request::root()}}/img/language.png" alt="">
            <div>Tiếng việt</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Tiếng việt</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            <a href="#"><i class="fa fa-user"></i> Đăng nhập</a>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            @foreach ($menus as $item)
                @if (empty($item->parent_id))
                    <li class="{{(request()->path() == $item->router)? 'active': ''}}">
                        <a href="{{Request::root()}}/{{$item->router}}">
                            @if(!empty($item->icon))
                                <span class="menu-icon" style="width: 20px">{!!$item->icon!!}</span>
                            @endif
                            <span class="menu-title"> {{ $item->title }} </span>
                        </a>
                        <ul class="header__menu__dropdown">
                            @foreach ($menus as $sub)
                                @if($sub->parent_id == $item->id)
                                    <li class="{{(request()->path() == $sub->router)? 'active': ''}}">
                                        <a href="{{Request::root()}}/{{ $sub->router }}">
                                            @if(!empty($sub->icon))
                                                <span class="menu-icon" style="width: 20px">{!!$sub->icon!!}</span>
                                            @endif
                                            <span class="menu-title"> {{ $sub->title }} </span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
           @endforeach
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="{{ $sites->link_facebook ?? '#'}}"><i class="fa fa-facebook"></i></a>
        <a href="{{ $sites->link_youtube ?? '#'}}"><i class="fa fa-youtube"></i></a>
        <a href="{{ $sites->link_tiktok ?? '#'}}"><svg style="height: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 8.24537V15.5C16 19.0899 13.0899 22 9.5 22C5.91015 22 3 19.0899 3 15.5C3 11.9101 5.91015 9 9.5 9C10.0163 9 10.5185 9.06019 11 9.17393V12.3368C10.5454 12.1208 10.0368 12 9.5 12C7.567 12 6 13.567 6 15.5C6 17.433 7.567 19 9.5 19C11.433 19 13 17.433 13 15.5V2H16C16 4.76142 18.2386 7 21 7V10C19.1081 10 17.3696 9.34328 16 8.24537Z"></path></svg>
        </a>
    </div>
    <div class="humberger__menu__contact">
        <ul>

            <li><i class="fa fa-envelope"></i> {{$sites->email ?? ''}}</li>
            <li>{!! $sites->other ?? '' !!}</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li class="fw-bold">{!! $sites->other ?? '' !!}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="{{ $sites->link_facebook ?? '#'}}"><i class="fa fa-facebook"></i></a>
                            <a href="{{ $sites->link_youtube ?? '#'}}"><i class="fa fa-youtube"></i></a>
                            <a href="{{ $sites->link_tiktok ?? '#'}}"><svg style="height: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8.24537V15.5C16 19.0899 13.0899 22 9.5 22C5.91015 22 3 19.0899 3 15.5C3 11.9101 5.91015 9 9.5 9C10.0163 9 10.5185 9.06019 11 9.17393V12.3368C10.5454 12.1208 10.0368 12 9.5 12C7.567 12 6 13.567 6 15.5C6 17.433 7.567 19 9.5 19C11.433 19 13 17.433 13 15.5V2H16C16 4.76142 18.2386 7 21 7V10C19.1081 10 17.3696 9.34328 16 8.24537Z"></path></svg>
                            </a>
                        </div>
                        <div class="header__top__right__language">
                            <img src="{{Request::root()}}/img/language.png" alt="">
                            <div>Tiếng Việt</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">Tiếng Việt</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div>
                        <div class="header__top__right__auth">
                            <a href="#"><i class="fa fa-user"></i>Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bot" id="header__bot">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="{{Request::root()}}">
                            <img src="{{$site->logo??Request::root().'/img/logo.png'}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            @foreach ($menus as $item)
                                @if (empty($item->parent_id))
                                    <li class="{{(request()->path() == $item->router)? 'active': ''}}">
                                        <a href="{{Request::root()}}/{{$item->router}}">
                                            @if(!empty($item->icon))
                                                <span class="menu-icon">{!!$item->icon!!}</span>
                                            @endif
                                            <span class="menu-title"> {{ $item->title }} </span>
                                        </a>
                                        <ul class="header__menu__dropdown">
                                            @foreach ($menus as $sub)
                                                @if($sub->parent_id == $item->id)
                                                    <li class="{{(request()->path() == $sub->router)? 'active': ''}}">
                                                        <a href="{{Request::root()}}/{{ $sub->router }}">
                                                            @if(!empty($sub->icon))
                                                                <span class="menu-icon">{!!$sub->icon!!}</span>
                                                            @endif
                                                            <span class="menu-title"> {{ $sub->title }} </span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <div class="header__cart">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                            <li><a data-toggle="popover" data-bs-placement="bottom"><i class="fa fa-shopping-bag"></i> <span id="cart-number">3</span></a></li>
                        </ul>
                        <div class="header__cart__price"><span class="text-danger">150.000</span> (vnd)</div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </div>
    <div class="cart-container relative w-50"></div>
</header>
<!-- Header Section End -->
<script>
    var header = document.getElementById("header__bot");
    document.onscroll = function() {
        if (header !== null) {
            let sticky = header.offsetTop;
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    };
</script>
