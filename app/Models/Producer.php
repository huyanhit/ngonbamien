<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producer extends Model
{
    use HasFactory;

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
