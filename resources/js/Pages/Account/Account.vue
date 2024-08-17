<template>
    <AccountLayout bg="" title="Account" :backUrl="route('home')">
        <div class="h-[calc(100dvh-3.5rem)] flex p-2">
            <div class="flex flex-col justify-start md:items-center gap-4 w-full">
                <div class="flex flex-col md:w-1/2 gap-1">
                    <h2 class="text-2xl">Products</h2>
                    <Link :href="route('account.products', { status: 'active' })" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50"
                        >Active Products</Link
                    >
                    <Link :href="route('account.products', { status: 'inactive' })" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50"
                        >Inactive Products</Link
                    >
                    <Link href="/" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Buyed</Link>
                </div>
                <div class="flex flex-col md:w-1/2">
                    <h2 class="text-2xl">Messages</h2>
                    <Link :href="route('account.chats.index')" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Message box</Link>
                </div>
                <div class="flex flex-col md:w-1/2">
                    <h2 class="text-2xl">Favorites</h2>
                    <Link :href="route('account.favorites.index')" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Favorites</Link>
                </div>
                <div class="flex flex-col gap-1 md:w-1/2">
                    <h2 class="text-2xl">Orders</h2>
                    <Link href="/" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Orders</Link>
                </div>
                <div class="flex flex-col md:w-1/2">
                    <h2 class="text-2xl">Profile Management</h2>
                    <Link :href="route('account.settings')" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Profile Management</Link>
                </div>
                <a :href="route('logout')" class="text-center text-red-500 text-xl p-2 dark:bg-zinc-900 bg-stone-50 hover:opacity-50 transition"
                    >Log out <i class="pi pi-sign-out"></i></a>
            </div>
        </div>
    </AccountLayout>
</template>

<script>
import AccountLayout from "../../Layouts/AccountLayout.vue";
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        AccountLayout,
        Link,
    },
};
</script>
