<template>
    <a :href="store.product[id]?.url" target="blank" class="card p-2 mb-2">
        <div class="card-body" style="max-width: 260px;">
            <div class="border rounder mb-3">
                <img :src="store.product[id]?.image">
            </div>
            <div style="line-height: 15px;">
                <b class="text-muted">{{store.product[id]?.title}}</b>
                <div class="card-text small text-muted  mt-2">{{store.product[id]?.description}}</div>
            </div>
        </div>
    </a>
</template>

<script setup>
    import { useSocketStore } from '@/stores/chat.js'
    import { onMounted } from 'vue';
    import { reactive } from 'vue';

    const store = useSocketStore()
    const props = defineProps(['id']); 
    const data  = reactive({
        product: {
            title: '',
            description: '',
            image:'',
            url:''
        }
    })
    onMounted(() => {
        if(!store.product[props.id]){
            store.getProduct({id:props.id});
        }
    })
</script>
