<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\SliderService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SliderController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new SliderService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'       => array('title'=> 'Tiêu đề', 'type' => self::TEXT),
            'description' => array('title'=> 'Mô tả', 'type' => self::TEXT),
            'url'         => array('title'=> 'Đường dân', 'type' => self::TEXT),
            'image_id'    => array('title'=> 'Hình ảnh', 'type' => self::IMAGE_ID, 'group' => 'Hình ảnh'),
            'active'      => array('title'=> 'Trang thái', 'type' => self::CHECK, 'column' => 2, 'group' => 'Công bố'),
            'index'       => array('title'=> 'Thứ tự hiển thị', 'type' => self::TEXT, 'column' => 2, 'group' => 'Công bố'),
            'type' => array(
                'title' => 'Danh mục',
                'data'  => array(
                    1 => 'Trang Home',
                    2 => 'Trang Bài Viết',
                    3 => 'Trang Cửa hàng'
                ),
                'type'     => self::SELECT,
                'column'   => 2,
                'group'    => 'Danh mục',
            ),
        );
        $this->view['list'] = array(
            'image_id' => array(
                'title' => 'Hình Ảnh',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ),
            'title' => array(
                'title' => 'Tiêu đề',
                'width' => 10,
                'update'=> true,
                'views'  => array(
                    'type' => self::TEXT,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'url' => array(
                'title' => 'Đường dân',
                'width' => 10,
                'update'=> true,
                'views'  => array(
                    'type' => self::TEXT,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'index' => array(
                'title'=> 'Thứ tự hiển thị',
                'width' => 3,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Active',
                'width' => 7,
                'update'=> true,
                'data'  => array(null => self::CHOOSE , 0 => 'Không hiển thị', 1 => 'Hiển thị'),
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
