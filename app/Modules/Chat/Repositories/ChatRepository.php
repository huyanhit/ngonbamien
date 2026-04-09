<?php

namespace App\Modules\Chat\Repositories;

use App\Modules\Chat\Models\Contact;
use App\Modules\Chat\Models\File;
use App\Modules\Chat\Models\Message;
use App\Modules\Chat\Models\MessageFile;
use App\Modules\Chat\Models\ModuleRoom;
use App\Modules\Chat\Models\Reaction;
use App\Modules\Chat\Models\Room;
use App\Modules\Chat\Models\RoomFile;
use App\Modules\Chat\Models\UserFile;
use App\Modules\Chat\Models\UserRoom;
use App\Models\User;

class ChatRepository implements ChatRepositoryInterface {
    private function mapObjectModel($object, $key): ?array
    {
        $keys = explode('_', $key);
        return match ($object) {
            'ROOM' => ([
                'model' => new Room(),
                'key' => ['id' => $keys[0] ?? 0],
            ]),
            'MEMBER' => ([
                'model' => new UserRoom(),
                'key' => ['room_id' => $keys[0] ?? 0, 'user_id' => $keys[1] ?? 0],
            ]),
            'ROOM_MEMBER' => ([
                'model' => new UserRoom(),
                'key' => ['room_id' => $keys[0] ?? 0],
                'pluck' => 'user_id',
            ]),
            'MY_ROOM' => ([
                'model' => UserRoom::join('chat_rooms', 'chat_rooms.id', '=', 'chat_user_room.room_id')
                        ->where('chat_rooms.type', '!=', 4)
                        ->orderBy('chat_rooms.pin', 'desc')
                        ->orderBy('chat_rooms.type', 'asc')
                        ->orderBy('chat_rooms.updated_at', 'desc')
                        ->limit('200'),
                'key' => ['user_id' => $keys[0] ?? 0],
                'pluck' => 'room_id',
            ]),
            'MY_COMMENT' => ([
                'model' => UserRoom::join('chat_rooms', 'chat_rooms.id', '=', 'chat_user_room.room_id')->where('chat_rooms.type', 4),
                'key' => ['user_id' => $keys[0] ?? 0],
                'pluck' => 'room_id',
            ]),
            'FILE' => ([
                'model' => new File(),
                'key' => ['id' => $keys[0] ?? 0],
            ]),
            'MY_FILE' => ([
                'model' => new UserFile(),
                'key' => ['user_id' => $keys[0] ?? 0],
                'pluck' => 'file_id',
            ]),
            'ROOM_FILE' => ([
                'model' => new RoomFile(),
                'key' => ['room_id' => $keys[0] ?? 0],
                'pluck' => 'file_id',
            ]),
            'MESSAGE_FILE' => ([
                'model' => new MessageFile(),
                'key' => ['message_id' => $keys[0] ?? 0],
                'pluck' => 'file_id',
            ]),
            'USER' => ([
                'model' => new User(),
                'key' => ['id' => $keys[0] ?? 0],
            ]),
            'MY_USER' => ([
                'model' => Contact::where(['requested' => 2]),
                'key' => ['user_id' => $keys[0] ?? 0],
                'pluck' => 'contact_id',
            ]),
            'MY_CONTACT' => ([
                'model' => Contact::where(['requested' => 2]),
                'key' => ['contact_id' => $keys[0] ?? 0],
                'pluck' => 'user_id',
            ]),
            'CONTACT' => ([
                'model' => new Contact(),
                'key' => ['user_id' => $keys[0] ?? '', 'contact_id' => $keys[1] ?? 0],
            ]),
            'ROOM_MESSAGE' => ([
                'model' => Message::where(['thread' => 0]),
                'key' => ['room_id' => $keys[0] ?? 0],
                'pluck' => 'id',
            ]),
            'MESSAGE' => ([
                'model' => Message::where(['thread' => 0]),
                'key' => ['room_id' => $keys[0] ?? 0, 'id' => $keys[1] ?? 0]
            ]),
            'MESSAGE_THREAD' => ([
                'model' => new Message(),
                'key' => ['thread' => $keys[0] ?? 0],
                'pluck' => 'id',
            ]),
            'THREAD' => ([
                'model' => new Message(),
                'key' => ['thread' => $keys[0] ?? 0, 'id' => $keys[1] ?? 0],
            ]),
            'MESSAGE_IDS' => ([
                'model' => new Message(),
                'key' => ['ids' => $keys[0] ?? 0],
            ]),
            'MODULE_ROOM' => ([
                'model' => new ModuleRoom(),
                'key' => ['module' => $keys[0] ?? '', 'object_id' => $keys[1] ?? 0],
            ]),
            'REACTION' => ([
                'model' => new Reaction(),
                'key' => ['room_id' => $keys[0] ?? 0, 'message_id' => $keys[1] ?? 0, 'id' => $keys[2] ?? 0],
            ]),
            'MESSAGE_REACTION' => ([
                'model' => new Reaction(),
                'key' => ['room_id' => $keys[0] ?? 0, 'message_id' => $keys[1] ?? 0],
                'pluck' => 'id',
            ]),
        };
    }

