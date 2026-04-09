<?php
namespace App\Modules\Admin\Controllers;

use App\Models\Supplier;
use App\Modules\Admin\Models\SOrderModel;
use App\Modules\Admin\Models\SupplierModel;
use App\Modules\Admin\Requests\SUpdatePaymentRequest;
use App\Modules\Admin\Services\SupplierOrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SOrderController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new SupplierOrderService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'order_status_id' => array(
                'title'=> 'Trạng thái hiện tại',
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1, 'type'=> 2], null), 'id', 'title'
                ),
                'type' => self::SELECT,
                'validate' => ['required', function ($attribute, $value, $fail) {
                    $order = $this->service->model->find(request()->route('order'));
                    if ($order->order_status_id > $value) {
                        return $fail('Trạng thái chọn phải không được quay lại trạng thái trước đó.');
                    }
                }],
                'group' => 'Trạng thái đơn hàng', 
                'column' => 2
            ),
            'supplier_order_status' => array(
                'title'=> 'Trạng thái đơn hàng', 'type' => self::HAS_MANY,
                'form' => [
                    'order_status_id' => array(
                         'title'=> 'Trạng thái',
                         'data' => $this->renderSelectByTable($this->getDataTable('order_statuses', ['active' => 1, 'type'=> 2], null), 'id', 'title'),
                         'type' => self::SELECT,
                         'validate' => 'required',
                    ),
                    'note' => array('title'=> 'Mô tả', 'type' => self::AREA, 'validate' => 'max:255'),
                ],  'group' => 'Cập nhật trạng thái', 'column' => 1
            ),
        );
        $this->view['list'] = array(
            'code' => array(
                'width' => 3,
                'title'=> 'Mã đơn hàng',
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'name' => array(
                'width' => 3,
                'title'=> 'Tên khách hàng',
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'address' => array(
                'width' => 5,
                'title'=> 'Địa chỉ',
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'phone' => array(
                'width' => 3,
                'title'=> 'Số điện thoại',
                'views' => array(
                    'type' => self::PHONE,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'total' => array(
                'width' => 3,
                'title'=> 'Đơn giá',
                'views' => array(
                    'type' => self::PRICE,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'order_status_id' => array(
                'title'  => 'Trang thái đơn',
                'width'  => 3,
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1], null), 'id', 'title'
                ),
                'views' => array(
                    'type' => self::SELECT ,
                ),
            ),
            'created_at' => array(
                'width' => 2,
                'title'=> 'Ngày tạo',
                'views' => array(
                    'type' => self::DATE,
                ),
                'sort' => [
                    'order' => 'created_at',
                    'by' => 'DESC',
                ]
            ),
        );
        $this->view['list_option'] = array(
            'hide_action' => ['create', 'clone']
        );
	}
    
    public function detail($id){
        $this->setConditionModel();
        $supplier = null;
        $order    = $this->service->model->find($id);
        if($order->supplier_id){
             $supplier = SupplierModel::find($order->supplier_id);
        }
        if(!empty($order)){
            return view('Admin::Orders.detail', ['order' => $order, 'supplier' => $supplier]);
        }else{
            return redirect('404');
        }
    }

    public function invoice($id){
        $this->setConditionModel();
        $supplier = null;
        $order    = $this->service->model->find($id);
        if($order->supplier_id){
             $supplier = SupplierModel::find($order->supplier_id);
        }
        if(!empty($order)){
            return view('Admin::Orders.invoice', ['order' => $order, 'supplier' => $supplier]);}
        else{
            return redirect('404');
        }
    }

    public function index(){
        $this->setConditionModel();
        return parent::index();
    }

    public function show($id){
        $this->setConditionModel();
        return parent::show($id);
    }

    public function edit($id){
        $this->setConditionModel();
        return parent::edit($id);
    }

    public function update($id){
        $this->setConditionModel();
        return parent::update($id);
    }

    public function destroy($ids){
        $this->setConditionModel();
        return parent::destroy($ids);
    }

    public function getField($field, $id){
        $this->setConditionModel();
        return parent::getField($$field, $id);
    }

    private function setConditionModel(){
        $supplier = Supplier::where('auth_id', Auth::id())->first();
        if(!empty($supplier)){
            $this->service->model = $this->service->model->where('supplier_id', $supplier->id);
        }else{
            throw new Exception('shop not found');
        }
    }

    public function payment(){
        $order = $this->service->getPayment();
        if(!empty($order)){
            return view('Admin::Orders.spayment', ['order' => $order]);
        }else{
            return redirect('404');
        }
    }

    public function updatePayment(SUpdatePaymentRequest $request){
        $sOrderIds   = $request->get('order_ids');
        $supllierId  = $request->get('shop_id');
        $paymentInfo = $request->get('upload_payment');
            
        $update = SOrderModel::where(['done' => 0, 'supplier_id' => $supllierId])
        ->whereIn('id', json_decode($sOrderIds))
        ->update(['done' => 1, 'pay_file' => $paymentInfo]);

        if($update){
            return redirect(route('order-payment'))->with('message_update', 'Cập nhật thành công!');
        }else{
            return redirect(route('order-payment'))->with('message_error', 'Cập nhật thát bại!');
        }
    }
}
