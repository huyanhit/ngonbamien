<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Models\User;
use Carbon\Carbon;
use App\Modules\Admin\Models\OrderModel;
use Carbon\CarbonPeriod;
class ReportService extends Service{
    function __construct(){
        parent::__construct(new OrderModel());
    }

    public function generateReport(){
        $this->model       = $this->model->where(['active' => 1])->with('products');
        $time_query        = '';
        $all               = null;
        $types             = [
            'weeks'  => $this->getAllWeeksOfYear(),
            'months' => $this->getAllMonthsOfYear(),
            'years'  => ['2026'],
        ];
        $report = [
            'query'      => request()->report_query?? 1,
            'type_week'  => request()->report_type_week,
            'type_month' => request()->report_type_month,
            'type_year'  => request()->report_type_year,
        ];
       
        switch($report['query']){
            case'2':
                $report['type_month'] = $report['type_month']?? count($types['months']);
                $month = $types['months'][$report['type_month']];
                $this->model = $this->model->whereBetween('created_at', [$month['start'], $month['end']]);
                $all = $this->model->get();
                break;
            case'3':
                $report['type_year'] = $report['type_year']?? 2026;
                $this->model = $this->model->whereBetween('created_at', [
                    Carbon::parse($report['type_year'].'-01-01')->startOfYear(), 
                    Carbon::parse($report['type_year'].'-01-01')->endOfYear()
                ]);
                $all = $this->model->get();
                break;
            default:
                $report['type_week'] = $report['type_week']?? count($types['weeks']);
                $week = $types['weeks'][$report['type_week']];
                $this->model = $this->model->whereBetween('created_at', [$week['start'], $week['end']]);
                $all = $this->model->get();
                break;
        }

        switch($report['query']){
            case 2:
                $time_query = 'tháng '.$report['type_month'];
                break;
            case 3:
                $time_query = 'năm '.$report['type_year'];
                break;
            default:
                $time_query = 'tuần '.$report['type_week'];
                break;
        }
        $allOrder = $all->count();
        $sumOrder = $all->sum(function($item){
            return ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']);
        });

        $allOrderDone = $all->sum(function($item){
            return $item->supplier_order->sum(function($item){
                return $item->order_status_id == 10;
            });
        });
        $sumOrderDone = $all->sum(function($item){
            return $item->supplier_order->sum(function($item){
                return $item->order_status_id == 10? ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']): 0;
            });
        });

        return[
            'chart'             => $this->parserChartData($report, $types, $all),
            'all_order'         => $allOrder,
            'sum_order'         => $sumOrder,
            'all_order_done'    => $allOrderDone,
            'sum_order_done'    => $sumOrderDone,
            'time_query'        => $time_query,
            'report_query'      => $report['query'],
            'report_type_week'  => $report['type_week'],
            'report_type_month' => $report['type_month'],
            'report_type_year'  => $report['type_year'],
            'report_order'      => $this->getReportOrder($all)
        ];
    }

    private function getReportOrder($data){
        $groupDate = $data->groupBy(function ($item) {
            return $item['created_at']->format('d/m/Y');
        });
        $date_sell_est = $groupDate->map(function($items, $key){
            return [
                'date' => $key,
                'value'=> $items->count()
            ];
        })->sortByDesc(function ($item) {
            return $item['value'];
        })->first();

        $date_bill_est = $groupDate->map(function($items, $key){
            return [
                'date' => $key,
                'value'=> $items->sum(function($item){
                    return $item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount'];
                })
            ];
        })->sortByDesc(function ($item) {
            return $item['value'];
        })->first();

        $bill_est = $data->sortByDesc(function ($item) {
            return ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']);
        })->first();

        $product = $data->flatMap(function($items){
            return $items->products;
        })->groupBy(function ($item) {
            return $item->id;
        })->sortDesc()->first();

        $customer_bill_est = 0; 
        $customer_buy_name = '';
        $order_sell_est = $data->groupBy(function ($item) {
            return $item->user_id;
        })->sortDesc()->first();
        $customer_bill_est = $order_sell_est->sum(function($item){
            return ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']);
        });
        $customer_buy_name = User::find($order_sell_est->first()->user_id)->name?? '';
      
        return [
            'date_sell_est'    => ['date' => $date_sell_est['date']??'', 'value'=> $date_sell_est['value']??0],
            'date_bill_est'    => ['date' => $date_bill_est['date']??'', 'value'=> $date_bill_est['value']??0],
            'bill_est'         => ['code' => $bill_est->code??'', 'value'=> $bill_est->total??0],
            'product_sell_est' => ['code' => $product?$product->first()->title:'', 'value'=> $product?$product->count():0],
            'customer_buy_est' => ['name' => $customer_buy_name, 'value'=> $customer_bill_est],
        ];
    }

