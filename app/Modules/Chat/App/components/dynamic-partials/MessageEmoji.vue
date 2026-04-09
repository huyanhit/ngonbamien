<template>
    <span class="icon-emoji mr-1">
        <img :src="src"/>
    </span>
</template>
<script setup>
    defineProps(['src'])
</script>
<style>
    .icon-emoji img{
        height: 25px;
        width: 25px;
    }
    .icon-scale-y{
        transform: scaleY(-1);
    }
    .icon-scale-x{
        transform: scaleX(-1);
    }
</style>