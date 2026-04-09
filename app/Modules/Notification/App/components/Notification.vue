<template>
    <BDropdown variant="ghost-dark" dropstart class="ms-1 dropdown"
               :offset="{ alignmentAxis: 53, crossAxis: 0, mainAxis: -42 }"
               toggle-class="btn-icon btn-topbar rounded-circle arrow-none"
               id="page-header-notifications-dropdown"
               menu-class="dropdown-menu-lg dropdown-menu-end p-0"
               auto-close="outside"
               no-caret
               @shown="showPopover"
        >
        <template #button-content>
            <i class='bx bx-bell fs-22'></i>
            <span v-if="all?.total_unread > 0"
                class="bg-danger position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill">
                {{ all?.total_unread > 99  ? '99+' : all?.total_unread }}
            </span>
        </template>
        <div class="dropdown-head bg-success bg-pattern rounded-top dropdown-menu-lg">
            <div class="p-3">
                <BRow class="align-items-center">
                    <BCol>
                        <h6 class="m-0 fs-16 fw-semibold text-white">
                           {{ $t('notification.notification.notification') }}
                        </h6>
                    </BCol>
                    <BCol cols="auto" class="dropdown-tabs">
                        <BBadge variant="light-subtle" class="bg-light-subtle text-body fs-13">
                            {{ all?.total_unread }} {{ $t('notification.notification.new') }}
                        </BBadge>
                    </BCol>
                </BRow>
            </div>
        </div>
        <BTabs nav-class="nav-tabs-custom nav-success px-2 pt-2" @activate-tab="activeTab">
            <BTab v-for="(item, index) in data.summary" :key="index"
                  :title="$t('notification.notification.'+item.name.toLowerCase()) + ' (' + item.total + ')'"
                  :id="'tab'+item.id"
                  class="tab-pane fade"
                  role="tabpanel"
                  aria-labelledby="messages-tab"
                >
                <b-overlay :show="data.overlay" rounded="sm" style="min-height: 200px" spinner-variant="secondary">
                    <template v-if="data.notifications && index === data.activate" >
                        <div v-if="data.notifications.data && data.notifications.data.length > 0" data-simplebar style="max-height: 300px">
                            <div v-for="(notification, i) in data.notifications.data" :key="i"
                                class="text-reset notification-item d-block dropdown-item"
                                :set="extra = getExtra(notification.extra)" :class="{'bg-light':!notification.auth_read}">
                                <div class="d-flex" >
                                    <img v-if="notification.auth_avatar"
                                         @error.once="$event.target.src='https://ui-avatars.com/api/?name='+notification.auth_name"
                                         :src="notification.auth_avatar" class="mt-3 me-3 rounded-circle avatar-xs" :alt="notification.auth_name" />
                                    <img v-else :src="'https://ui-avatars.com/api/?name='+notification.auth_name" class="mt-3 me-3 rounded-circle avatar-xs" :alt="notification.auth_name"/>
                                    <div class="flex-grow-1">
                                        <a :href="domain+'/'+notification.url" target="_blank" @click="setRead(notification)" >
                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">
                                                {{ $t('notification.command.'+notification.title, extra) }}
                                            </h6>
                                            <div class="fs-13 text-muted">
                                                <p class="mb-1">
                                                    {{ $t('notification.command.'+notification.content, extra) }}
                                                </p>
                                            </div>
                                            <p class="mb-0 fs-11 fw-medium text-muted">
                                                <span class="me-2"><i class="mdi mdi-clock-outline small"></i> {{filters.fromNow(notification.updated_at)}} </span>
                                                <span>
                                                     <i class="bx bx-check-double text-success" v-if="notification.auth_read"></i>
                                                     <i class="bx bx-check-double text-white" v-else></i>
                                                </span>
                                            </p>
                                        </a>
                                    </div>
                                    <div class="fs-15 menu-notification d-flex">
                                        <div @click="setRead(notification)" class="mt-2 cursor-pointer" title="Click to read">
                                            <i class="bx bx-check-circle text-danger" v-if="!notification.auth_read"></i>
                                        </div>
                                        <BDropdown variant="ghost-dark" dropstart
                                                   toggle-class="btn-icon rounded-circle" no-caret
                                                   menu-class="p-0"
                                            >
                                            <template #button-content>
                                                <i class="ri-more-2-fill"></i>
                                            </template>
                                            <BDropdownItem v-if="!notification.auth_read" @click="setRead(notification)">
                                                {{$t('notification.notification.set_read')}}
                                            </BDropdownItem>
                                            <BDropdownItem v-else @click="setRead(notification)">
                                                {{$t('notification.notification.set_unread')}}
                                            </BDropdownItem>
                                            <BDropdownItem @click="remove(notification)">
                                                {{$t('notification.notification.remove')}}
                                            </BDropdownItem>
                                        </BDropdown>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template v-else>
                            <div class="empty-notification-elem">
                                <div class="w-18 w-50 pt-5 mx-auto">
                                    <img src="../assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                </div>
                                <div class="text-center pb-3 mt-2">
                                    <h6 class="fs-16 fw-semibold lh-base">{{ $t('notification.notification.no_notification') }} </h6>
                                </div>
                            </div>
                        </template>
                    </template>
                    <template v-else>
                        <div class="empty-notification-elem">
                            <div class="w-25 w-50 pt-3 mx-auto">
                                <img src="../assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                            </div>
                            <div class="text-center pb-5 mt-2">
                                <h6 class="fs-16 fw-semibold lh-base">{{ $t('notification.notification.no_notification') }} </h6>
                            </div>
                        </div>
                    </template>
                </b-overlay>
            </BTab>
        </BTabs>
        <div class="mt-1 text-center m-2">
            <a class="btn btn-soft-secondary" href="/notification">
                {{ $t('notification.notification.view_all') }}
                <i class="ri-arrow-right-line align-middle"></i>
            </a>
        </div>
    </BDropdown>
