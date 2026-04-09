
<template>
    <span class="message-img-list">
        <a class="popup-img d-inline-block">
            <img v-on:click="showImage()" class="message-image mr-2" :src="getImage(img_id)" @error.once="setDefaultImage" ref="img"/>
            <span class="message-img-link">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ri-more-fill"></i> </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item cursor-pointer" @click.prevent.stop="downloadFile(img_id)"><i class="ri-download-2-line me-2 text-muted align-bottom"></i>Download</a>
                        </div>
                    </li>
                </ul>
            </span>
        </a>
    </span>
</template>
<script setup>
import { ref } from 'vue'
import { useSocketStore } from '@/stores/chat.js'
import FileService from '@/services/file.js'
import Helper from '@/helpers/common'
import defaultImage  from '@/assets/images/no-image.jpg'

const store = useSocketStore();
const img = ref({});
const fileService = new FileService();
const event = Helper.useEvent();

const props = defineProps(['img_id'])
const showImage = function() {
    event.emit('show-image-modal', props.img_id)
}
const setDefaultImage = function() {
    if(img.value)
        img.value.src = defaultImage
}

const downloadFile = async (file_id) => {
    if(store.chat.FILE[file_id]){
        const a = document.createElement("a");
        document.body.appendChild(a);
        if (!store.chat.FILE_RAW[file_id]) {
            await fileService.getImageRaw({ id: file_id }).then(res => res.blob()).then(blob => {
                if (blob) store.chat.FILE_RAW = { ...store.chat.FILE_RAW, ...{ [file_id]: { 'blob': URL.createObjectURL(blob) } } }
            })
        }
        a.style    = "display: none";
        a.href     = store.chat.FILE_RAW[file_id]['blob'];
        a.download = store.chat.FILE[file_id].name + '.' + store.chat.FILE[file_id].ext;
        a.click();
    }
}
const getImage = function(id) {
    if (store.chat.FILE[id] && store.chat.FILE[id]['blob'] && img.value) {
        if (store.chat.FILE[id].type === 'image') {
            img.value.src = store.chat.FILE[id]['blob'];
        }
    } else {
        fileService.getImage({ id: id }).then(res => {
            if (res.status === 200) {
                res.blob().then(blob => {
                    if (store.chat.FILE[id]) {
                        store.chat.FILE[id]['blob'] = URL.createObjectURL(blob);
                    } else {
                        store.chat.FILE[id] = { 
                            'blob': URL.createObjectURL(blob),
                            'type': 'image'
                        }
                    }
                    if (img.value)
                        img.value.src = store.chat.FILE[id] ? store.chat.FILE[id]['blob'] : null
                });
            }
        })
    }
}
</script>
<style>
.message-img-list{
    min-width: 100px;
    min-height: 100px;
    display: inline-block;
    position: relative;
}
.message-img-link{
    position: absolute;
    bottom: 0;
    left: 0;
}
</style>