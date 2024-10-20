<template>
    <AccountLayout title="Favorites" :backUrl="route('account.index')">
        <template v-slot:content>
            <div class="h-[calc(100svh-56px)] md:px-16 flex flex-col gap-4 p-2">
                <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5" v-if="favorites.length > 0">
                    <productCard :link="route('product.show', { product: fav.product.id })" v-for="fav in favorites" :product="fav.product"></productCard>
                </div>
                <div v-else>
                    <h5 class="text-3xl text-center">You dont have any favorites</h5>
                </div>
            </div>
        </template>
    </AccountLayout>
</template>
<script>
import ProductCard from "@/Components/ProductCard.vue";
import AccountLayout from "../../Layouts/AccountLayout.vue";
export default {
    props: {
        favorites: Object,
    },
    components: {
        ProductCard,
        AccountLayout,
    },
};
</script>
