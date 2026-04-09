import { defineStore } from "pinia";
import { socket } from "../socket";
import { showNotification } from '../helpers/notification'
import NotificationService from '../services/notification'

const notifyService = new NotificationService();
export const notifyStore = defineStore("notify-store", {
    state: () => ({
        summary: [],
        setting_default: {},
        setting_by_object: [],
        muted:[],
    }),
    getters: {},
    actions: {
        bindEvents(event) {
            socket.on("notification", (data) => {
                showNotification(data, this)
                event.emit('push-notification', data);
            });
        },
        async getSummary(params) {
            return await notifyService.getSummary(params);
        },
        async getNotifications(params) {
            return await notifyService.getNotifications(params);
        },
        async editNotification(id, params) {
            return await notifyService.editNotification(id, params);
        },
        async deleteNotification(id) {
            return await notifyService.deleteNotification(id);
        },
        async updateSetting(id, params) {
            return await notifyService.updateSetting(id, params);
        },
        async getSettingDefault(params) {
            const response =  await notifyService.getSettingDefault(params);
            if (response.success) {
                this.setting_default = response.data;
            }
        },
        async getSettingByObject(params) {
            const response = await notifyService.getSettingByObject(params);
            if (response?.success) {
                this.setting_by_object = response.data;
            }
        }
    }
})