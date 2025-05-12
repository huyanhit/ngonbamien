<?php

namespace App\Filters;

use App\Models\ProductOption;
use Illuminate\Support\Facades\Auth;

class PostFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'author_id',
    ];

    public function filterTitle($name)
    {
        return $this->builder->where('title', 'like', '%' . $name . '%');
    }

    public function filterPostCategory($slug)
    {
        return $this->builder->join('post_categories', function ($join) use ($slug) {
            $join->on('posts.post_category_id', '=', 'post_categories.id')
                ->where('post_categories.slug', 'like', $slug);
        });
    }

    public function filterXuatXu($slug)
    {
        return $this->builder->join('producers', function ($join) use ($slug) {
            $join->on('producers.id', '=', 'posts.producer_id')
                ->where('producers.slug', 'like', $slug);
        });
    }
}
