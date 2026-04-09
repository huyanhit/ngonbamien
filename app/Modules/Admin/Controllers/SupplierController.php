<?php
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Services\SupplierService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SupplierController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new SupplierService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'       => array('title'=> 'Tên cửa hàng', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'slug'        => array('title'=> 'Đường dẫn', 'type' => self::SLUG, 'validate' => 'required|max:255'),
            'description' => array('title'=> 'Mô tả ngắn', 'type' => self::AREA),
            'content'     => array('title'=> 'Nội dung', 'type' => self::AREA),

            'warehouse' => array('title'=> 'Địa chỉ kho vận', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin của hàng'),
            'phone'     => array('title'=> 'Điện thoại', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin của hàng'),
            'address'   => array('title'=> 'Địa chỉ', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin của hàng'),
            'tax_code'  => array('title'=> 'Mã số thuế', 'type' => self::TEXT, 'validate' => 'max:50', 'group'=>'Thông tin của hàng'),

            'meta_title'        => array('title'=> 'Meta title', 'type' => self::TEXT, 'validate' => 'max:1000', 'group' => 'Seo'),
            'meta_keywords'     => array('title'=> 'Meta keywords', 'type' => self::TEXT, 'validate' => 'max:1000', 'group' => 'Seo'),
            'meta_description'  => array('title'=> 'Meta description', 'type' => self::TEXT, 'validate' => 'max:1000', 'group' => 'Seo'),

            'bank'        => array('title'=> 'Ngân hàng', 'type' => self::TEXT, 'validate' => 'max:50', 'column' => 2, 'group'=>'Thông tin tài khoản'),
            'bank_name'   => array('title'=> 'Tên chủ tài khoản', 'type' => self::TEXT, 'validate' => 'max:50','column' => 2, 'group'=>'Thông tin tài khoản'),
            'bank_number' => array('title'=> 'Số tài khoản', 'type' => self::TEXT, 'validate' => 'max:50','column' => 2, 'group'=>'Thông tin tài khoản'),

            'supplier_ship' => array(
                'title'=> 'Thêm loại shipping', 'type' => self::HAS_MANY,
                'form' => [
                    'ship_id' => array(
                        'title'=> 'Chọn cách giao hàng',
                        'data' => array(1 => 'Giao nhanh', 2 => 'Giao tiết kiệm'),
                        'type' => self::SELECT,
                        'validate' => 'required',
                    ),
                    'fee' => array('title'=> 'Phí giao hàng', 'type' => self::TEXT, 'validate' => 'numeric|max:25'),
                ],  'group' => 'Thông tin shipping', 'column' => 2
            ),

            'supplier_support' => array(
                'title'=> 'Thêm hổ trợ', 'type' => self::HAS_MANY,
                'form' => [
                    'support_id' => array(
                        'title'=> 'Chọn loại hổ trợ',
                        'data' => array(1 => 'Giao hàng miễn phí đơn hàng từ Mức 1', 2 => 'Giảm Mức 1 cho đơn hàng từ Mức 2'),
                        'type' => self::SELECT,
                        'validate' => 'required',
                    ),
                    'value_1' => array('title'=> 'Mức 1', 'type' => self::TEXT, 'validate' => 'numeric|max:25'),
                    'value_2' => array('title'=> 'Mức 2', 'type' => self::TEXT, 'validate' => 'numeric|max:25'),
                ],  'group' => 'Thông tin support', 'column' => 2
            ),

            'icon'     => array('title'=> 'Icon', 'type' => self::IMAGE_ID, 'column' => 2, 'group' => 'Hình ảnh'),
            'image_id' => array('title'=> 'Ảnh chính', 'type' => self::IMAGE_ID, 'column' => 2, 'group' => 'Hình ảnh'),
            'images'   => array('title'=> 'Slider', 'type' => self::IMAGES, 'column' => 2,'group' => 'Hình ảnh'),

            'index'    => array('title'=> 'Thứ tự', 'type' => self::NUMBER, 'column' => 2 , 'group' => 'Công bố'),
            'active'   => array('title'=> 'Trạng thái', 'type' => 'check', 'column' => 2, 'group' => 'Công bố'),
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
            'title' => array(
                'title'=> 'Tiều đề',
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'active' => array(
                'title' => 'Trạng thái',
                'width' => 7,
                'update'=> true,
                'data'  => array(null => self::CHOOSE , 0 => 'UnActive', 1 => 'Active'),
                'views' => array(
                    'type' => self::CHECK,
                ),
                'filter' => array(
                    'type' => 'select',
                    'value' => '',
                ),
            )
        );
	}
}
