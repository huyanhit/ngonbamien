<?php

namespace App\Modules\Notification\Filters;

use App\Filters\QueryFilter;

class NotificationFilter extends QueryFilter
{
    protected $filterable = ['read'];
}
