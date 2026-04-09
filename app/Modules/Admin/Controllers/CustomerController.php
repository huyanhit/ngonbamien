<?php
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Services\StorageService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class CustomerController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new StorageService());
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
            'title'  => array(
                'title'=> 'Tên',
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'product_category_id'  => array(
                'title'=> 'Loại',
                'width' => 10,
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'
                ),
                'update'=> true,
                'views' => array(
                    'type' => self::SELECT ,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            ),
            'supplier_id'  => array(
                'title'=> 'Nhà cung cấp',
                'width' => 10,
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('suppliers', ['active' => 1], null), 'id', 'title'
                ),
                'update'=> true,
                'views' => array(
                    'type' => self::SELECT ,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            ),
            'producer_id'  => array(
                'title'=> 'Xuất xứ',
                'width' => 10,
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('producers', ['active' => 1], null), 'id', 'title'
                ),
                'update'=> true,
                'views' => array(
                    'type' => self::SELECT ,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            ),
            
        );
	}

    public function index(){
        $this->init($this->view);
        $this->view['data'] = $this->service->generateList($this->view);
        return view('Admin::Products.storage', $this->view);
	}
}
