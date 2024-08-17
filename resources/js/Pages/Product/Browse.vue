<template>
    <MainLayout>
        <div class="flex flex-col items-center">
            <h2 class="text-2xl">
                <span v-if="parentCategory != null">{{ parentCategory.category }}</span> Categories
            </h2>
            <div id="categories-list" class="flex flex-col gap-2 items-start w-full md:w-1/2 p-2">
                <a
                    :href="route('product.index', { cat: parentCategory != null ? parentCategory.id : 0 })"
                    class="border p-2 text-lg w-full flex justify-between items-center rounded-lg border-yellow-400"
                >
                    <span
                        >All <span v-if="parentCategory != null">{{ parentCategory.category }}</span> Products</span
                    >
                    <span class="flex flex-row justify-around gap-1 items-center"><small>(0)</small><i class="pi pi-arrow-right"></i></span>
                </a>
                <a
                    :href="route('browse.index', { cat: cat.id })"
                    class="border p-2 text-lg w-full flex justify-between items-center rounded-lg border-yellow-400"
                    v-for="cat in categories"
                >
                    <span>{{ cat.category }}</span>
                    <span class="flex flex-row justify-around gap-1 items-center"><small>(0)</small><i class="pi pi-arrow-right"></i></span>
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
        parentCategory: Object,
    },
    components: {
        MainLayout,
        Link,
    },
};
</script>
