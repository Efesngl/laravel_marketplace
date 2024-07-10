<template>
    <MainLayout>
        <h2 class="text-3xl text-center mt-3">Öne çıkan ilanlar</h2>
        <div class="grid gap-4 grid-cols-1 p-3 md:grid-cols-4">
            <Link :href="route('ilan')" class="flex flex-col hover:text-c-yellow" v-for="i in 50">
                <img src="/storage/images/1/araba.jpg" alt="">
                <p class="w-full max-h-12 overflow-hidden transition-all">Lorem ipsum dolor sit amet consectetur, ... adipisicing elit. Explicabo, earum.</p>
            </Link>
        </div>
    </MainLayout>
</template>
<script>
    import { Link } from "@inertiajs/vue3";
    import MainLayout from "../Layouts/MainLayout.vue"
    export default{
        components:{
            Link,
            MainLayout
        }
    }
</script>