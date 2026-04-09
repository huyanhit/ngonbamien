<?php

namespace  App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CommentModel extends Model
{
    protected $table = 'comments';
    protected $guarded = [];

    public function replies(): HasMany
    {
        return $this->hasMany(CommentModel::class, 'comment_id');
    }
}
