<?php

namespace  App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PostCategoryModel extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'post_categories';
}
