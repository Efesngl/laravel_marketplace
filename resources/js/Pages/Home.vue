<template>
    <MainLayout>
        <div class="md:px-16 p-3">
            <h2 class="text-2xl text-center">Latest products</h2>
            <div class="grid gap-1 grid-cols-2 md:grid-cols-5 md:grid-rows-10 min-h-[calc(100dvh-9.25rem)]">
                <ProductCard :link="route('product.show', { product: product.id })" :product="product" v-for="product in products.data"></ProductCard>
            </div>
        </div>
    </MainLayout>
</template>
<script>
import { Link } from "@inertiajs/vue3";
import ProductCard from "../Components/ProductCard.vue";
import MainLayout from "../Layouts/MainLayout.vue";

import Paginator from "primevue/paginator";

export default {
    props: {
        products: Object,
        categories: Object,
    },
    components: {
        ProductCard,
        MainLayout,
        Paginator,
        Link,
    },
};
</script>
