<template>
    <MainLayout>
        <div>
            <h2 class="text-3xl text-center">Öne çıkan ilanlar</h2>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-4">
                <DealCard :deal="deal" v-for="i in 50"></DealCard>
            </div>
        </div>
    </MainLayout>
</template>
<script>
import DealCard from "../Components/DealCard.vue";
import MainLayout from "../Layouts/MainLayout.vue";
export default {
    components: {
        DealCard,
        MainLayout,
    },
    data() {
        return {
            deal: {
                image: "/storage/images/1/araba.jpg",
                title: "Lorem, ipsum dolor.",
                id: 1,
                price: 3000000,
            },
        };
    },
};
</script>
