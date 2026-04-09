<?php

namespace App\Modules\Chat\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Chat\Requests\AddReactionRequest;
use App\Modules\Chat\Services\ReactionService;
use Illuminate\Http\JsonResponse;

class ReactionController extends Controller {
    private ReactionService $reactionService;
    public function __construct(ReactionService $reactionService){
        $this->reactionService = $reactionService;
    }

    public function store(AddReactionRequest $request): JsonResponse
    {
        return $this->sendResponse($this->reactionService->addReaction($request->input()));
    }
}
