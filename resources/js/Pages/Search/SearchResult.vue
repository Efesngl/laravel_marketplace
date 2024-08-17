<template>
    <MainLayout>
        <div class="md:px-16 p-3">
            <h2 class="text-3xl text-center">Products about {{ search }}</h2>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5">
                <ProductCard :product="product" v-for="product in products.data"></ProductCard>
            </div>
            <Paginator @update:rows="changeRowsAmount" v-if="products.total > 0" :totalRecords="products.total" :rows="rowAmount" :rowsPerPageOptions="[0,50, 100, 250, 500]"></Paginator>
        </div>
    </MainLayout>
</template>
<script>
import ProductCard from "@/Components/ProductCard.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import Paginator from "primevue/paginator";
export default {
    props:{
        products:Object,
        search:String,
        rowAmount:Number
    },
    components: {
        ProductCard,
        MainLayout,
        Paginator
    },
};
</script>
