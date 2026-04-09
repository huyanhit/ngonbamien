<template>
    <BModal @shown="showModal" id="update_room_info" ref="modal" title="S??a th�ng tin Room" scrollable size="lg">
        <Form :validation-schema="schema" ref="form" class="form-add-room" >
            <div class="row">
                <div class="col-3 d-flex justify-content-center align-items-center">
                    <div class="avatar-lg cursor-pointer" @click="data.show_upload_avatar = !data.show_upload_avatar">
                        <ImageFile v-if="data.form.icon" :img_id="data.form.icon" class="rounded-circle img-fluid userprofile"/>
                        <img v-else src="https://ui-avatars.com/api/?name=Room" class="rounded-circle avatar-lg" alt="">
                        <div class="small text-center mt-2">  {{$t('chat.message.click-to-upload')}} </div>
                    </div>
                    <BModal v-model="data.show_upload_avatar" title="Upload avatar" scrollable>
                        <div class="row">
                            <div class="col-12 ">
                                <div class="border-1">
                                    <img v-for="(item, index) in data.scr_preview"
                                         ref="preview_image_upload"
                                         :src="item" class="mx-1 my-2"
                                         :key="index" alt="preview"/>
                                    <span v-for="(item, index) in data.icon_preview" v-html="item" :key="index" class="mx-1 my-2 file-upload"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="customFile">Choose File</label>
                                <input type="file" class="form-control" ref="fileUpload" v-on:change="displayImage($event)"/>
                            </div>
                        </div>
                        <template #footer>
                            <b-button type="submit" variant="secondary" class="w-sm" :disabled="data.saving" @click="uploadFiles">
                                <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                                {{ $t('common.form.save') }}
                            </b-button>
                            <b-button variant="outline-secondary" @click="data.show_upload_avatar = false">
                                {{ $t('common.form.cancel') }}
                            </b-button>
                        </template>
                    </BModal>
                </div>
                <div class="col-9">
                    <div class="mb-1">
                        <label class="form-label mt-2 pe-2"> {{$t('chat.message.room-name')}} <span class="text-danger">*</span> </label>
                        <div class="flex-grow-1">
                            <Field name="name" :label="$t('chat.message.room-name')" class="form-control" v-model="data.form.name" v-slot="{ field  }">
                                <input type="text" class="form-control" v-model="data.form.name"
                                       :placeholder="$t('chat.message.enter-room-name')">
                            </Field>
                            <ErrorMessage name="name" class="text-danger"/>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label mt-2 pe-2"> {{$t('chat.message.description')}} <span class="text-danger">*</span> </label>
                        <div class="flex-grow-1">
                            <Field name="description" :label="$t('chat.message.description')" class="form-control" v-model="data.form.description" v-slot="{ field  }">
                                <textarea type="text" class="form-control" v-model="data.form.description" :placeholder="$t('chat.message.enter-description')"/>
                            </Field>
                            <ErrorMessage name="description" class="text-danger"/>
                        </div>
                    </div>
                </div>
            </div>
        </Form>
        <template #footer>
            <b-button type="submit" variant="secondary" class="w-sm" :disabled="data.saving || getRole() !== 2" @click="saveRoom">
                <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                {{ $t('common.form.save') }}
            </b-button>
            <b-button variant="outline-secondary" @click="closeModal">
                {{ $t('common.form.cancel') }}
            </b-button>
        </template>
    </BModal>
</template>

<script setup>
    
import { BModal } from 'bootstrap-vue-next'
import { reactive, ref } from 'vue'
import { useSocketStore } from '@/stores/chat.js'
import { ErrorMessage, Field, Form } from 'vee-validate'

import Helper, { showToast } from '@/helpers/common.js'
import i18n from '@/plugins/i18n'
import ImageFile from '@/components/file-partials/ImageFile.vue'

const store = useSocketStore();
const form  = ref(null);
const event = Helper.useEvent();
const modal = ref(null);
const roles = [
    { value: "1", label: 'Member'},
    { value: "2", label: 'Admin'},
    { value: "3", label: 'Read Only'},
]

const data = reactive({
    overlay: false,
    saving: false,
    disabled: true,
    modal: false,
    response: null,

    files: [],
    scr_preview: [],
    icon_preview: [],
    waiting_upload: false,

    form: {
        name: "",
        description: "",
        icon: "",
    }
})

const displayImage = function(e){
    data.scr_preview = [];
    for(let item of e.target.files){
        if(item.type.substring(0, 5) === 'image'){
            data.scr_preview.push(URL.createObjectURL(item));
        } else {
            data.icon_preview.push('<i class="ri-folder-zip-line"></i>');
        }
        data.files.push(item)
    }
}

const uploadFiles = async function() {
    if (data.files !== null) {
        let formData = new FormData()
        data.waiting_upload = true
        for (let index = 0; index < data.files.length; index++) {
            if (data.files[index].name !== undefined) {
                formData.append('file[]', data.files[index])
            }
        }

        formData.append('room_id', store.chat.CURRENT_ROOM.id)
        const response = await store.uploadFile(formData);
        if(response.success){
            data.show_upload_avatar = false;
            data.form.icon = Object.keys(response.data.FILE)[0];
        }
    }
}

const getRole = function(){
    const key = store.chat.CURRENT_ROOM.id+'_'+store.chat.CURRENT_USER.id
    return store.chat.MEMBER[key]?store.chat.MEMBER[key].type: 0;
}

const schema = {
};

const closeModal = function(){
    modal.value.hide();
}

const showModal = function(){
    data.response = null;
    data.form.name = store.room.name;
    data.form.description = store.room.description;
    data.form.icon =  store.room.icon;
}
const resetForm = function(){
    data.form.name = '';
    data.form.description = '';
    data.form.icon = '';
}

const saveRoom = async function() {
    const validate = await form.value.validate()
    if (validate.valid) {
        data.saving = true
        const response = await store.updateRoom(store.chat.CURRENT_ROOM.id, data.form)
        if(response?.success){
            resetForm();
            showToast({ icon: "success", title: i18n.global.t('common.message.success') });
            closeModal();
        } else {
            data.response = response
        }

        data.saving = false
    }
}

</script>
<style scoped>
.form-add-room .list-contact{
    max-height: 300px;
    overflow: auto;
}
</style>