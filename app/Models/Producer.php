<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $softDelete = true;

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function getSliderAttribute()
    {
        return Image::whereIn('id', explode(',', $this->images))->where('active', 1)->get();
    }
}
