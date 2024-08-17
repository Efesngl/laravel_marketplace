<template>
    <AccountLayout title="products" :backUrl="route('account.index')">
        <div class="h-[calc(100svh-56px)] flex flex-col gap-4 p-2">
            <h1 class="text-center text-3xl">Products</h1>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5" v-if="products.length > 0">
                <ProductCard :link="route('product.edit', { product: product.id })" v-for="product in products" :product="product"></ProductCard>
            </div>
            <div v-else>
                <h5 class="text-3xl text-center">You dont have any products</h5>
            </div>
        </div>
    </AccountLayout>
</template>
<script>
import ProductCard from "@/Components/ProductCard.vue";
import AccountLayout from "../../Layouts/AccountLayout.vue";
export default {
    props: {
        products: Object,
    },
    components: {
        ProductCard,
        AccountLayout,
    },
};
</script>
