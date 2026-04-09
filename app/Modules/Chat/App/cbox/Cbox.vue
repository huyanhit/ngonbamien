<template>
    <a id="cbox-btn" @click="showCbox()">
        <i class="fa fa-comment"></i>
        <span class="badge badge-pill badge-danger position-absolute small">{{ getAllMessageUnread() }}</span>
    </a>
    <div class="card chat-conversation" v-if="data.showCbox">
        <template v-if="!data.cbox_token">
            <div class="card-header">
                <b class="card-title">Thiết lập kết nối</b>
                <button type="button" class="btn float-right text-muter" @click="data.showCbox = false;">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="m-3 p-3"> 
                    <b class="mb-3">Kênh chat ngonbamien.com rất vui được hổ trợ bạn.</b>
                    <div class="text-muted m-3">Hãy nhập một vài thông tin.</div>
                    <div class="m-3 p-3 row border rounded-pill">
                        <div class="col-4">
                            <select class="form-control form-select border-0" v-model="data.form.cb_sex">
                                <option value="1">Chị</option>
                                <option value="2">Anh</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="data.form.cb_name" id="cbox_name" maxlength="30" placeholder="Nhập tên của bạn.">
                            <span class="text-danger small pull-left" v-if="data.error_name">Bạn chưa nhập tên.</span>
                        </div>
                    </div>
                    <button class="btn btn-info btn-label rounded-pill" @click="createCbox()">
                        <i class="ri-links-line me-2"></i> Kết nối kênh chat
                    </button>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="card-header bg-light text-left">
                <div class="btn-group pull-left">
                    <img class="img-fluid border bg-success" :src="'https://ui-avatars.com/api/?name='+store.room.name" style="max-width: 38px;">
                    <button type="button" class="btn btn-light border dropdown-toggle"  
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ store.room.name }}
                    </button>
                    <div class="dropdown-menu">
                        <template v-for="item in store.rooms">
                            <a class="dropdown-item pr-1" @click="changeRoom(item.id)" :class="{active:item.id == store.chat.CURRENT_ROOM.id}">
                                {{item.name}}
                                <span class="badge badge-pill badge-danger small pull-right">{{ getMessageUnread(item) }}</span>
                            </a>
                        </template>
                    </div>
                </div><!-- /btn-group -->
                <button type="button" class="btn float-right text-muter btn-sm" @click="data.showCbox = false;">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="text-center text-muted loading_message" v-if="data.loading">
                    <img src="@/assets/images/loading-c.gif" class="avatar-xxs" />
                </div>
                <chat-time-line @loading="setLoading"/>
            </div>
            <div class="card-footer p-0">
                <chat-input/>
            </div>
        </template>`
    </div>
</template>
<script setup>
import { useSocketStore } from '@/stores/chat'
import { onMounted, reactive } from 'vue'
import { defineAsyncComponent } from 'vue'
import Helper from '@/helpers/common'

const ChatInput     = defineAsyncComponent(() => import('@/cbox/ChatInputCbox.vue'))
const ChatTimeLine  = defineAsyncComponent(() => import('@/cbox/ChatTimeLineCbox.vue'))

const store = useSocketStore();
const event = Helper.useEvent();
const data  = reactive({
    search: '',
    keydown: [],
    loading: false,
    showCbox: false,
    hasLoadCbox: false,
    cbox_token: '',
    form:{
        cb_name: '',
        cb_sex: 1
    },
    error_name: false
})
store.bindEvents(event);

onMounted(()=>{
    getCbox();
})

const getCbox = async function(){
    data.cbox_token = localStorage.getItem("cbox_token");
    if(data.cbox_token){
        if(!data.hasLoadCbox){
            data.hasLoadCbox = true;
            await store.getCbox();
        }
    }
}

const createCbox = async function(){
    if(data.form.cb_name.trim().length > 0){
        data.error_name = false;
        await store.createCbox(data.form);
        data.cbox_token = localStorage.getItem("cbox_token");
        store.joinChannel({token:data.cbox_token, room_id: store.chat.CURRENT_ROOM.id, cbox:true});
        scrollCbox();
    }else{
        data.error_name = true;
    }
}

const showCbox = function(){
    data.showCbox = !data.showCbox;
    scrollCbox()
}

const setLoading = function(param){
    data.loading = param
}

const scrollCbox = function(){
    if(data.showCbox){
       event.emit('chat_scroll_bottom', 500)
    }
}

event.on('open_popup_chat', async(id) => {
    data.showCbox = true; 
    await store.getCbox({id: id});
    console.log(id);
    store.chat.CURRENT_ROOM.id = id;
    store.joinChannel({token:data.cbox_token, room_id: id});
    scrollCbox();
})


const getAllMessageUnread = function(){
    let total = 0
    for (const key in store.rooms) {
       total += getMessageUnread(store.rooms[key]);
    }

    return total;
}

const getMessageUnread = function(item){
    let total = 0
    if(store.chat.MEMBER[item.id+'_0']){
        total = (item.total - store.chat.MEMBER[item.id+'_0'].position) 
    }

    return (total > 0)? total: 0;
}

const changeRoom = async function(id){
    store.chat.CURRENT_ROOM.id = id;
    await store.getCbox({id: id});
    scrollCbox();
}   

</script>

<style>
    .chat-conversation{    
        position: fixed;
        box-shadow: 1px 2px 3px 0px #6c757d;
        background-color: #fff;
        height: 80vh !important;
        width: 25%;
        bottom: 5px;
        display: inline-block;
        right: 76px;
        z-index: 100;
    }
    .chat-conversation .card-header{
        height: 8%;
        line-height: 40px;
        min-height: 60px;
    }
    .chat-conversation .card-body{
        height: 70%;
        padding: 0;
    }
    .chat-conversation .card-footer{
        height: 22%;
    }
    .loading_message{
        height: 20px;
        display: inline-block;
        width: 20px;
        position: absolute;
        top: 35%;
        z-index: 1000;
        left: 45%;
    }
</style>