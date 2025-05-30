<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    use HasFactory;
    protected $softDelete = true;
    protected $table = 'banners';

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
