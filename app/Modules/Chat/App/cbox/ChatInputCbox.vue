<template>
    <div class="chat-input-section">
        <form id="chatinput-form" enctype="multipart/form-data">
            <div class="row g-0 align-items-center">
                <div class="col-auto">
                    <div class="chat-input-links mb-2">
                        <div class="links-list-item d-flex">
                            <div class="dropdown align-self-start message-box-drop">
                                <a class="text-decoration-none border-0 px-1"
                                   role="button" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx text-success bx-smile align-middle"></i>
                                </a>
                                <div class="dropdown-menu icon-emoji">
                                    <a class="dropdown-item" v-for="(item, index) in data.icon" href="#" :key="index" @click.prevent="addIcon(item)">
                                        <img :src="item.src">
                                    </a>
                                </div>
                            </div>
                            <BDropdown v-model="data.show_contact" class="dropdown-contact" :noCaret="true" :dropup="true"
                                v-if="store.room && store.room.type === 1">
                                <template #button-content>
                                    <i class="bx text-success bx-user align-middle"></i>
                                </template>
                                <div class="mx-2 d-flex flex-fill" @click.stop >
                                    <input type="text" v-model="data.filter_contact"
                                           class="form-control w-100 me-2"
                                           :placeholder="$t('chat.message.search-contact')">
                                </div>
                                <TransitionGroup tag="ul" name="fade" class="list-contact list-group">
                                        <li :class="{'active': data.to_all || data.active_contact === -1}" key="-1"
                                            class="border-bottom border-gray-200 dropdown-item text-uppercase fw-bold cursor-pointer"
                                            @click.prevent="addContact('all')">To all
                                        </li>
                                        <template v-for="(item, index) in filterContact" :key="index">
                                            <li class="dropdown-item cursor-pointer" :class="{active: data.active_contact === index}"
                                                @click.prevent="addContact(item)">
                                                <img :src="item.avatar? item.avatar: 'https://ui-avatars.com/api/?name='+item.name"
                                                     @error.once="$event.target.src='https://ui-avatars.com/api/?name='+item.name"
                                                > {{ item.name }}
                                            </li>
                                        </template>
                                </TransitionGroup>
                            </BDropdown>
                            <a class="text-decoration-none emoji-btn border-0 px-1" v-on:click="boldText">
                                <i class="bx text-success bx-bold align-middle"></i>
                            </a>
                            <a class="text-decoration-none emoji-btn border-0 px-1" v-on:click="italicText">
                                <i class="bx text-success bx-italic align-middle"></i>
                            </a>
                            <a class="text-decoration-none border-0 px-1" @click="data.modal = true">
                                <i class="bx text-success bx-images align-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-0 align-items-center p-1">
                <div class="col" :class="{edit: data.edit && data.edit.status === 3}">
                    <textarea ref="content" type="text" class="form-control chat-input border-light bg-light-subtle"
                               :placeholder="$t('chat.message.input-message-placeholder')"
                               id="chat-input"
                               autocomplete="off"
                               @dragover.prevent
                               @drop.prevent="dragFile"
                               @click.stop="event.emit('change-height-input', 200)"
                               @keydown="processKeyAction"
                               @keyup="getSearch"
                               @keyup.shift.enter="sendMessage"
                               @keyup.ctrl.enter="sendMessage"
                               @keyup.esc="event.emit('cancel-edit-message')"
                               @paste="processPaste($event)"
                               v-model="data.content">
                    </textarea>
                </div>
                <div class="col-auto">
                    <div class="chat-input-links ms-2">
                        <div class="links-list-item">
                            <button class="btn btn-success chat-send waves-effect waves-light"
                                    @click.prevent="sendMessage">
                                    <i class="ri-send-plane-2-fill align-bottom"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <BModal id="upload-image" class="modal fade" v-model="data.modal" hide-footer>
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ $t("chat.chat.upload_file")}}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="border-1">
                                <img v-for="(item, index) in data.scr_preview"
                                     ref="preview_image_upload"
                                     :src="item" class="w-100 mx-1 my-2"
                                     :key="index" alt="preview"/>
                                <span v-for="(item, index) in data.icon_preview" v-html="item" :key="index" class="mx-1 my-2 file-upload"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="file" multiple ref="fileUpload" v-on:change="displayImage($event)"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-primary" v-on:click="uploadFiles">{{ $t("chat.chat.choose_file") }}</button>
                    <button type="button" class="btn btn-primary" v-on:click="resetForm">{{ $t("chat.chat.reset") }}</button>
                </div>
            </div>
    </BModal>
