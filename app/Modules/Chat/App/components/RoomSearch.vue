<template>
    <span class="search-box flex-grow-1">
        <input type="text"
               class="form-control bg-light border-light"
               ref="filter"
               :placeholder="$t('chat.message.filter-list-room')"
               :value="$props.modelValue"
               @input="$emit('update:modelValue', $event.target.value)"
        >
        <i class="ri-search-2-line search-icon"></i>
    </span>
</template>
<script setup>
   import { ref } from 'vue';
   import Helper from '@/helpers/common.js'
   
   const props  = defineProps(['modelValue'])
   const event  = Helper.useEvent();
   const filter = ref(null);

   event.on('filter-room-focus', () => {
       setTimeout(()=>{
           filter.value.focus();
       }, 50)
   })
</script>