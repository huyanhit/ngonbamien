import ApiService from '@/services/api-service.js'
export default class RoomService extends ApiService {
    getRooms() {
        return this.callApi({ method: "get", url: '/chat/room'})
    }
    getRoom(id, data) {
        return this.callApi({ method: "get", url: '/chat/room/'+id, param: data })
    }
    addRoom(data) {
        return this.callApi({ method: "post", url: '/chat/room', param:data })
    }
    updateRoom(id, data) {
        return this.callApi({ method: "put", url: '/chat/room/'+id, param:data })
    }
    setUnreadMessage(id, data) {
        return this.callApi({ method: "put", url: '/chat/update-unread-message/'+id, param: data })
    }
}