</template>

<script setup>
import Helper from '@/helpers/common'
import Emoji from '@/constants/emoji'
import storage from '@/helpers/storage'
import { useSocketStore } from '@/stores/chat.js'
import { nextTick, reactive, ref } from 'vue'
import { computed } from 'vue'

const store = useSocketStore();
const event = Helper.useEvent();
const content = ref(null);
const fileUpload = ref('');

const data = reactive({
    content: '',
    uploading: false,
    sending: false,
    edit: {},
    old_edit_status: 0,
    icon: Emoji.ICON,
    files: [],
    scr_preview: [],
    icon_preview: [],
    waiting_upload: false,
    show_contact: false,
    show_emoj: false,
    filter_contact: '',
    active_contact: -1,
    to_all: false,
    modal: false,
})

event.on('focus-chat-box', (param) => {
    if(content.value){
        if(param && param.focus){
            nextTick(() => content.value.setSelectionRange(param.focus, param.focus))
        }
        content.value.focus();
        setTimeout(()=>{
            (data.content || param.open)?
                event.emit('change-height-input', 200):
                event.emit('change-height-input', 45)
        }, 100)
    }
})

event.on('change-content', (param) => {
    data.content = param.content;
    event.emit('focus-chat-box', param)
})

event.on('edit-message', (item) => {
    data.old_edit_status = item.status
    data.edit = item
    data.edit.status = 3
})

event.on('cancel-edit-message', () => {
    data.edit.status = data.old_edit_status
    data.content = '';
})

const dragFile = async function(ev) {
    const img = ev.dataTransfer.getData("file");
    if(img){
        data.content += '[img:'+ img +'] '
    } else if (ev.dataTransfer){
        data.waiting_upload = true
        if (ev.dataTransfer.items) {
            [...ev.dataTransfer.items].forEach((item, i) => {
                if (item.kind === "file") {
                    const file = item.getAsFile()
                    data.files.unshift(file);
                }
            });
        } else {
            [...ev.dataTransfer.files].forEach((file) => {
                data.files.unshift(file);
            });
        }
        await uploadFiles();
        data.waiting_upload = false
    }
}

const filterContact = computed(()=>{
    if(store.users){
        return store.users.filter(item =>
            item.id !== store.chat.CURRENT_USER.id &&
            item.name.toLowerCase().includes(data.filter_contact.toLowerCase()) &&
            store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id] &&
            store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id].includes(item.id)
        )
    }
    return []
})

const pushMessageTemp = function(data){
    let messageIdAdd = 1;
    let message = store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id];
    if(message){
        messageIdAdd = parseInt(message.slice(-1)[0]) + 1
        store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id].push(messageIdAdd);
    } else {
        store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id] = [messageIdAdd]
    }
    storage.merge(store.chat,{
        MESSAGE:{[store.chat.CURRENT_ROOM.id + '_' + messageIdAdd]: {
                content: data['content'],
                auth: store.chat.CURRENT_USER.id,
                status: 4
            }
        }
    })
}

const sendMessage = async function() {
    if(data.content.trim() !== ''){
        let message  = {content: data.content, room_id: store.chat.CURRENT_ROOM.id};
        data.content = ''
        data.sending = true
        if(data.edit && data.edit.status === 3){
            await store.editCboxMessage(data.edit.id, message);
        } else {
            pushMessageTemp(message);
            event.emit('chat_scroll_bottom');
            await store.sendCboxMessage(message);
        }

        data.sending = false
    }else{
        console.log('empty')
    }
}


