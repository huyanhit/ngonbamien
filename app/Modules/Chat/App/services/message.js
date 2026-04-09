import ApiService from '@/services/api-service.js'
export default class MessageService extends ApiService {
    getMessages(data) {
        return this.callApi({ method: "get", url: '/chat/message', param: data })
    }
    getMessage(id, data) {
        return this.callApi({ method: "get", url: '/chat/message/'+id, param: data })
    }
    searchMessage(data) {
        return this.callApi({ method: "get", url: '/chat/message', param: data })
    }
    sendMessage(data) {
        return this.callApi({ method: "post", url: '/chat/message', param: data })
    }
    editMessage(id, data) {
        return this.callApi({ method: "put", url: '/chat/message/'+id, param: data })
    }
    deleteMessage(id, data) {
        return this.callApi({ method: "delete", url: '/chat/message/'+id, param: data })
    }
}