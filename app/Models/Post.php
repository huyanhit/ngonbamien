<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, Filterable;
    use SoftDeletes;
    protected $softDelete = true;

    protected $table = 'posts';
    public function image(): BelongsTo{
        return $this->belongsTo(Image::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    public function recent(): HasMany{
        return $this->hasMany(PostRecent::class, 'post_id', 'id')
            ->where('user_id', Auth::id());
    }
}
