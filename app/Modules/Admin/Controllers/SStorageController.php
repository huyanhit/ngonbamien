<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\SStorageService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SStorageController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new SStorageService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = [];
        $this->view['list'] = array(
            'image_id' => array(
                'title' => 'Hình Ảnh',
                'width' => 6,
                'update'=> true,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ),
            'sku'  => array(
                'title' => 'Mã hàng hóa',
                'width' => 3,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'supplier_id'  => array(
                'title'=> 'Nhà cung cấp',
                'width' => 10,
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('suppliers', ['active' => 1], null), 'id', 'title'
                ),
                'update'=> false,
                'views' => array(
                    'type' => self::SELECT,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            ),
            'title'  => array(
                'title'=> 'Tên',
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'stock'  => array(
                'title'=> 'Số lượng',
                'width' => 10,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            
            'date_in'  => array(
                'title'=> 'Ngày nhập',
                'width' => 10,
                'views' => array(
                    'type' => self::DATE,
                ),
            ),
            'date_ex'  => array(
                'title'=> 'Ngày hết hạn',
                'width' => 10,
                'views' => array(
                    'type' => self::DATE,
                ),
            ),
        );
	}

    public function index(){
        $this->init($this->view);
        $this->view['query']  = $this->service->storeQuery();
        $this->view['data']   = $this->service->generateList($this->view);
        $this->view['report'] = $this->service->generateReport();
        return view('Admin::Products.storage', $this->view);
	}
}
