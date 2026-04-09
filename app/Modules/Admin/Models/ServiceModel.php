<?php

namespace  App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ServiceModel extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $guarded = [];
    protected $table = 'services';
}
