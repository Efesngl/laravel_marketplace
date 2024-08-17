<template>
    <MainLayout>
        <div class="md:px-16 p-3">
            <h2 class="text-2xl text-center">Latest deals</h2>
            <div class="grid gap-1 grid-cols-2 md:grid-cols-5 md:grid-rows-10 min-h-[calc(100dvh-9.25rem)]">
                <DealCard :link="route('deal.show', { deal: deal.id })" :deal="deal" v-for="deal in deals.data"></DealCard>
            </div>
        </div>
    </MainLayout>
</template>
<script>
import { Link } from "@inertiajs/vue3";
import DealCard from "../Components/DealCard.vue";
import MainLayout from "../Layouts/MainLayout.vue";

import Paginator from "primevue/paginator";

export default {
    props: {
        deals: Object,
        categories: Object,
    },
    components: {
        DealCard,
        MainLayout,
        Paginator,
        Link,
    },
};
</script>
