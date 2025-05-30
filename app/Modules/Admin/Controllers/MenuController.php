<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\MenuService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class MenuController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new MenuService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'  => array('title'=> 'Tiêu đề', 'type' => self::TEXT, 'validate' => 'required'),
            'router' => array('title'=> 'Đường dẫn', 'type' => self::TEXT, 'validate' => 'required'),
            'index'  => array(
                'title'  => 'Thứ tự',
                'type'   => self::TEXT,
                'column' => 2,
                'group'  => 'Công bố'
            ),
            'type'       => array(
                'title'  => 'Loai menu',
                'type'   => self::SELECT,
                'data'   => array(null => self::CHOOSE , 0 => 'Menu trên', 1 => 'Menu dưới'),
                'column' => 1,
                'group'  => 'Danh mục',
            ),
            'parent_id'  => array(
                'title'  => 'Menu Cha',
                'data'   => $this->renderSelectByTable(
                    $this->getDataTable('menus', ['active' => 1], null), 'id', 'title'
                ),
                'type'   => self::SELECT,
                'column' => 1,
                'group'  => 'Danh mục'
            ),
            'active' => array(
                'title'  => 'Trang thái',
                'type'   => self::CHECK,
                'column' => 2,
                'group'  => 'Công bố'
            ),
            'icon'       => array(
                'title'  => 'Icon',
                'type'   => self::TEXT,
                'column' => 2,
                'group'  => 'Hình ảnh'
            ),
        );

        $this->view['list'] = array(
            'title'  => array(
                'title'=> 'Tiêu đề',
                'width' => 3,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'router' => array(
                'title' => 'Đường dẫn',
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
            'parent_id' => array(
                'title' => 'Menu Cha',
                'width' => 6,
                'data'  => $this->renderSelectByTable($this->getDataTable('menus', ['active' => 1], null), 'id', 'title'),
                'views' => array(
                    'type' => self::SELECT,
                ),
                'sort' => 'hidden'
            ),
            'index' => array(
                'title' => 'Thứ tự',
                'width' => 6,
                'update'=> true,
                'views' => array(
                    'type' => self::TEXT,
                ),
                'sort' => 'hidden'
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
