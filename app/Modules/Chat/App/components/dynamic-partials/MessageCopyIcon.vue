<template>
    <span class="code-copy-icon" @click="copyData($event)">
       {{ copy? 'copied': 'copy' }}
    </span>
</template>

<script setup>
let copy = ref(false);
const copyData = function(e){
    if(e.currentTarget.parentElement){
        copy.value = true
        navigator.clipboard.writeText(e.currentTarget.parentElement.firstChild.textContent);
    }
}
</script>