    private function parserChartData($report, $types, $data){
        $series = array(
            [
                'name'=> 'Tổng tiền',
                'type'=> 'column',
                'data'=> []
            ],
            [
                'name'=> 'Tổng đơn hàng',
                'type'=> 'line',
                'data'=> [] ,
            ],
            [
                'name'=> 'Đơn đã chốt',
                'type'=> 'area',
                'data'=> [],
            ]
        );

        $labels = [];
        switch($report['query']){
            case 2:
                $month = $types['months'][$report['type_month']];
                for ($date = $month['start']; $date < $month['end']; $date->addDay()) {
                    $total    = 0;
                    $bill     = 0;
                    $billDone = 0;
                    foreach($data as $item){
                        if($item['created_at']->format('d') == $date->format('d')){
                            $total += ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']);
                            $bill  ++;
                            if($item->order_status_id == 10){
                                $billDone ++;;
                            }
                        }
                    }

                    $series[0]['data'][] = $total;
                    $series[1]['data'][] = $bill;
                    $series[2]['data'][] = $billDone;
                    $labels[] = $date->format('d');
                }
                break;
            case 3:
                $year      = $report['type_year'];
                $startYear = Carbon::parse($year.'01-01')->startOfYear();
                $endYear   = Carbon::parse($year.'01-01')->endOfYear();
                for ($month = $startYear; $month < $endYear; $month->addMonth()) {
                    $total    = 0;
                    $bill     = 0;
                    $billDone = 0;
                    foreach($data as $item){
                        if($item['created_at']->format('m') == $month->format('m')){
                            $total += ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']);
                            $bill ++;
                            if($item->order_status_id == 10){
                                $billDone ++;;
                            }
                        }
                    }

                    $series[0]['data'][] = $total;
                    $series[1]['data'][] = $bill;
                    $series[2]['data'][] = $billDone;
                    $labels[] = $month->format('m/Y');
                }
                break;
            default:
                $week = $types['weeks'][$report['type_week']];
                for ($date = $week['start']; $date < $week['end']; $date->addDay()) {
                    $total    = 0;
                    $bill     = 0;
                    $billDone = 0;
                    foreach($data as $item){
                        if($item['created_at']->format('d') == $date->format('d')){
                            $total += ($item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount']);
                            $bill  ++;
                            if($item->order_status_id == 10){
                                $billDone ++;;
                            }
                        }
                    }

                    $series[0]['data'][] = $total;
                    $series[1]['data'][] = $bill;
                    $series[2]['data'][] = $billDone;
                    $labels[] = $date->format('d');
                }
                break;
        }
        return [
            'series' => json_encode($series),
            'labels' => json_encode($labels)
        ];
    }

    public function getAllWeeksOfYear() {
        $startDate = Carbon::now()->startOfYear();
        $endDate   = Carbon::now();
        $period    = CarbonPeriod::create($startDate, '1 week', $endDate);
        $weeks     = [];
        $i         = 1;
        foreach ($period as $date) {
            $startOfWeek = $date->copy()->startOfWeek();
            $endOfWeek   = $date->copy()->endOfWeek();
            if ($startOfWeek->lte($endDate)) {
                $weeks[$i++] = [
                    'start' => $startOfWeek,
                    'end' => $endOfWeek
                ];
            }
        }
        
        return $weeks;
    }

    public function getAllMonthsOfYear() {
        $startDate = Carbon::now()->startOfYear();
        $endDate   = Carbon::now();
        $period    = CarbonPeriod::create($startDate, '1 month', $endDate);
        $months    = [];  
        $i         = 1;
        foreach ($period as $date) {
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth   = $date->copy()->endOfMonth();

            if ($startOfMonth->lte($endDate)) {
                $months[$i++] = [
                    'start' => $startOfMonth,
                    'end' => $endOfMonth
                ];
            }
        }
        
        return $months;
    }
}
