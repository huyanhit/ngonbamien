<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use Exception;
use DateTime;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Modules\Admin\Models\OrderStatusModel;
use App\Modules\Admin\Models\SOrderModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class SBillService extends Service{
    function __construct(){
        parent::__construct(new SOrderModel());
    }

    public function generateList($data){
        $this->setConditionModel();
        $this->filter($data);
        $this->sort($data);
        if(request()->export_excel){
            return $this->exportExcel();
        }else{
            return $this->paginate($data);
        }
    }

    public function generateReport(){
        $time_query     = '';
        $all            = null;
        $bill_report    = request()->bill_query?? Session::get('bill_report');
        $picker_from    = request()->picker_from?? Session::get('picker_from');
        $picker_to      = request()->picker_to?? Session::get('picker_to');
        $bill_number    = request()->bill_number?? Session::get('bill_number');
        $this->setConditionModel();
        if(request()->bill_query){
            Session::put('bill_report', request()->bill_query);
            Session::put('piker_from', request()->piker_from);
            Session::put('picker_to', request()->picker_to);
            Session::put('bill_number', request()->storage_number);
        }
        switch($bill_report){
             case'1':
                $this->model = $this->model->where('active', 1)->whereBetween('created_at', 
                [Carbon::now()->subDays(1), Carbon::now()]);
                $all = $this->model->get();
                break;
            case'2':
                $this->model = $this->model->where('active', 1)->whereBetween('created_at', 
                [Carbon::now()->subDays(Carbon::now()->dayOfWeek), Carbon::now()]);
                $all = $this->model->get();
                break;
            case'3':
                $this->model = $this->model->where('active', 1)->whereBetween('created_at', 
                [Carbon::now()->startOfMonth(), Carbon::now()]);
                $all = $this->model->get();
                break;
            case'4':
                $this->model = $this->model->where('active', 1)->whereBetween('created_at', 
                [Carbon::now()->startOfYear(), Carbon::now()]);
                $all = $this->model->get();
                break;
            case'5':
                if($picker_from && $picker_to){
                    $this->model = $this->model->where('active', 1)->whereBetween('created_at', 
                    [Carbon::createFromFormat('d/m/Y', $picker_from), Carbon::createFromFormat('d/m/Y', $picker_to)]);
                }
                $all = $this->model->get();
            break;
            case'6':
                $this->model = $this->model->where('active', 1)->where('created_at', '<', Carbon::now()->addDays($bill_number));
                $all = $this->model->get();
            break;
            default:
                $this->model = $this->model->where('active', 1)->whereBetween('created_at', 
                [Carbon::now()->subDays(Carbon::now()->dayOfWeek), Carbon::now()]);
                $all = $this->model->get();
                break;
        }

        for($i=12; $i>0; $i--){
            $order = $all->filter(function($item)use($i){
                return $item['order_status_id'] == $i;
            });
            $sumOrder[$i] = $order->sum(function($item){
                return $item['total'] + $item['ship_price'] - $item['down_price'] - $item['discount'];
            });
            $allOrder[$i] = $order->count();
        }

        switch($bill_report){
            case 1:
                $time_query = 'Hôm nay';
                break;
            case 2:
                $time_query = 'Tuần '.Carbon::now()->weekOfYear;
                break;
            case 3:
                $time_query = 'Tháng '.date('m');
                break;
            case 4:
                $time_query = 'Năm '.date('Y');
                break;
            case 5:
                if($picker_from && $picker_to){
                    $time_query = Carbon::createFromFormat('d/m/Y', $picker_from)->format('d/m').' - '.Carbon::createFromFormat('d/m/Y',$picker_to)->format('d/m');
                }
                break;
            case 6:
                $time_query = $bill_number.' ngày';
                break;
            default:
                $time_query = 'Tuần '.Carbon::now()->weekOfYear;
                break;
        }

        return[
            'all_order'   => $allOrder,
            'sum_order'   => $sumOrder,
            'time_query'  => $time_query,
            'bill_query'  => $bill_report,
            'picker_from' => $picker_from,
            'picker_to'   => $picker_to,
            'bill_number' => $bill_number
        ];
    }

    public function exportExcel(){
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $orders      = $this->model->get();
        $titles = [
            "0"=>"Sản phẩm",
            "1"=>"Các đơn trong ngày",
            "2"=>"Các đơn trong tuần",
            "3"=>"Các đơn trong tháng",
            "4"=>"Các đơn trong năm",
            "5"=>"Các đơn trong khoản " . request()->piker_from .' đến '. request()->picker_to,
            "6"=>"Các đơn trong vòng " . request()->storage_number . " ngày"
        ];
        $query = request()->storage_query;
        $title = $query?$titles[$query]:"Tất cả sản phẩm";
        $sheet->setTitle($title); 
        $sheet
            ->setCellValue('A1', 'Mã đơn hàng')
            ->setCellValue('B1', 'Tên khách hàng')
            ->setCellValue('C1', 'Địa chỉ')
            ->setCellValue('D1', 'Số điện thoại')
            ->setCellValue('E1', 'Đơn giá') 
            ->setCellValue('F1', 'Trang thái đơn')
            ->setCellValue('G1', 'Ngày tạo đơn');

        $j = 2;
       
        foreach ($orders as $key => $order) {
            $sheet->setCellValue("A$j", $order->code); 
            $sheet->setCellValue("B$j", $order->name); 
            $sheet->setCellValue("C$j", $order->address);
            $sheet->setCellValue("D$j", $order->phone);
            $sheet->setCellValue("E$j", $order->total);
            $sheet->setCellValue("F$j", OrderStatusModel::find($order->order_status_id)->title??'');
            $sheet->setCellValue("G$j", $order->created_at);
            $j++;
        }
        
        foreach (range('A', 'G') as $columnId) {
            $sheet->getColumnDimension($columnId)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="bill_order.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    private function setConditionModel(){
        $supplier = Supplier::where(['auth_id'=>Auth::id(), 'active'=>1])->first();
        if(!empty($supplier)){
            $this->model = $this->model->where('supplier_id', $supplier->id);
        }else{
            throw new Exception('không tìm thấy Shop');
        }
    }
}