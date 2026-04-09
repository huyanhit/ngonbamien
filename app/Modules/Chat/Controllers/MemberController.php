<?php

namespace App\Modules\Chat\Controllers;

use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Requests\SetUnreadRequest;
use App\Modules\Chat\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    private MemberService $memberService;
    public function __construct(MemberService $memberService){
        $this->memberService = $memberService;
    }


    public function setUnread(SetUnreadRequest $request): JsonResponse
    {
        try {
            $this->memberService->updateUnread($request->input(), Auth::id());
            $key = $request->room_id.'_'.Auth::id();
            return $this->sendResponse($this->memberService->getChatRepository()->getObject('MEMBER', $key));
        }catch (\Exception $e){
            throw new ProcessException($e);
        }
    }
}
