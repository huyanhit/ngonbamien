<template>
    <div class="d-flex align-items-center cursor-pointer border border-outset me-1 my-1 pe-1 bg-light" v-if="store.chat.USER[id]"
        @click="event.emit('show-modal-user-info', id)">
        <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-1 ms-0">
            <img :src="store.chat.USER[id].avatar? store.chat.USER[id].avatar : 'https://ui-avatars.com/api/?name=' + store.chat.USER[id].name"
                 class="avatar-xxs"/>
        </div>
        <div class="flex-grow-1 px-1">
            <span class="text-truncate mb-0 text-dark text-capitalize"><a>{{store.chat.USER[id].name}}</a></span>
        </div>
    </div>
</template>
<script setup>
    import { useSocketStore } from '@/stores/chat.js'
    import Helper from '@/helpers/common.js'
    import { ref } from 'vue';
    const store = useSocketStore()
    const props = defineProps(['id'])
    const event = Helper.useEvent();
    const show  = ref(false)
</script>
<style></style>