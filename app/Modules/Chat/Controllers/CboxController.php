<?php

namespace App\Modules\Chat\Controllers;

use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Chat\Jobs\SendMessage;
use App\Modules\Chat\Jobs\UpdateMessage;
use App\Modules\Chat\Services\CboxService;
use App\Modules\Chat\Services\MemberService;
use App\Modules\Chat\Services\MessageService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CboxController extends Controller {
    private CboxService $cboxService;
    private MessageService $messageService;
    private MemberService $memberService;
    use DispatchesJobs;

    public function __construct(
        MemberService $MemberService,
        CboxService $CboxService,
        MessageService $MessageService){
            
        $this->cboxService    = $CboxService;
        $this->messageService = $MessageService;
        $this->memberService  = $MemberService;
    }

    public function getCbox(Request $request){
        return $this->sendResponse($this->cboxService->getCbox($request));
    }

    public function getCboxData(Request $request){
        $cboxData = $this->cboxService->getCboxData($request);
        if(isset($cboxData['CURRENT_ROOM'])){ 
            $messages = $this->messageService->getMessages(
                ['room_id' => $cboxData['CURRENT_ROOM']['id'], 'position'=> $request->position]
            );
            return $this->sendResponse(array_merge($cboxData, $messages));
        }

        return $this->sendError();
    }

    public function createCbox(Request $request){
        $data = $this->cboxService->createCbox($request);
        $cbox = $data['cbox'];
        $name = ($request->get('cb_sex') == 1)?'Chị ':'Anh ';
        if(isset($cbox['room_id'])){
            $this->dispatchSync((new SendMessage([
                'auth'    => 1,
                'room_id' => $cbox['room_id'],
                'content' => 'Chào '.$name.$request->get('cb_name').'.'.PHP_EOL.$name.'cần hổ trợ gì không?'
            ]))->onQueue('message'));

            $messages = $this->messageService->getMessages(
                ['room_id' => $cbox['room_id'], 'position'=> $request->position]
            );
            $data['chat'] = array_merge($data['chat'], $messages);
        }

        return $this->sendResponse($data);
    }

    public function setUnread(Request $request): JsonResponse
    {
        try {
            $this->memberService->updateUnread($request->input(), '0');
            $key = $request->room_id.'_0';
            return $this->sendResponse($this->memberService->getChatRepository()->getObject('MEMBER', $key));
        }catch (\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {
            if($request->get('keyword')){
                return $this->sendResponse($this->messageService->searchMessages([
                    'room_id'=> $request->get('room_id'),
                    'keyword'=> $request->get('keyword')
                ]));
            }else{
                return $this->sendResponse($this->messageService->getMessages([
                    'room_id'=> $request->get('room_id'),
                    'position'=> $request->get('position'),
                    'type'=> $request->get('type')
                ]));
            }
        }catch (\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function show(Request $request,  $id): JsonResponse
    {
        try {
            return $this->sendResponse(
                $this->messageService->getMessage([
                    'room_id'=> $request->get('room_id'),
                    'message_id'=> $id
                ])
            );
        }catch (\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function store(Request $request): JsonResponse
    { 
        try {
            $data = $request->input();
            $data['auth'] = 0;
              
            $this->dispatchSync((new SendMessage($data))->onQueue('message'));

            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function update(Request $request, $messageId): JsonResponse
    {
        try {
            $data = $request->input();
            $data['auth'] = 0;
            $this->dispatchSync((new UpdateMessage($messageId, $data))->onQueue('message'));

            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function destroy(Request $request, $messageId): JsonResponse
    {
        try {
            $data = ['room_id' => $request->room_id, 'auth' => 0, 'status'  => 0, 'content' => ""];
            $this->dispatchSync((new UpdateMessage($messageId, $data))->onQueue('message'));

            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function messageCommand(Request $request){
        try {
            $this->cboxService->processCommand($request);
            return $this->sendResponse(true);
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function getProduct(Request $request){
        $product = Product::find($request->id);
        return $this->sendResponse([
            'title'=> $product->title,
            'description' => $product->description,
            'image' => str_replace('ngonbamien', 'thumb_ngonbamien', $product->image->uri),
            'url' => url("/san-pham/{$product->slug}")
        ]);
    }
}
