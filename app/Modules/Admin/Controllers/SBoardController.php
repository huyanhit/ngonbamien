<?php
namespace App\Modules\Admin\Controllers;

use App\Models\Product;
use App\Modules\Admin\Models\CommentModel;
use App\Modules\Admin\Models\CounterModel;
use App\Modules\Admin\Models\SupplierModel;
use App\Modules\Admin\Models\SupplierOrderModel;
use App\Modules\Admin\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SBoardController extends MyController
{
    function __construct(Request $request){
        parent::__construct($request, new DashboardService());
    }
    public function index(){
        $supplier = SupplierModel::where(['auth_id' => Auth::id(), 'active' => 1])->first();
        $sOrders  = SupplierOrderModel::where('supplier_id', $supplier->id)
        ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()])
        ->whereIn('order_status_id', ['4','5','6','7','10'])->orderBy('order_status_id', 'ASC')->get();
        $sCustomer = SupplierOrderModel::select(['phone','name','address', 'total' ,'created_at'])->where('supplier_id', $supplier->id)->get();

        $oNew    = $sOrders->filter(function($item){
            return $item->order_status_id == 4 || $item->order_status_id == 5 || $item->order_status_id == 6;
        });
        $oBox    = $sOrders->filter(function($item){
            return $item->order_status_id == 5;
        });
        $oShip   = $sOrders->filter(function($item){
            return $item->order_status_id == 6;
        });
        $oComp   = $sOrders->filter(function($item){
            return $item->order_status_id == 7;
        });
        $oDone   = $sOrders->filter(function($item){
            return $item->order_status_id == 10;
        });

        $oWeek   = $sOrders->filter(function($item){
            return ($item->created_at > Carbon::now()->startOfWeek() 
            && $item->created_at < Carbon::now()->endOfWeek());
        });

        $oMonth   = $sOrders->filter(function($item){
            return ($item->created_at > Carbon::now()->startOfMonth() 
            && $item->created_at < Carbon::now()->endOfMonth());
        });

        
        $oQuarter  = $sOrders->filter(function($item){
            return ($item->created_at > Carbon::now()->startOfQuarter() 
            && $item->created_at < Carbon::now()->endOfQuarter());
        });

        $oYear   = $sOrders->filter(function($item){
            return ($item->created_at > Carbon::now()->startOfYear() 
            && $item->created_at < Carbon::now()->endOfYear());
        });

        $sProducts = Product::where(['auth_id' => Auth::id(), 'active' => 1])->with('product_option')->get()->flatMap(function($item){
            return $item->product_option;
        });
        $sDiscount = $sProducts->filter(function($item){ return $item->discount; });
        $sDirty    = $sProducts->filter(function($item){ return $item->stock < 10; });
        $sEmpty    = $sProducts->filter(function($item){ return $item->stock < 1; });

        $comments = CommentModel::where(['products.auth_id' => Auth::id(), 'products.active' => 1])
            ->select(['comments.*','products.id as product_id', 'products.title', 'products.slug'])
            ->join('products', 'comments.product_id','=','products.id')->where('comments.comment_id', null)
            ->orderBy('comments.id', 'desc')
                ->with('replies')->limit(20)->get();
       
        return view('Admin::sdashboard', [
            'data'=>[
                [
                    'title'      => 'Đơn hàng',
                    'link'       => '/admin/order',
                    'icon'       => 'ri-bill-line',
                    'class'      => '#f3f6f9',
                    'desc'       => 'Năm '.Carbon::now()->format('Y'),
                    'line_1'     =>  [
                        'Đóng gói', $oBox->count(), number_format($oBox->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                    ],
                    'line_2'     =>  [
                        'Đang giao', $oShip->count(), number_format($oShip->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                    ],
                    'line_3'     =>  [
                        'Hoàn thành', $oComp->count(), number_format($oComp->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                    ],
                    'line_4'     =>  [
                        'Đã chốt', $oDone->count(), number_format($oDone->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                    ],
                ],
                [
                    'title'      => 'Sản phẩm',
                    'link'       => '/admin/product',
                    'icon'       => 'ri-product-hunt-line',
                    'class'      => '#f3f6f9',
                    'desc'       => 'Có '.$sProducts->count().' Mặt hàng',
                    
                    'line_1'     =>  [
                        'Tổng sản phẩm', $sProducts->sum(function($item){return $item->stock;}).' SP', number_format($sProducts->sum(function($item){return $item->price_root * $item->stock;}), 0, ',', '.').' đ'
                    ],
                    'line_2'      =>  [
                        'Đang giảm giá', $sDiscount->sum(function($item){return $item->stock;}).' SP', number_format($sDiscount->sum(function($item){return $item->price_root * $item->stock;}), 0, ',', '.').' đ'
                    ],
                    'line_3'      =>  [
                        'Sắp hết hàng', 'Dưới 10 SP', $sDirty->count(). ' Mặt hàng'
                    ],
                    'line_4'      =>  [
                        'Hết hàng', '', $sEmpty->count(). ' Mặt hàng'
                    ],
                ],
                [
                    'title'      => 'Khách hàng',
                    'link'       => '/admin/customer',
                    'icon'       => 'ri-product-hunt-line',
                    'class'      => '#f3f6f9',
                    'desc'       => $supplier->created_at->format('m/Y'),
                    'line_1'     =>  [
                        'Tổng', '', $sCustomer->groupBy('phone')->count()
                    ],
                    'line_2'      => [
                        'Khách quen', '', $sCustomer->groupBy('phone')->filter(function($item){
                            return ($item->count() > 1);
                        })->count()
                    ],
                    'line_3'      => [
                        'Khách mới',  $sCustomer->groupBy('phone')->filter(function($item){
                            return ($item->every(function($i){
                                return $i->created_at > Carbon::now()->subDays(30);
                            }));
                        })->count(), 'HD 30 ngày'
                    ],
                    'line_4'      => [
                        'Khách tiềm năng', $sCustomer->groupBy('phone')->filter(function($item){
                            return ($item->sum(function($i){
                                return $i->total;
                            }) > 5000000);
                        })->count(), 'Tổng đơn hàng > 5tr'
                    ],
                ],
            ],
            'supplier' => $supplier,
            'sell' => [
                'week'  => [
                    'count' => $oWeek->count(),
                    'value' => number_format($oWeek->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                ],
                'month' => [
                    'count' => $oMonth->count(),
                    'value' => number_format($oMonth->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                ],
                'quarter' => [
                    'count' => $oQuarter->count(),
                    'value' => number_format($oQuarter->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                ],
                'year'  => [
                    'count' => $oYear->count(),
                    'value' => number_format($oYear->sum(function($item){return $item->total;}), 0, ',', '.').' đ'
                ],
            ],
            'comments' => $comments,
            'counter' => [
                'online'=> CounterModel::where('created_at', '>', Carbon::now()
                    ->subMinutes(5)->format('Y-m-d H:i:s'))->count(),
                'total' => CounterModel::count(),
            ],
            'sOderNew' => $oNew
        ]);
    }
}
