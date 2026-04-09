<?php

namespace App\Modules\Notification\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'content'       => $this->content,
            'type_id'       => $this->type_id,
            'url'           => $this->url,
            'action'        => $this->action,
            'extra'         => $this->extra,
            'auth_avatar'   => $this->auth?->avatar,
            'auth_name'     => $this->auth?->username,
            'auth_read'     => $this->authNotify?->read? true: false,
            'updated_at'    => $this->updated_at
        ];
    }
}