const getSearch = function() {
    if (data.show_contact){
        data.filter_contact = data.content.substring(data.content.lastIndexOf('@') + 1);
        if((data.filter_contact.toLowerCase()) === 'all'){
            data.to_all = true
            data.active_contact = -1
        }else {
            data.to_all = false
        }
        if(filterContact.value.length === 0){
            data.show_contact = false
        }
    } else {
        localStorage.setItem( 'room-content-'+store.chat.CURRENT_ROOM.id, data.content)
    }
}

const processKeyAction = function(e) {

    if(e.keyCode === 50){
        data.show_contact = true
    }

    if(data.show_contact){
        if(data.active_contact > filterContact.value.length){
            data.active_contact = 0
        }
        if (e.keyCode === 37 || e.keyCode === 39 || e.keyCode === 38 || e.keyCode === 40 || e.keyCode === 13){
            e.preventDefault();
        }
        if (e.keyCode === 38 && data.active_contact > -1){
            data.active_contact --;
        } else if (e.keyCode === 40 && data.active_contact < filterContact.value.length - 1){
            data.active_contact ++;
        }

        if (e.keyCode === 13){
            e.preventDefault();
            data.show_contact = false
            if(data.active_contact === -1){
                addContact('all');
            } else {
                addContact(filterContact.value[data.active_contact]);
            }
            data.content = data.content.replace('@'+data.filter_contact, '');

            return false
        }
    }else if(e.keyCode === 38){
        let lastMessage = store.messages.at(-1);
        if(lastMessage.auth === store.chat.CURRENT_USER.id){
            event.emit('edit-message', lastMessage);
            event.emit('change-content', { content: lastMessage.content })
        }
    }
}

const displayImage = function(e){
    data.scr_preview = [];
    for(let item of e.target.files){
        if(item.type.substring(0, 5) === 'image'){
            data.scr_preview.push(URL.createObjectURL(item));
        } else {
            data.icon_preview.push('<i class="ri-folder-zip-line"></i>');
        }
        data.files.push(item)
    }
}

const resetForm = function(){
    data.files          = [];
    data.scr_preview    = [];
    data.waiting_upload = false;
    fileUpload.value.value = "";
}

const italicText =  function() {
    event.emit('change-content', { content:'[i]' +  data.content + '[/i]', focus: 3})
}

const boldText =  function() {
    event.emit('change-content',{ content: '[b]' +  data.content + '[/b]', focus: 3})
}

const addIcon = function(item){
    event.emit('change-content',{ content: data.content += item.code +' '})
}

const addContact = function(item){
    if(item === 'all'){
        event.emit('change-content',{ content: data.content += '[toall] \n'})
    }else{
        event.emit('change-content',{ content: data.content += '[to:'+item.id+'] '})
    }
}

const uploadFiles = async function() {
    if (data.files !== null) {
        let formData = new FormData()
        data.waiting_upload = true
        for (let index = 0; index < data.files.length; index++) {
            if (data.files[index].name !== undefined) {
                formData.append('file[]', data.files[index])
            }
        }
        formData.append('room_id', store.chat.CURRENT_ROOM.id)
        data.uploading = true;
        appendFileContent(await store.uploadCboxFile(formData));
        data.uploading = false;
    }
}

const appendFileContent = function(response){
    let file = response.data.FILE
    for (let index in file) {
        if(file[index].type === 'image'){
            data.content += '[img:'+ index +'] '
        }else{
            data.content += '[file:'+ index +'] '
        }
    }
    data.files          = [];
    data.scr_preview    = [];
    data.waiting_upload = false;
    fileUpload.value.value = "";
    data.modal = false;
    sendMessage();
}

const processPaste = async (evt) => {
    const dT = evt.clipboardData || window.clipboardData;
    if(dT.files.length > 0){
        data.files = dT.files;
        await uploadFiles();
    }
};
</script>

<style>
.chat-input-section{
    position: absolute;
    bottom: 0;
    width: 100%;
    border-top: 1px #ccc solid;
    padding: 10px;
}
.chat-input-section textarea{
    border-color: #ccc !important;
    height: 100px;
}
.chat-conversation {
    height: calc(100vh - 299px)
}

@media (max-width: 991.98px) {
    .chat-conversation {
        height:calc(100vh - 275px)
    }
}

