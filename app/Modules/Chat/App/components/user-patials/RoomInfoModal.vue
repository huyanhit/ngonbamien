<template>
    <BModal ref="modal" hide-footer title="Thông tin Room">
        <b-overlay :show="data.overlay" spinner-variant="secondary">
            <div class="p-3 text-center bg-light border border-groove" v-if="data.room">
                <ImageFile v-if="data.room.icon" :img_id="data.room.icon" class="avatar-lg img-thumbnail mx-auto profile-img"/>
            <div class="mt-3">
                <h5 class="fs-16 mb-1"><a class="link-primary username">Name: {{data.room.name}}</a></h5>
                <div class="vstack gap-2"><div class="border rounded border-dashed p-2">Description: {{data.room.description}}</div></div>
            </div>
                <div class="p-3 text-center">
                    <div class="d-flex flex-wrap justify-content-center" style="max-height: 220px; overflow-y: auto">
                        <template v-for="val in store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id]">
                            <div class="flex-grow-0 avatar-sm m-1"
                                 :class="{'border border-success': val === store.chat.CURRENT_USER.id}"
                                 v-if="store.chat.USER[val]" >
                                <img :src="store.chat.USER[val].avatar? store.chat.USER[val].avatar:
                                     'https://ui-avatars.com/api/?name='+store.chat.USER[val].name"
                                     @click="event.emit('show-modal-user-info', store.chat.USER[val].id)"
                                     @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.USER[val].name"
                                     :alt="store.chat.USER[val].name"
                                     class="img-fluid">
                            </div>
                        </template>
                        <template v-for="val in store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id]">
                            <div class="flex-grow-0 chat-avatar avatar-sm m-1"
                                 v-if="store.chat.GUEST[val]">
                                <img :src="store.chat.GUEST[val].avatar? store.chat.GUEST[val].avatar:
                                     'https://ui-avatars.com/api/?name='+store.chat.GUEST[val].name"
                                     @click="event.emit('show-modal-user-info', store.chat.GUEST[val].id)"
                                     @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.GUEST[val].name"
                                     class="img-fluid">
                            </div>
                        </template>
                    </div>
                </div>
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn avatar-xs p-0" title="Message">
                    <span class="avatar-title rounded bg-light text-body">
                        <i class="ri-question-answer-line"></i>
                    </span>
                </button>
                <button type="button" class="btn avatar-xs p-0" title="Favourite">
                    <span class="avatar-title rounded bg-light text-body"><i class="ri-star-line"></i></span>
                </button>
                <div class="dropdown">
                    <button class="btn avatar-xs p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar-title bg-light text-body rounded">
                            <i class="ri-more-fill"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item">
                                <i class="ri-inbox-archive-line align-bottom text-muted me-2"></i>Archive
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item">
                                <i class="ri-mic-off-line align-bottom text-muted me-2"></i>Muted
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item">
                                <i class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </b-overlay>
    </BModal>
</template>
<script setup>
    
    import { BModal } from 'bootstrap-vue-next'
    import { useSocketStore } from '@/stores/chat'
    import Helper from '@/helpers/common.js'
    import ImageFile from '@/components/file-partials/ImageFile.vue'
    import { reactive, ref } from 'vue';

    const store = useSocketStore();
    const event = Helper.useEvent();
    const modal = ref(null);
    const data  = reactive({
        overlay: false,
        room: {}
    });

    event.on('show-modal-room-info', async id => {
        modal.value.show();
        if (store.chat.ROOM[id]) {
            data.room = store.chat.ROOM[id];
        }
    })
</script>
<style scoped>

</style>