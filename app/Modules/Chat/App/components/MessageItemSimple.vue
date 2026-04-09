<template>
    <div class="text-truncate simple-message" >
        {{item.content.replace(Regex.TAG.ALL_TAG, '.')}}
    </div>
</template>

<script setup>
import Regex from '@/constants/regex.js'
const props = defineProps(['item'])
</script>
<style>
.simple-message{
    height: 25px;
    margin-right: 15px;
}
.simple-message pre{
    font-size: unset;
    font-family: unset;
}
</style>