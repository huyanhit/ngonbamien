<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\SOrderModel;
use App\Modules\Admin\Requests\ConfirmPaymentRequest;
use App\Modules\Admin\Requests\UpdatePaymentRequest;
use App\Modules\Admin\Services\OrderService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class OrderController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new OrderService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'name' => array('title'=> 'Tên khách', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'phone' => array('title'=> 'Điện thoại khách', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'address' => array('title'=> 'Địa chỉ giao hàng ', 'type' => self::TEXT, 'validate' => 'required|max:1000'),
            'order_status_id' => array(
                'title'=> 'Trạng thái đơn hàng hiện tại',
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1, 'type'=> 1], null), 'id', 'title'
                ),
                'type' => self::SELECT,
                'validate' => ['required', function ($attribute, $value, $fail) {
                    $order = $this->service->model->find(request()->route('order'));
                    if ($order->order_status_id > $value) {
                        return $fail('Trạng thái đơn hàng chọn phải theo trình tự quy định.');
                    }
                }],
                'group' => 'Trạng thái đơn hàng', 
                'column' => 1
            ),
            'order_order_status' => array(
                'title'=> 'Cập nhật trạng thái đơn hàng', 'type' => self::HAS_MANY,
                'form' => [
                    'order_status_id' => array(
                         'title'=> 'Trạng thái',
                         'data' => $this->renderSelectByTable($this->getDataTable('order_statuses', ['active' => 1, 'type'=> 1], null), 'id', 'title'),
                         'type' => self::SELECT,
                         'validate' => 'required',
                    ),
                    'note' => array('title'=> 'Mô tả', 'type' => self::AREA, 'validate' => 'required|max:255'),
                ],  'group' => 'Trạng thái đơn hàng', 'column' => 1
            ),
            'payment' => array('title'=> 'Thanh toán',
                'data'=> array(1 => 'Thu tiền khi giao', 2 => 'Thanh toán qua QR', 3 => 'Thanh toán qua Ngân hàng'), 
                'type' =>  self::SELECT, 'group' => 'Giao hàng', 'column' => 2
            ),
            'note' => array('title'=> 'Ghi chú', 'type' => self::AREA, 'validate' => 'required', 'group' => 'Giao hàng', 'column' => 2), 
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
                'update' => true,
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1, 'type'=> 1], null), 'id', 'title'
                ),
                'views' => array(
                    'type' => self::SELECT,
                ),
            ),
            'created_at' => array(
                'width' => 3,
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
	}
    
    public function detail($id){
        $order = $this->service->model->find($id);
        if(!empty($order)){
            return view('Admin::Orders.detail', ['order' => $order]);
        }else{
            return redirect('404');
        }
    }

    public function invoice($id){
        $order = $this->service->model->find($id);
        if(!empty($order)){
            return view('Admin::Orders.invoice', ['order' => $order]);
        }else{
            return redirect('404');
        }
    }

    public function payment(){
        $order = $this->service->getPayment();
        if(!empty($order)){
            return view('Admin::Orders.payment', ['order' => $order]);
        }else{
            return redirect('404');
        }
    }

    public function updatePayment(UpdatePaymentRequest $request){
        $sOrderIds   = $request->get('order_ids');
        $supllier_id = $request->get('shop_id');
        $filePath    = $this->service->upload($request->file('upload_payment'));
            
        $update = SOrderModel::where(['done' => 0, 'supplier_id' => $supllier_id])
        ->whereIn('id', json_decode($sOrderIds))
        ->update(['done' => 2,'pay_file' => $filePath]);

        if($update){
            return redirect(route('orders-payment'))->with('message_update', 'Cập nhật thành công!');
        }else{
            return redirect(route('orders-payment'))->with('message_error', 'Cập nhật that bại!');
        }
    }

    public function confirmPayment(ConfirmPaymentRequest $request){
        $sOrderIds   = $request->get('conf_ids');
        $supllier_id = $request->get('shop_id');
        $update = SOrderModel::where(['done' => 1, 'supplier_id' => $supllier_id])
        ->whereIn('id', json_decode($sOrderIds))
        ->update(['done' => 2]);
        if($update){
            return redirect(route('orders-payment'))->with('message_update', 'Cập nhật thành công!');
        }else{
            return redirect(route('orders-payment'))->with('message_error', 'Cập nhật thát bại!');
        }
    }
    
}
