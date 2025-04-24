<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\SiteService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SiteController extends MyController
{
    function __construct(Request $request)
	{
        parent::__construct($request, new SiteService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'logo'       => array('title'=> 'Logo', 'type' => self::IMAGE_ID),
            'slogan'     => array('title'=> 'Slogan', 'type' => self::TEXT),
            'hotline'    => array('title'=> 'Hotline', 'type' => self::TEXT, 'validate' => 'max:50'),
            'address'    => array('title'=> 'Địa chỉ', 'type' => self::TEXT, 'validate' => 'max:255'),
            'email'      => array('title'=> 'Email', 'type' => self::TEXT, 'validate' => 'max:50'),

            'company'   => array('title'=> 'Tên công ty', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin công ty'),
            'warehouse' => array('title'=> 'Kho vận', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin công ty'),
            'phone'     => array('title'=> 'Điện thoại', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin công ty'),
            'other'     => array('title'=> 'Thông tin khác', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Thông tin công ty'),

            'meta_title'       => array('title'=> 'Site title', 'type' => self::TEXT, 'group'=>'Seo'),
            'meta_keyword'     => array('title'=> 'Từ khóa Seo', 'type' => self::TEXT, 'group'=>'Seo'),
            'meta_description' => array('title'=> 'Mô tả Seo', 'type' => self::TEXT, 'group'=>'Seo'),

            'maintenance'      => array('title'=> 'Bật tình trạng bảo trì', 'type' => self::CHECK, 'group'=>'Bảo trì', 'column' => 2),

            'link_facebook' => array('title'=> 'Link facebook', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Fan page', 'column' => 2),
            'link_youtube'  => array('title'=> 'Link youtube', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Fan page', 'column' => 2),
            'link_tiktok'   => array('title'=> 'Link tiktok', 'type' => self::TEXT, 'validate' => 'max:255', 'group'=>'Fan page', 'column' => 2),

            'fan_page'  => array('title'=> 'Facebook', 'type' => self::TEXT, 'validate' => 'max:4000', 'group'=>'Link', 'column' => 2),
            'map'      => array('title'=> 'Google map', 'type' => self::TEXT, 'validate' => 'max:4000', 'group'=>'Link', 'column' => 2),

            'analytic' => array('title'=> 'Google analytic id', 'type' => self::TEXT, 'group'=>'Google analytic', 'column' => 2),
            'zalo'     => array('title'=> 'Zalo oaid', 'type' => self::TEXT, 'group'=>'Zalo popup', 'column' => 2),
        );
        $this->view['list'] = array(
            'logo' => array(
                'title' => 'Logo',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ),
            'meta_title' => array(
                'title' => 'Site title',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'hotline' => array(
                'title' => 'Hotline',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'maintenance' => array(
                'title' => 'Maintenance',
                'width' => 7,
                'data'  => array(null => self::CHOOSE, 0 => 'Hoạt động', 1 => 'Bảo trì'),
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
