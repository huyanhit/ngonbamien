<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use DateTime;
use App\Modules\Admin\Models\ProductModel;
use App\Modules\Admin\Models\SOrderModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SStorageService extends Service{
    function __construct(){
        parent::__construct(new ProductModel());
    }

     public function generateList($data){
        $this->setConditionModel();
        $this->filter($data);
        $this->sort($data);
        $this->model->select(['products.*', 
            DB::raw('CONCAT(products.title," ",product_option.title) AS title'), 
            'product_option.stock', 
            'product_option.price_root',
            'product_option.date_ex',
            'product_option.date_in'
        ]);
        $this->model->join('product_option','product_option.product_id','=', 'products.id');
        if(request()->export_excel){
            return $this->exportExcel();
        }else{
            return $this->paginate($data);
        }
    }

    public function generateReport(){
        $allProducts   = ProductModel::join('product_option','product_option.product_id','=', 'products.id')->where('active', 1)
        ->where('auth_id', Auth::id())->where('active', 1)->get();
        $sumStProducts = $allProducts->sum(function($item){
            return $item['stock'];
        });
        $sumPriceRoot = $allProducts->sum(function($item){
            return $item['stock'] * $item['price_root'];
        });
        $productStock = $allProducts->filter(function ($product) {
            return $product->stock < 10;
        });
        $sumProductStock = $allProducts->sum(function ($product) {
            return ($product->stock < 10)? $product->stock: 0;
        });

        $productEx = $allProducts->filter(function ($product) {
            if($product->date_ex){
                return Carbon::parse($product->date_ex) < Carbon::now()->addDays(10);
            }
            return false;
        });
        $sumProductEx = $allProducts->sum(function ($product) {
            if($product->date_ex){
                return (Carbon::parse($product->date_ex) < Carbon::now()->addDays(10))?$product->stock :0;
            }
        });

        $productExportWeek = SOrderModel::whereBetween('created_at', 
            [Carbon::now()->subDays(Carbon::now()->dayOfWeek), Carbon::now()])->get()->sum(function($item){
            return $item->products->sum(function($item){
                return $item->pivot->quantity;
            });
        });
        $productExportMonth = SOrderModel::whereBetween('created_at', 
            [Carbon::now()->startOfMonth(), Carbon::now()])->get()->sum(function($item){
            return $item->products->sum(function($item){
                return $item->pivot->quantity;
            });
        });
        $productExportYear  = SOrderModel::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()])->get()->sum(function($item){
            return $item->products->sum(function($item){
                return $item->pivot->quantity;
            });
        });

        return [
            'product_total'  => $allProducts->count(),
            'product_sum_st' => $sumStProducts,
            'product_sum_pr' => $sumPriceRoot,
            'product_stock'  => $productStock->count(),
            'sum_product_stock' => $sumProductStock,
            'product_ex'        => $productEx->count(),
            'sum_product_ex'    => $sumProductEx,
            'product_export_week'  => $productExportWeek,
            'product_export_month' => $productExportMonth,
            'product_export_year'  => $productExportYear,
            'supplier_count'       => 0,
        ];
    }

    public function storeQuery(){
        $query['storage_report'] = request()->storage_query?? Session::get('storage_report');
        $query['picker_from']    = request()->picker_from?? Session::get('storage_report_picker_from');
        $query['picker_to']      = request()->picker_to?? Session::get('storage_report_picker_to');
        $query['storage_number'] = request()->storage_number?? Session::get('storage_report_storage_number');
        if(request()->storage_query){
            Session::put('storage_report', request()->storage_query);
            Session::put('storage_report_picker_from', request()->picker_from);
            Session::put('storage_report_picker_to', request()->picker_to);
            Session::put('storage_report_storage_number', request()->storage_number);
        }
        if($query){
            switch($query['storage_report']){
                case '1':
                    if($query['picker_from'] && $query['picker_to']){
                        $this->model = $this->model->whereBetween('product_option.date_in', 
                        [Carbon::createFromFormat('d/m/Y', $query['picker_from']), Carbon::createFromFormat('d/m/Y', $query['picker_to'])]);
                    }
                break;
                case '2':
                    if($query['picker_from'] && $query['picker_to']){
                        $ids = SOrderModel::whereBetween('created_at',
                        [Carbon::createFromFormat('d/m/Y',$query['picker_from']), Carbon::createFromFormat('d/m/Y',$query['picker_to'])])->get()->pluck('id');
                        $this->model = $this->model->whereIn('products.id', $ids);
                    }
                break;
                case '3':
                    $this->model = $this->model->where('product_option.date_ex', '<', Carbon::now()->addDays($query['storage_number']));
                break;
                case '4':
                    $this->model = $this->model->where('product_option.stock','<', $query['storage_number']);
                break;
                case '5':
                    $this->model = $this->model->where('product_option.discount', '>', 0);
                break;
                case '6':
                    $this->model = $this->model->whereNull('product_option.price');
                break;
            }
        }

        return $query;
    }

    public function exportExcel(){
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $products    = $this->model->get();

        $query['storage_report'] = request()->storage_query?? Session::get('storage_report');
        $query['picker_from']     = request()->picker_from?? Session::get('storage_report_picker_from');
        $query['picker_to']      = request()->picker_to?? Session::get('storage_report_picker_to');
        $query['storage_number'] = request()->storage_number?? Session::get('storage_report_storage_number');
        $titles = [
            "0"=>"Sản phẩm",
            "1"=>"Nhập kho". $query['picker_from'] .' đến '. $query['picker_to'],
            "2"=>"Xuất kho". $query['picker_from'] .' đến '. $query['picker_to'],
            "3"=>"Quá hạn sau ".$query['storage_number']." ngày",
            "4"=>"Sắp hết hàng dưới ".$query['storage_number']." sản phẩm",
            "5"=>"Sản phẩm đang giảm giá",
            "6"=>"Sản phẩm chưa niêm yết giá"
        ];
        
        $title = $query['storage_report']?$titles[$query['storage_report']]:"Tất cả sản phẩm";
        $sheet->setTitle($title); 
        $sheet->setCellValue('A1', 'Tên sản phẩm')
            ->setCellValue('B1', 'Mã SP')
            ->setCellValue('C1', 'Số lượng')
            ->setCellValue('D1', 'Giá nhập')
            ->setCellValue('E1', 'Ngày nhập') 
            ->setCellValue('F1', 'Ngày hết hạn');

        $j = 2;
       
        foreach ($products as $key => $product) {
            $sheet->setCellValue("A$j", $product->title); 
            $sheet->setCellValue("B$j", $product->sku); 
            $sheet->setCellValue("C$j", $product->stock);
            $sheet->setCellValue("D$j", $product->price_root);
            $sheet->setCellValue("E$j", $product->date_in);
            $sheet->setCellValue("F$j", $product->date_ex);
            $j++;
        }
        
        foreach (range('A', 'F') as $columnId) {
            $sheet->getColumnDimension($columnId)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="storage_product.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    private function setConditionModel(){
        $this->model = $this->model->where('auth_id', Auth::id());
    }
}