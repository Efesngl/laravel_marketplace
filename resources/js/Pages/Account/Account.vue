<template>
    <AccountLayout bg="bg-stone-200 dark:bg-zinc-900" title="Account" :backUrl="route('home')">
        <div class="h-[calc(100svh-56px)] flex flex-col gap-4 p-2">
            <h1 class="text-center text-3xl">My Account</h1>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <h2 class="text-2xl">Deals</h2>
                    <Link :href="route('account.deals',{status:'active'})" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Active Deals</Link>
                    <Link :href="route('account.deals',{status:'inactive'})" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Inactive Deals</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Messages</h2>
                    <Link href="/" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Message box</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Favorites</h2>
                    <Link href="/" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Favorite deals</Link>
                </div>
                <div class="flex flex-col gap-1">
                    <h2 class="text-2xl">Deals</h2>
                    <Link href="/" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Selled</Link>
                    <Link href="/" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Buyed</Link>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-2xl">Profile Management</h2>
                    <Link :href="route('account.settings')" class="text-white text-xl dark:bg-zinc-800 dark:text-white rounded p-2 bg-stone-50">Profile Management</Link>
                </div>
                <a :href="route('logout')" class="text-center text-red-500 text-xl p-2 dark:bg-zinc-900 bg-stone-50">Log out <fa-icon icon="fa-solid fa-arrow-right-from-bracket"></fa-icon></a>
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
