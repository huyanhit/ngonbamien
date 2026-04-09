<template>
    <div class="flex-shrink-0">
        <div>
            <button type="button" class="btn btn-ghost-success btn-icon" size="lg"
                    @click="data.modal = true" title="Quản lý danh bạ">
                <i class="ri ri-user-add-line" size="lg"></i>
                <span v-if="data.notice_contact > 0"
                      class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                    {{ data.notice_contact }}
                </span>
            </button>
        </div>
        <BModal v-model="data.modal" title="Quản lý danh bạ" scrollable size="lg" hide-footer>
            <b-tabs v-model="data.tab_active" @activate-tab="changeTab">
                <b-tab :title="$t('chat.message.contact')">
                    <b-card>
                        <div class="d-flex">
                             <span class="search-box flex-grow-1">
                                <input type="text"
                                       class="form-control bg-light border-light"
                                       :placeholder="$t('chat.message.search-contact')"
                                       v-model="data.keyword"
                                >
                                <i class="ri-search-2-line search-icon ml-3"></i>
                             </span>
                        </div>
                        <b-overlay :show="data.overlay" rounded="max" spinner-variant="secondary">
                            <div class="row mt-3 list-contact">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="list-contact py-2 px-3 border border-groove rounded" v-if="contactFilter.length > 0">
                                        <template v-for="(item, index) in contactFilter" :key="index">
                                            <div class="row border-1" :class="{'border-bottom-groove': index <= contactFilter.length - 2}"
                                                 v-if="item.id !== store.chat.CURRENT_USER.id">
                                                <div class="col-6">
                                                    <div class="d-flex my-2">
                                                        <div class="avatar-xs me-1">
                                                            <img class="rounded-circle img-fluid" :src="'https://ui-avatars.com/api/?name='+item.name">
                                                        </div>
                                                        <span class="mt-1 fw-bold"> {{item.name}} </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex justify-content-end my-2">
                                                        <div class=" me-2">
                                                            <b-button class="btn btn-outline-success" size="sm" @click="openChat(item)">
                                                                {{$t('chat.message.chat')}}
                                                            </b-button>
                                                        </div>
                                                        <div class=" me-2">
                                                            <b-button class="btn-outline-danger" size="sm" @click="removeContactId(store.chat.USER[item.id])">
                                                                <span class="spinner-border spinner-border-sm mr-2"
                                                                      role="status" aria-hidden="true" v-show="store.chat.USER[item.id].destroy">
                                                                     </span>
                                                                {{$t('chat.message.remove-contact')}}
                                                            </b-button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div v-else class="list-contact py-2 px-3 border border-groove rounded">
                                        {{$t('chat.message.empty-contact')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        </b-overlay>
                    </b-card>
                </b-tab>
                <b-tab title="">
                    <template #title>
                         <div class="position-relative">{{$t('chat.message.approve')}}
                              <span
                                 v-if="data.notice_contact > 0"
                                 class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-1">
                                 <span class="visually-hidden">{{ data.notice_contact }}</span>
                              </span>
                         </div>
                    </template>
                    <b-card>
                        <div class="d-flex">
                         <span class="search-box flex-grow-1">
                            <input type="text"
                                   class="form-control bg-light border-light"
                                   :placeholder="$t('chat.message.search-contact')"
                                   v-model="data.keyword"
                            >
                            <i class="ri-search-2-line search-icon ml-3"></i>
                         </span>
                        </div>
                        <div class="mb-2">
                            <div class="my-2 bg-light p-2 border border-groove rounded">
                                <b-form-checkbox v-model="data.check_all_approve" v-on:change="checkAllMemberApprove()" id="check_all_approve">
                                    <span class="text-capitalize bold"> {{$t('chat.message.check-all')}}</span>
                                </b-form-checkbox>
                            </div>
                        </div>
                        <b-overlay :show="data.overlay" rounded="max" style="min-height: 300px" spinner-variant="secondary">
                            <div class="row mt-3 list-contact">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="list-contact py-2 px-3 border border-groove rounded"
                                             v-if="contactApproveFilter.length > 0">
                                            <template v-for="(item, index) in contactApproveFilter" :key="index">
                                                <div class="row border-1" :class="{'border-top-groove': index > 0}">
                                                    <div class="col-6 my-1">
                                                        <b-form-checkbox v-model="store.chat.APPROVE[item.id].check" :id="'check-item-approve-'+item.id" class="mt-2">
                                                            <div class="d-flex mt-1 mx-2">
                                                                <div class="avatar-xs me-1">
                                                                    <img class="rounded-circle img-fluid" :src="'https://ui-avatars.com/api/?name='+item.name">
                                                                </div>
                                                                <span class="mt-1 fw-bold"> {{item.name}} </span>
                                                            </div>
                                                        </b-form-checkbox>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex justify-content-end my-2">
                                                            <div class="me-2">
                                                                <b-button type="submit" size="sm" class="btn-outline-success"
                                                                          @click="approveContactId(store.chat.APPROVE[item.id])">
                                                                    <span class="spinner-border spinner-border-sm mr-2"
                                                                          role="status" aria-hidden="true" v-show="store.chat.APPROVE[item.id].saving">
                                                                    </span>
                                                                    {{$t('chat.message.accept')}}
                                                                </b-button>
                                                            </div>
                                                            <div class=" me-2">
                                                                <b-button class="btn-outline-danger" size="sm" @click="cancelContactId(store.chat.APPROVE[item.id])">
                                                                     <span class="spinner-border spinner-border-sm mr-2"
                                                                           role="status" aria-hidden="true" v-show="store.chat.APPROVE[item.id].canceling">
                                                                     </span> {{$t('chat.message.deny')}}
                                                                </b-button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div v-else class="list-contact py-2 px-3 border border-groove rounded">
                                            {{$t('chat.message.empty-contact')}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </b-overlay>
                        <div class="row mt-3">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span v-if="getIdsCheckApprove.length > 0">
                                        Bạn đã chọn {{getIdsCheckApprove.length}} thành viên.
                                    </span>
                                </div>
                                <div class="flex-shrink-0">
                                    <b-button type="submit" variant="secondary" class="w-sm me-2" :disabled="data.saving || getIdsCheckApprove.length === 0" @click="cancelContact">
                                        <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                                        {{$t('chat.message.not-approve-all')}}
                                    </b-button>
                                    <b-button variant="outline-secondary" @click="closeModal">
                                        {{ $t('common.form.cancel') }}
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </b-card>
                </b-tab>
                <b-tab :title="$t('chat.message.requested')">
                    <b-card>
                        <div class="d-flex">
                            <span class="search-box flex-grow-1">
                                 <input type="text"
                                        class="form-control bg-light border-light"
                                        :placeholder="$t('chat.message.search-contact')"
                                        v-model="data.keyword"
                                 >
                                 <i class="ri-search-2-line search-icon ml-3"></i>
                            </span>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="my-2 bg-light p-2 border border-groove rounded">
                                        <b-form-checkbox v-model="data.check_all_requested" v-on:change="checkAllMemberRequest()" id="check_all_requested">
                                            <span class="text-capitalize bold"> {{$t('chat.message.check-all')}}</span>
                                        </b-form-checkbox>
                                    </div>
                                    <b-overlay :show="data.overlay" rounded="max" style="min-height: 300px" spinner-variant="secondary">
                                        <div class="row list-contact">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="list-contact py-2 px-3 border border-groove rounded"
                                                         v-if="contactRequestedFilter.length > 0">
                                                        <template v-for="(item, index) in contactRequestedFilter" :key="index">
                                                            <div class="row border-1" :class="{'border-top-groove': index > 0}">
                                                                <div class="col-md-6">
                                                                    <div class="my-2 pt-1">
                                                                        <b-form-checkbox v-model="store.chat.REQUESTED[item.id].check" :id="'check-item-'+item.id" class="mt-2">
                                                                            <div class="d-flex mt-1 mx-2">
                                                                                <div class="avatar-xs me-1">
                                                                                    <img class="rounded-circle img-fluid" :src="'https://ui-avatars.com/api/?name='+item.name">
                                                                                </div>
                                                                                <span class="mt-1 fw-bold"> {{item.name}} </span>
                                                                            </div>
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 my-1">
                                                                    <div class="d-flex justify-content-end my-2">
                                                                        <div class=" me-2">
                                                                            <b-button class="btn-outline-danger" size="sm" @click="unRequestContactId(store.chat.REQUESTED[item.id])">
                                                                                 <span class="spinner-border spinner-border-sm mr-2"
                                                                                       role="status" aria-hidden="true" v-show="store.chat.REQUESTED[item.id].un_requested">
                                                                                 </span>
                                                                                {{$t('chat.message.cancel-request')}}
                                                                            </b-button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                    <div v-else class="list-contact py-2 px-3 border border-groove rounded">
                                                        {{$t('chat.message.empty-contact')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-overlay>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span v-if="getIdsCheckRequested.length > 0">
                                        Bạn đã chọn {{getIdsCheckRequested.length}} thành viên.
                                    </span>
                                </div>
                                <div class="flex-shrink-0">
                                    <b-button type="submit" variant="secondary" class="w-sm me-2" :disabled="data.saving || getIdsCheckRequested.length === 0" @click="unRequestContact">
                                        <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                                        {{$t('chat.message.not-request-all')}}
                                    </b-button>
                                    <b-button variant="outline-secondary" @click="closeModal">
                                        {{ $t('common.form.cancel') }}
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </b-card>
                </b-tab>
                <b-tab :title="$t('chat.message.find-contact')">
                    <b-card>
                        <div class="d-flex">
                         <span class="search-box flex-grow-1">
                            <input type="text"
                                   class="form-control bg-light border-light"
                                   :placeholder="$t('chat.message.search-contact')"
                                   v-model="data.keyword"
                            >
                            <i class="ri-search-2-line search-icon ml-3"></i>
                        </span>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="mb-2">
                                        <div class="my-2 bg-light p-2 border border-groove rounded">
                                            <b-form-checkbox v-model="data.check_all" v-on:change="checkAllMember()" id="check_all_contact">
                                                <span class="text-capitalize bold"> {{$t('chat.message.check-all')}}</span>
                                            </b-form-checkbox>
                                        </div>
                                    </div>
                                    <b-overlay :show="data.overlay" rounded="max" style="min-height: 300px" spinner-variant="secondary">
                                        <div class="list-contact py-2 px-3 border border-groove rounded"
                                            v-if="unFriendFilter.length > 0">
                                            <template v-for="(item, index) in unFriendFilter" :key="index">
                                                <div class="row border-1" :class="{'border-top-groove': index > 0}">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="my-2 pt-1">
                                                            <b-form-checkbox v-model="store.chat.UNFRIEND[item.id].check" :id="'check-item-'+item.id" class="mt-2">
                                                                <div class="d-flex mt-1 mx-2">
                                                                    <div class="avatar-xs me-1">
                                                                        <img class="rounded-circle img-fluid" :src="'https://ui-avatars.com/api/?name='+item.name">
                                                                    </div>
                                                                    <span class="mt-1 fw-bold"> {{item.name}} </span>
                                                                </div>
                                                            </b-form-checkbox>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex justify-content-end my-2">
                                                            <div class=" me-2">
                                                                <b-button type="submit" class="btn-outline-success" @click="addContactId(store.chat.UNFRIEND[item.id])">
                                                                    <span class="spinner-border spinner-border-sm mr-2"
                                                                          role="status" aria-hidden="true" v-show="store.chat.UNFRIEND[item.id].saving">
                                                                    </span>
                                                                    Kết bạn
                                                                </b-button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div v-else class="list-contact py-2 px-3 border border-groove rounded">
                                            {{$t('chat.message.empty-contact')}}
                                        </div>
                                    </b-overlay>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <span v-if="getIdsCheckUnFriend.length > 0">
                                        Bạn đã chọn {{getIdsCheckUnFriend.length}} thành viên.
                                    </span>
                                </div>
                                <div class="flex-shrink-0">
                                   <b-button type="submit" variant="secondary" class="w-sm me-2" :disabled="data.saving || getIdsCheckUnFriend.length === 0" @click="addContact">
                                       <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true" v-show="data.saving"></span>
                                       Kết bạn với thành viên đã check
                                   </b-button>
                                   <b-button variant="outline-secondary" @click="closeModal">
                                       {{ $t('common.form.cancel') }}
                                   </b-button>
                                </div>
                            </div>
                        </div>
                    </b-card>
                </b-tab>
            </b-tabs>
        </BModal>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useSocketStore } from '@/stores/chat.js'
import Helper, { showConfirm, showToast } from '@/helpers/common.js'
import { computed } from 'vue';

const store = useSocketStore();
const event = Helper.useEvent();

const data = reactive({
    overlay: false,
    saving: false,
    disabled: true,
    modal: false,
    check_all: false,
    check_all_approve: false,
    check_all_requested: false,
    keyword: '',
    tab_active: 0,
    users: [],
    notice_contact: 0,
})

data.notice_contact = computed(()=>{
    return Object.keys(store.chat.APPROVE).length
})

onMounted(() => {
     getApproveContact();
})

const closeModal = function() {
    data.modal = false;
}
const changeTab = function(index){
    data.tab_active = index;
    switch (index){
        case 1:
            getApproveContact();
            break;
        case 2:
            getRequestedContact();
        break;
        case 3:
            getUnfriendContact();
        break;
    }
}


const openChat = async function(item) {
    const roomId = parseInt(store.chat.CONTACT[item.id].room_id);
    event.emit('change-room', {id: roomId});
    closeModal();
}

const getApproveContact = async function() {
    if(!Object.keys(store.chat.APPROVE).length){
        data.overlay = true
        await store.getApproveContact()
        data.overlay = false
    }
}

const getRequestedContact = async function() {
    if(!Object.keys(store.chat.REQUESTED).length) {
        data.overlay = true
        await store.getRequestedContact()
        data.overlay = false
    }
}

const getUnfriendContact = async function() {
    data.overlay = true
    await store.getUnfriendContact()
    data.overlay = false
}

const contactFilter = computed(()=>{
    if(store.users){
        return store.users.filter(item => {
            return item.name.includes(data.keyword)
        })
    }

    return [];
})

const contactApproveFilter = computed(()=>{
    return Object.values(store.chat.APPROVE).filter(item => {
        return item.name.includes(data.keyword)
    })
})

const contactRequestedFilter = computed(()=>{
    return Object.values(store.chat.REQUESTED).filter(item => {
        return item.name.includes(data.keyword)
    })
})

const unFriendFilter = computed(()=>{
    return Object.values(store.chat.UNFRIEND).filter(item => {
        return item.name.includes(data.keyword)
    })
})

const checkAllMember = function(){
    for (let index in store.chat.UNFRIEND){
        store.chat.UNFRIEND[index].check = data.check_all;
    }
}

const checkAllMemberRequest = function() {
    for (let index in store.chat.REQUESTED) {
        store.chat.REQUESTED[index].check = data.check_all_requested;
    }
}

const checkAllMemberApprove = function() {
    for (let index in store.chat.APPROVE) {
        store.chat.APPROVE[index].check = data.check_all_approve;
    }
}

const getIdsCheckUnFriend = computed(() => {
    let ids = []
    for (const index in store.chat.UNFRIEND) {
        if(store.chat.UNFRIEND[index].check){
            ids.push(index)
        }
    }
    return ids;
})

const getIdsCheckRequested = computed(() => {
    let ids = []
    for (const index in store.chat.REQUESTED) {
        if(store.chat.REQUESTED[index].check){
            ids.push(index)
        }
    }
    return ids;
})

const getIdsCheckApprove = computed(() => {
    let ids = []
    for (const index in store.chat.APPROVE) {
        if(store.chat.APPROVE[index].check){
            ids.push(index)
        }
    }
    return ids;
})


const addContact = async function() {
    data.saving = true
    const response = await store.addContact({ids: getIdsCheckUnFriend.value})
    if(response.success){
        for (const id of getIdsCheckUnFriend.value) {
            if(Object.keys(store.chat.REQUESTED).length) {
                store.chat.REQUESTED[id] = store.chat.UNFRIEND[id]
            }
            if(Object.keys(store.chat.UNFRIEND).length) {
                delete store.chat.UNFRIEND[id]
            }
        }
        data.tab_active = 2;
        showToast({icon : "success", title: 'Đã gửi lời mời kết bạn thành công'});
    }else{
        data.response = response
    }
    data.saving = false
}

const unRequestContact = async function() {
    data.saving = true
    const response = await store.unRequestContact({ids: getIdsCheckRequested.value})
    if(response.success){
        for (const id of getIdsCheckRequested.value) {
            if(Object.keys(store.chat.UNFRIEND).length) {
                store.chat.UNFRIEND[id] = store.chat.REQUESTED[id]
            }
            if(Object.keys(store.chat.REQUESTED).length) {
                delete store.chat.REQUESTED[id]
            }
        }
        data.tab_active = 3;
        showToast({icon : "success", title: 'Đã hủy yêu cầu kết bạn thành công'});
    }else{
        data.response = response
    }
    data.saving = false
}

const cancelContact = async function() {
    data.saving = true
    const response = await store.cancelContact({ids: getIdsCheckApprove.value})
    if(response.success){
        for (const id of getIdsCheckApprove.value) {
            if(Object.keys(store.chat.APPROVE).length) {
                delete store.chat.APPROVE[id]
            }
        }
        data.tab_active = 3;
        showToast({icon : "success", title: 'Đã từ chối kết bạn thành công'});
    }else{
        data.response = response
    }
    data.saving = false
}

const addContactId = async function(item) {
    item.saving = true
    const response = await store.addContact({ids:[item.id]})
    if(response.success){
        if(Object.keys(store.chat.REQUESTED).length) {
            store.chat.REQUESTED[item.id] = store.chat.UNFRIEND[item.id]
        }
        if(Object.keys(store.chat.UNFRIEND).length) {
            delete store.chat.UNFRIEND[item.id]
        }
        data.tab_active = 2;
        showToast({icon : "success", title: 'Đã gửi lời mời kết bạn đến '+item.name});
    }else{
        data.response = response
    }
    item.saving = false
}

const approveContactId = async function(item) {
    item.saving = true
    const response = await store.approveContact({ids:[item.id]})
    if(response.success){
        if(Object.keys(store.chat.APPROVE).length) {
            delete store.chat.APPROVE[item.id]
        }
        data.tab_active = 0;
        showToast({icon : "success", title: 'Đã chấp nhận yêu cầu kết bạn từ '+item.name});
    }else{
        data.response = response
    }

    item.saving = false
}

const cancelContactId = async function(item) {
    item.canceling = true
    const response = await store.cancelContact({ids:[item.id]})
    if(response.success){
        if(Object.keys(store.chat.APPROVE).length) {
            delete store.chat.APPROVE[item.id]
        }
        data.tab_active = 3;
        showToast({icon : "success", title: 'Đã từ chối cầu kết bạn từ '+item.name});
    }else{
        data.response = response
    }

    item.canceling = false
}

const unRequestContactId = async function(item) {
    item.saving = true
    const response = await store.unRequestContact({ids:[item.id]})
    if(response.success){
        if(Object.keys(store.chat.UNFRIEND).length) {
            store.chat.UNFRIEND[item.id] = store.chat.REQUESTED[item.id]
        }
        if(Object.keys(store.chat.REQUESTED).length) {
            delete store.chat.REQUESTED[item.id]
        }
        data.tab_active = 3;
        showToast({icon : "success", title: 'Đã hủy yêu cầu kết bạn đến '+item.name});
    }else{
        data.response = response
    }

    item.saving = false
}

const removeContactId = async function(item) {
    showConfirm({title: 'Hủy kết bạn với ' + item.name}).then( async (result) => {
        if(result.isConfirmed) {
            item.saving = true
            const response = await store.removeContact({ ids: [item.id] })
            if (response.success) {
                if (Object.keys(store.chat.USER).length) {
                    delete store.chat.USER[item.id]
                }
                data.tab_active = 3;
                showToast({ icon: "success", title: 'Đã hủy kết bạn với ' + item.name });
            } else {
                data.response = response
            }

            item.saving = false
        }
    })
}
</script>

<style>
.list-contact >div:last-child{
   border-bottom: none !important;
}
</style>