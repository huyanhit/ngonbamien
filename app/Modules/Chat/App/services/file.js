import ApiService from '@/services/api-service.js'
export default class FileService extends ApiService {
    uploadFile(data) {
        return this.callApi({ method: "upload", url: '/chat/file', param: data })
    }
    removeFile(id) {
        return this.callApi({ method: "delete", url: '/chat/file/'+id})
    }
    getFiles(data) {
        return this.callApi({ method: "get", url: '/chat/file', param: data })
    }
    getImageRaw(data) {
        return this.callApi({ method: "image", url: '/chat/get-file-raw', param: data})
    }
    getImage(data) {
        return this.callApi({ method: "image", url: '/chat/get-file-thumbnail', param: data})
    }
}