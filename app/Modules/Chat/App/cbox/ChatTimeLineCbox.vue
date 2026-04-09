<template>
    <ul id="chat-time-line" class="list-unstyled chat-conversation-list h-100 p-3"
        v-on:scroll="eventScrollMessage"
        v-on:mouseover="onHover"
        v-on:mouseleave="data.hover_time_line = false">
        <li class="position-relative message-item" v-for="(item, index) in store.messages"
            :key="index"
            :id="'message-item-'+item.id"
            :class="item.auth == store.chat.CURRENT_USER.id? 'right': 'left'">
            <span class="unread flex-fill"
                  v-if="
                      store.member?.position === item.id &&
                      store.member?.position < store.room.total &&
                      !store.messages.find(item => item.status === 4)
                  ">
                  <span class="tag-unread">
                      <i v-if="data.load_unread" class="bx bx-loader bx-spin text-success me-1"></i>
                      <i v-else class="bx bx-border-circle text-success me-1"></i>
                      <span> {{ $t("chat.chat.unread") }} </span>
                  </span>
            </span>
            <message-item :item="item" :unread="store.member?.position"/>
        </li>
    </ul>
</template>

<script setup>

import MessageItem from '@/cbox/MessageCboxItem.vue'
import Helper      from '@/helpers/common';
import { useSocketStore }     from '@/stores/chat.js'
import { nextTick, onMounted, reactive } from 'vue'

const LOAD_MORE_MESSAGE_UP       = '1';
const LOAD_MORE_MESSAGE_DOWN     = '2';
const LOAD_MORE_MESSAGE_POSITION = '3';
const store = useSocketStore();
const event = Helper.useEvent();
const emit  = defineEmits('loading');
const data  = reactive({
    hover_time_line: false,
    set_unread: false,
    load_unread: false,
    load_more_message: false,
    scroll_bottom: false,
    scroll_data: null,
})

event.on('chat_scroll_push', (time) => {
    let box = document.getElementById('chat-time-line');
    console.log('sss');
    if(box && (box.scrollTop >= (box.scrollHeight - box.offsetHeight - 100))){
        event.emit('chat_scroll_bottom', time)
    } else {
        box.scrollTop = box.scrollTop - 100
    }
})

event.on('chat_scroll_bottom', (time) => {
    setTimeout(() => scrollBottom(), time?? 0)
})

event.on('chat_scroll_id', (data) => {
    nextTick(() => {
        scrollToId(data.id, data.behavior)
    })
})

event.on('set_unread', (id) => {
    data.load_unread = data.set_unread = true;
    store.setCboxUnread({ room_id: store.chat.CURRENT_ROOM.id, position:id - 1 })
    data.load_unread = false
})

const scrollBottom = () =>{
    let box = document.getElementById('chat-time-line');
    if(box !== null){
        box.scrollTo({ top: box.scrollHeight, behavior: 'smooth' })
    }
}

const callApiLoadMore = async function(position, type) {
    data.load_more_message = true;
    await store.getCboxMessages({ room_id: store.chat.CURRENT_ROOM.id, position: position, type: type })
    data.load_more_message = false;
}

const addMoreMessages = async function(messageId, type) {
    let roomMessages = [];
    if (type === LOAD_MORE_MESSAGE_UP) {
        let position = messageId - 1
        if (store.chat.MESSAGE[store.chat.CURRENT_ROOM.id + "_" + messageId - 1] === undefined) {
            emit('loading', true)
            await callApiLoadMore(position, type);
            emit('loading', false)
        }

        roomMessages = store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id].slice(0, 30);
    }
    if (type === LOAD_MORE_MESSAGE_DOWN) {
        if (store.chat.MESSAGE[store.chat.CURRENT_ROOM.id + "_" + messageId] !== undefined) {
            emit('loading', true)
            await callApiLoadMore(messageId, type);
            emit('loading', false)
        }
        roomMessages = store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id].slice(-30);
    }

    if (roomMessages !== null) {
        store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id] = roomMessages;
        scrollToId(messageId, 'auto', type);
    }
}

