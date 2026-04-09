import ApiService from '@/services/api-service.js'
export default class UserService extends ApiService {
    getContacts(data) {
        return this.callApi({ method: "get", url: '/chat/contact', param: data })
    }
    getGuests(data) {
        return this.callApi({ method: "get", url: '/chat/contact-guests', param: data })
    }
    addContact(data) {
        return this.callApi({ method: "post", url: '/chat/contact', param: data })
    }
    approveContact(data) {
        return this.callApi({ method: "post", url: '/chat/contact/approve', param: data})
    }
    unRequestContact(data) {
        return this.callApi({ method: "post", url: '/chat/contact/un-request', param: data})
    }
    cancelContact(data) {
        return this.callApi({ method: "post", url: '/chat/contact/cancel', param: data})
    }
    removeContact(data) {
        return this.callApi({ method: "post", url: '/chat/contact/remove', param: data})
    }
    getUnfriendContact() {
        return this.callApi({ method: "get", url: '/chat/get-user/unfriend'})
    }
    getApproveContact() {
        return this.callApi({ method: "get", url: '/chat/get-user/approve'})
    }
    getRequestedContact() {
        return this.callApi({ method: "get", url: '/chat/get-user/requested'})
    }
    getUserInfo(id) {
        return this.callApi({ method: "get", url: '/chat/contact/'+id })
    }
}