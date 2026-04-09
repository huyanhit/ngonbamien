<?php

namespace  App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierModel extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $guarded = [];
    protected $table = 'suppliers';

    public function supplier_ship(): HasMany
    {
        return $this->hasMany(SupplierShipModel::class, 'supplier_id');
    }

    public function supplier_support(): HasMany
    {
        return $this->hasMany(SupplierSupportModel::class, 'supplier_id');
    }
}
