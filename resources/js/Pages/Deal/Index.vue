<template>
    <MainLayout>
        <div class="flex flex-col md:px-16">
            <h1 class="text-3xl text-center">{{ title }} Deals</h1>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5" v-if="deals.total > 0">
                <DealCard :deal="deal" v-for="deal in deals.data" :link="route('deal.show', { deal: deal.id })"></DealCard>
            </div>
            <Paginator @update:rows="changeRowsAmount" v-if="deals.total > 0" :totalRecords="deals.total" :rows="rowAmount" :rowsPerPageOptions="[0,50, 100, 250, 500]"></Paginator>
            <h2 v-else class="text-xl text-center">There are no deals</h2>
        </div>
    </MainLayout>
</template>

<script>
import Paginator from "primevue/paginator";
import MainLayout from "@/Layouts/MainLayout.vue";
import DealCard from "@/Components/DealCard.vue";
import { router } from "@inertiajs/vue3";
export default {
    props: {
        deals: Object,
        title: String,
        category:String,
        catID:Number,
        rowAmount:Number
    },
    components: {
        MainLayout,
        DealCard,
        Paginator,
    },
    methods: {
        changeRowsAmount(value) {
            router.visit(route(route().current(),{rows:value,cat:this.catID}),{},{only:["deals"]});
        },
    },
};
</script>
