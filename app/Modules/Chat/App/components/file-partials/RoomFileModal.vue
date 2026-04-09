<template>
    <div class="inline-block">
        <b-popover placement="bottom" :click="true" :title="$t('chat.message.my-files')" class="z-1">
            <template #target>
                <button class="btn btn-ghost-success btn-icon" type="button"
                        title="Danh sách files bạn đã upload">
                    <i class="ri ri-folder-line"></i>
                </button>
            </template>
            <b-overlay :show="data.overlay" spinner-variant="secondary"  >
                <div class="b-overlay-wrap"
                     style="min-height: 300px; max-height: 440px; overflow-y: auto"
                     v-if="store.my_files && store.my_files.length > 0"
                     @scroll="checkScroll($event)">
                    <div class="vstack gap-2" v-for="item in store.my_files">
                        <div class="border rounded border-dashed p-2">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                        <div class="avatar-xs me-2" v-if="item.type === 'image'">
                                            <ImageFile :img_id="item.id" class="img-fluid userprofile"> </ImageFile>
                                        </div>
                                        <div v-else class="avatar-title bg-light text-secondary rounded fs-20">
                                            <i class="ri-folder-zip-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">{{item.name}}.{{item.ext}}</a></h5>
                                    <div class="text-muted"><file-size :item="item"/></div>
                                </div>
                                <div class="d-flex align-items-end flex-column">
                                    <a class="flex-grow-1 cursor-pointer" @click="downloadFile(item)">
                                        <i class="ri-download-2-line align-bottom me-2 text-muted"></i>
                                    </a>
                                    <span class="flex-grow-1 text-muted small">
                                    {{filters.fromNow(item.created_at)}}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center border rounded border-dashed p-2">
                    <i class="ri-delete-bin-7-line fs-24 text-muted"></i>
                    <div class="text-center pb-3 mt-2"> Không có file nào </div>
                </div>
            </b-overlay>
        </b-popover>
    </div>
</template>
<script setup>
    import { useSocketStore } from '@/stores/chat'
    import FileSize from '@/components/file-partials/FileSize.vue'
    import ImageFile from '@/components/file-partials/ImageFile.vue'
    import FileService from '@/services/file.js'
    import { reactive } from 'vue';

    const fileService = new FileService();
    const store = useSocketStore();
    const data  = reactive({
        overlay: false,
        modal: false,
        page: 0
    })
    const checkScroll = async function(e) {
        let obj = e.target;
        if (Math.ceil(obj.scrollTop) >= (obj.scrollHeight - obj.offsetHeight)) {
            if (data.page < store.chat.MY_FILE.total_page - 1) {
                data.page++;
                data.overlay = true
                await store.getFiles({ page: data.page })
                obj.scrollTop = 1
                data.overlay = false
            }
        } else if (Math.ceil(obj.scrollTop) < 1) {
            if (data.page > 1){
                data.page --;
                data.overlay = true
                await store.getFiles({ page: data.page })
                obj.scrollTop = (obj.scrollHeight - obj.offsetHeight) - 1
                data.overlay = false
            }
        }
    }
    const downloadFile = async (item) => {
        const a = document.createElement("a");
        document.body.appendChild(a);
        if (!store.chat.FILE_RAW[item.id]) {
            await fileService.getImageRaw({ id: item.id }).then(res => res.blob()).then(blob => {
                if (blob) store.chat.FILE_RAW = { ...store.chat.FILE_RAW, ...{ [item.id]: { 'blob': URL.createObjectURL(blob) } } }
            })
        }
        a.style    = "display: none";
        a.href     = store.chat.FILE_RAW[item.id]['blob'];
        a.download = item.name + '.' + item.ext;
        a.click();
    }
</script>
<style scoped>

</style>