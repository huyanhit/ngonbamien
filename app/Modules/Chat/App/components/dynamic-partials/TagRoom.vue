<template>
    <div class="d-flex align-items-center mx-1 cursor-pointer bg-light my-1 me-2 border border-outset" v-if="store.chat.ROOM[id]"
        @click.prevent.stop="event.emit('show-modal-room-info', id)">
        <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-1 ms-0">
            <ImageFile v-if="store.chat.ROOM[id].icon" :img_id="store.chat.ROOM[id].icon"  class="avatar-xxs"/>
        </div>
        <div class="flex-grow-1 pe-1">
            <span class="text-truncate mb-0 text-capitalize text-dark"><a>{{store.chat.ROOM[id].name}}</a></span>
        </div>
    </div>
</template>

<script setup>
import { useSocketStore } from '@/stores/chat.js'
import Helper from '@/helpers/common.js'
import ImageFile from '@/components/file-partials/ImageFile.vue'
const store = useSocketStore()
const event = Helper.useEvent();
const props = defineProps(['id'])
</script>
<style></style>