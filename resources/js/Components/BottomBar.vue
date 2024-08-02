<template>
    <div id="bottom-bar" class="h-16 z-50 flex flex-row justify-between px-3 text-c-white fixed bg-zinc-800 w-full bottom-0 left-0">
        <Link :href="route(ni.routeName)" v-for="ni in navItems" class="flex flex-col items-center justify-center" :class="{ 'text-yellow-400': route().current().includes(ni.routeName) }">
            <div class="bottom-bar-box flex flex-col">
                <fa-icon :icon="'fa-solid ' + ni.icon" size="lg"></fa-icon>
                <span class="text-sm">{{ ni.text }}</span>
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
    data() {
        return {
            navItems: [
                {
                    text: "Home Page",
                    icon: "fa-house",
                    routeName: "home",
                },
                {
                    text: "Browse",
                    icon: "fa-list",
                    routeName: "browse.index",
                },
                {
                    text: "New Deal",
                    icon: "fa-circle-plus",
                    routeName: "deal.create",
                },
                {
                    text: "Search",
                    icon: "fa-magnifying-glass",
                    routeName: "search",
                },
                {
                    text: this.$page.props.auth.user != null ? "Account" : "Login",
                    icon: "fa-user",
                    routeName: this.$page.props.auth.user != null ? "account" : "login",
                },
            ],
        };
    },
};
</script>
