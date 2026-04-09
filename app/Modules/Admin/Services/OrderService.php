<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Models\Supplier;
use App\Modules\Admin\Models\OrderModel;
use App\Modules\Admin\Models\SupplierOrderModel;
use Carbon\Carbon;

class OrderService extends Service{
    function __construct(){
        parent::__construct(new OrderModel());
    }

    public function editData($request, $id, $data)
    {
        $edit = parent::editData($request, $id, $data);
        if($edit && $request->get('order_status_id')){
            SupplierOrderModel::where(['order_id' => $id])->update(
                ['order_status_id' => $request->get('order_status_id')]
            );
        }

        return $edit;
    }

    public function getPayment($year = '2026')
    {
        $startYear = Carbon::parse($year.'-01-01')->startOfYear();
        $endYear   = Carbon::parse($year.'-01-01')->endOfYear();
        $suppliers = Supplier::where('active', 1)->get()->keyBy('id')->toArray();
        $this->model = $this->model->whereBetween('created_at', [$startYear , $endYear])->with('supplier_order');

        $all = $this->model->get()->flatMap(function ($item) use ($suppliers){
            return $item->supplier_order->map(function ($sorder) use ($suppliers){
                $sorder->setAttribute('week', Carbon::parse($sorder->created_at)->weekOfYear);
                $sorder->setAttribute('supplier', $suppliers[$sorder->supplier_id]?? null);
                return $sorder;
            });
        });

        $groupShop = $all->groupBy(function ($item) {
            return $item->week;
        })->map(function ($group) {
            return $group->groupBy(function ($item) {
                return $item->supplier_id;
            });
        })->reverse();

        return $groupShop;
    }
}
