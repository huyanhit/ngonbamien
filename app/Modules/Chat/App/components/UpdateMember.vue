<template>
    <BModal @shown="loadData" @hidden="resetModal" id="update_member_modal" :title="$t('chat.message.update-member')" scrollable size="lg" ref="modal">
        <TransitionGroup tag="div" class="d-flex flex-wrap" style="max-height: 220px; overflow-y: scroll">
            <template v-for="val in store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id]">
                <div class="d-flex p-2 border border-groove me-2 my-1 rounded"
                    :class="{'bg-light border-success': val === store.chat.CURRENT_USER.id}" v-if="store.chat.USER[val]">
                    <div class="flex-grow-0 avatar-sm me-2">
                        <img :src="store.chat.USER[val].avatar? store.chat.USER[val].avatar:
                             'https://ui-avatars.com/api/?name='+store.chat.USER[val].name"
                             @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.USER[val].name"
                             class="rounded-circle img-fluid">
                    </div>
                    <div class="flex-fill me-2">
                        <div class="me-2 fw-bold text-truncate"> {{store.chat.USER[val].name}}</div>
                        <div class="badge border border-success text-success">{{ getRoleMember(val) }}</div>
                    </div>
                </div>
                <div v-else-if="store.chat.GUEST[val]" class="d-flex p-2 border border-groove me-2 my-1 rounded" >
                    <div class="flex-grow-0 avatar-sm me-2" v-if="store.chat.GUEST[val]">
                        <img :src="store.chat.GUEST[val].avatar? store.chat.GUEST[val].avatar:
                             'https://ui-avatars.com/api/?name='+store.chat.GUEST[val].name"
                             @error.once="$event.target.src='https://ui-avatars.com/api/?name='+store.chat.GUEST[val].name"
                             class="rounded-circle img-fluid">
                    </div>
                    <div class="flex-fill me-2">
                        <div class="me-2 fw-bold text-truncate"> {{store.chat.GUEST[val].name}}</div>
                        <div class="badge border border-success text-success">{{ getRoleMember(val) }}</div>
                    </div>
                </div>
            </template>
        </TransitionGroup>
        <div class="row mt-2" v-if="getRole() === 2 && getRoomType() !== 4">
            <div class="col-12">
                <div class="form-group">
                    <div class="d-flex my-2">
                         <div class="bg-light me-2 p-2 border border-groove rounded">
                            <b-form-checkbox v-model="data.check_all" v-on:change="checkAllMember()" id="check_all_members">
                                {{$t('chat.message.check-all')}}
                            </b-form-checkbox>
                         </div>
                         <div class="flex-fill bg-light border border-groove rounded">
                            <input type="text"
                                class="form-control bg-light border-light"
                                :placeholder="$t('chat.message.search-contact')"
                                v-model="data.keyword"
                            >
                        </div>
                    </div>
                    <div class="list-contact py-1 px-3 border border-groove rounded"
                         style="max-height: 400px; min-height: 300px; overflow-y: auto">
                        <template v-for="(item, index) in filterUser" :key="index">
                            <div class="row border-bottom-inset border-1" v-if="item.id !== store.chat.CURRENT_USER.id">
                                <div class="col-md-6 mb-2">
                                    <div class="my-3 pt-1">
                                        <b-form-checkbox v-model="item.check" :id="'check-item-members-'+item.id">
                                            {{item.name}}
                                        </b-form-checkbox>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex my-2" v-if="item.check">
                                    <div class="flex-grow-1 my-1 me-2">
                                        <Field :name="'member_roles'+item.id" v-model="item.role">
                                            <Multiselect
                                                v-model="item.role" value="1" :options="roles">
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
        <template #footer>
            <b-button variant="secondary" class="w-sm btn-save-modal" :disabled="checkDisabled()" @click="updateMembers">
                <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                {{ $t('common.form.save') }}
            </b-button>
            <b-button variant="outline-secondary" @click="modal.hide()">
                {{ $t('common.form.cancel') }}
            </b-button>
        </template>
    </BModal>
</template>
<script setup>

import { BModal } from 'bootstrap-vue-next'
import { useSocketStore } from '@/stores/chat.js'
import { Field } from 'vee-validate'
import Helper, { showConfirm, showToast } from '@/helpers/common.js'
import i18n from '@/plugins/i18n'
import { computed, reactive, ref } from 'vue'
import Multiselect from 'vue-multiselect'

const store = useSocketStore();
const event = Helper.useEvent();
const modal = ref(null);
const data = reactive({
    check_all: false,
    keyword: '',
    filterUser: [],
    members: [],
    saving: false,
    response: null
})

const roles = [
    { value: "1", label: 'Member'},
    { value: "2", label: 'Admin'},
    { value: "3", label: 'Read Only'},
]
const getRoleMember = function(user_id){
    const type = store.chat.MEMBER[store.chat.CURRENT_ROOM.id+'_'+user_id].type;
    return (type === 1)? "Member": ( type === 2 ) ? "Admin" : "Read only";
}
const checkAllMember = function(){
    for (let item of filterUser.value){
        item.check = data.check_all;
    }
}
const checkDisabled = function(){
    return data.saving
        || Object.keys(getFormMembers.value).length === 0
        || getRole() !== 2
        || getRoomType() === 4
}
const checkMember = function(id){
    for (const index in store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id]) {
        if(store.chat.ROOM_MEMBER[store.chat.CURRENT_ROOM.id][index] === id){
            return true;
        }
    }

    return false;
}

const getRole = function(){
    const key = store.chat.CURRENT_ROOM.id+'_'+store.chat.CURRENT_USER.id
    return store.chat.MEMBER[key]?store.chat.MEMBER[key].type: 0;
}

const getRoomType = function(){
    const key = store.chat.CURRENT_ROOM.id
    return store.chat.ROOM[key]?store.chat.ROOM[key].type: 0;
}
const resetModal = function(){
    data.check_all = false
    data.keyword   = ''
    data.response  = null
}
const mergeMember = function(){
    let mergers = store.members.concat(store.users);
    return mergers.filter((value, index, self) => {
        return (self.findIndex((v) => v.id === value.id) === index);
    });
}

const loadData = function(){
    data.members = mergeMember();
    data.members.forEach(item => {
        if (checkMember(item.id)){
            item.check = true
            item.role  = store.chat.MEMBER[store.chat.CURRENT_ROOM.id + '_' +item.id].type
        }else{
            item.check = false
            item.role  = 1
        }
    })
    data.members.sort((a, b) => {
        return b.check - a.check
    })
}

const filterUser = computed(()=>{
    return data.members.filter(item => {
        return item.name.includes(data.keyword)
    })
})

const getFormMembers = computed(()=>{
    let members = {}
    for (let item of data.members) {
        if (item.check && item.id !== store.chat.CURRENT_USER.id) members[item.id] = item.role
    }

    return members;
})
const updateMembers = async function() {
    if(Object.keys(getFormMembers.value).length > 0){
        showConfirm({title: 'are you sure save info ?'}).then( async (result) => {
            if(result.isConfirmed){
                data.saving = true
                const response = await store.updateRoom(store.chat.CURRENT_ROOM.id, { members: getFormMembers.value })
                if (response.success) {
                    modal.value.hide();
                    showToast({ icon: "success", title: i18n.global.t('common.message.success') });
                } else {
                    data.response = response
                }

                data.saving = false
            }
        })
    }
}

</script>