<template>
    <MainLayout bg="bg-stone-200">
        <div>
            <h1 class="text-center text-3xl mt-2 mb-2">My Account</h1>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col">
                    <h2 class="text-2xl">Deal Management</h2>
                    <Link href="/" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Active Deals</Link>
                    <Link href="/" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Inactive Deals</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Messages</h2>
                    <Link href="/" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Message box</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Favorites</h2>
                    <Link href="/" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Favorite deals</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Deals</h2>
                    <Link href="/" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Selled</Link>
                    <Link href="/" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Buyed</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Profile Management</h2>
                    <Link :href="route('account.settings')" class="text-c-black text-xl border border-stone-200 p-2 bg-stone-50">Profile Management</Link>
                </div>
                <a :href="route('logout')" class="text-xl text-blue-500 text-center">Logout</a>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        MainLayout,
        Link,
    },
};
</script>
