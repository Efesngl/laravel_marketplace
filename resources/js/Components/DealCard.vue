<style>
    .p-card-title{
        overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    .p-card-body{
        background: var(--p-surface-950) !important; 
    }
</style>
<template>
    <Link :href="link" class="w-48">
        <Card class="overflow-hidden bg-zinc-950">
            <template #header>
                <img :src="deal.banner" alt="" class="w-full max-h-36 h-36 contain-content" />
            </template>
            <template #title>
                {{ deal.title }}
            </template>
            <template #subtitle>
                <span class="truncate">{{ deal.price }} TL</span>
            </template>
        </Card>
    </Link>
</template>

<script>
import Card from "primevue/card";
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        Link,
        Card,
    },
    props: {
        deal: Object,
        link:String
    },
};
</script>
