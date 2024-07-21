<template>
    <MainLayout>
        <div class="flex flex-col">
            <h1 class="text-3xl text-center">{{ category.category }} Deals</h1>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-4" v-if="deals.length > 0">
                <DealCard :deal="deal" v-for="deal in deals"></DealCard>
            </div>
            <h2 v-else class="text-xl text-center">There are no deals for this category</h2>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import DealCard from "@/Components/DealCard.vue";
export default {
    props: {
        category: String,
        deals: Object,
    },
    components: {
        MainLayout,
        DealCard,
    },
};
</script>
