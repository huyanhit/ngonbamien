<template>
    <router-view :key="$i18n.locale"></router-view>
</template>

<script setup>
import { socket } from "@/socket";
if(socket) socket.off();
</script>
