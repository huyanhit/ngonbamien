<?php

// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});

Breadcrumbs::for('products', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Sản phẩm', route('products.index'));
});
Breadcrumbs::for('products-create', function ($trail) {
    $trail->parent('products');
    $trail->push('Thêm sản phẩm', route('products.create'));
});
Breadcrumbs::for('products-show', function ($trail, $data) {
    $trail->parent('products');
    $trail->push($data['title'], route('products.show', $data['id']));
});
Breadcrumbs::for('products-edit', function ($trail, $data) {
    $trail->parent('products');
    $trail->push($data['title'], route('products.edit', $data['id']));
});

Breadcrumbs::for('producer', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Xuất xứ', route('producer.index'));
});
Breadcrumbs::for('producer-show', function ($trail, $data) {
    $trail->parent('producer');
    $trail->push($data['title'], route('producer.show', $data['id']));
});
Breadcrumbs::for('producer-create', function ($trail) {
    $trail->parent('producer');
    $trail->push('Thêm xuất xứ', route('producer.create'));
});
Breadcrumbs::for('producer-edit', function ($trail, $data) {
    $trail->parent('producer');
    $trail->push($data['title'], route('producer.edit', $data['id']));
});

Breadcrumbs::for('product-categories', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Sản loại phẩm', route('product-categories.index'));
});
Breadcrumbs::for('product-categories-show', function ($trail, $data) {
    $trail->parent('product-categories');
    $trail->push($data['title'], route('product-categories.show', $data['id']));
});
Breadcrumbs::for('product-categories-create', function ($trail) {
    $trail->parent('product-categories');
    $trail->push('Thêm loại sản phẩm', route('product-categories.create'));
});
Breadcrumbs::for('product-categories-edit', function ($trail, $data) {
    $trail->parent('product-categories');
    $trail->push($data['title'], route('product-categories.edit', $data['id']));
});