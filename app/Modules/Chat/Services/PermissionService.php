<?php

namespace App\Modules\Chat\Services;

use Illuminate\Support\Facades\Auth;

class PermissionService extends ChatService {

    public function checkAuthInRoom($request): bool
    {
        if(empty($request->room_id)) $request->room_id = $request->route('room');
        $object = $this->getChatRepository()->getObject('MY_ROOM', Auth::id());
        return in_array($request->room_id, $object['MY_ROOM'][Auth::id()]);
    }

    public function checkAuthInComment($request): bool
    {
        if(empty($request->room_id)) $request->room_id = $request->route('room');
        $object = $this->getChatRepository()->getObject('MY_COMMENT', Auth::id());
        return in_array($request->room_id, $object['MY_COMMENT'][Auth::id()]);
    }

    public function checkMessageForAuth($request): bool
    {
        if($request['thread']){
            $key = $request->thread.'_'.$request->route('comment');
            $object = $this->getChatRepository()->getObject('THREAD', $key);
            return $object['THREAD'][$key] && $object['THREAD'][$key]['auth'] == Auth::id();
        }else{
            $messageId = $request->route('message')?? $request->route('comment');
            $key = $request->room_id.'_'.$messageId;
            $object = $this->getChatRepository()->getObject('MESSAGE', $key);
            return $object['MESSAGE'][$key] && $object['MESSAGE'][$key]['auth'] == Auth::id();
        }
    }

    public function checkAdminOfRoom($request): bool
    {
        if(empty($request->room_id)) $request->room_id = $request->route('room');
        $key = $request->room_id.'_'.Auth::id();
        $object = $this->getChatRepository()->getObject('MEMBER', $key);

        return $object['MEMBER'][$key]['type'] == 2;
    }

    public function checkUpdateRoom($request): bool
    {
        if(empty($request->room_id)) $request->room_id = $request->route('room');
        $room = $this->getChatRepository()->getObject('ROOM', $request->room_id);
        if(isset($request->members)){
            if(($room['ROOM'][$request->room_id]['type'] === 4) ||
                !$this->checkAdminOfRoom($request) ||
                !$this->checkAuthInRoom($request)) {
                return false;
            }
        }

        if(isset($request->leave)){
            if($room['ROOM'][$request->room_id]['type'] === 1){
                return true;
            }else{
                return false;
            }
        }

        return true;
    }

    public function checkUserDeleteFile($request): bool
    {
        if(empty($request->file_id)) $request->file_id = $request->route('file');
        {
            $files = $this->getChatRepository()->getList('MY_FILE', Auth::id());
            if(in_array($request->file_id, $files))  return true;
        }

        return false;
    }

    public function checkUserInCompany($request): bool
    {
        return true;
    }
}
