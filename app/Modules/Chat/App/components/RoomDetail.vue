<template>
    <div class="sidebar-right p-0" v-if="store.room" >
        <div v-if="store.room.type === 3" class="p-2">
            <div class="p-3 text-center bg-light">
                <img v-if="userDirect" :src="userDirect.avatar? userDirect.avatar:
                     'https://ui-avatars.com/api/?name='+userDirect.name" :alt="userDirect.name"
                     @error.once="$event.target.src='https://ui-avatars.com/api/?name='+userDirect.name"
                     class="avatar-lg img-thumbnail mx-auto profile-img">
                <div class="mt-3">
                    <h5 class="fs-16 mb-1"><a href="javascript:void(0);" class="link-primary username">{{
                            store.room?.name }}</a></h5>
                    <p class="text-muted"><i
                        class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i>Online</p>
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn avatar-xs p-0" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Message">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="ri-question-answer-line"></i>
                        </span>
                    </button>

                    <button type="button" class="btn avatar-xs p-0" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Favourite">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="ri-star-line"></i>
                        </span>
                    </button>

                    <button type="button" class="btn avatar-xs p-0" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Phone">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="ri-phone-line"></i>
                        </span>
                    </button>

                    <div class="dropdown">
                        <button class="btn avatar-xs p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <span class="avatar-title bg-light text-body rounded">
                                <i class="ri-more-fill"></i>
                            </span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                class="ri-inbox-archive-line align-bottom text-muted me-2"></i>Archive</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                class="ri-mic-off-line align-bottom text-muted me-2"></i>Muted</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);"><i
                                class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <template v-else>
            <div class="p-3">
                <h5 class="fs-15 mb-3 fw-bold">{{$t('chat.message.member')}}
                    <a class="float-end cursor-pointer" v-if="getRole() === 2" v-b-modal.update_member_modal>
                        <i class="ri-pencil-fill align-bottom me-2 text-muted small"></i>
                    </a>
                </h5>
                <TransitionGroup tag="div" name="fade" class="d-flex flex-wrap" style="max-height: 220px; overflow-y: scroll">
                    <template v-for="val in store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id]">
                        <div class="flex-grow-0 avatar-sm m-1 cursor-pointer border"
                             :class="{'border border-success': val === store.chat.CURRENT_USER.id}"
                             v-if="store.chat.USER[val]" >
                            <img :src="store.chat.USER[val].avatar? store.chat.USER[val].avatar:
                                 'https://ui-avatars.com/api/?name='+store.chat.USER[val].name"
                                 @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.USER[val].name"
                                 @click="event.emit('show-modal-user-info', store.chat.USER[val].id)"
                                 class="img-fluid fs-10">
                        </div>
                        <div v-else-if="store.chat.GUEST[val]" class="d-flex p-2 border border-groove me-2 my-1 rounded">
                            <div class="flex-grow-0 chat-avatar avatar-sm m-1">
                                <img :src="store.chat.GUEST[val].avatar? store.chat.GUEST[val].avatar:
                                 'https://ui-avatars.com/api/?name='+store.chat.GUEST[val].name"
                                     @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.GUEST[val].name"
                                     @click="event.emit('show-modal-user-info', store.chat.GUEST[val].id)"
                                     class="img-fluid fs-10">
                            </div>
                        </div>
                    </template>
                </TransitionGroup>
            </div>
        </template>
        <div class="border-top border-top-dashed p-3">
            <h5 class="fs-15 mb-3 fw-bold">{{$t('chat.message.description')}}
                <a class="float-end cursor-pointer" v-if="getRole() === 2" v-b-modal.update_room_info>
                    <i class="ri-pencil-fill align-bottom me-2 text-muted small"></i>
                </a>
            </h5>
            <div class="vstack gap-2">
                <div class="border rounded border-dashed p-2">
                    {{ store.room.description }}
                </div>
            </div>
            <RoomUpdate/>
        </div>
        <div class="border-top border-top-double p-3">
            <h5 class="fs-15 mb-3 fw-bold">{{$t('chat.message.file-in-room')}}</h5>
            <b-overlay :show="data.overlay" spinner-variant="secondary"  >
                <div class="b-overlay-wrap"
                     style="max-height: 300px; overflow-y: auto"
                     v-if="store.room_files && store.room_files.length > 0"
                     @scroll="checkScroll($event)">
                     <div class="vstack gap-2" v-for="item in store.room_files">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-xs me-2" v-if="item.type === 'image'">
                                            <ImageFile :img_id="item.id" class="img-fluid userprofile"> </ImageFile>
                                        </div>
                                        <div v-else class="avatar-title bg-light text-secondary rounded fs-20">
                                            <i class="ri-folder-zip-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-fill overflow-hidden">
                                    <h5 class="fs-13 mb-1">
                                        <span class="text-body d-block">
                                            {{item.name}}.{{item.ext}}</span>
                                    </h5>
                                    <div class="text-muted small"><file-size :item="item"/></div>
                                </div>
                                <div class="d-flex align-items-end flex-column">
                                    <div class="flex-grow-1 ">
                                        <a class="cursor-pointer" @click="downloadFile(item)">
                                            <i class="ri-download-2-line align-bottom me-2 text-muted"></i>
                                        </a>
                                        <a class="cursor-pointer" @click="removeFile(item)">
                                            <i v-if="item.removing" class="bx bx-loader bx-spin align-content-center text-muted"></i>
                                            <i v-else class="ri-close-fill align-bottom text-muted" title="Xóa tài liệu"></i>
                                        </a>
                                    </div>
                                    <span class="flex-grow-1 text-muted small text-truncate">
                                        {{filters.fromNow(item.created_at)}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center border rounded border-dashed p-2">
                    <i class="ri-delete-bin-7-line fs-24 text-muted"></i>
                    <div class="text-center pb-3 mt-2"> Không có file nào </div>
                </div>
            </b-overlay>
        </div>
    </div>
</template>

<script setup>
import { useSocketStore } from '@/stores/chat.js'
import ImageFile from '@/components/file-partials/ImageFile.vue'
import FileSize from '@/components/file-partials/FileSize.vue'
import RoomUpdate from '@/components/RoomUpdate.vue'
import FileService from '@/services/file.js'
import Helper, { showConfirm } from '@/helpers/common'
import { computed } from 'vue'
import { reactive } from 'vue'

const fileService = new FileService();
const store = useSocketStore();
const event = Helper.useEvent();
const data  = reactive({
    page: 0,
    overlay: false
})
const userDirect = computed(()=>{
    if(store.room.type === 3){
        for (const index in store.chat.CONTACT) {
            if (store.chat.USER[index] && store.chat.CONTACT[index].room_id === store.chat.CURRENT_ROOM.id){
                return  store.chat.USER[index];
            }
        }
    }
    
    return []
})

const getRole = function(){
    const key = store.chat.CURRENT_ROOM.id+'_'+store.chat.CURRENT_USER.id
    return store.chat.MEMBER[key]?store.chat.MEMBER[key].type: 0;
}

const checkScroll = async function(e) {
    let obj = e.target;
    if (Math.ceil(obj.scrollTop) === (obj.scrollHeight - obj.offsetHeight)) {
        if (data.page < (store.chat.ROOM_FILE['total_page_'+store.chat.CURRENT_ROOM.id] - 1)) {
            data.page++;
            data.overlay = true
            await store.getFiles({room_id:store.chat.CURRENT_ROOM.id, page: data.page })
            obj.scrollTop = 1
            data.overlay = false
        }
    } else if (Math.ceil(obj.scrollTop) < 1) {
        if (data.page > 1){
            data.page --;
            data.overlay = true
            await store.getFiles({room_id:store.chat.CURRENT_ROOM.id, page: data.page })
            obj.scrollTop = (obj.scrollHeight - obj.offsetHeight) - 1
            data.overlay = false
        }
    }
}

const removeFile = (item) => {
    showConfirm({title: 'Xóa tài liệu ' + item.name+'.'+item.ext}).then( async (result) => {
        if(result.isConfirmed) {
            item.removing = true
            store.removeFile(item.id);
        }
    })
}
const downloadFile = async (item) => {
    const a = document.createElement("a");
    document.body.appendChild(a);
    if (!store.chat.FILE_RAW[item.id]) {
        await fileService.getImageRaw({ id: item.id }).then(res => res.blob()).then(blob => {
            if (blob) store.chat.FILE_RAW = { ...store.chat.FILE_RAW, ...{ [item.id]: { 'blob': URL.createObjectURL(blob) } } }
        })
    }
    a.style    = "display: none";
    a.href     = store.chat.FILE_RAW[item.id]['blob'];
    a.download = item.name + '.' + item.ext;
    a.click();
}

</script>

<style>
.sidebar-right{
    width: 480px;
    background-color: var(--vz-secondary-bg);
}
</style>