<template>
    <div class="flex-shrink-0">
        <div >
            <button type="button" class="btn " size="lg" @click="data.modal = true">
                <i class="ri ri-group-line" size="lg">+</i>
            </button>
        </div>
        <BModal v-model="data.modal" :title="$t('chat.message.create-room')" scrollable size="lg">
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
                                <Field name="description" label="Mô tả" class="form-control" v-model="data.form.description" v-slot="{ field  }">
                                    <textarea type="text" class="form-control" v-model="data.form.description" placeholder="Enter description"/>
                                </Field>
                                <ErrorMessage name="description" class="text-danger"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="my-2 bg-light p-2 border border-groove rounded">
                                <b-form-checkbox v-model="data.check_all" v-on:change="checkAllMember()" id="check_all_item">
                                    {{$t('chat.message.check-all')}}
                                </b-form-checkbox>
                            </div>
                            <div class="list-contact py-2 px-3 border border-groove rounded" >
                                <template v-for="(item, index) in store.users" :key="index">
                                    <div class="row border-bottom-inset border-1" v-if="item.id !== store.chat.CURRENT_USER.id">
                                        <div class="col-md-6 mb-2">
                                            <div class="my-2 py-1">
                                                <b-form-checkbox v-model="data.members[item.id]" :id="'check-item-'+item.id">
                                                    {{item.name}}
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-md-6" v-if="data.members[item.id]">
                                            <div class="py-1">
                                                <Field :name="'member_roles'+item.id" v-model="data.member_roles[item.id]">
                                                    <Multiselect
                                                        v-model="data.member_roles[item.id]" value="1" :options="roles">
                                                        <template v-slot:tag="{ option, handleTagRemove, disabled }">
                                                            <div class="multiselect-tag is-user" :class="{'is-disabled': disabled}">
                                                                <span>{{ option.label }}</span>
                                                                <span
                                                                    v-if="!disabled"
                                                                    class="multiselect-tag-remove"
                                                                    @click="handleTagRemove(option, $event)">
                                                                <span class="multiselect-tag-remove-icon"></span>
                                                            </span>
                                                            </div>
                                                        </template>
                                                    </Multiselect>
                                                </Field>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </Form>
            <template #footer>
                <b-button type="submit" variant="secondary" class="w-sm" :disabled="data.saving" @click="saveRoom">
                    <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                    {{ $t('common.form.save') }}
                </b-button>
                <b-button variant="outline-secondary" @click="closeModal">
                    {{ $t('common.form.cancel') }}
                </b-button>
            </template>
        </BModal>
    </div>
</template>

<script setup>
    
import { BModal } from 'bootstrap-vue-next'
import { reactive, ref } from 'vue'
import { useSocketStore } from '@/stores/chat.js'
import { ErrorMessage, Field, Form } from 'vee-validate'

import Helper from '@/helpers/common.js'
import ImageFile from '@/components/file-partials/ImageFile.vue'
import Multiselect from 'vue-multiselect'

const store = useSocketStore();
const form  = ref(null);
const event = Helper.useEvent();

const roles = [
    { value: "1", label: 'Member'},
    { value: "2", label: 'Admin'},
    { value: "3", label: 'Read Only'},
]

const data = reactive({
    check_all: false,
    overlay: false,
    saving: false,
    members: [],
    disabled: true,
    member_roles: [],
    modal: false,
    show_upload_avatar: false,

    files: [],
    scr_preview: [],
    icon_preview: [],
    waiting_upload: false,

    form: {
        name: "",
        description: "",
        icon: "",
        members: {},
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

const checkAllMember = function(){
    for (let item of store.users){
        data.members[item.id] = data.check_all;
    }
}

const schema = {
};

const closeModal = function(){
    data.modal = false;
}
const resetForm = function(){
    data.form.name = '';
    data.form.description = '';
    data.form.icon = '';
    data.form.members = {};
    data.member_roles = {};
    data.members = {};
    data.check_all = false;
    form.value.resetForm();
}
const getFormMembers = function(){
    let members = {};
    data.members = { ...data.members, ...data.member_roles};
    for (let index in data.members){
        if(data.members[index]) {
            members[index] = data.members[index];
        }
    }

    return members;
}
const saveRoom = async function() {
    const validate = await form.value.validate()
    if (validate.valid) {
        data.saving = true
        data.form.members = getFormMembers();
        const response = await store.addRoom(data.form)
        if(response?.success){
            const roomId = parseInt(Object.keys(response.data.ROOM)[0])
            store.joinChannel({'room_id': roomId})
            event.emit('change-room', {id: roomId});
            resetForm();
        }else{
            data.response = response
        }

        data.saving = false
        closeModal();
    }
}
</script>
<style scoped>
.form-add-room .list-contact{
    max-height: 300px;
    overflow: auto;
}
</style>