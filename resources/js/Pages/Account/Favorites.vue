<template>
    <AccountLayout title="Favorites" :backUrl="route('account.index')">
        <div class="h-[calc(100svh-56px)] flex flex-col gap-4 p-2">
            <h1 class="text-center text-3xl">Favorites</h1>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5" v-if="favorites.length > 0">
                <DealCard :link="route('deal.show', { deal: fav.deal.id })" v-for="fav in favorites" :deal="fav.deal"></DealCard>
            </div>
            <div v-else>
                <h5 class="text-3xl text-center">You dont have any favorites</h5>
            </div>
        </div>
    </AccountLayout>
</template>
<script>
import DealCard from "../../Components/DealCard.vue";
import AccountLayout from "../../Layouts/AccountLayout.vue";
export default {
    props: {
        favorites: Object,
    },
    components: {
        DealCard,
        AccountLayout,
    },
};
</script>
