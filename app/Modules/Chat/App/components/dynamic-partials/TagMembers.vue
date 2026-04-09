<template>
    <div class="d-flex flex-wrap">
        <div v-for="id in props.members.split('-')">
            <div class="d-flex align-items-center cursor-pointer my-1 me-2" v-if="store.chat.USER[id]"
                @click="event.emit('show-modal-user-info', id)">
                <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-1 ms-0">
                     <img :src="store.chat.USER[id].avatar? store.chat.USER[id].avatar : 'https://ui-avatars.com/api/?name=' + store.chat.USER[id].name"
                          @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.USER[id].name"
                          class="rounded-circle avatar-xxs"
                     />
                </div>
                <div class="flex-grow-1 pe-1">
                    <span class="text-truncate mb-0 text-dark text-capitalize"><a>{{store.chat.USER[id].name}}</a></span>
                </div>
            </div>
            <GuestInfo :id="id" v-else> </GuestInfo>
        </div>
    </div>
</template>

<script setup>
import { useSocketStore } from '@/stores/chat.js'
import Helper from '@/helpers/common'
import GuestInfo from '@/components/user-patials/GuestInfo.vue'
const store = useSocketStore()
const props = defineProps(['members'])
const event = Helper.useEvent();
</script>
<style></style>