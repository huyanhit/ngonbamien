<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisterEmail extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'register_emails';
    protected $fillable = [
        'email', 'active'
    ];
}
