<template>
    <MainLayout>
        <div class="flex flex-col md:px-16">
            <h1 class="text-3xl text-center">{{ category }}</h1>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5" v-if="products.total > 0">
                <ProductCard :product="product" v-for="product in products.data" :link="route('product.show', { product: product.id })"></ProductCard>
            </div>
            <Paginator @update:rows="changeRowsAmount" v-if="products.total > 0" :totalRecords="products.total" :rows="rowAmount" :rowsPerPageOptions="[0,50, 100, 250, 500]"></Paginator>
            <h2 v-else class="text-xl text-center">There are no products</h2>
        </div>
    </MainLayout>
</template>

<script>
import Paginator from "primevue/paginator";
import MainLayout from "@/Layouts/MainLayout.vue";
import { router } from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
export default {
    props: {
        products: Object,
        title: String,
        category:String,
        catID:Number,
        rowAmount:Number
    },
    components: {
        MainLayout,
        Paginator,
        ProductCard
    },
    methods: {
        changeRowsAmount(value) {
            router.visit(route(route().current(),{rows:value,cat:this.catID}),{},{only:["products"]});
        },
    },
};
</script>
