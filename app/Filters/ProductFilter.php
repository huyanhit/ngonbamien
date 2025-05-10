<?php

namespace App\Filters;

use App\Models\ProductOption;
use Illuminate\Support\Facades\Auth;

class ProductFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'author_id',
    ];

    public function filterTitle($name)
    {
        return $this->builder->where('title', 'like', '%' . $name . '%');
    }

    public function filterSKU($sku)
    {
        return $this->builder->where('sku', 'like', $sku . '%');
    }

    public function filterGia($option)
    {
         return match ($option) {
            'duoi-100k' => $this->builder->where('product_option.price','<','100000')->where('product_option.price','>','0'),
            '100k-200k' => $this->builder->where('product_option.price','>=','100000')->where('product_option.price','<=','200000'),
            '200k-500k' => $this->builder->where('product_option.price','>','200000')->where('product_option.price','<=','500000'),
            'tren-500k' => $this->builder->where('product_option.price','>','500000'),
            default     => $this->builder
        };
    }

    public function filterProductCategory($slug)
    {
        return $this->builder->join('product_categories', function ($join) use ($slug) {
            $join->on('products.product_category_id', '=', 'product_categories.id')
                ->where('product_categories.slug', 'like', $slug);
        });
    }

    public function filterXuatXu($slug)
    {
        return $this->builder->join('producers', function ($join) use ($slug) {
            $join->on('producers.id', '=', 'products.producer_id')
                ->where('producers.slug', 'like', $slug);
        });
    }

    public function filterLoai($option)
    {
        return match ($option) {
            'mon-mua-nhieu'     => $this->builder->where('products.is_hot', 1),
            'mon-moi'           => $this->builder->where('products.is_new', 1),
            'dang-khuyen-mai'   => $this->builder->where('products.is_promotion', 1),
            'mon-da-thich'      => $this->builder
                ->join('favor_products', 'products.id', '=', 'favor_products.product_id')
                ->where('favor_products.user_id', Auth::id()),
            'mon-da-mua'        => $this->builder
                ->join('order_products', 'products.id', '=', 'order_products.product_id')
                ->where('order_products.user_id', Auth::id()),
            default             => $this->builder
        };
    }
}
