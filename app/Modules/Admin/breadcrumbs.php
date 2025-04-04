<?php

// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});
Breadcrumbs::for('products', function ($trail) {
    $trail->push('Sản phẩm', route('products.index'));
});
Breadcrumbs::for('products-create', function ($trail) {
    $trail->parent('products');
    $trail->push('Thêm sản phẩm', route('products.create'));
});
Breadcrumbs::for('products-update', function ($trail) {
    $trail->parent('product');
    $trail->push('Sửa sản phẩm', route('products.update'));
});