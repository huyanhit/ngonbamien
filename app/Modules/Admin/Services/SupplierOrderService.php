<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Models\Supplier;
use App\Modules\Admin\Models\SupplierOrderModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SupplierOrderService extends Service{
    function __construct(){
        parent::__construct(new SupplierOrderModel());
    }

    public function getPayment($year = '2026')
    {
        $startYear  = Carbon::parse($year.'-01-01')->startOfYear();
        $endYear    = Carbon::parse($year.'-01-01')->endOfYear();
        $suppliers  = Supplier::where('active', 1)->get()->keyBy('id')->toArray();
        $supplier   = Supplier::where(['active' => 1, 'auth_id' => Auth::id()])->first();
        if(!empty($supplier)){
            $this->model = $this->model->whereBetween('created_at', [$startYear , $endYear])->where('supplier_id', $supplier->id);
            $all = $this->model->get()->map(function ($sorder) use ($suppliers){
                $sorder->setAttribute('week', Carbon::parse($sorder->created_at)->weekOfYear);
                $sorder->setAttribute('supplier', $suppliers[$sorder->supplier_id]?? null);
                return $sorder;
            });

            $groupShop = $all->groupBy(function ($item) {
                return $item->week;
            })->map(function ($group) {
                return $group->groupBy(function ($item) {
                    return $item->supplier_id;
                });
            })->reverse();
        }

        return $groupShop;
    }
}