</template>

<script setup>
import Helper from '../helpers/common'
import { computed, onMounted, reactive } from 'vue'
import { notifyStore } from '../stores/notification'

const store  = notifyStore();
const event  = Helper.useEvent();
const domain = window.location.origin;
store.bindEvents(event);
const data = reactive({
    shows:[],
    overlay: false,
    activate: 0,
    is_open: false,
    last_type_id: 0,
    notifications: {
        data : []
    },
    summary:{}
})

const hoverRead = async function(notification) {
    if(!notification.auth_read){
        const response = await store.editNotification(notification.id, {read: 1})
        if(response?.success){
            event.emit('edit_notifications_data', notification);
        }
    }
}

const setRead = async function(notification) {
    const read = notification.auth_read? 0 : 1;
    const response = await store.editNotification(notification.id, {read: read})
    if(response?.success){
        event.emit('edit_notifications_data', notification);
    }
}

const remove = async function(notification) {
    const response = await store.deleteNotification(notification.id)
    if(response?.success){
        event.emit('delete_notifications_data', notification);
    }
}

const all = computed(()=>{
    return data.summary[0];
})

const getData = function(params) {
    data.overlay = true
    data.last_type_id = params.type_id
    store.getNotifications(params).then(res => {
        if(data.last_type_id === res.param.type_id){
            data.notifications = res.data
            data.overlay = false;
        }
    })
}

const activeTab = function(tab) {
    data.activate = tab
    if(data.is_open){
        getData({ type_id: data.summary[tab].id });
    }
}

const showPopover = function() {
    data.is_open = true;
    getData({ type_id: 0 });
}

event.on('push-notification', param => {
    const summary = data.summary.find(item => item.id === parseInt(param.type_id));
    if(summary){
        summary.total += 1
        summary.total_unread += param.auth_read? 0 : 1
        data.summary[0].total += 1
        data.summary[0].total_unread += param.auth_read? 0 : 1
    }
    const notification = {
        "title": param.title,
        "content": param.text,
        "type_id": param.type_id,
        "url": param.url,
        "extra": param.extra,
        "updated_at": Date.now(),
        "auth_avatar": param.auth_avatar,
        "auth_name": param.auth_name,
        "auth_read": param.auth_read
    }
    if(data.notifications?.data){
        data.notifications.data.unshift(notification);
    }
})

event.on('edit_notifications_data', notification => {
    notification.auth_read? ++data.summary[0].total_unread: --data.summary[0].total_unread;
    for (const index in data.summary) {
        for (const i in data.notifications.data) {
            if(data.notifications.data[i].id === parseInt(notification.id)){
                data.notifications.data[i].auth_read = !notification.auth_read;
            }
        }
    }
})

event.on('delete_notifications_data', notification => {
    -- data.summary[0].total;
    -- data.summary[notification.type_id].total;
    for (const index in data.summary) {
        for (const i in data.notifications.data) {
            if(data.notifications.data[i].id === parseInt(notification.id)){
                data.notifications.data.splice(i, 1);
            }
        }
    }
})

onMounted( async () => {
    const response = await store.getSummary({});
    if (response?.success) {
        data.summary = response.data
    }
});

const getExtra = (extra) => {
    return extra? JSON.parse(extra): null
}

</script>