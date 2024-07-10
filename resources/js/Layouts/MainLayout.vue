<template>
    <div class="container">
        <nav id="navbar" class="bg-c-bh text-white  px-3 py-2">
            <div v-if="!isSearhBarShowing" class="flex flex-row justify-between content-center align-middle ">
                <div id="logo">
                    <h1 class="text-3xl">Logo</h1>
                </div>
                <span @click="toggleSearch(true)" class="h-full text-c-white"><fa-icon icon="fa-solid fa-magnifying-glass" size="xl" transform="down-5"></fa-icon></span>
            </div>
            <div id="search-bar" class="flex flex-row content-center align-middle" v-if="isSearhBarShowing">
                <fa-icon icon="fa-solid fa-magnifying-glass" class="text-c-white bg-c-pr p-2" size="xl"></fa-icon>
                <input type="text" class="w-5/6 bg-c-pr border-0 text-c-white placeholder:text-c-white focus:ring-0 focus:border-none" placeholder="Ara..." />
                <button type="submit" class="bg-c-pr w-1/6 text-c-white" @click="toggleSearch(false)"><fa-icon icon="fa-solid fa-xmark"></fa-icon></button>
            </div>
        </nav>
        <slot />
        <div id="bottom-bar" class="md:hidden flex flex-row justify-between px-3 text-c-white fixed bg-c-black w-full h-16 bottom-0 left-0">
            <Link href="/" v-for="ni in navItems" class="content-center" :class="{'text-c-pr':route().current()==ni.routeName}">
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
    components: {
        Link,
    },
    data() {
        return {
            navItems: [
                {
                    text: "Ana Sayfa",
                    icon: "fa-house",
                    routeName:"home"
                },
                {
                    text: "İlan ver",
                    icon: "fa-circle-plus",
                    routeName:"ad.new",
                },
                {
                    text: (this.$page.props.user!=null)?"Hesabım":"Giriş yap",
                    icon: "fa-user",
                    routeName:(this.$page.props.user!=null)?"auth.login":"account.details"
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