    public function getObject($object, $key): ?array
    {
        $query = $this->mapObjectModel($object, $key);
        if(isset($query['pluck'])){
            $data = $query['model']->where($query['key'])->get()->pluck($query['pluck'])->toArray();
            return [$object => [$key => $data]];
        }else{
            $data = $query['model']->where($query['key'])->first();
            return [$object => [$key => $data]];
        }
    }

    public function getObjectsByList($object, $list, $key = null): array
    {
        if(!empty($list)){
            $keyList = '';
            $query   = $this->mapObjectModel($object, $key);
            foreach ($query['key'] as $k => $value){
                if($value){
                    $query['model'] = $query['model']->where($k, $value);
                }else{
                    $query['model'] = $query['model']->whereIn($k, $list);
                    $keyList = $k;
                }
            }
            $data = $query['model']->get()->keyBy(function ($item) use ($key, $keyList){
                return empty($key) ? $item[$keyList] : $key . '_' . $item[$keyList];
            });

            return [$object => $data->toArray()];
        }

        return [$object => []];
    }

    public function addObject($object, $prefix, $data)
    {
        $query  = $this->mapObjectModel($object, $prefix);
        $object = $query['model']->create($data);
        return ($prefix)? $prefix.'_'.$object->id: $object->id;
    }

    public function updateObject($object, $key, $data)
    {
        $query = $this->mapObjectModel($object, $key);
        return $query['model']->where($query['key'])->update($data);
    }

    public function deleteObject($object, $key)
    {
        $query = $this->mapObjectModel($object, $key);
        return $query['model']->where($query['key'])->delete();
    }

    public function getList($object, $key, $property = null, $start = 0, $end = -1)
    {
        $query = $this->mapObjectModel($object, $key);
        $data  = $query['model']->where($query['key'])->orderBy($query['pluck'], 'ASC');
        $total = $data->count();

        if($start < 0) {
            $data = $data->offset($total + $start);
        }
        if($start > 0) {
            $data = $data->offset($start);
        }

        if($end > 0){
            return $data->limit($end - $start)->get()->pluck($query['pluck'])->toArray();
        }else{
            return $data->limit($total)->get()->pluck($query['pluck'])->toArray();
        }
    }

    public function getPageList($object, $key, $page, $reverse = false){
        $start  = $page  * 50 - 50;
        $end    = $start + 50;
        $result = $this->getDataList($object, $key, $start, $end, $reverse);
        $result['per_page'] = 50;
        $result['total_page'] = ceil($result['total']/50);

        return $result;
    }

    public function getLenOfList($object, $key, $property = null)
    {
        $query = $this->mapObjectModel($object, $key);
        return $query['model']->where($query['key'])->count();
    }

    public function getListCondition($object, $key, $where)
    {
        $query = $this->mapObjectModel($object, $key);
        return $query['model']->where($query['key'])
            ->where(...$where)->limit(50)->get()->pluck($query['pluck'])->toArray();
    }

    private function getDataList($object, $key, $start, $end, $reverse = false){
        $list  = [];
        $query = $this->mapObjectModel($object, $key);
        $data  = $query['model']->where($query['key']);
        $total = $data->count();

        if($reverse){
            $data->orderBy('id', 'DESC');
        }else{
            $data->orderBy('id', 'ASC');
        }

        if($start < 0) {
            $start = ($total + $start);
            $end   = ($total + $end);
        }

        if($start >= 0){
            $data = $data->offset($start);
            if($end > $start) {
                $list = $data->limit($end - $start)->orderBy($query['pluck'], 'asc')->get()->pluck($query['pluck'])->toArray();
            }else{
                $list = $data->limit($total)->orderBy($query['pluck'], 'asc')->get()->pluck($query['pluck'])->toArray();
            }
        }

        return ['list' => $list, 'total' => $total];
    }
}
