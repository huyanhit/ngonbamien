<?php
namespace App\Modules\Chat\Services;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Modules\Chat\Jobs\SendMessage;
use App\Modules\Chat\Models\Cbox;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CboxService extends ChatService
{
    
    use DispatchesJobs;

    public function getCbox(Request $request)
    {
        return Cbox::where('token', $request->bearerToken())->get()->pluck('room_id');
    }

    public function getCboxData(Request $request)
    {
        return $this->getDataCbox($request->bearerToken(), $request->id);
    }

    public function createCbox(Request $request)
    {
        $token = Str::random(60);
        $name = ($request->get('cb_sex') == 1)?'Chị '.$request->get('cb_name'):'Anh '.$request->get('cb_name');
        if(!Cbox::where('token', $token)->exists()){
            return $this->createCboxData($token, $name); 
        }else{
            return $this->createCbox($request);
        }
    }

    public function emitCreateCbox($roomId){
        $admins     = User::where('type', 2)->get()->toArray();
        $room       = $this->getChatRepository()->getObject('ROOM', $roomId);
        $members    = $this->getMemberCbox($roomId, $admins);
        $socketService = new SocketService(); 
        $socketService->connect();
        foreach($admins as $user){
            $myRoom = $this->getChatRepository()->getObject('MY_ROOM', $user['id']);
            $socketService->emit([
                'channel' => 'USER_' . $user['id'],
                'event'   => 'user_add_room',
                'data'    => array_merge($room, $members, $myRoom)
            ]);
        }
        $socketService->disconnect();
    }

    public function processCommand($request){
        $cboxs = Cbox::where('token', $request->bearerToken())->get();
        if($cboxs){
            $comand = $request->command;
            switch ($comand){
                case 'chat_product':
                    $product  = Product::find($request->id);
                    if($product){
                        $cbox = $cboxs->where('supplier_id', $product->supplier_id)->first();
                        if(!$cbox){
                            $supplier = Supplier::find($product->supplier_id);
                            if($supplier){
                                $data = $this->createCboxData($request->bearerToken(), $supplier->title, $supplier->id);
                                $cbox = $data['cbox'];
                            }
                        }
                        if($cbox){
                            $this->dispatchSync((new SendMessage([
                                'room_id' => $cbox->room_id,
                                'content' => 'Bạn đang quan tâm đến sản phẩm.'.PHP_EOL.
                                            '[product:'.$request->id.']Bạn cần tư vấn điều gì?',
                                'auth'    => '1',
                                'command' => true,
                                'token'   => $request->bearerToken()
                            ]))->onQueue('message'));
                        }
                    }
                break;
                case 'chat_shop':
                    $supplier = Supplier::find($request->id);
                    if($supplier){
                        $cbox = $cboxs->where(['token'=> $request->bearerToken(), 'supplier_id'=> $request->id])->first();
                        if(!$cbox){
                            $data = $this->createCboxData($request->bearerToken(), $supplier->title, $supplier->id);
                            $cbox = $data['cbox'];
                        }
                        $this->dispatchSync(new SendMessage([
                            'room_id' => $cbox->room_id,
                            'content' => "Shop ".$supplier->title." xin chào. Rất vui được hổ trợ Bạn.",
                            'auth'    => $supplier->auth_id,
                            'command' => true,
                            'token'   => $request->bearerToken()
                        ]))->onQueue('message');
                    }
                break;
            }
        }
    }

    private function createCboxData($token, $name, $supplier_id = 0){
        $roomId = $this->getChatRepository()->addObject('ROOM', null, array_merge([
            'type' => 5, 
            'name' => $name, 
            'description' => $name
        ]));
        $this->createMemberCbox($roomId, $name, $supplier_id);
        $cbox = Cbox::create([
            'token'       => $token,
            'ip'          => request()->ip(),
            'supplier_id' => $supplier_id,
            'room_id'     => $roomId,
            'active'      => 1,
        ]);
        $this->emitCreateCbox($roomId);
        return [
            'chat' => $this->getDataCbox($token, $roomId),
            'cbox' => $cbox,
        ];
    }

    private function createMemberCbox($roomId, $name, $supplier_id){
        if($supplier_id){
            $admins = User::where('id', Supplier::find($supplier_id)->auth_id)->get()->toArray();
        }else{
            $admins = User::where('type', 2)->get()->toArray();
        }
        $admins = array_merge([["id" => 0, "name" => $name]], $admins);
        foreach($admins as $user){
            $this->getChatRepository()->addObject('MEMBER', $roomId,
                ['type' => 2, 'position' => 1, 'room_id' => $roomId, 'user_id' => $user['id']]
            );
        }
    }

    private function getDataCbox($token, $room_id = 0)
    {
        $cboxs  = Cbox::where('token', $token)->get();
        $myRoom = $cboxs->pluck('room_id')->toArray();
        if($room_id == 0){
            $room_id = $cboxs->where('supplier_id', 0)->first()->room_id;
        }
        
        if($cboxs && in_array($room_id, $myRoom)){
            $admins   = User::where('type', 2)->get()->keyBy('id')->toArray();
            $default  = $this->getDataDefaultCbox($myRoom, $room_id);

            // get my room
            $rooms    = $this->getChatRepository()->getObjectsByList('ROOM', $myRoom);
            $users    = $this->getUserCbox($admins, $rooms['ROOM'][$room_id]['name']);
            $members  = $this->getMemberCbox($room_id, $admins);

            return array_merge($default, $rooms, $members, $users);
        }
    }

    private function getDataDefaultCbox($myRoom, $roomId)
    {
        return [
            "CURRENT_USER" => ['id'=> '0'], 
            "CURRENT_ROOM" => ['id'=> $roomId],
            "MY_ROOM"      => ["0" => $myRoom],
        ];
    }

    private function getMemberCbox($roomId, $users){
        $roomMember = $this->getChatRepository()->getObject('ROOM_MEMBER', $roomId);
        $members    = $this->getChatRepository()->getObjectsByList('MEMBER', $roomMember['ROOM_MEMBER'][$roomId], $roomId);
        return array_merge($members, ["ROOM_MEMBER" => [$roomId => array_keys($users)]] );
    }

    private function getUserCbox($users, $name){
        $users = ['0' => ["id" => 0, "name" => $name]] + $users;
        return array_merge(
            ["MY_USER" => ["0" => array_keys($users)]], 
            ["USER" => $users],
        );
    }
}
