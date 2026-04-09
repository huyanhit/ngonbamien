<?php

namespace App\Services;

use App\Modules\Chat\Repositories\ChatRepositoryInterface;

class ChatService
{
    private mixed $chatRepository;
    public function __construct()
    {
        $this->chatRepository = app(ChatRepositoryInterface::class);
    }
}
