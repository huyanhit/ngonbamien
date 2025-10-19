<?php
namespace App\Modules\Admin\Controllers;

use App\Models\Partner;
use App\Models\ProductCategory;
use App\Modules\Admin\Models\ContactModel;
use App\Modules\Admin\Models\CounterModel;
use App\Modules\Admin\Models\MenuModel;
use App\Modules\Admin\Models\NewsModel;
use App\Modules\Admin\Models\OrderModel;
use App\Modules\Admin\Models\OrderProductModel;
use App\Modules\Admin\Models\PageModel;
use App\Modules\Admin\Models\BannerModel;
use App\Modules\Admin\Models\PostCategoryModel;
use App\Modules\Admin\Models\PostModel;
use App\Modules\Admin\Models\ProducerModel;
use App\Modules\Admin\Models\ProductCategoryModel;
use App\Modules\Admin\Models\ProductModel;
use App\Modules\Admin\Models\ServiceModel;
use App\Modules\Admin\Models\SiteModel;
use App\Modules\Admin\Models\SliderModel;
use App\Modules\Admin\Models\UserModel;
use App\Modules\Admin\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class DashboardController extends MyController
{
    function __construct(Request $request){
        parent::__construct($request, new DashboardService());
    }
    public function index(){
        $page = PageModel::count();
        return view('Admin::dashboard', [
            'data'=>[
                [
                    'title'      => 'Đơn hàng',
                    'link'       => '/admin/orders',
                    'icon'       => 'ri-bill-line',
                    'background' => '#f3f6f9',
                    'class'      => '#f3f6f9',
                    'total'      =>  OrderModel::count(),
                    'new'        =>  OrderModel::where('order_status_id', '<', '3')->count(),
                    'check'      =>  OrderModel::where('order_status_id', '3')->count(),
                    'ship'       =>  OrderModel::where('order_status_id', '4')->count(),
                    'success'    =>  OrderModel::where('order_status_id', '5')->count(),
                ],
                [
                    'title'      => 'Loại sản phẩm',
                    'link'       => '/admin/product-categories',
                    'icon'       => 'ri-menu-2-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  ProductCategoryModel::count(),
                    'active'     =>  ProductCategoryModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Sản phẩm',
                    'link'       => '/admin/products',
                    'icon'       => 'ri-product-hunt-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  ProductModel::count(),
                    'active'     =>  ProductModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Bài viết',
                    'link'       => '/admin/posts',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  PostModel::count(),
                    'active'     =>  PostModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Loại bài viết',
                    'link'       => '/admin/post_categories',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  PostCategoryModel::count(),
                    'active'     =>  PostCategoryModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Xuất xứ',
                    'link'       => '/admin/producers',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  ProducerModel::count(),
                    'active'     =>  ProducerModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Trang',
                    'link'       => '/admin/pages',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  PageModel::count(),
                    'active'     =>  PageModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Slider',
                    'link'       => '/admin/sliders',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  SliderModel::count(),
                    'active'     =>  SliderModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Banner',
                    'link'       => '/admin/banners',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  BannerModel::count(),
                    'active'     =>  BannerModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Website',
                    'link'       => '/admin/sites',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  1,
                    'active'     =>  1,
                ],
                [
                    'title'      => 'Menus',
                    'link'       => '/admin/menus',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  MenuModel::count(),
                    'active'     =>  MenuModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Tài khoản',
                    'link'       => '/admin/users',
                    'icon'       => 'ri-article-line',
                    'background' => '#f3f6f9',
                    'class'      => '',
                    'total'      =>  UserModel::count(),
                    'active'     =>  UserModel::where('active', '1')->count(),
                ],
            ],
            'counter' => [
                'online'=> CounterModel::where('created_at', '>', Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'))->count(),
                'today' => CounterModel::whereDate('created_at', Carbon::now())->count(),
                'total' => CounterModel::count(),
            ],
            'size' => [
                'upload' => $this->getFileSize(),
            ]
        ]);
    }

    private function getFileSize(){
        $file_size = 0;
        foreach(File::allFiles(storage_path()) as $file){
                $file_size += $file->getSize();
        }

        return $file_size;
    }
}
