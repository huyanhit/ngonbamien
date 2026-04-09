<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\BillService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class BillController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new BillService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = [];
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
                    $this->getDataTable('order_statuses', ['active' => 1], null), 'id', 'title'
                ),
                'views' => array(
                    'type' => self::SELECT ,
                ),
                'sort' => [
                    'order' => 'order_status_id',
                    'by' => 'ASC',
                ]
            ),
        );
	}

    public function index(){
        $this->init($this->view);
        $this->view['report'] = $this->service->generateReport();
        $this->view['data']   = $this->service->generateList($this->view);
        return view('Admin::Orders.bill', $this->view);
	}
}
