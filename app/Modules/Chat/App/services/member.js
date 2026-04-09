import ApiService from '@/services/api-service.js'
export default class MemberService extends ApiService {
    setUnread(data) {
        return this.callApi({ method: "post", url: '/chat/set-unread', param: data })
    }
}