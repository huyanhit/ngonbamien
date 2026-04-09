import ApiService from '@/services/api-service.js'
export default class UserService extends ApiService {
    getAuth() {
        return this.callApi({ method: "get", url: '/chat/auth'})
    }
}