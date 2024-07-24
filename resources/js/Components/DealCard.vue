<style>
    .p-card-title{
        overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
</style>
<template>
    <Link :href="route('deal.show', { deal: deal.id })">
        <Card style="overflow: hidden;">
            <template #header>
                <img :src="deal.banner" alt="" class="w-full" />
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
    },
};
</script>
