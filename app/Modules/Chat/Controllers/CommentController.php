<?php

namespace App\Modules\Chat\Controllers;

use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use App\Modules\Chat\Jobs\SendMessage;
use App\Modules\Chat\Jobs\SendThread;
use App\Modules\Chat\Jobs\UpdateMessage;
use App\Modules\Chat\Requests\AddCommentRequest;
use App\Modules\Chat\Requests\AddThreadMessageRequest;
use App\Modules\Chat\Requests\DeleteMessageRequest;
use App\Modules\Chat\Requests\GetCommentRequest;
use App\Modules\Chat\Requests\UpdateMessageRequest;
use App\Modules\Chat\Services\CommentService;
use App\Modules\Chat\Services\MemberService;
use App\Modules\Chat\Services\MessageService;
use App\Modules\Chat\Services\SocketService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use DispatchesJobs;
    private CommentService $commentService;
    private MemberService $memberService;
    private SocketService $socketService;
    private MessageService $messageService;

    public function __construct(
        MessageService $messageService,
        SocketService $socketService,
        CommentService $commentService,
        MemberService $memberService){
        $this->messageService = $messageService;
        $this->socketService = $socketService;
        $this->commentService = $commentService;
        $this->memberService = $memberService;
    }

    public function getRoom($roomId): JsonResponse
    {
        try {
            return $this->sendResponse($this->commentService->getRoom($roomId));
        }catch (\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function index(GetCommentRequest $request): JsonResponse
    {
        try {
            return $this->sendResponse($this->messageService->getMessages([
                'room_id'=> $request->get('room_id'),
                'position'=> $request->get('position'),
                'type'=> $request->get('type')
            ]));
        }catch (\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function store(AddCommentRequest $request): JsonResponse
    {
        try {
            $data = $request->input();
            $data['auth'] = Auth::id();

            if($request->input('thread')){
                $this->dispatchSync((new SendThread($data))->onQueue('message'));
            }else{
                $this->dispatchSync((new SendMessage($data))->onQueue('message'));
            }

            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function update(UpdateMessageRequest $request, $messageId): JsonResponse
    {
        try {
            $data = $request->only(['content', 'room_id', 'thread']);
            $data['auth'] = Auth::id();
            $this->dispatchSync((new UpdateMessage($messageId, $data))->onQueue('message'));
            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function destroy(DeleteMessageRequest $request, $messageId): JsonResponse
    {
        try {
            $data = [
                'room_id' => $request->room_id,
                'thread'=> $request->thread,
                'auth' => Auth::id(),
                'status'  => 0, 
                'content' => ""
            ];
            $this->dispatchSync((new UpdateMessage($messageId, $data))->onQueue('message'));

            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }
}
