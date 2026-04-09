// @ts-nocheck
import ApiService from '@/services/api-service.js'

export default class NotificationService extends ApiService {
    getSummary(params) {
        return this.callApi({ method: "get", url: '/notification/summary', param: params })
    }
    getNotifications(params) {
        return this.callApi({ method: "get", url: '/notification/notification', param: params })
    }
    editNotification(id, params) {
        return this.callApi({ method: "put", url: '/notification/notification/'+id, param: params })
    }
    deleteNotification(id) {
        return this.callApi({ method: "delete", url: '/notification/notification/'+id})
    }
    updateSetting(id, params) {
        return this.callApi({ method: "put", url: '/notification/update-setting/'+id, param: params})
    }
    getSettingByObject(params) {
        return this.callApi({ method: "get", url: '/notification/setting-by-object', param: params })
    }
}