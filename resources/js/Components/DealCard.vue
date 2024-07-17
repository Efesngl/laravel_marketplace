<template>
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <Link :href="route('deal.show', { deal: deal.id })">
            <img class="rounded-t-lg" :src="deal.image" alt="product image" />
            <div class="px-5 pb-3">
                <Link :href="route('deal.show', { deal: deal.id })">
                    <h5 class="text-lg truncate font-semibold tracking-tight text-gray-900 dark:text-white">{{ deal.title }}</h5>
                </Link>
                <div class="flex flex-col items-center justify-between">
                    <span class="text-base font-bold text-gray-900 dark:text-white">{{ deal.price }} TL</span>
                </div>
            </div>
        </Link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        Link,
    },
    props: {
        deal: Object,
    },
};
</script>
