<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'sites';

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'logo');
    }
}
