<template>
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="chat-left-sidebar">
            <div class="d-flex p-3">
                <room-search v-model="data.search"/>
                <room-add/>
            </div>
            <!-- .p-4 -->
            <room-list :keyword="data.search"/>
            <!-- end tab contact -->
        </div>
        <div class="user-chat w-100 overflow-hidden">
            <div class="chat-content d-lg-flex">
                <!-- start chat conversation section -->
                <div class="w-100 overflow-hidden position-relative">
                    <!-- conversation user -->
                    <div class="position-relative">
                        <div class="position-relative" id="users-chat" style="display: block;">
                            <chat-header/>
                            <!-- end chat user head -->
                            <div class="chat-conversation" id="chat-conversation" data-simplebar="init">
                                <div class="w-100 text-center text-muted loading_message" v-if="data.loading">
                                    <img src="@/assets/images/loading-c.gif" class="avatar-xxs" />
                                </div>
                                <chat-time-line @loading="setLoading"/>
                            </div>
                        </div>
                        <!-- end chat-conversation -->
                        <chat-input/>
                    </div>
                </div>
            </div>
        </div>
        <room-detail/>
        <user-info-modal/>
        <room-info-modal/>
        <show-image-file/>
    </div>
    <!-- end chat-wrapper -->
</template>
<script setup>
import { useSocketStore } from '@/stores/chat'
import { onMounted, reactive } from 'vue'
import { onBeforeRouteUpdate } from 'vue-router'
import { defineAsyncComponent } from 'vue'
import { useRouter, useRoute } from 'vue-router'; 
import Helper from '@/helpers/common'

const RoomList   = defineAsyncComponent(() => import('@/components/RoomList.vue'))
const RoomSearch = defineAsyncComponent(() => import('@/components/RoomSearch.vue'))
const ChatInput  = defineAsyncComponent(() => import('@/components/ChatInput.vue'))
const ChatHeader = defineAsyncComponent(() => import('@/components/ChatHeader.vue'))

const RoomDetail    = defineAsyncComponent(() => import('@/components/RoomDetail.vue'))
const ChatTimeLine  = defineAsyncComponent(() => import('@/components/ChatTimeLine.vue'))
const RoomAdd       = defineAsyncComponent(() => import('@/components/RoomAdd.vue'))
const UserInfoModal = defineAsyncComponent(() => import('@/components/user-patials/UserInfoModal.vue'))
const ShowImageFile = defineAsyncComponent(() => import('@/components/file-partials/ShowImageFile.vue'))
const RoomInfoModal = defineAsyncComponent(() => import('@/components/user-patials/RoomInfoModal.vue'))

const store  = useSocketStore();
const event  = Helper.useEvent();
const router = useRouter();
const route  = useRoute();

store.bindEvents(event);

const data = reactive({
    search: '',
    keydown: [],
    loading: false,
})

window.addEventListener("keyup", (e) => {
    data.keydown = [];
});

window.addEventListener("keydown", (e) => {
    data.keydown.push(e.keyCode);
    processHotKey(e);
});

onMounted(async () => {
    store.getContacts();
    store.getFiles();
    store.getGuests();
    await store.getRooms();
    if (route.params.roomId && store.chat.ROOM[route.params.roomId]) {
        return await changeRoom({ id:parseInt(route.params.roomId), position:parseInt(route.params.position)})
    } else if(route.params.id){
        const userId = route.params.id
        await store.getContacts();
        if(store.chat.USER[userId]){
            const roomId = parseInt(store.chat.CONTACT[userId].room_id);
            return await changeRoom({ id: parseInt(roomId) })
        }
    }

    goMyChat()
})

onBeforeRouteUpdate((to, from, next) => {
    if (to.name === 'chat-room') {
        let params = to.params.roomId.split('-');
        if(params[0] && params[1]){
            changeRoom({ id: params[0], position:params[1] })
        } else {
            changeRoom({ id: to.params.roomId })
        }

        next();
    }
})

event.on('change-room', (data) => {
    changeRoom(data)
})

event.on('change-page-title', (title) => {
    document.title = 'MP Chat - ' + title;
})

event.on('change-height-input', async (num) => {
    let conversation = document.getElementById('chat-conversation');
    let input = document.getElementById('chat-input');
    let box = document.getElementById('chat-time-line');
    if(conversation && input){
        conversation.style.height="calc(100vh - "+(num + 280)+"px)";
        input.style.height = num + 'px';
    }
    if(box && (box.scrollTop >= (box.scrollHeight - box.offsetHeight - 100))){
        event.emit('chat_scroll_bottom', 300)
    }
})

const changeRoom = async function(param) {
    if(param.id !== store.chat.CURRENT_ROOM.id){
        store.chat.CURRENT_ROOM.id = parseInt(param.id);
        data.loading = true
        if (param.position) {
            if (!store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id]) {
                await store.getRoom(store.chat.CURRENT_ROOM.id, { position: param.position });
            }
            event.emit('chat_scroll_id', { id: param.position, behavior: 'smooth' });
        } else {
            if( !store.chat.ROOM_MESSAGE[store.chat.CURRENT_ROOM.id] ||
                !store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id] ){
                await store.getRoom(store.chat.CURRENT_ROOM.id, {});
            }
            if(store.member.position){
                event.emit('chat_scroll_id', { id: store.member.position, behavior: 'smooth' });
            } else {
                event.emit('chat_scroll_bottom', 300);
            }
        }
        data.loading = false
        let content = localStorage.getItem( 'room-content-'+store.chat.CURRENT_ROOM.id)?? ''
        event.emit('change-content', {content: content, focus: content.length})
        event.emit('change-page-title', store.room.name)
    }
}

const processHotKey = (e) => {
    if(data.keydown.includes(17) && data.keydown.includes(67)){
        e.preventDefault();
        event.emit('focus-chat-box', { open: true });
    }
    if(data.keydown.includes(17) && data.keydown.includes(70)){
        e.preventDefault();
        event.emit('search-room-focus');
        event.emit('change-height-input', 45);
    }
    if(data.keydown.includes(17) && data.keydown.includes(82)){
        e.preventDefault();
        event.emit('filter-room-focus');
        event.emit('change-height-input', 45);
    }
}

const setLoading = function(param){
    data.loading = param
}

const goMyChat = function(){
    if(store.rooms !== null){
        const myRoom = store.rooms.find(item => item.type === 2);
        router.push('/chat/rid-'+ myRoom.id)
    }
}

</script>
<style>
.chat-left-sidebar {
    min-width: 300px;
    max-width: 300px;
    background-color: var(--vz-secondary-bg);
}
.layout-chat .chat-content{
    background: url(../../../assets/images/chat-bg-pattern.png);
}

.layout-chat .chat-conversation{
    height: calc(100vh - 270px);
    transition: .3s;
}
#chat-input {
    height: 100px;
}
.loading_message{
    height: 0;
    top: 10px;
    position: absolute;
}
.fade-move,
.fade-enter-active,
.fade-leave-active {
    transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scaleY(0.01);
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>