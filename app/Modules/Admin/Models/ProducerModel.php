<?php

namespace  App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ProducerModel extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table   = 'producers';
    protected $guarded = [];
}
