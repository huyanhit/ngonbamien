import ApiService from '@/services/api-service.js'
export default class ReactionService extends ApiService {
    updateReaction(data) {
        return this.callApi({ method: "post", url: '/chat/reaction', param: data })
    }
    getReaction(data) {
        return this.callApi({ method: "get", url: '/chat/reaction', param: data })
    }
}