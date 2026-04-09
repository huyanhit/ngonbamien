<template>
    <div class="chat-input-section">
        <form id="chatinput-form" enctype="multipart/form-data" v-if="store.chat.CURRENT_ROOM.id">
            <div class="row g-0 align-items-center">
                <div class="col-auto">
                    <div class="chat-input-links">
                        <div class="links-list-item d-flex">
                            <BDropdown v-model="data.show_emoj" class="dropdown-emoj" :noCaret="true" :dropup="true">
                                <template #button-content>
                                    <i class="bx text-success bx-smile align-middle"></i>
                                </template>
                                <TransitionGroup tag="ul" name="fade" class="icon-emoji px-3">
                                    <a class="dropdown-item" v-for="(item, index) in data.icon" href="#" :key="index" @click.prevent="addIcon(item)">
                                        <img :src="item.src">
                                    </a>
                                </TransitionGroup>
                            </BDropdown>
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
                            <a class="text-decoration-none border-0 px-1" data-bs-toggle="modal" data-bs-target="#upload-image">
                                <i class="bx text-success bx-upload align-middle"></i>
                            </a>
                            <a class="text-decoration-none emoji-btn border-0 px-1" v-on:click="codeText">
                                <i class="bx text-success bx-code-alt align-middle"></i>
                            </a>
                            <a class="text-decoration-none emoji-btn border-0 px-1" data-bs-toggle="modal" data-bs-target="#conversation-modal">
                                <i class="bx text-success bx-video align-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-0 align-items-center p-1">
                <div class="col" :class="{edit: data.edit && data.edit.status === 3}">
                    <textarea ref="content" type="text" class="form-control chat-input border-light bg-light-subtle"
                               :placeholder="$t('chat.message.input-message-placeholder')"
                               :disabled="(store.chat.CURRENT_ROOM.id === null) || data.uploading"
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
    <div id="upload-image" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" ref="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ $t("chat.chat.upload_file")}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
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
                            <label class="form-label" for="customFile">{{ $t("chat.chat.choose_file") }}</label>
                            <input type="file" multiple class="form-control" ref="fileUpload" v-on:change="displayImage($event)"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-primary" v-on:click="uploadFiles">{{ $t("chat.chat.choose_file") }}</button>
                    <button type="button" class="btn btn-primary" v-on:click="resetForm">{{ $t("chat.chat.reset") }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="conversation-modal" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Video call</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <Conversation/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { useSocketStore } from '@/stores/chat.js'
import Helper from '@/helpers/common'
import Emoji from '@/constants/emoji'
import storage from '@/helpers/storage'
import Conversation from '@/components/Conversation.vue'
import { Modal } from 'bootstrap'
import { nextTick, reactive, ref } from 'vue'
import { computed } from 'vue'

const store = useSocketStore();
const event = Helper.useEvent();
const content = ref(null);
const myModal = ref('');
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
        let message = {content: data.content, room_id: store.chat.CURRENT_ROOM.id};
        data.content = ''
        data.sending = true
        if(data.edit && data.edit.status === 3){
            await store.editMessage(data.edit.id, message);
        } else {
            pushMessageTemp(message);
            event.emit('chat_scroll_bottom');
            await store.sendMessage(message);
        }

        data.sending = false
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
const codeText =  function() {
    event.emit('change-content',{ content: '[code]' +  data.content + '[/code]', focus: 6})
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
        appendFileContent(await store.uploadFile(formData));
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
    Modal.getInstance(myModal.value)?.hide();
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