<template>
    <v-runtime-template :template="content" />
</template>
<script>
import VRuntimeTemplate from "vue3-runtime-template";
import MessageImage from './MessageCboxImage.vue';
import MessageFile from './MessageCboxFile.vue';
import MessageReplyIcon from './MessageReplyCboxIcon.vue';
import PreviewLinkApp from './PreviewLinkCboxApp.vue';
import MessageToIcon from '@/components/dynamic-partials/MessageToIcon.vue';
import MessageCopyIcon from '@/components/dynamic-partials/MessageCopyIcon.vue';
import MessageEmoji from '@/components/dynamic-partials/MessageEmoji.vue';
import TagAuth from '@/components/dynamic-partials/TagAuth.vue';
import TagRoom from '@/components/dynamic-partials/TagRoom.vue';
import TagMembers from '@/components/dynamic-partials/TagMembers.vue';
import ProductCbox from '@/components/dynamic-partials/ProductCbox.vue';

export default {
    name: 'Dynamic',
    props: {
        content: {
            required: true,
            type: String
        }
    },
    components: {
        VRuntimeTemplate,
        MessageToIcon,
        MessageReplyIcon,
        MessageCopyIcon,
        MessageEmoji,
        MessageImage,
        MessageFile,
        TagAuth,
        TagRoom,
        TagMembers,
        PreviewLinkApp,
        ProductCbox
    }
};
</script>
<style>
.user-chat-content{
    max-width: 100%;
}
.ctext-content pre{
    margin: 0;
    font-family: unset;
    font-size: 14px;
    overflow: visible;
    color: black;
    display: contents;
    white-space: break-spaces;
}
.ctext-content .ico{
    font-size: 0;
    margin-left: 0;
    height: 12px;
}
.content-message > .message-icon{
    display: inline-block;
    line-height: 10px;
}
.content-message .auth .img-to{
    height: 28px;
    width: 28px;
    border-radius: 50%;
    background: #ccc;
    font-size: 0;
    position: relative;
    top: -1px;
}

.ctext-content .auth{
    margin-right: 5px;
}
.ctext-content .re::before{
    content: 'RE';
}
.ctext-content .to::before{
    content: 'TO';
}
.ctext-content .to-all{
    height: 20px;
    width: 60px;
    display: inline-block;
}
.ctext-content .to-all::before{
    content: 'TOALL';
}
.ctext-content .ico::before{
    background: #0ab39c;
    font-size: 14px;
    padding: 2px 6px;
    padding-bottom: 3px;
    margin-right: 3px;
    font-weight: 600;
    font-family: system-ui;
    line-height: 10px;
    color: #fff;
    border-radius: 5px;
    position: relative;
    top: 1px;
}

.message-image{
    height: 100px;
    margin-bottom: 5px;
    display: inline-block;
}

.reply{
    border-left: 3px #0c9eb9 solid;
    padding-left: 10px;
}

.chat-code{
    margin-top: 2px;
    background: #292D3E !important;
    padding: 5px;
    border-left: 3px #04AA6D solid;
    padding-left: 10px;
    font-size: 14px;
    font-family: source-code-pro,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,
    monospacesource-code-pro,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;
}
.chat-code .code_message_format{
    color: #DDD !important;
}
.code-copy-icon{
    position: absolute;
    top: 4px;
    right: 3px;
    color: #495057;
    font-size: 12px;
    cursor: pointer;
    text-transform: uppercase;
    background: #f3f6f9;
    padding: 0 3px;
    border-radius: 5px;
    border: 1px #495057 solid;
}

</style>