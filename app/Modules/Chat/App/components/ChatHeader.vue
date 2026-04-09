<template>
    <div class="px-3 py-2 user-chat-topbar">
        <div class="row align-items-center">
            <div class="col-sm-4 col-8">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 d-block d-lg-none me-3">
                        <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i
                                class="ri-arrow-left-s-line align-bottom"></i></a>
                    </div>
                    <div class="flex-grow-1 overflow-hidden" v-if="store.room">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-2 ms-0">
                                <div class="avatar-sm">
                                    <ImageFile v-if="store.room.icon" :img_id="store.room.icon" class="rounded-circle img-fluid userprofile avatar-sm"/>
                                    <img v-else class="rounded-circle img-fluid userprofile avatar-sm"
                                         :src="'https://ui-avatars.com/api/?name='+store.room.name"/>
                                </div>
                                <span v-if="store.room.type === 3" class="user-status"></span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden cursor-pointer">
                                <h5 class="text-truncate mb-0 fs-20" v-b-modal.update_room_info>
                                    <a class="text-reset username" >{{ store.room?.name }}</a>
                                </h5>
                                <p class="text-truncate text-muted fs-14 mb-0 userStatus cursor-pointer" v-b-modal.update_member_modal
                                    v-if="store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id]">
                                    {{ store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id].length }} {{$t('chat.message.member')}}
                                </p>
                                <UpdateMember/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-4">
                <ul class="list-inline user-chat-nav text-end mb-0">
                    <li class="list-inline-item m-0">
                        <div class="d-flex">
                            <div class="py-2 me-2">
                                <div class="search-box">
                                    <input type="text" class="form-control bg-light border-light"
                                           :placeholder="$t('chat.message.find-message-in-room')" id="searchMessage" ref="search"
                                           :class="{active:data.active_search}"
                                           @focusin="data.active_search = true"
                                           @focusout="data.active_search = false"
                                           @keyup.enter="searchMessage(data.keyword)"
                                           v-model="data.keyword">
                                    <i class="ri-search-2-line search-icon cursor-pointer px-3 " @click.prevent.stop="searchMessage()"></i>
                                </div>
                                <message-search-modal/>
                            </div>
                            <div class="py-2">
                                <contact-manager/>
                            </div>
                            <div class="py-2">
                                <room-file-modal/>
                            </div>
                            <div class="py-2">
                                <button class="btn btn-ghost-success btn-icon" type="button" :title="$t('chat.chat.your_task_list')">
                                    <i class="ri ri-task-line"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item m-0">
                        <div class="dropdown">
                            <button class="btn btn-ghost-success btn-icon" type="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ri ri-menu-2-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item cursor-pointer" v-if="store.room && store.room.type === 1" @click="leaveRoom"><i
                                        class="ri-logout-box-r-line align-bottom text-muted me-2"></i>{{$t('chat.message.leave-room')}}</a>
                                <a class="dropdown-item cursor-pointer" @click="deleteRoom"
                                   v-if="store.room && store.room.type === 1 && store.member && store.member.type === 2"><i
                                        class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>{{$t('chat.message.delete-room')}}</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useSocketStore } from '@/stores/chat'
import { defineAsyncComponent } from 'vue'
import { useI18n } from 'vue-i18n';
import { showConfirm, showToast } from '@/helpers/common'
import Helper from '@/helpers/common'
import { ref } from 'vue';
import { reactive } from 'vue';

const { t } = useI18n();

const ImageFile = defineAsyncComponent(() => import('@/components/file-partials/ImageFile.vue'))
const UpdateMember = defineAsyncComponent(() => import('@/components/UpdateMember.vue'))
const MessageSearchModal = defineAsyncComponent(() => import('@/components/message-partials/MessageSearchModal.vue'))
const ContactManager = defineAsyncComponent(() => import('@/components/ContactManager.vue'))
const RoomFileModal = defineAsyncComponent(() => import('@/components/file-partials/RoomFileModal.vue'))

const event  = Helper.useEvent();
const store  = useSocketStore();
const search = ref(null);

const data= reactive({
    active_search: false,
    keyword: '',
})

const searchMessage = function(data = null){
    event.emit('show-modal-search-message', data)
}
const leaveRoom = function(){
    showConfirm({title: t("chat.chat.leave_room_confirm")}).then( async (result) => {
        if(result.isConfirmed) {
            const response = await store.updateRoom(store.chat.CURRENT_ROOM.id, {leave:store.chat.CURRENT_USER.id})
            if(response.success){
                showToast({icon : "success", title: t("chat.chat.leave_room_success")})
            }else {
                showToast({icon : "error", title: t("chat.chat.leave_room_fail")})
            }
        }
    })
}

const deleteRoom = function(){
    showConfirm({title: t("chat.chat.delete_room_confirm")}).then( async (result) => {
        if(result.isConfirmed) {
            showToast({icon : "error", title: 'Không cho phép xóa đâu?'})
        }
    })
}

event.on('search-room-focus', () => {
    setTimeout(()=>{
        search.value.focus();
    }, 50)
})

</script>
<style scoped>
.search-box .search-icon{
    left: 0 !important;
}
.search-box > input.active{
    min-width: 500px;
}
.search-box > input{
    min-width: 300px;
    transition: 0.5s;
}
</style>