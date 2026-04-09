<template>
    <div class="link-preview">
        <template v-if="local >= 0">
            <span class="domain text-info text-truncate cursor-pointer" @click="gotoLink">{{ url }}</span>
            <div class="flex-grow-1" v-if="data.room_id && data.message_id">
                <template v-if="store.chat.MESSAGE[data.room_id+'_'+data.message_id]">
                    <message-render :item="store.chat.MESSAGE[data.room_id+'_'+data.message_id]"/>
                </template>
                <template v-else>
                    <span class="spinner-border spinner-border-sm mr-2"></span> {{ $t("chat.chat.loading") }}...
                </template>
            </div>
            <div class="flex-grow-1" v-else-if="data.room_id">
                <tag-room :id="data.room_id"/>
            </div>
        </template>
        <template v-else>
            <div v-if="!store.meta">
                <div class="link-preview-section mt-1">
                    <a :href="url" class="domain text-info">{{ url }}</a>
                    <div class="d-flex justify-content-between">
                        <div class="flex-fill">
                            <Skeletor height="15" class="mb-2" />
                            <Skeletor height="15" class="mb-2" />
                            <Skeletor height="15" class="mb-2"/>
                        </div>
                        <div class="flex-shrink-0">
                            <Skeletor height="60" width="60" class="mx-2" />
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="d-flex link-preview-section" >
                <div class="flex-fill justify-content-end me-2 link-description">
                    <div class="link-data">
                        <a :href="url" class="domain text-info">{{ url }}</a>
                        <div class="link-title">{{store.meta[url].title}}</div>
                        <div class="link-description">{{store.meta[url].description}}</div>
                    </div>
                </div>
                <div class="flex-grow-1 link-image" v-if="store.meta[url].images">
                    <img v-if="store.meta[url].images[0]" class="avatar-lg" :src="store.meta[url].images[0]" :alt="store.meta[url].title"/>
                </div>
            </div>
        </template>
    </div>
</template>
<script setup>
import { useSocketStore } from '@/stores/chat.js'
import Helper from '@/helpers/common'
import TagRoom from '@/components/dynamic-partials/TagRoom.vue'
import MessageRender from './MessageCboxRender.vue'
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";

const store    = useSocketStore()
const props    = defineProps(['url', 'local'])
const event    = Helper.useEvent();
const url_meta = `https://jsonlink.io/api/extract?url=`
const api_key  = `pk_53278ea4066d369ffac9726359a8c4bc482391e5`;
const data     = reactive({
    show: false,
    room_id: 0,
    message_id: 0,
})

onMounted(async () => {
    if(props.local >= 0){
        const pathLink = props.url.match(/rid[-\d+]+[-\d+]/i);
        const arrPath = pathLink[0].split('-')
        if (arrPath[1] && arrPath[2]) {
            data.room_id = arrPath[1]
            data.message_id = arrPath[2]
            await store.getMessage(data.message_id, {room_id: data.room_id })
        } else if (arrPath[1]) {
            data.room_id = arrPath[1]
        }
    } else if (!store.meta[props.url]) {
        const apiUrl = url_meta + props.url + '&api_key=' + api_key;
        store.meta[props.url] = await fetch(apiUrl)
            .then(response => {
                return response.json();
            }).catch(() => {
                return null;
            })
    }
})
const gotoLink = function() {
    if(data.room_id && data.message_id){
        if (store.chat.CURRENT_ROOM.id === parseInt(data.room_id)) {
            event.emit('chat_scroll_id', { id: data.message_id });
        } else {
            event.emit('change-room', { id: data.room_id, position: data.message_id });
        }
    }
}
</script>
<style>
.link-preview {
    max-width: 700px;
    height: 100px;
    overflow: auto;
    margin-top: 0;
}

.link-preview-section {
    border-radius: 5px;
    line-height: 1.5;
    cursor: pointer;
    white-space: break-spaces;
}

.link-preview-section .link-image {
    height: 100%;
    padding-top: 2px;
}

</style>