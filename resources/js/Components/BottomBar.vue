<template>
    <div id="bottom-bar" class="h-16 md:hidden z-50 flex flex-row justify-between px-3 text-zinc-50 fixed bg-zinc-800 w-dvw bottom-0 left-0">
        <Link :href="route(ni.routeName)" v-for="ni in navItems" class="flex flex-col items-center justify-center" :class="{ 'text-yellow-400': route().current().includes(ni.routeName) }">
            <div class="flex flex-col items-center justify-start">
                <i :class="ni.icon"></i>
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
                    icon: "pi pi-home",
                    routeName: "home",
                },
                {
                    text: "Browse",
                    icon: "pi pi-bars",
                    routeName: "browse.index",
                },
                {
                    text: "New Product",
                    icon: "pi pi-plus-circle",
                    routeName: "product.create",
                },
                {
                    text: "Search",
                    icon: "pi pi-search",
                    routeName: "search",
                },
                {
                    text: this.$page.props.auth.user != null ? "Account" : "Login",
                    icon: "pi pi-user",
                    routeName: this.$page.props.auth.user != null ? "account.index" : "login",
                },
            ],
        };
    },
};
</script>
