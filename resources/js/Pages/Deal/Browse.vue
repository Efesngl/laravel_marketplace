<template>
    <MainLayout>
        <div class="flex flex-col items-center">
            <h2 class="text-2xl"><span v-if="parentCategory!=null">{{ parentCategory.category }}</span> Categories</h2>
            <div id="categories-list" class="flex flex-col gap-0 items-start w-full p-2">
                <a :href="route('deal.index', { cat: (parentCategory!=null)?parentCategory.id:0 })" class="border p-2 text-lg w-full flex justify-between items-center">
                    <span>All <span v-if="parentCategory!=null">{{ parentCategory.category }}</span> Deals</span>
                    <span class="flex flex-row justify-around gap-1 items-center"><small>(0)</small><fa-icon class="text-blue-400" icon="fa-solid fa-arrow-right"></fa-icon></span>
                </a>
                <a :href="route('browse.index', { cat: cat.id })" class="border p-2 text-lg w-full flex justify-between items-center" v-for="cat in categories">
                    <span>{{ cat.category }}</span>
                    <span class="flex flex-row justify-around gap-1 items-center"><small>(0)</small><fa-icon class="text-blue-400" icon="fa-solid fa-arrow-right"></fa-icon></span>
                </a>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
export default {
    props: {
        categories: Object,
        parentCategory:Object
    },
    components: {
        MainLayout,
        Link,
    },
};
</script>
