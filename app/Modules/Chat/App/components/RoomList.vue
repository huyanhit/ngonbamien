<template>
    <TransitionGroup tag="ul" name="fade" class="list-unstyled chat-list chat-user-list border-top" id="userList">
        <li v-for="(item, index) in roomFilter" :key="index"
            :id="'room-item-'+item.id" :class="{active:item.id === store.chat.CURRENT_ROOM.id}">
            <router-link :to="'/chat/rid-'+item.id" class="p-2">
                <div class="d-flex">
                    <div class="flex-grow-0 chat-user-img align-self-center me-2 ms-0">
                        <div class="avatar-sm">
                            <ImageFile v-if="item.icon" :img_id="item.icon" class="rounded-circle img-fluid userprofile avatar-sm"/>
                            <img v-else class="rounded-circle img-fluid userprofile avatar-sm" :src="item.icon? item.icon: 'https://ui-avatars.com/api/?name='+item.name"/>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <div class="d-flex">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mt-1 mb-0 fw-bold">{{item.name}}</p>
                            </div>
                            <div class="ms-auto me-1">
                                <span class="border border-success text-success unread-badge"
                                      :class="{'bg-success text-white': store.chat.MEMBER[item.id+'_'+store.chat.CURRENT_USER.id].mention > 0}"
                                      v-if="getMessageUnread(item) > 0">
                                      {{ getMessageUnread(item) }}
                                </span>
                            </div>
                            <div class="flex-shrink-0 overflow-hidden room-pin" @click.prevent.stop="pinRoom(item)">
                                <span v-if="item.pin">
                                    <i class="spinner-border spinner-border-sm mr-2" v-if="item.pining"></i>
                                    <i class="ri ri-pushpin-2-fill active" v-else/>
                                </span>
                                <span v-else>
                                    <i class="spinner-border spinner-border-sm mr-2" v-if="item.pining"></i>
                                    <i class="ri ri-pushpin-line" v-else></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex" v-if="store.chat.MESSAGE[item.id+'_'+item.total]">
                            <span class="message-room text-muted flex-fill flex-grow-1 text-truncate" v-if="item.total > 0">
                               <message-item-simple :item="store.chat.MESSAGE[item.id+'_'+item.total]" v-if="store.chat.MESSAGE[item.id+'_'+item.total]"/>
                            </span>
                            <span class="text-muted flex-shrink-0 text-truncate" v-if="item.total > 0">
                                {{ filters.fromNow(store.chat.MESSAGE[item.id+'_'+item.total].created_at) }}
                            </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </li>
    </TransitionGroup>
</template>

<script setup>
import { useSocketStore } from '@/stores/chat.js'
import { showToast  } from '@/helpers/common'
import { computed } from 'vue'
import filters from '@/helpers/filter'
import ImageFile from '@/components/file-partials/ImageFile.vue'
import MessageItemSimple from '@/components/MessageItemSimple.vue'

const store  = useSocketStore();
const props  = defineProps(['keyword'])

const getMessageUnread = function(item){
    if(store.chat.MEMBER[item.id+'_'+store.chat.CURRENT_USER.id]){
        return item.total - store.chat.MEMBER[item.id+'_'+store.chat.CURRENT_USER.id].position
    }

    return 0;
}
const formatRoomDirect = function(item){
    for (const index in store.chat.CONTACT) {
        if (store.chat.USER[index] && store.chat.CONTACT[index].room_id === item.id){
            item.name = store.chat.USER[index].name;
            item.icon = store.chat.USER[index].avatar;
        }
    }

    return 'Direct'
}

const pinRoom = async function(item) {
    item.pining = true
    const response = await store.updateRoom(item.id, {pin: !item.pin})
    if (response.success) {
        item.pining = false
        showToast({ icon: "success", title: 'Pin room '+item.name+' success' });
    }
}

const roomFilter = computed(()=>{
    if(store.rooms){
        return store.rooms.filter(item => {
            if(item.type === 3) formatRoomDirect(item)
            return item.name.includes(props.keyword)
        }).sort((a, b) => {
            return (new Date(b.updated_at).valueOf()) - (new Date(a.updated_at).valueOf())
        }).sort((a, b) => {
            return b.pin - a.pin
        })
    }
})
</script>

<style scoped>
.chat-list{
    height: calc(100vh - 250px);
    overflow-y: auto;
    padding-bottom: 5px;
}
.chat-list li:hover{
    background-color: rgba(var(--vz-success-rgb), 0.15);
    color: var(--vz-success);
}
.unread-badge{
    height: 15px;
    min-width: 15px;
    border-radius: 15px;
    text-align: center;
    display: inline-block;
    font-size: 10px;
    padding: 2px;
    line-height: 10px;
}
.message-room{
    width: 50px;
}
.room-pin i{
    color: lightgrey;
    cursor: pointer;
}
.room-pin:hover i, .room-pin i.active{
    color: black;
}
</style>