.chat-conversation .simplebar-content-wrapper {
    display: flex;
    flex-direction: column
}

.chat-conversation .simplebar-content-wrapper .simplebar-content {
    margin-top: auto
}

.chat-conversation .chat-conversation-list {
    padding-top: 10px;
    margin-bottom: 0;
    overflow: auto;
}

.chat-conversation .chat-conversation-list>li {
    display: flex
}

.chat-conversation li:last-of-type .conversation-list {
    margin-bottom: 0
}

.chat-conversation .chat-list.left .check-message-icon {
    display: none
}

.chat-conversation .chat-list .message-box-drop {
    visibility: hidden
}

.chat-conversation .chat-list:hover .message-box-drop {
    visibility: visible
}

.chat-conversation .chat-avatar {
    margin: 0 16px 0 0
}

.chat-conversation .chat-avatar img {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    max-width: initial;
}

.chat-conversation .chat-day-title {
    position: relative;
    text-align: center;
    margin-bottom: 24px;
    margin-top: 12px;
    width: 100%
}

.chat-conversation .chat-day-title .title {
    background-color: #fff;
    position: relative;
    font-size: 13px;
    z-index: 1;
    padding: 6px 12px;
    border-radius: 5px
}

.chat-conversation .chat-day-title:before {
    content: "";
    position: absolute;
    width: 100%;
    height: 1px;
    left: 0;
    right: 0;
    background-color: rgba(64,81,137,.2);
    top: 10px
}

.chat-conversation .chat-day-title .badge {
    font-size: 12px
}

.chat-conversation .conversation-list {
    margin-bottom: 24px;
    display: inline-flex;
    position: relative;
    align-items: flex-end;
    max-width: 80%
}

@media (max-width: 575.98px) {
    .chat-conversation .conversation-list {
        max-width:90%
    }
}

.chat-conversation .conversation-list .ctext-wrap {
    display: flex;
    margin-bottom: 10px
}

.chat-conversation .conversation-list .ctext-content {
    word-wrap: break-word;
    word-break: break-word
}

.chat-conversation .conversation-list .ctext-wrap-content {
    padding: 12px 20px;
    background-color: var(--vz-light);
    position: relative;
    border-radius: 3px;
    box-shadow: 0 5px 10px rgba(30,32,37,.12)
}

@media (max-width: 575.98px) {
    .chat-conversation .conversation-list .ctext-wrap-content .attached-file .attached-file-avatar {
        display:none
    }

    .chat-conversation .conversation-list .ctext-wrap-content .attached-file .dropdown .dropdown-toggle {
        display: block
    }
}

.chat-conversation .conversation-list .conversation-name {
    font-weight: 500;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px
}

.chat-conversation .conversation-list .dropdown .dropdown-toggle {
    font-size: 18px;
    padding: 4px;
    color: #878a99
}

.chat-conversation .conversation-list .dropdown .dropdown-toggle::after {
    display: none
}

@media (max-width: 575.98px) {
    .chat-conversation .conversation-list .dropdown .dropdown-toggle {
        display:none
    }
}

.chat-conversation .conversation-list .chat-time {
    font-size: 12px;
    margin-top: 4px;
    text-align: right
}

.chat-conversation .conversation-list .message-img {
    border-radius: .2rem;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    gap: 8px
}

.chat-conversation .conversation-list .message-img .message-img-list {
    position: relative
}

.chat-conversation .conversation-list .message-img img {
    max-width: 150px
}

.chat-conversation .conversation-list .message-img .message-img-link {
    position: absolute;
    right: 10px;
    left: auto;
    bottom: 10px
}

.chat-conversation .conversation-list .message-img .message-img-link li>a {
    font-size: 18px;
    color: #fff;
    display: inline-block;
    line-height: 20px;
    width: 26px;
    height: 24px;
    border-radius: 3px;
    background-color: rgba(33,37,41,.7);
    text-align: center
}

.chat-conversation .right {
    justify-content: flex-end
}

.chat-conversation .right .chat-avatar {
    order: 3;
    margin-right: 0;
    margin-left: 16px
}

