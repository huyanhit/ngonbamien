<template>
    <span class="message-icon">
        <span class="d-flex flex-nowrap align-items-center message-icon" >
            <span class="ico to"> TO </span>
            <tag-auth :id="props.user_id"/>
        </span>
    </span>
</template>

<script setup>
import { useSocketStore } from '@/stores/chat.js'
import TagAuth from '@/components/dynamic-partials/TagAuth.vue'
const store = useSocketStore()
const props = defineProps([ 'user_id'])
</script>
<style></style>