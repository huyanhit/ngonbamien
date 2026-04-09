import { defineStore } from "pinia";
import { socket } from "@/socket";
import storage from "@/helpers/storage.js"

import MessageService from '@/services/message'
import RoomService from '@/services/room'
import ContactService from '@/services/contact.js'
import FileService from '@/services/file.js'
import MemberService from '@/services/member.js'
import ReactionService from '@/services/reaction.js'
import CboxService from '@/services/cbox.js'

const messageService  = new MessageService();
const roomService     = new RoomService();
const memberService   = new MemberService();
const contactService  = new ContactService();
const reactionService = new ReactionService();
const fileService     = new FileService();
const cboxService     = new CboxService();

const authId = document.querySelector("meta[name='user-id']")?.getAttribute('content');

export const useSocketStore = defineStore("socket-chat", {
    state: () => ({
        is_connected: false,
        chat: {
            CURRENT_USER:  {id: parseInt(authId)},
            CURRENT_ROOM:  {id: null},
            MY_USER: {},
            USER: {0:{id:0, name:'KH'}},
            MY_ROOM: {},
            ROOM: {},
            ROOM_MESSAGE:{},
            ROOM_MEMBER: {},
            MEMBER: {},
            MY_FILE: {},
            ROOM_FILE: {},
            FILE: {},
            FILE_RAW: {},
            CONTACT: {},
            UNFRIEND: {},
            REQUESTED: {},
            APPROVE: {},
            GUEST: {},
            REACTION: {},
            MESSAGE: {},
            MESSAGE_REACTION: {},
            MESSAGE_THREAD: {}
        },
        product:{}
    }),
    getters: {
        messages: (state) => {
            return storage.mapObject(state.chat.ROOM_MESSAGE, state.chat.MESSAGE, state.chat.CURRENT_ROOM.id);
        },
        rooms: (state) => {
            return storage.mapObject(state.chat.MY_ROOM, state.chat.ROOM, state.chat.CURRENT_USER.id);
        },
        users: (state) => {
            return storage.mapObject(state.chat.MY_USER, state.chat.USER, state.chat.CURRENT_USER.id);
        },
        members: (state) => {
            return storage.mapObject(state.chat.ROOM_MEMBER, state.chat.USER, state.chat.CURRENT_ROOM.id);
        },
        room_files: (state) => {
            return storage.mapObject(state.chat.ROOM_FILE, state.chat.FILE, state.chat.CURRENT_ROOM.id);
        },
        my_files: (state) => {
            return storage.mapObject(state.chat.MY_FILE, state.chat.FILE, state.chat.CURRENT_USER.id);
        },
        member: (state) => {
            return state.chat.MEMBER[state.chat.CURRENT_ROOM.id + '_' + state.chat.CURRENT_USER.id]
        },
        room: (state) => {
            return state.chat.ROOM[state.chat.CURRENT_ROOM.id]
        },
    },
    actions: {
        bindEvents(event) {
            if(socket) {
                socket.on("connect", () => {
                    this.is_connected = true;
                });
                socket.on("disconnect", () => {
                    this.is_connected = false;
                });
                socket.on("re-connect", () => {
                    this.is_connected = true;
                });
                socket.on("user_add_contact", (data) => {
                    storage.merge(this.chat, data)
                });
                socket.on("user_cancel_contact", (data) => {
                    storage.merge(this.chat, data)
                });
                socket.on("user_un_request_contact", (data) => {
                    storage.merge(this.chat, data)
                });
                socket.on("user_remove_contact", (data) => {
                    storage.merge(this.chat, data)
                    socket.emit('leave_channel', { 'room_id': parseInt(Object.keys(data.ROOM)[0]) })
                });
                socket.on("user_update_member", (data) => {
                    storage.merge(this.chat, data);
                    if (data.ROOM) {
                        if (this.rooms.find((item) => (item.id === parseInt(Object.keys(data.ROOM)[0])))) {
                            socket.emit('join_channel', { 'room_id': parseInt(Object.keys(data.ROOM)[0]) })
                        } else {
                            socket.emit('leave_channel', { 'room_id': parseInt(Object.keys(data.ROOM)[0]) })
                            event.emit('change-room', { id: 'my-chat' })
                        }
                    }
                });
                socket.on("user_approve_contact", (data) => {
                    storage.merge(this.chat, data);
                    socket.emit('join_channel', { 'room_id': parseInt(Object.keys(data.ROOM)[0]) })
                });
                socket.on("room_push_message", (data) => {
                    let currentId = this.chat.CURRENT_ROOM.id
                    if (storage.last(this.chat.ROOM_MESSAGE[currentId]) > storage.last(data.ROOM_MESSAGE[currentId])) {
                        delete (data.ROOM_MESSAGE);
                    }
                    storage.merge(this.chat, data);
                    if(data.MESSAGE['auth'] !== this.chat.CURRENT_USER.id){
                        event.emit('chat_scroll_push', 100);
                    }
                });
                socket.on("room_update_message", (data) => {
                    storage.merge(this.chat, data);
                });
                socket.on("room_update_info", (data) => {
                    storage.merge(this.chat, data);
                });
                socket.on("user_add_room", (data) => {
                    storage.merge(this.chat, data);
                    socket.emit('join_channel', { 'room_id': Object.keys(data.ROOM)[0] })
                });
                socket.on("room_update_reaction", (data) => {
                    storage.merge(this.chat, data);
                });
                socket.on("open_popup_chat", (data) => {
                    event.emit('open_popup_chat', data);
                });
            }
        },
        joinChannel(data) {
            socket.emit('join_channel', data);
        },
        async getGuests(data) {
            const response = await contactService.getGuests(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }
        },
        async getUserInfo(id) {
            return await contactService.getUserInfo(id);
        },
        async getContacts() {
            const response = await contactService.getContacts();
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getUnfriendContact() {
            const response = await contactService.getUnfriendContact();
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getApproveContact() {
            const response = await contactService.getApproveContact();
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getRequestedContact(data) {
            const response = await contactService.getRequestedContact();
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async addContact(data) {
            return await contactService.addContact(data);
        },
        async approveContact(data) {
            return await contactService.approveContact(data);
        },
        async unRequestContact(data) {
            return await contactService.unRequestContact(data);
        },
        async cancelContact(data) {
            return await contactService.cancelContact(data);
        },
        async removeContact(data) {
            return await contactService.removeContact(data);
        },
        async getRooms() {
            const response = await roomService.getRooms();
            if(response?.success){
                storage.merge(this.chat, response.data)
            }
            return response;
        },
        async addRoom(data) {
            const response =  await roomService.addRoom(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async updateRoom(id, data) {
            const response = await roomService.updateRoom(id, data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async setUnread(data) {
            const response = await memberService.setUnread(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getRoom(id, data) {
            const response = await roomService.getRoom(id, data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getMessages(data) {
            const response = await messageService.getMessages(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getMessage(id, data) {
            const response = await messageService.getMessage(id, data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async searchMessage(data) {
            return await messageService.searchMessage(data);
        },
        async sendMessage(data) {
            return await messageService.sendMessage(data);
        },
        async editMessage(id, data) {
            return await messageService.editMessage(id, data);
        },
        async deleteMessage(id, data) {
            return await messageService.deleteMessage(id, data);
        },
        async uploadFile(data) {
            const response = await fileService.uploadFile(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async removeFile(id) {
            const response = await fileService.removeFile(id);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getFiles(data) {
            const response = await fileService.getFiles(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async updateReaction(data) {
            return await reactionService.updateReaction(data);
        },
        async getCbox(data) {
            const response = await cboxService.getCbox(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }
            
            return response;
        },
        async createCbox(data) {
            const response = await cboxService.createCbox(data);
            if(response?.success){
                localStorage.setItem("cbox_token", response.data.cbox.token);
                storage.merge(this.chat, response.data.chat)
            }
            
            return response;
        },
        async getCboxMessages(data) {
            const response = await cboxService.getMessages(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getCboxMessage(id, data) {
            const response = await cboxService.getMessage(id, data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async searchCboxMessage(data) {
            return await cboxService.searchMessage(data);
        },
        async sendCboxMessage(data) {
            return await cboxService.sendMessage(data);
        },
        async editCboxMessage(id, data) {
            return await cboxService.editMessage(id, data);
        },
        async deleteCboxMessage(id, data) {
            return await cboxService.deleteMessage(id, data);
        },
        async updateCboxReaction(data) {
            return await cboxService.updateReaction(data);
        },
        async setCboxUnread(data) {
            const response = await cboxService.setUnread(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async uploadCboxFile(data) {
            const response = await cboxService.uploadFile(data);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async removeCboxFile(id) {
            const response = await cboxService.removeFile(id);
            if(response?.success){
                storage.merge(this.chat, response.data)
            }

            return response;
        },
        async getProduct(data){
            const response = await cboxService.getProduct(data);
            if(response?.success){
                storage.merge(this.product, {
                    [data.id]: response.data
                })
            }
            return response;
        }
    }
})