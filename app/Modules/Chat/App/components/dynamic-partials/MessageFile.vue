<template>
    <span class="message-img-list">
        <a class="popup-img d-inline-block" v-if="store.chat.FILE[file_id]">
            <span class=" file-message d-flex">
                <i class="flex-grow-1 ri-file-2-line file-upload-i"></i>
                <h5 class="flex-shrink-1 fs-13 mt-3 me-3">
                    <span class="text-body text-truncate d-block pt-3">
                        {{store.chat.FILE[file_id].name}}.{{store.chat.FILE[file_id].ext}}
                    </span>
                    <span class="text-muted"><file-size :item="store.chat.FILE[file_id]"/></span>
                </h5>
            </span>
            <span class="message-img-link">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ri-more-fill"></i> </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item cursor-pointer" @click.prevent.stop="downloadFile(file_id)">
                                <i class="ri-download-2-line me-2 text-muted align-bottom"></i>Download</a>
                        </div>
                    </li>
                </ul>
            </span>
        </a>
    </span>
</template>
<script setup>
import FileSize from '@/components/file-partials/FileSize.vue'
import FileService from '@/services/file.js'
import { useSocketStore } from '@/stores/chat.js'

const store = useSocketStore();
const props = defineProps(['file_id'])
const fileService = new FileService();
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
</script>
<style scoped>
.file-upload-i{
    font-size: 60px;
}
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