<template>
    <div class="container">
        <nav id="navbar" class="bg-c-bh text-white h-14 px-3 py-2">
            <div v-if="!isSearhBarShowing" class="flex flex-row justify-between content-center align-middle ">
                <div id="logo">
                    <h1 class="text-3xl">Logo</h1>
                </div>
                <span v-if="route().current()!=undefined&&!route().current().includes('account')" @click="toggleSearch(true)" class="h-full text-c-white"><fa-icon icon="fa-solid fa-magnifying-glass" size="xl" transform="down-5"></fa-icon></span>
            </div>
            <div id="search-bar" class="flex flex-row content-center align-middle" v-if="isSearhBarShowing">
                <fa-icon icon="fa-solid fa-magnifying-glass" class="text-c-white bg-c-pr p-2" size="xl"></fa-icon>
                <input type="text" class="w-5/6 bg-c-pr border-0 text-c-white placeholder:text-c-white focus:ring-0 focus:border-none" placeholder="Ara..." />
                <button type="submit" class="bg-c-pr w-1/6 text-c-white" @click="toggleSearch(false)"><fa-icon icon="fa-solid fa-xmark"></fa-icon></button>
            </div>
        </nav>
        <div class="h-dvh overflow-scroll" :class="bg">
            <slot/>
        </div>
        <div id="bottom-bar" class="h-16 md:hidden flex flex-row justify-between px-3 text-c-white fixed bg-c-black w-full bottom-0 left-0">
            <Link :href="route(ni.routeName)" v-for="ni in navItems" class="content-center" :class="{'text-c-pr':route().current()==ni.routeName}">
                <div class="bottom-bar-box flex flex-col">
                    <fa-icon :icon="'fa-solid ' + ni.icon" size="lg"></fa-icon>
                    <span>{{ ni.text }}</span>
                </div>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
    props:["bg"],
    components: {
        Link,
    },
    data() {
        return {
            navItems: [
                {
                    text: "Home Page",
                    icon: "fa-house",
                    routeName:"home"
                },
                {
                    text: "Categories",
                    icon: "fa-list",
                    routeName:"home",
                },
                {
                    text: "New Deal",
                    icon: "fa-circle-plus",
                    routeName:"home",
                },
                {
                    text: (this.$page.props.auth.user!=null)?"Account":"Log In",
                    icon: "fa-user",
                    routeName:(this.$page.props.auth.user!=null)?"account":"login"
                },
            ],
            isSearhBarShowing: false,
        };
    },
    methods: {
        toggleSearch(status) {
            this.isSearhBarShowing = status;
        },
    },
};
</script>
