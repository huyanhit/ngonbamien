<template>
    <BModal size="lg" ref="modal" title="Search Messages" hide-footer scrollable class="search-modal">
        <div class="py-2 me-2">
            <div class="search-box d-flex">
                <div class="flex-fill me-2">
                    <input type="text" class="form-control bg-light border-light"
                           :placeholder="$t('chat.message.find-message-in-room')" id="searchMessage"
                           @keyup.enter="event.emit('show-modal-search-message', (data.keyword))"
                           v-model="data.keyword">
                    <i class="ri-search-2-line search-icon"></i>
                </div>
                <b-button class="flex-shrink-0" variant="success"
                          @click="event.emit('show-modal-search-message', (data.keyword))">Search</b-button>
            </div>
        </div>
        <b-overlay :show="data.overlay" spinner-variant="secondary" style="min-height: 300px">
            <TransitionGroup tag="ul" name="fade" v-if="data.messages" class="list-group">
                <template v-if="Object.keys(data.messages).length > 0">
                    <li class="d-flex list-group-item list-group-item-action mt-1 p-2" v-for="item in data.messages">
                        <div @click="gotoMessage(item)"  class="flex-fill">
                            <message-render :item="item"/>
                        </div>
                        <div class="d-flex flex-shrink-0 align-items-end flex-column">
                            <div class="flex-fill dropdown">
                                <a data-bs-toggle="dropdown">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <div class="dropdown-menu p-0">
                                    <a @click.prevent.stop="gotoMessage(item)"  class="dropdown-item reply-message cursor-pointer">
                                         <i class="ri-message-3-line me-2"></i> {{$t('chat.message.detail')}}
                                    </a>
                                </div>
                            </div>
                            <div class="flex-shrink-0 m-0 ">
                                <small class="text-muted time" v-if="item.status === 4">
                                    {{filters.fromNow(Date.now())}}
                                </small>
                                <small class="text-muted time" v-else> {{ filters.fromNow(item.created_at) }}</small>
                            </div>
                        </div>
                    </li>
                </template>
                <li v-else class="p-3 text-center fs-16 list-group-item">
                    <i class="ri ri-chat-1-line me-2"/>{{$t('chat.message.message-empty')}}
                </li>
            </TransitionGroup>
        </b-overlay>
    </BModal>
</template>
<script setup>
    
    import { BModal } from 'bootstrap-vue-next'
    import { useSocketStore } from '@/stores/chat'
    import Helper from '@/helpers/common.js'
    import filters from '@/helpers/filter.js'
    import MessageRender from '@/components/dynamic-partials/MessageRender.vue'
    import { ref } from 'vue';
    import { reactive } from 'vue';

    const store  = useSocketStore();
    const event  = Helper.useEvent();
    const modal  = ref(null);
    const data   = reactive({
        room: {},
        overlay: false,
        messages: [],
        keyword: ''
    });

    event.on('show-modal-search-message',async (keyword) => {
        modal.value.show();
        if(keyword){
            data.overlay = true
            data.keyword = keyword
            const response = await store.searchMessage({ room_id: store.chat.CURRENT_ROOM.id, keyword: keyword })
            if (response.success) {
                data.messages = response.data['MESSAGE'];
            }
            data.overlay = false
        }
    })
    const gotoMessage = function(item) {
        modal.value.hide();
        event.emit('chat_scroll_id', {id:item.id, behavior:'smooth'})
    }
</script>
<style scoped>
.search-modal pre.content-message{
    margin: 0;
    font-family: unset;
}
</style>