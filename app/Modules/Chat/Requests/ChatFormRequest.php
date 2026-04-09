<?php

namespace App\Modules\Chat\Requests;

use App\Modules\Chat\Services\PermissionService;
use Illuminate\Foundation\Http\FormRequest;

class ChatFormRequest extends FormRequest
{
    public PermissionService $permission;
    public function __construct(PermissionService $permissionService)
    {
        $this->permission = $permissionService;
        parent::__construct();
    }
}