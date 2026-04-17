<?php

namespace App\Filters;

use Illuminate\Support\Facades\Auth;

class SupplierProductFilter extends QueryFilter
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

    public function filterLoai($option)
    {
        return $this->builder->join('product_categories', function ($join) use ($option) {
            $join->on('products.product_category_id', '=', 'product_categories.id')
                ->where('product_categories.slug', 'like', $option);
        });
    }

    public function filterMuc($option)
    {
        return match ($option) {
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
