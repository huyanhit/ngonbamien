<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Modules\Admin\Models\PostCategoryModel;

class PostCategoryService extends Service{
    function __construct(){
        parent::__construct(new PostCategoryModel());
    }
}
