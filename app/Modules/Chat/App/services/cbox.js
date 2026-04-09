import ApiService from '@/services/api-service.js'
export default class UserService extends ApiService {
    getCbox(data) {
        return this.callApi({ method: "get", url: '/cbox/cbox-data', param: data })
    }
    createCbox(data) {
        return this.callApi({ method: "post", url: '/cbox/create-cbox', param: data })
    }
    getMessages(data) {
        return this.callApi({ method: "get", url: '/cbox/message', param: data })
    }
    getMessage(id, data) {
        return this.callApi({ method: "get", url: '/cbox/message/'+id, param: data })
    }
    searchMessage(data) {
        return this.callApi({ method: "get", url: '/cbox/message', param: data })
    }
    sendMessage(data) {
        return this.callApi({ method: "post", url: '/cbox/message', param: data })
    }
    editMessage(id, data) {
        return this.callApi({ method: "put", url: '/cbox/message/'+id, param: data })
    }
    deleteMessage(id, data) {
        return this.callApi({ method: "delete", url: '/cbox/message/'+id, param: data })
    }
    setUnread(data) {
        return this.callApi({ method: "post", url: '/cbox/set-unread', param: data })
    }
    uploadFile(data) {
        return this.callApi({ method: "upload", url: '/cbox/file', param: data })
    }
    removeFile(id) {
        return this.callApi({ method: "delete", url: '/cbox/file/'+id})
    }
    getFiles(data) {
        return this.callApi({ method: "get", url: '/cbox/file', param: data })
    }
    getImageRaw(data) {
        return this.callApi({ method: "image", url: '/cbox/get-file-raw', param: data})
    }
    getImage(data) {
        return this.callApi({ method: "image", url: '/cbox/get-file-thumbnail', param: data})
    }
    updateReaction(data) {
        return this.callApi({ method: "post", url: '/cbox/reaction', param: data })
    }
    getReaction(data) {
        return this.callApi({ method: "get", url: '/cbox/reaction', param: data })
    }
    getProduct(data) {
        return this.callApi({ method: "get", url: '/cbox/get-product', param: data })
    }
}