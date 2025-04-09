<?php
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Services\ProductService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class ProductController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new ProductService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'sku'          => array('title'=> 'Mã sản phẩm', 'type' => self::TEXT, 'validate' => 'max:50'),
            'title'        => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'description'  => array('title'=> 'Thông số kỹ thuật', 'type' => self::TEXT, 'validate' => 'max:255'),
            'content'      => array('title'=> 'Mo tả sản phẩm', 'type' => self::AREA),

            'image_id'     => array('title'=> 'Ảnh chính', 'type' => self::IMAGE_ID, 'group' => 'Hình ảnh sản phẩm'),
            'images'       => array('title'=> 'Ảnh phụ', 'type' => self::IMAGES, 'group' => 'Hình ảnh sản phẩm'),

            'meta_title'        => array('title'=> 'Meta title', 'type' => self::TEXT, 'validate' => 'max:50', 'group' => 'Seo'),
            'meta_keywords'     => array('title'=> 'Meta keywords', 'type' => self::TEXT, 'validate' => 'max:255', 'group' => 'Seo'),
            'meta_description'  => array('title'=> 'Meta description', 'type' => self::TEXT, 'validate' => 'max:255', 'group' => 'Seo'),

            'status'       => array(
                'title'=> 'Công bố',
                'data'=> array(
                    1 => 'Bản nháp',
                    2 => 'Bản chính thức',
                    3 => 'Theo lịch'
                ),
                'type' => self::SELECT,
                'column' => 2,
                'group' => 'Trạng thái'
            ),
            'active'       => array(
                'title'=> 'Ẩn hiện',
                'data'=> array(
                    1 => 'Hiển thị',
                    0 => 'Ẩn',
                ),
                'type' => self::SELECT,
                'column' => 2,
                'group' => 'Trạng thái'
            ),
            'product_category_id' => array(
                'title'    => 'Loại sản phẩm',
                'data'     => $this->renderSelectByTable(
                    $this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'),
                'type'     => self::SELECT,
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
            'producer_id' => array(
                'title'=> 'Xuất xứ',
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('producers', ['active' => 1], null), 'id', 'title'),
                'type' => self::SELECT,
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
            'product_option' => array('title'=> '', 'type' => self::HAS_MANY,
                 'form' => [
                     'option_price_id' => array(
                         'title'=> 'Phân loại',
                         'data'=> array(1 => 'Trọng lượng, Kích thước, Loại hàng', 2 => 'Hình ảnh',  3 => 'Màu sắc'),
                         'type' => self::SELECT,
                         'validate' => 'required',
                     ),
                     'title'      => array('title'=> 'Mô tả', 'type' => self::TEXT, 'validate' => 'required|max:255'),
                     'price_root' => array('title'=> 'Giá nhập', 'type' => self::NUMBER, 'validate' => 'nullable|numeric', 'placeholder'=>'VND'),
                     'price'      => array('title'=> 'Giá bán', 'type' => self::NUMBER, 'validate' => 'nullable|numeric', 'placeholder'=>'VND'),
                     'stock'      => array('title'=> 'Số lượng', 'type' => self::NUMBER, 'validate' => 'nullable|numeric', 'placeholder'=>'0'),
                     'discount'   => array('title'=> 'Giảm giá', 'type' => self::NUMBER, 'validate' => 'nullable|numeric', 'placeholder'=>'%')
                 ], 'column' => 2, 'group' => 'Phân loại hàng hóa'
            ),
            'is_new'       => array('title'=> 'Sản phẩm mới', 'type' => self::CHECK, 'validate' => 'numeric|max:1', 'column' => 2, 'group' => 'Loại'),
            'is_promotion' => array('title'=> 'Khuyến mãi', 'type' => self::CHECK, 'validate' => 'numeric|max:1', 'column' => 2, 'group' => 'Loại'),
            'is_hot'       => array('title'=> 'Bán chạy', 'type' => self::CHECK, 'validate' => 'numeric|max:1', 'column' => 2, 'group' => 'Loại'),
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
                    $this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'),
                'update'=> true,
                'views' => array(
                    'type' => self::SELECT ,
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
            'is_new'  => array(
                'title'=> 'Mới',
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'is_promotion'  => array(
                'title'=> 'Khuyến mãi',
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'is_hot'  => array(
                'title'=> 'Bán chạy',
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK,
                ),
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Hiển thị',
                'width' => 5,
                'update'=> true,
                'data' => array(null => self::CHOOSE , 0 => 'Ẩn', 1 => 'Hiển thị'),
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
}
