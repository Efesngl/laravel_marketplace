<style>
.p-dock-item {
    width: 20% !important;
    padding: 0px !important;
}
.p-dock-list-container{
    width: 100% !important;
}
.p-dock-item-content {
    width: 100% !important;
}
.p-dock-item-link{
    width: 100% !important;
}
.p-dock-list {
    width: 100%;
    margin: 0px !important;
    justify-content: space-between !important;
}
</style>
<template>
    <Dock :model="navItems" position="bottom">
        <template #itemicon="{ item }">
            <Link :href="route(item.routeName)" class="flex flex-col items-center justify-center" :class="{'text-yellow-400':route().current()==item.routeName}">
                <fa-icon :icon="'fa-icon ' + item.icon"></fa-icon>
                <small>{{ item.text }}</small>
            </Link>
        </template>
    </Dock>
</template>

<script>
import Dock from "primevue/dock";
import { Link } from "@inertiajs/vue3";

export default {
    components: {
        Dock,
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
