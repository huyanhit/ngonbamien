<?php
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SProductController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new ProductService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'sku'          => array('title'=> 'Mã sản phẩm', 'type' => self::TEXT, 'validate' => 'required|unique:products,sku,:id|max:50'),
            'title'        => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'slug'         => array('title'=> 'Link sản phẩm', 'type' => self::SLUG, 'reference' => "title", 'prefix' => route('san-pham',''), 
                                    'validate' => 'required|unique:products,slug,:id|max:255|min:6'),
            'description'  => array('title'=> 'Mô tả ngắn', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'content'      => array('title'=> 'Nội dung chi tiết', 'type' => self::AREA),
            'make'         => array('title'=> 'Nội dung cách chế biến', 'type' => self::AREA),

            'image_id'     => array('title'=> 'Ảnh chính', 'type' => self::IMAGE_ID, 'group' => 'Hình ảnh sản phẩm'),
            'images'       => array('title'=> 'Ảnh phụ (chọn nhiều ảnh)', 'type' => self::IMAGES, 'group' => 'Hình ảnh sản phẩm'),

            'meta_title'        => array('title'=> 'Meta title', 'type' => self::TEXT, 'validate' => 'max:50', 'group' => 'Seo'),
            'meta_keywords'     => array('title'=> 'Meta keywords', 'type' => self::TEXT, 'validate' => 'max:255', 'group' => 'Seo'),
            'meta_description'  => array('title'=> 'Meta description', 'type' => self::TEXT, 'validate' => 'max:255', 'group' => 'Seo'),

            'status'       => array(
                'title'=> 'Trạng thái bán',
                'data'=> array(
                    1 => 'Liên hệ',
                    2 => 'Chính thức',
                    3 => 'Theo lịch'
                ),
                'type' => self::SELECT,
                'validate' => 'required|numeric',
                'column' => 2,
                'group' => 'Trạng thái', 
            ),
            'active'       => array(
                'title'=> 'Ẩn hiện',
                'data'=> array(
                    1 => 'Hiển thị',
                    0 => 'Ẩn',
                ),
                'type' => self::SELECT,
                'validate' => 'required|numeric',
                'column' => 2,
                'group' => 'Trạng thái'
            ),
            'product_category_id' => array(
                'title'    => 'Loại sản phẩm',
                'data'     => $this->renderSelectByTable(
                    $this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title', false
                ),
                'type'     => self::SELECTS,
                'validate' => 'required',
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
            'producer_id' => array(
                'title'=> 'Xuất xứ',
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('producers', ['active' => 1], null), 'id', 'title'
                ),
                'type' => self::SELECT,
                'validate' => 'required|numeric',
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
            'auth_id'  => array(
                'title'    => 'Nguời tạo',
                'type'     => self::AUTH,
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
            'product_option' => array('title'=> '', 'type' => self::HAS_MANY,
                'form' => [
                    // 'option_price_id' => array(
                    //     'title'=> 'Phân loại',
                    //     'data' => array(1 => 'Trọng lượng, Kích thước, Loại hàng', 2 => 'Hình ảnh',  3 => 'Màu sắc'),
                    //     'type' => self::SELECT,
                    //     'validate' => 'required',
                    // ),
                    'title'      => array('title'=> 'Mô tả', 'type' => self::TEXT, 'validate' => 'required|max:255'),
                    'price_root' => array('title'=> 'Giá nhập', 'type' => self::PRICE, 'validate' => 'required|numeric', 'placeholder'=>'VND'),
                    'price'      => array('title'=> 'Giá bán', 'type' => self::PRICE, 'validate' => 'nullable|numeric', 'placeholder'=>'VND'),
                    'stock'      => array('title'=> 'Số lượng', 'type' => self::NUMBER, 'validate' => 'nullable|numeric', 'placeholder'=>'Sản phẩm'),
                    'discount'   => array('title'=> 'Giảm giá', 'type' => self::NUMBER, 'validate' => 'nullable|numeric', 'placeholder'=>'%'),
                    'date_in'    => array('title'=> 'Ngày nhập', 'type' => self::DATE, 'validate' => 'nullable', 'placeholder'=>'dd/mm/yy'),
                    'date_ex'    => array('title'=> 'Ngày hết hạn', 'type' => self::DATE, 'validate' => 'nullable', 'placeholder'=>'dd/mm/yy')
                ],  'column'     => 2, 'group' => 'Phân loại hàng hóa'
            ),
        );
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
            'product_category_id'  => array(
                'title'=> 'Loại',
                'width' => 10,
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'
                ),
                'update'=> true,
                'views' => array(
                    'type' => self::SELECTS,
                ),
                'filter' => array(
                    'type' => self::SELECTS,
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
            'active' => array(
                'title' => 'Hiển thị',
                'width' => 5,
                'update'=> true,
                'data'  => array(null => self::CHOOSE , 0 => 'Ẩn', 1 => 'Hiển thị'),
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => 'select',
                    'value' => '',
                ),
            )
        );
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
        $this->service->model = $this->service->model->where('auth_id', Auth::id());
    }
}
