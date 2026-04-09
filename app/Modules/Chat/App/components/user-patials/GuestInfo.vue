<template>
    <div class="d-flex align-items-center cursor-pointer me-2 my-1" v-if="data.user"
        @click="event.emit('show-modal-user-info', data.user.id)">
        <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-1 ms-0">
            <img :src="data.user.avatar? data.user.avatar : 'https://ui-avatars.com/api/?name=' + data.user.name"
                 @error.once="$event.target.src='https://ui-avatars.com/api/?name='+data.user.name"
                 class="rounded-circle avatar-xxs" :alt="data.user.name"
            />
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <p class="text-truncate mb-0 fs-16 text-dark"><a>{{data.user.name}}</a></p>
        </div>
    </div>
</template>
<script setup>
    import { useSocketStore } from '@/stores/chat'
    import Helper from '@/helpers/common.js'
    const props = defineProps(['id'])
    const store = useSocketStore();
    const event = Helper.useEvent();
    const data  = reactive({
        overlay: false,
        user: {}
    });

    onMounted(async () => {
        if (store.chat.GUEST && store.chat.GUEST[props.id]) {
            data.user = store.chat.GUEST[props.id]
        } else {
            data.overlay = true
            const response = await store.getUserInfo(props.id);
            if(response.success){
                data.user = store.chat.GUEST[props.id] = response.data.USER[props.id]
            }
            data.overlay = false
        }
    })
</script>
<style scoped>

</style>