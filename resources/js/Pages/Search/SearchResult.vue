<template>
    <MainLayout>
        <div>
            <h2 class="text-3xl text-center">Deals about {{ search }}</h2>
            <div class="grid gap-1 grid-cols-2 p-3 md:grid-cols-5">
                <DealCard :deal="deal" v-for="deal in deals"></DealCard>
            </div>
        </div>
    </MainLayout>
</template>
<script>
import DealCard from "../../Components/DealCard.vue";
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    props:{
        deals:Object,
        search:String
    },
    components: {
        DealCard,
        MainLayout,
    },
};
</script>