.chat-conversation .right .chat-time {
    text-align: left;
    color: #878a99
}

.chat-conversation .right .conversation-list {
    text-align: right
}

.chat-conversation .right .conversation-list .ctext-wrap {
    justify-content: flex-end
}

.chat-conversation .right .conversation-list .ctext-wrap .ctext-wrap-content {
    order: 2;
    background-color: #ddede1;
    color: #28a745;
    text-align: right;
    box-shadow: none
}

.chat-conversation .right .conversation-list .ctext-wrap .ctext-wrap-content .replymessage-block {
    background-color: rgba(255,255,255,.5);
    border-color: #0c9eb9;
    color: #212529
}

.chat-conversation .right .conversation-list .ctext-wrap .ctext-wrap-content .replymessage-block .conversation-name {
    color: rgba(var(--vz-success-rgb),1)
}

.chat-conversation .right .conversation-list .conversation-name {
    justify-content: flex-end
}

.chat-conversation .right .conversation-list .conversation-name .check-message-icon {
    order: 1
}

.chat-conversation .right .conversation-list .conversation-name .time {
    order: 2
}

.chat-conversation .right .conversation-list .conversation-name .name {
    order: 3
}

.chat-conversation .right .conversation-list .dropdown {
    order: 1
}

.chat-conversation .right .dot {
    background-color: #212529
}

.chat-input-section {
    border-top: 1px solid transparent;
    background-color: #fbfffc;
    position: relative;
    z-index: 1
}

.chat-input-section .chat-input-feedback {
    display: none;
    position: absolute;
    top: -20px;
    left: 4px;
    font-size: 12px;
    color: #f06548
}

.chat-input-section .show {
    display: block
}

.chat-input-links {
    display: flex
}

.chat-input-links .links-list-item>.btn {
    box-shadow: none;
    padding: 0;
    font-size: 20px;
    width: 37.5px;
    height: 37.5px
}

.chat-input-links .links-list-item>.btn.btn-link {
    color: #878a99
}

.copyclipboard-alert {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    display: none
}

.replyCard {
    position: absolute;
    left: 0;
    right: 0;
    border-top: 1px solid var(--vz-border-color);
    overflow: hidden;
    opacity: 0;
    bottom: 0;
    border-radius: 0;
    transition: all .4s
}

@media (max-width: 991.98px) {
    .replyCard {
        bottom:-12px
    }
}

.replyCard.show {
    transform: translateY(-88px);
    opacity: 1
}

@media (max-width: 991.98px) {
    .replyCard.show {
        transform:translateY(-83px)
    }
}

.replymessage-block {
    padding: 12px 20px;
    margin-bottom: 8px;
    text-align: left;
    border-radius: 4px;
    background-color: rgba(var(--vz-success-rgb),.1);
    border-left: 2px solid rgba(var(--vz-success-rgb),1)
}

.replymessage-block .conversation-name {
    color: rgba(var(--vz-success-rgb),1);
    font-size: 14px
}

.chat-sm .ctext-wrap-content {
    box-shadow: none!important
}

.chat-sm .message-img img {
    max-width: 90px!important
}

.chat-sm .message-img-link {
    bottom: 0!important;
    right: 5px!important
}
.links-list-item a > i{
    font-size: 18px;
    padding: 0 5px;
}
.icon-emoji{
    margin-top: 10px;
    min-width: 400px;
}
.icon-emoji .dropdown-item{
    display: inline-block;
    width: 40px;
    padding: 0;
}
.icon-emoji .dropdown-item img{
    margin: 5px;
    height: 25px;
    width: 25px;
    text-align: center;
}
.list-contact{
    min-width: 400px;
    margin-top: 10px;
}
.list-contact img{
    height: 25px;
    width: 25px;
    text-align: center;
}
.file-upload{
    font-size: 40px;
}

.chat-input-links .list-contact{
    max-height: 200px;
    overflow: auto;
}
.edit{
    border: #0c9eb9 1px solid;
}
.dropdown-contact > .btn, .dropdown-emoj > .btn{
    background: unset;
    padding: 0 10px;
    border: none;
    font-size: 18px;
    line-height: 20px;
}
</style>