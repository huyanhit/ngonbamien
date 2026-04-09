<template>
    <span class="d-flex align-items-center message-icon" >
        <span class="ico re"> {{ $t("chat.chat.reply") }} </span>
        <tag-auth :id="props.uid"/>
    </span>
    <div class="reply">
        <message-render :item="message"/>
    </div>
</template>

<script setup>
    import { useSocketStore } from '@/stores/chat.js'
    import MessageRender from '@/components/dynamic-partials/MessageRender.vue'
    import TagAuth from '@/components/dynamic-partials/TagAuth.vue'
    const store = useSocketStore()
    const props = defineProps([ 'uid', 'mid', 'rid'])
    const message = store.chat.MESSAGE[props.rid+'_'+props.mid]
</script>
