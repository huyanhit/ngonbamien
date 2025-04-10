<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\PostService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class PostController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new PostService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'   => array('title' => 'Tiều đề', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'content' => array('title' => 'Nội dung', 'type' => self::AREA),

            'image_id' => array('title'=> 'Ảnh chính', 'type' => self::IMAGE_ID, 'group' => 'Hình ảnh'),
            'images'   => array('title'=> 'Ảnh phụ', 'type' => self::IMAGES, 'group' => 'Hình ảnh'),

            'status'    => array(
                'title' => 'Công bố',
                'data'  => array(
                    1 => 'Bản nháp',
                    2 => 'Bản chính thức',
                    3 => 'Theo lịch'
                ),
                'type'   => self::SELECT,
                'column' => 2,
                'group'  => 'Trạng thái'
            ),

            'active'    => array(
                'title' => 'Ẩn hiện',
                'data'  => array(
                    1 => 'Hiển thị',
                    0 => 'Ẩn',
                ),
                'type'   => self::SELECT,
                'column' => 2,
                'group'  => 'Trạng thái'
            ),

            'product_category_id' => array(
                'title'    => 'Loại sản phẩm',
                'data'     => $this->renderSelectByTable(
                    $this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'),
                'type'     => self::SELECT,
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
            'producer_id'  => array(
                'title'    => 'Xuất xứ',
                'data'     => $this->renderSelectByTable(
                    $this->getDataTable('producers', ['active' => 1], null), 'id', 'title'),
                'type'     => self::SELECT,
                'column'   => 2,
                'group'    => 'Danh mục',
            ),

            'meta_title'        => array('title'=> 'Meta title', 'type' => self::TEXT, 'validate' => 'max:1000', 'group' => 'Seo', 'column' => 2),
            'meta_keywords'     => array('title'=> 'Meta keywords', 'type' => self::TEXT, 'validate' => 'max:1000', 'group' => 'Seo', 'column' => 2),
            'meta_description'  => array('title'=> 'Meta description', 'type' => self::TEXT, 'validate' => 'max:1000', 'group' => 'Seo', 'column' => 2),
        );

        $this->view['list'] = array(
            'image_id'  => array(
                'title' => 'Hình Ảnh',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort'     => 'hidden'
            ),
            'title'     => array(
                'title' => 'Tiêu đề',
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
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
            'producer_id'  => array(
                'title'=> 'Xuất xứ',
                'width' => 10,
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('producers', ['active' => 1], null), 'id', 'title'),
                'update'=> true,
                'views' => array(
                    'type' => self::SELECT ,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Active',
                'width' => 7,
                'data'  => array(null => self::CHOOSE , 0 => 'UnActive', 1 => 'Active'),
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter'    => array(
                    'type'  => 'select',
                    'value' => '',
                ),
            )
        );
	}
}
