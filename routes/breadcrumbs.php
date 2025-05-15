<?php

// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('home'));
});

Breadcrumbs::for('don-hang', function ($trail) {
    $trail->parent('home');
    $trail->push('Đơn hàng', route('don-hang'));
});

Breadcrumbs::for('gio-hang', function ($trail) {
    $trail->parent('home');
    $trail->push('Giỏ hàng', route('gio-hang'));
});

Breadcrumbs::for('dat-hang', function ($trail) {
    $trail->parent('home');
    $trail->push('Xác nhận đơn hàng', route('dat-hang'));
});

Breadcrumbs::for('thanh-toan', function ($trail, $data) {
    $trail->parent('home');
    $trail->push('Thanh toán', route('thanh-toan', $data['code']));
});

Breadcrumbs::for('tim-kiem', function ($trail) {
    $trail->parent('home');
    $trail->push('Tìm kiếm', route('tim-kiem'));
});

Breadcrumbs::for('yeu-thich', function ($trail) {
    $trail->parent('home');
    $trail->push('Yêu thích', route('yeu-thich'));
});

Breadcrumbs::for('khuyen-mai', function ($trail) {
    $trail->parent('home');
    $trail->push('Khuyến mãi', route('khuyen-mai'));
});


Breadcrumbs::for('lien-he', function ($trail) {
    $trail->parent('home');
    $trail->push('Liên hệ', route('lien-he'));
});

Breadcrumbs::for('cua-hang', function ($trail) {
    $trail->parent('home');
    $trail->push('Cửa hàng', route('cua-hang'));
});

Breadcrumbs::for('san-pham', function ($trail, $data) {
    $trail->parent('cua-hang');
    $trail->push($data['title'], route('san-pham', $data['title']));
});

Breadcrumbs::for('xem-trang', function ($trail, $data) {
    $trail->parent('home');
    $trail->push($data['page_title'], route('xem-trang', $data['page_router']));
});