const scrollToId = function(id, behavior = 'auto', type = LOAD_MORE_MESSAGE_POSITION) {
    if (id !== 0) {
        nextTick(async () => {
            let box = document.getElementById('chat-time-line');
            let element = document.getElementById('message-item-' + id);
            let boxOffset = box.getBoundingClientRect();
            if (element !== null) {
                if (type === LOAD_MORE_MESSAGE_POSITION) {
                    element.classList.add('high-light')
                    setTimeout(() => {
                        element.classList.remove('high-light')
                    }, 3000)
                }
                let position = element.getBoundingClientRect().bottom - boxOffset.top + box.scrollTop;
                if (type === LOAD_MORE_MESSAGE_DOWN) {
                    box.scrollTo({ top: position - box.offsetHeight - 8, behavior: behavior })
                } else {
                    box.scrollTo({ top: position - element.offsetHeight - 16, behavior: behavior })
                }
            } else {
                await callApiLoadMore(id, LOAD_MORE_MESSAGE_UP);
                if(!data.load_more_message){
                    scrollToId(id, 'smooth');
                }
            }
        })
    }
}

const getPositionById = function(id){
    let box = document.getElementById('chat-time-line');
    let element = document.getElementById('message-item-' + id);
    let boxOffset = box.getBoundingClientRect()
    let top = 0;
    if(element){
        top = element.getBoundingClientRect().bottom - boxOffset.top;
        return top + box.scrollTop;
    }

    return top;
}

const pushListPosition = function(){
    let data = []
    for (let index in store.messages){
        data.push({ id: store.messages[index].id,  position:getPositionById(store.messages[index].id)})
    }

    return data;
}

const onHover = function(){
    data.hover_time_line = true;
    if(!data.load_more_message && !data.set_unread && store.member && store.room){
        if(store.member.position < store.room.total){
            data.set_unread = true;
            data.scroll_data = pushListPosition()
            setTimeout(()=>{
                setScrollData();
            }, 2000)
        }
    }
}

const setScrollData = async function() {
    data.load_unread = true;

    let room_id = store.room.id;
    let id = store.member.position;
    let box = document.getElementById('chat-time-line');
    let scroll = (box.scrollTop + box.offsetHeight - 18);
    let readMessage = data.scroll_data.find(message => {
        return Math.round(message.position) >= scroll;
    });

    if(!readMessage){
        let lastMessage = store.messages? store.messages.slice(-1)[0]: 0;
        let messageId = parseInt(lastMessage.id);
        await store.setCboxUnread({ room_id: room_id, position: messageId })
    }else if (readMessage.id >= id) {
        await store.setCboxUnread({ room_id: room_id, position: readMessage.id })
    }

    data.load_unread = data.set_unread = false
}

const eventScrollMessage = function(){
    if(data.hover_time_line){
        let box = document.getElementById('chat-time-line');
        if(box !== null){
            if (box.scrollTop <= 0 && !data.load_more_message && store.messages !== null) {
                let firstMessage = store.messages[0];
                let messageId = parseInt(firstMessage.id);
                if(messageId > 0){
                    addMoreMessages(messageId, LOAD_MORE_MESSAGE_UP);
                }
            }
            let top = (box.scrollHeight - box.clientHeight);
            if (box.scrollTop >= top && !data.load_more_message && store.messages !== null) {
                let lastMessage = store.messages? store.messages.slice(-1)[0]: 0;
                let messageId = parseInt(lastMessage.id);
                if(messageId < store.room.total){
                    addMoreMessages(lastMessage.id, LOAD_MORE_MESSAGE_DOWN);
                }
            }
        }
    }
}
onMounted(()=>{
    event.emit('chat_scroll_bottom', 500)
})
</script>
<style>
.unread{
    position: absolute;
    bottom: -7px;
    width: 100%;
    text-align: center;
}
.unread::before{
    content: '';
    position: absolute;
    width: 50%;
    border: none;
    left: 25%;
    background-image: linear-gradient(to right,
    rgba(255, 0, 0, 0), grey, rgba(255, 0, 0, 0));
    height: 1px;
}
.unread .tag-unread{
    color: grey;
    background: #fff;
    padding: 2px 5px;
    top: -12px;
    position: relative;
    border: 1px solid;
    border-radius: 10px;
    font-size: 7px;
}
.high-light .ctext-wrap-content{
    background-color: rgba(var(--vz-secondary-rgb), 0.15)!important;
    color: var(--vz-secondary)!important;
}
</style>