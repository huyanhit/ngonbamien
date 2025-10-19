<?php
namespace App\Modules\Admin\Controllers;

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
            'address' => array('title'=> 'Địa chỉ giao hàng', 'type' => self::TEXT, 'validate' => 'required|max:1000'),
            'ship_type' => array('title'=> 'Cách giao hàng',
                'data'=> array(1 => 'Giao nhanh', 2 => 'Giao tiết kiệm', 3 => 'Giao trong ngày', 4 => 'Giao thứ 7, CN'), 'type' =>  self::SELECT
            ),
            'order_status_id' => array(
                'title'=> 'Trang thái đơn hàng',
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1], null), 'id', 'title'
                ),
                'type' => self::SELECT,
                'validate' => 'required'
            ),
            'payment' => array('title'=> 'Thanh toán',
                'data'=> array(1 => 'Thu tiền khi giao', 2 => 'Thanh toán qua QR', 3 => 'Thanh toán qua Ngân hàng'), 'type' =>  self::SELECT
            ),
            'note' => array('title'=> 'Ghi chú', 'type' => self::AREA, 'validate' => 'required'),
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
}
