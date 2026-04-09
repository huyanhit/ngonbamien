<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'suppliers';

    public function supplier_support(): HasMany
    {
        return $this->hasMany(SupplierSupport::class, 'supplier_id', 'id');
    }

    public function supplier_ship(): HasMany
    {
        return $this->hasMany(SupplierShip::class, 'supplier_id', 'id');
    }
}
